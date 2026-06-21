<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailEksternal;
use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use App\Models\User;
use App\Actions\RekapJam\CalculateRekapJamAction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tahun = now()->year;

        // Statistik
        $acaraAktif = MDiklat::whereIn('status', ['Berlangsung', 'Terbuka'])->count();

        $totalPeserta = RecordAbsensiDiklat::distinct('id_user')->count('id_user');

        $eksternalAktif = DetailEksternal::where('status', 'aktif')->count();

        // Karyawan belum 20 jam
        $action = new CalculateRekapJamAction();
        $karyawanKurangJam = User::where('type', 'internal')
            ->where('isActive', 1)
            ->get()
            ->filter(fn($user) => $action->execute($user->id, $tahun)->total() < 20)
            ->count();

        // Acara mendatang
        $acaraMendatang = MDiklat::whereIn('status', ['Terbuka', 'Berlangsung', 'Draft'])
            ->orderBy('tglJamMulai')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'acara_aktif'         => $acaraAktif,
                'total_peserta'       => $totalPeserta,
                'karyawan_kurang_jam' => $karyawanKurangJam,
                'eksternal_aktif'     => $eksternalAktif,
            ],
            'acaraMendatang' => $acaraMendatang,
        ]);
    }
}