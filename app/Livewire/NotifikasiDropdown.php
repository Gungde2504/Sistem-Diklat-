<?php
namespace App\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class NotifikasiDropdown extends Component
{
    public bool $open = false;
    public array $notifikasi = [];
    public int $jumlahBelumBaca = 0;

    public function mount(): void
    {
        $this->loadNotifikasi();
    }

    public function loadNotifikasi(): void
    {
        $user = auth()->user()->fresh();
        $notif = collect();
        $lastRead = $user->notif_last_read_at
            ? \Carbon\Carbon::parse($user->notif_last_read_at)
            : null;

        $isNew = fn($tanggal) => $lastRead === null || \Carbon\Carbon::parse($tanggal)->gt($lastRead);

        // ── ADMIN (super_admin, admin_diklat) ──
        if (in_array($user->role, ['admin_diklat', 'super_admin'])) {

            $pesertaBaru = DB::table('detail_eksternals')
                ->join('users', 'users.id', '=', 'detail_eksternals.id_user')
                ->where('detail_eksternals.approval_status', 'pending')
                ->where('detail_eksternals.created_at', '>=', now()->subDays(14))
                ->orderByDesc('detail_eksternals.created_at')
                ->limit(5)
                ->get(['users.nama', 'detail_eksternals.jenis', 'detail_eksternals.created_at'])
                ->map(fn($p) => [
                    'icon'   => '👤',
                    'judul'  => 'Pendaftaran Baru: ' . $p->nama . ' (' . ucfirst(str_replace('_', ' ', $p->jenis)) . ')',
                    'waktu'  => \Carbon\Carbon::parse($p->created_at)->diffForHumans(),
                    'warna'  => 'yellow',
                    'is_new' => $isNew($p->created_at),
                ]);
            $notif = $notif->merge($pesertaBaru);

            $mandiriBaru = DB::table('diklat_mandiris')
                ->where('status', 'pending')
                ->where('created_at', '>=', now()->subDays(14))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($m) => [
                    'icon'   => '📄',
                    'judul'  => 'Pengajuan Diklat Mandiri: ' . $m->nama,
                    'waktu'  => \Carbon\Carbon::parse($m->created_at)->diffForHumans(),
                    'warna'  => 'orange',
                    'is_new' => $isNew($m->created_at),
                ]);
            $notif = $notif->merge($mandiriBaru);
        }

