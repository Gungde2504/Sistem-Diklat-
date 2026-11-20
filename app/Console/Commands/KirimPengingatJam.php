<?php

namespace App\Console\Commands;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Mail\PengingatJamPelatihan;
use App\Models\SistemKonfigurasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KirimPengingatJam extends Command
{
    protected $signature = 'jam:kirim-pengingat
                            {--sesi=pagi : Sesi pengiriman: pagi atau malam}
                            {--tanggal= : Simulasi tanggal (Y-m-d), untuk uji coba}
                            {--dry-run : Hanya tampilkan siapa yang akan diingatkan, tanpa menyimpan/mengirim}';

    protected $description = 'Kirim pengingat (notifikasi sistem + email) kepada pegawai dan karyawan eksternal yang jam pelatihannya belum memenuhi target';

    /** Jadwal bawaan (MM-DD): Juli-Okt 1x/bln, Nov 2x, Des 3x */
    public const JADWAL_DEFAULT = '07-01,08-01,09-01,10-01,11-01,11-15,12-01,12-15,12-25';

    /** Pengingat yang terlewat (scheduler mati) masih dikirim maksimal sekian hari setelah tanggalnya */
    private const TOLERANSI_HARI = 3;

    private const JENIS_KARYAWAN = [
        'karyawan_iss', 'karyawan_bss', 'karyawan_adidaya',
        'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa',
    ];

    public function handle(CalculateRekapJamAction $action): int
    {
        if (SistemKonfigurasi::get('pengingat_aktif', '1') !== '1') {
            $this->info('Pengingat jam pelatihan dinonaktifkan di Konfigurasi Sistem.');
            return self::SUCCESS;
        }

        $today  = $this->option('tanggal')
            ? Carbon::parse($this->option('tanggal'))->startOfDay()
            : now()->startOfDay();
        $dryRun = (bool) $this->option('dry-run');
        $tahun  = (int) $today->year;
        $target = (float) SistemKonfigurasi::get('target_jam_tahunan', 20);

        $sesi = $this->option('sesi') === 'malam' ? 'malam' : 'pagi';

        $md = $this->slotJatuhTempo($today, $sesi);
        if (!$md) {
            $this->info('Tidak ada jadwal pengingat (' . $sesi . ') untuk ' . $today->toDateString() . '.');
            return self::SUCCESS;
        }

        // Pagi memakai "MM-DD", malam "MM-DD-m" supaya keduanya tercatat terpisah di hari yang sama
        $slot = $sesi === 'malam' ? $md . '-m' : $md;

        $tingkat   = $this->tingkat((int) substr($md, 0, 2));
        $sisaBulan = max(0, 12 - $today->month);

        $this->info("Tahap pengingat {$md} sesi {$sesi} ({$tingkat}) - target {$target} jam" . ($dryRun ? ' [DRY RUN]' : ''));

        $users = User::where('isActive', 1)
            ->where(function ($q) {
                $q->where(function ($q1) {
                    $q1->where('type', 'internal')->where('role', 'pegawai');
                })->orWhere(function ($q2) {
                    $q2->where('type', 'external')
                       ->whereHas('detailEksternal', fn($d) => $d
                           ->whereIn('jenis', self::JENIS_KARYAWAN)
                           ->where('approval_status', 'approved')
                           ->where('status', '!=', 'selesai'));
                });
            })
            ->orderBy('id')
            ->get();

        $dikirim = 0; $dilewati = 0; $gagalEmail = 0;

        foreach ($users as $user) {
            $rekap = $action->execute($user->id, $tahun);
            $total = (float) $rekap->total();

            if ($rekap->sudahMemenuhiTarget($target)) {
                $dilewati++;
                continue;
            }

            if ($dryRun) {
                $this->line(" - {$user->nama} ({$user->nip}): {$total}/{$target} jam");
                $dikirim++;
                continue;
            }

            // Catat dulu; unique(id_user, tahun, slot) mencegah kirim ganda
            $baru = DB::table('pengingat_jam_logs')->insertOrIgnore([
                'id_user'      => $user->id,
                'tahun'        => $tahun,
                'slot'         => $slot,
                'jam_saat_ini' => $total,
                'target_jam'   => $target,
                'dikirim_at'   => now(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            if (!$baru) {
                $dilewati++;
                continue;
            }

            $dikirim++;

            if (!$user->email) {
                continue;
            }

            try {
                Mail::to($user->email)->send(new PengingatJamPelatihan(
                    nama:         $user->nama ?? $user->name ?? 'Bapak/Ibu',
                    jamSaatIni:   $total,
                    target:       $target,
                    jamAcara:     (float) $rekap->jamDiklatAcara,
                    jamMandiri:   (float) $rekap->jamDiklatMandiri,
                    jamElearning: (float) $rekap->jamElearning,
                    tahun:        $tahun,
                    sisaBulan:    $sisaBulan,
                    tingkat:      $tingkat,
                    role:         $user->role,
                ));

                DB::table('pengingat_jam_logs')
                    ->where('id_user', $user->id)->where('tahun', $tahun)->where('slot', $slot)
                    ->update(['email_terkirim' => true, 'updated_at' => now()]);
            } catch (\Throwable $e) {
                $gagalEmail++;
                Log::error('[Pengingat Jam] Gagal kirim email ke user ' . $user->id . ': ' . $e->getMessage());
            }
        }

        $this->info("Selesai: {$dikirim} pengingat, {$dilewati} dilewati (sudah memenuhi target / sudah terkirim), {$gagalEmail} email gagal.");
        Log::info("[Pengingat Jam] Tahap {$slot}: {$dikirim} dikirim, {$dilewati} dilewati, {$gagalEmail} email gagal.");

        return self::SUCCESS;
    }

    /**
     * Tahap jadwal (MM-DD) yang jatuh tempo.
     * Pagi: tanggal hari ini atau yang terlewat (toleransi 3 hari).
     * Malam: hanya tanggal hari ini (tidak ada penyusulan).
     */
    private function slotJatuhTempo(Carbon $today, string $sesi = 'pagi'): ?string
    {
        $jadwal = collect(explode(',', (string) SistemKonfigurasi::get('pengingat_jadwal', self::JADWAL_DEFAULT)))
            ->map(fn($s) => trim($s))
            ->filter(fn($s) => preg_match('/^(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $s))
            ->unique()
            ->sortDesc();

        foreach ($jadwal as $md) {
            try {
                $tgl = Carbon::createFromFormat('Y-m-d', $today->year . '-' . $md)->startOfDay();
            } catch (\Throwable $e) {
                continue;
            }
            if ($sesi === 'malam') {
                if ($tgl->equalTo($today)) {
                    return $md;
                }
                continue;
            }

            if ($tgl->lte($today) && $tgl->diffInDays($today, true) <= self::TOLERANSI_HARI) {
                return $md;
            }
        }

        return null;
    }

    private function tingkat(int $bulan): string
    {
        return match (true) {
            $bulan >= 12 => 'terakhir',
            $bulan === 11 => 'tegas',
            $bulan >= 9   => 'sedang',
            default       => 'ringan',
        };
    }
}
