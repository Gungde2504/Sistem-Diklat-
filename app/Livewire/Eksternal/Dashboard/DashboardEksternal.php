<?php
namespace App\Livewire\Eksternal\Dashboard;
use App\Models\DetailEksternal;
use App\Models\ExternalDailyAttendance;
use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Title('Dashboard')]
class DashboardEksternal extends Component
{
    public function render()
    {
        $user   = auth()->user();
        $detail = DetailEksternal::where('id_user', $user->id)
            ->with(['unit', 'supervisor'])
            ->first();

        $isKaryawan = $detail && DetailEksternal::isKaryawanExternal($detail->jenis);

        $today    = now()->toDateString();
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // Absensi hari ini
        $absensiHarini = ExternalDailyAttendance::where('id_user', $user->id)
            ->where('tanggal', $today)
            ->first();

        // Rekap bulan ini
        $totalHadir = ExternalDailyAttendance::where('id_user', $user->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('is_valid', 1)
            ->count();

        $totalAbsensi = ExternalDailyAttendance::where('id_user', $user->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->count();

        // Sisa hari & progress — hanya untuk PKL/Magang
        $sisaHari         = 0;
        $totalHariPeriode = 0;
        $hariSudahDilalui = 0;
        $persenPeriode    = 0;

        if (!$isKaryawan && $detail && $detail->tanggal_selesai) {
            $sisaHari = max(0, now()->diffInDays(Carbon::parse($detail->tanggal_selesai), false));

            $mulai   = Carbon::parse($detail->tanggal_mulai);
            $selesai = Carbon::parse($detail->tanggal_selesai);
            $totalHariPeriode = max(1, $mulai->diffInDays($selesai));
            $hariSudahDilalui = min($totalHariPeriode, max(0, $mulai->diffInDays(now())));
            $persenPeriode    = round(($hariSudahDilalui / $totalHariPeriode) * 100);
        }

        return view('livewire.eksternal.dashboard.dashboard-eksternal', compact(
            'detail', 'isKaryawan', 'absensiHarini', 'totalHadir', 'totalAbsensi',
            'sisaHari', 'persenPeriode', 'hariSudahDilalui', 'totalHariPeriode'
        ));
    }
}