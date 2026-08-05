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

        $acaraAktif = MDiklat::whereIn('status', ['Berlangsung', 'Terbuka'])->count();
        $totalPeserta = RecordAbsensiDiklat::distinct('id_user')->count('id_user');
        $eksternalAktif = DetailEksternal::where('status', 'aktif')->count();

        $action = new CalculateRekapJamAction();
        $karyawanKurangJam = User::where('type', 'internal')
            ->where('isActive', 1)
            ->get()
            ->filter(fn($user) => $action->execute($user->id, $tahun)->total() < 20)
            ->count();

        $acaraMendatang = MDiklat::whereIn('status', ['Terbuka', 'Berlangsung', 'Draft'])
            ->orderBy('tglJamMulai')
            ->limit(5)
            ->get();

        // Chart: Acara per bulan
        $acaraPerBulan = MDiklat::selectRaw('MONTH(STR_TO_DATE(tglJamMulai, "%Y-%m-%dT%H:%i")) as bulan, COUNT(*) as total')
            ->whereRaw('YEAR(STR_TO_DATE(tglJamMulai, "%Y-%m-%dT%H:%i")) = ?', [$tahun])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
        $chartAcaraBulan = collect(range(1, 12))->map(fn($b) => $acaraPerBulan[$b] ?? 0)->values();

        // Chart: Status acara
        $statusAcara = MDiklat::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Chart: Peserta per jenis (total)
        $pesertaPerJenis = DetailEksternal::selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->pluck('total', 'jenis');

        // Chart: Peserta per jenis per bulan (untuk horizontal bar)
        $rawJenisBulan = DetailEksternal::selectRaw('jenis, MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('jenis', 'bulan')
            ->orderBy('bulan')
            ->get();

        $pesertaJenisBulan = [];
        foreach ($rawJenisBulan as $row) {
            $pesertaJenisBulan[$row->jenis][$row->bulan] = $row->total;
        }
        // Fill semua bulan dengan 0
        foreach ($pesertaJenisBulan as $jenis => &$data) {
            $filled = [];
            for ($b = 1; $b <= 12; $b++) {
                $filled[$b] = $data[$b] ?? 0;
            }
            $data = array_values($filled);
        }

        // Absensi per bulan
        $absensiPerBulan = RecordAbsensiDiklat::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->where('is_hadir', 1)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');
        $chartAbsensiBulan = collect(range(1, 12))->map(fn($b) => $absensiPerBulan[$b] ?? 0)->values();

        return view('admin.dashboard', [
            'stats' => [
                'acara_aktif'         => $acaraAktif,
                'total_peserta'       => $totalPeserta,
                'karyawan_kurang_jam' => $karyawanKurangJam,
                'eksternal_aktif'     => $eksternalAktif,
            ],
            'acaraMendatang'    => $acaraMendatang,
            'chartAcaraBulan'   => $chartAcaraBulan,
            'chartAbsensiBulan' => $chartAbsensiBulan,
            'statusAcara'       => $statusAcara,
            'pesertaPerJenis'   => $pesertaPerJenis,
            'pesertaJenisBulan' => $pesertaJenisBulan,
            'tahun'             => $tahun,
        ]);
    }
}