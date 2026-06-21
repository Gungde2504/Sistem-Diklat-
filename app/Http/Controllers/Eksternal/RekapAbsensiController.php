<?php

namespace App\Http\Controllers\Eksternal;

use App\Http\Controllers\Controller;
use App\Models\ExternalDailyAttendance;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function download(Request $request)
    {
        $format = $request->get('format', 'pdf'); // pdf atau excel
        $filter = $request->get('filter', 'semua');
        $bulan  = $request->get('bulan');
        $tahun  = $request->get('tahun', now()->year);
        $user   = auth()->user();

        $query = ExternalDailyAttendance::where('id_user', $user->id)
            ->orderByDesc('tanggal');

        if ($filter === 'bulan' && $bulan) {
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }

        $absensi    = $query->get();
        $totalHadir = $absensi->where('is_valid', 1)->count();
        $totalTidak = $absensi->where('is_valid', 0)->count();
        $detail     = $user->detailEksternal;

        $judul = $filter === 'bulan'
            ? 'Rekap Absensi ' . \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') . ' ' . $tahun
            : 'Rekap Absensi Semua Periode';

        if ($format === 'excel') {
            return $this->downloadExcel($absensi, $user, $detail, $judul, $totalHadir, $totalTidak);
        }

        return $this->downloadPdf($absensi, $user, $detail, $judul, $totalHadir, $totalTidak);
    }

    private function downloadPdf($absensi, $user, $detail, $judul, $totalHadir, $totalTidak)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('eksternal.absensi.rekap-pdf', compact(
            'absensi',
            'user',
            'detail',
            'judul',
            'totalHadir',
            'totalTidak'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('rekap-absensi-' . now()->format('Ymd') . '.pdf');
    }

    private function downloadExcel($absensi, $user, $detail, $judul, $totalHadir, $totalTidak)
    {
        $filename = 'rekap-absensi-' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($absensi, $user, $detail, $judul, $totalHadir, $totalTidak) {
            $file = fopen('php://output', 'w');

            // Header info
            fputcsv($file, [$judul]);
            fputcsv($file, ['Nama', $user->nama]);
            fputcsv($file, ['Email', $user->email]);
            fputcsv($file, ['Institusi', $detail?->institusi ?? '-']);
            fputcsv($file, ['Total Hadir', $totalHadir]);
            fputcsv($file, ['Total Tidak Valid', $totalTidak]);
            fputcsv($file, []);

            // Header kolom
            fputcsv($file, ['No', 'Tanggal', 'Check In', 'Check Out', 'Durasi', 'Status GPS']);

            foreach ($absensi as $i => $a) {
                fputcsv($file, [
                    $i + 1,
                    \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y'),
                    $a->checkin_at ? \Carbon\Carbon::parse($a->checkin_at)->format('H:i') : '-',
                    $a->checkout_at ? \Carbon\Carbon::parse($a->checkout_at)->format('H:i') : '-',
                    $a->durasi ? $a->durasi . ' menit' : '-',
                    $a->is_valid ? 'Valid' : 'Di luar radius',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
