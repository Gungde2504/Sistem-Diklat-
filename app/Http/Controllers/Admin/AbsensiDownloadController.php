<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Illuminate\Http\Request;

class AbsensiDownloadController extends Controller
{
    public function download(Request $request, MDiklat $diklat)
    {
        $format = $request->get('format', 'pdf');
        $tipe   = $request->get('tipe', 'semua');
        $unit   = $request->get('unit', '');
        $status = $request->get('status', 'semua');

        $query = RecordAbsensiDiklat::with('user')
            ->where('id_diklat', $diklat->id)
            ->when($status === 'hadir', fn($q) => $q->where('is_hadir', true))
            ->when($status === 'belum', fn($q) => $q->where('is_hadir', false))
            ->when($tipe !== 'semua', function ($q) use ($tipe) {
                if ($tipe === 'internal') {
                    $q->whereHas('user', fn($u) => $u->where('type', 'internal'));
                } else {
                    $q->whereHas('user', fn($u) => $u->where('type', 'external'));
                }
            })
            ->when($unit, fn($q) => $q->whereHas('user', fn($u) => $u->where('unit', $unit)))
            ->orderByDesc('is_hadir')
            ->orderBy('namaPeserta')
            ->get();

        $totalHadir = $query->where('is_hadir', true)->count();
        $totalBelum = $query->where('is_hadir', false)->count();

        if ($format === 'excel') {
            return $this->downloadExcel($diklat, $query, $totalHadir, $totalBelum);
        }

        return $this->downloadPdf($diklat, $query, $totalHadir, $totalBelum);
    }

    private function downloadPdf($diklat, $absensi, $totalHadir, $totalBelum)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.absensi.rekap-pdf', compact(
            'diklat', 'absensi', 'totalHadir', 'totalBelum'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('absensi-' . \Str::slug($diklat->nama) . '-' . now()->format('Ymd') . '.pdf');
    }

    private function downloadExcel($diklat, $absensi, $totalHadir, $totalBelum)
    {
        $filename = 'absensi-' . \Str::slug($diklat->nama) . '-' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($diklat, $absensi, $totalHadir, $totalBelum) {
            $file = fopen('php://output', 'w');

            // Info diklat
            fputcsv($file, ['Rekap Absensi Diklat']);
            fputcsv($file, ['Nama Acara', $diklat->nama]);
            fputcsv($file, ['Tanggal', $diklat->tglJamMulai]);
            fputcsv($file, ['Tempat', $diklat->tempat]);
            fputcsv($file, ['Narasumber', $diklat->namaNarasumber]);
            fputcsv($file, ['Total Hadir', $totalHadir]);
            fputcsv($file, ['Total Belum', $totalBelum]);
            fputcsv($file, []);

            // Header kolom
            fputcsv($file, ['No', 'Nama', 'NIK/Email', 'Unit/Institusi', 'Tipe', 'Status', 'Waktu Hadir']);

            foreach ($absensi as $i => $record) {
                fputcsv($file, [
                    $i + 1,
                    $record->namaPeserta,
                    $record->user?->nip ?? $record->user?->email ?? '-',
                    $record->user?->unit ?? $record->user?->detailEksternal?->institusi ?? '-',
                    $record->user?->type === 'internal' ? 'Internal' : 'Eksternal',
                    $record->is_hadir ? 'Hadir' : 'Belum Hadir',
                    $record->is_hadir && $record->date
                        ? \Carbon\Carbon::parse($record->date)->format('d/m/Y H:i')
                        : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}