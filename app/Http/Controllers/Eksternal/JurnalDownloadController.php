<?php

namespace App\Http\Controllers\Eksternal;

use App\Http\Controllers\Controller;
use App\Models\JurnalEksternal;
use Illuminate\Http\Request;

class JurnalDownloadController extends Controller
{
    public function download(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $filter = $request->get('filter', 'semua');
        $bulan  = $request->get('bulan');
        $tahun  = $request->get('tahun', now()->year);
        $user   = auth()->user();

        $query = JurnalEksternal::where('id_user', $user->id)
            ->orderByDesc('tanggal');

        if ($filter === 'bulan' && $bulan) {
            $query->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun);
        }

        $jurnal = $query->get();

        $judul = $filter === 'bulan'
            ? 'Jurnal Harian ' . \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y')
            : 'Jurnal Harian Semua Periode';

        if ($format === 'excel') {
            return $this->downloadExcel($jurnal, $user, $judul);
        }

        return $this->downloadPdf($jurnal, $user, $judul);
    }

    private function downloadPdf($jurnal, $user, $judul)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('eksternal.jurnal.jurnal-pdf', compact(
            'jurnal', 'user', 'judul'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('jurnal-' . now()->format('Ymd') . '.pdf');
    }

    private function downloadExcel($jurnal, $user, $judul)
    {
        $filename = 'jurnal-' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($jurnal, $user, $judul) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [$judul]);
            fputcsv($file, ['Nama', $user->nama]);
            fputcsv($file, ['Email', $user->email]);
            fputcsv($file, ['Total Jurnal', $jurnal->count()]);
            fputcsv($file, []);
            fputcsv($file, ['No', 'Tanggal', 'Aktivitas', 'Kendala', 'Rencana Besok']);

            foreach ($jurnal as $i => $j) {
                fputcsv($file, [
                    $i + 1,
                    \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y'),
                    $j->aktivitas,
                    $j->kendala ?? '-',
                    $j->rencana_besok ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}