        // ── PEGAWAI ──
        if ($user->role === 'pegawai' || in_array($user->role, ['admin_diklat', 'super_admin'])) {

            $terdaftar = DB::table('record_absensi_diklats')
                ->where('id_user', $user->id)
                ->pluck('id_diklat');

            $acaraBaru = DB::table('m_diklats')
                ->where('publish', 1)
                ->where('status', 'Terbuka')
                ->whereNotIn('id', $terdaftar)
                ->where('created_at', '>=', now()->subDays(7))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($a) => [
                    'icon'   => '🗓',
                    'judul'  => 'Acara Baru: ' . $a->nama,
                    'waktu'  => \Carbon\Carbon::parse($a->created_at)->diffForHumans(),
                    'warna'  => 'blue',
                    'is_new' => $isNew($a->created_at),
                ]);
            $notif = $notif->merge($acaraBaru);
        }

        if ($user->role === 'pegawai') {

            $mandiriHasil = DB::table('diklat_mandiris')
                ->where('id_user', $user->id)
                ->whereIn('status', ['Disetujui', 'Ditolak'])
                ->where('updated_at', '>=', now()->subDays(14))
                ->orderByDesc('updated_at')
                ->limit(5)
                ->get()
                ->map(fn($m) => [
                    'icon'   => $m->status === 'Disetujui' ? '✅' : '❌',
                    'judul'  => 'Diklat Mandiri ' . $m->status . ': ' . $m->nama,
                    'waktu'  => \Carbon\Carbon::parse($m->updated_at)->diffForHumans(),
                    'warna'  => $m->status === 'Disetujui' ? 'green' : 'red',
                    'is_new' => $isNew($m->updated_at),
                ]);
            $notif = $notif->merge($mandiriHasil);

            $unitUser = $user->unit ?? null;
            $elearningBaru = DB::table('elearning_modules')
                ->where('publish', 1)
                ->where(function ($q) use ($unitUser) {
                    $q->whereNull('id_target_unit');
                    if ($unitUser) {
                        $q->orWhere('id_target_unit', $unitUser);
                    }
                })
                ->where('created_at', '>=', now()->subDays(7))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($e) => [
                    'icon'   => '📚',
                    'judul'  => 'Modul E-Learning Baru: ' . $e->judul,
                    'waktu'  => \Carbon\Carbon::parse($e->created_at)->diffForHumans(),
                    'warna'  => 'purple',
                    'is_new' => $isNew($e->created_at),
                ]);
            $notif = $notif->merge($elearningBaru);

            // Sertifikat acara diklat baru terbit
            $diklatIds = DB::table('record_absensi_diklats')
                ->where('id_user', $user->id)
                ->pluck('id_diklat');

            $sertifikatAcaraBaru = DB::table('m_file_diklats')
                ->join('m_diklats', 'm_diklats.id', '=', 'm_file_diklats.id_diklat')
                ->where('m_file_diklats.type', 'sertifikat')
                ->whereIn('m_file_diklats.id_diklat', $diklatIds)
                ->where('m_file_diklats.created_at', '>=', now()->subDays(14))
                ->orderByDesc('m_file_diklats.created_at')
                ->limit(3)
                ->get(['m_diklats.nama', 'm_file_diklats.created_at'])
                ->map(fn($s) => [
                    'icon'   => '🎓',
                    'judul'  => 'Sertifikat Terbit: ' . $s->nama,
                    'waktu'  => \Carbon\Carbon::parse($s->created_at)->diffForHumans(),
                    'warna'  => 'purple',
                    'is_new' => $isNew($s->created_at),
                ]);
            $notif = $notif->merge($sertifikatAcaraBaru);

            // Sertifikat diklat mandiri siap
            $sertifikatMandiriBaru = DB::table('diklat_mandiris')
                ->where('id_user', $user->id)
                ->where('status', 'Disetujui')
                ->where('sertifikat', '!=', '')
                ->whereNotNull('sertifikat')
                ->where('updated_at', '>=', now()->subDays(14))
                ->orderByDesc('updated_at')
                ->limit(3)
                ->get()
                ->map(fn($m) => [
                    'icon'   => '🎓',
                    'judul'  => 'Sertifikat Diklat Mandiri Siap: ' . $m->nama,
                    'waktu'  => \Carbon\Carbon::parse($m->updated_at)->diffForHumans(),
                    'warna'  => 'purple',
                    'is_new' => $isNew($m->updated_at),
                ]);
            $notif = $notif->merge($sertifikatMandiriBaru);
        }

        // ── PESERTA EKSTERNAL (termasuk Karyawan External) ──
        if ($user->role === 'peserta_eksternal') {

            $detailUser = DB::table('detail_eksternals')
                ->where('id_user', $user->id)
                ->first();

            $jenisKaryawan = ['karyawan_iss', 'karyawan_bss', 'karyawan_adidaya', 'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa'];
            $isKaryawan = $detailUser && in_array($detailUser->jenis, $jenisKaryawan);

            // Acara baru
            $acaraBaru = DB::table('m_diklats')
                ->where('publish', 1)
                ->where('status', 'Terbuka')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($a) => [
                    'icon'   => '🗓',
                    'judul'  => 'Acara Baru: ' . $a->nama,
                    'waktu'  => \Carbon\Carbon::parse($a->created_at)->diffForHumans(),
                    'warna'  => 'blue',
                    'is_new' => $isNew($a->created_at),
                ]);
            $notif = $notif->merge($acaraBaru);

            // Status approval pendaftaran
            $statusApproval = DB::table('detail_eksternals')
                ->where('id_user', $user->id)
                ->whereIn('approval_status', ['approved', 'rejected'])
                ->where('updated_at', '>=', now()->subDays(14))
                ->orderByDesc('updated_at')
                ->limit(3)
                ->get()
                ->map(fn($d) => [
                    'icon'   => $d->approval_status === 'approved' ? '✅' : '❌',
                    'judul'  => $d->approval_status === 'approved'
                        ? 'Pendaftaran Anda Disetujui!'
                        : 'Pendaftaran Anda Ditolak',
                    'waktu'  => \Carbon\Carbon::parse($d->updated_at)->diffForHumans(),
                    'warna'  => $d->approval_status === 'approved' ? 'green' : 'red',
                    'is_new' => $isNew($d->updated_at),
                ]);
            $notif = $notif->merge($statusApproval);

            if ($isKaryawan) {
                // Status aktif/tidak aktif karyawan
                $statusKaryawan = DB::table('detail_eksternals')
                    ->where('id_user', $user->id)
                    ->where('status', 'selesai')
                    ->where('updated_at', '>=', now()->subDays(14))
                    ->orderByDesc('updated_at')
                    ->limit(2)
                    ->get()
                    ->map(fn($d) => [
                        'icon'   => '⚠',
                        'judul'  => 'Status Anda Ditandai Tidak Aktif',
                        'waktu'  => \Carbon\Carbon::parse($d->updated_at)->diffForHumans(),
                        'warna'  => 'orange',
                        'is_new' => $isNew($d->updated_at),
                    ]);
                $notif = $notif->merge($statusKaryawan);

                // E-learning baru untuk karyawan (sesuai unit)
                $unitKaryawan = $detailUser->id_unit ?? null;
                $elearningKaryawan = DB::table('elearning_modules')
                    ->where('publish', 1)
                    ->where(function ($q) use ($unitKaryawan) {
                        $q->whereNull('id_target_unit');
                        if ($unitKaryawan) {
                            $q->orWhere('id_target_unit', $unitKaryawan);
                        }
                    })
                    ->where('created_at', '>=', now()->subDays(7))
                    ->orderByDesc('created_at')
                    ->limit(3)
                    ->get()
                    ->map(fn($e) => [
                        'icon'   => '📚',
                        'judul'  => 'Modul E-Learning Baru: ' . $e->judul,
                        'waktu'  => \Carbon\Carbon::parse($e->created_at)->diffForHumans(),
                        'warna'  => 'purple',
                        'is_new' => $isNew($e->created_at),
                    ]);
                $notif = $notif->merge($elearningKaryawan);
            } else {
                // PKL/Magang/Orientasi — sertifikat siap
                $sertifikatSiap = DB::table('detail_eksternals')
                    ->where('id_user', $user->id)
                    ->whereNotNull('cert_file_path')
                    ->where('updated_at', '>=', now()->subDays(14))
                    ->orderByDesc('updated_at')
                    ->limit(3)
                    ->get()
                    ->map(fn($d) => [
                        'icon'   => '🎓',
                        'judul'  => 'Sertifikat Anda Sudah Siap!',
                        'waktu'  => \Carbon\Carbon::parse($d->updated_at)->diffForHumans(),
                        'warna'  => 'purple',
                        'is_new' => $isNew($d->updated_at),
                    ]);
                $notif = $notif->merge($sertifikatSiap);
            }
        }

        $this->notifikasi = $notif
            ->sortByDesc(fn($n) => $n['is_new'] ? 1 : 0)
            ->take(10)
            ->values()
            ->toArray();

        $this->jumlahBelumBaca = $notif->where('is_new', true)->count();
    }

    public function toggleOpen(): void
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->loadNotifikasi();
            auth()->user()->update(['notif_last_read_at' => now()]);
            $this->jumlahBelumBaca = 0;
        }
    }

    public function tutup(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.notifikasi-dropdown');
    }
}