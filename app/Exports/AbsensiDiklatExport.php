<?php

namespace App\Exports;

use App\Models\RecordAbsensiDiklat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class AbsensiDiklatExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private int    $tahun,
        private int    $bulan = 0,
        private string $unit  = ''
    ) {}

    public function collection(): Collection
    {
        return RecordAbsensiDiklat::with(['user', 'diklat'])
            ->whereYear('date', $this->tahun)
            ->when($this->bulan, fn($q) => $q->whereMonth('date', $this->bulan))
            ->when($this->unit,  fn($q) => $q->whereHas('user', fn($u) => $u->where('unit', $this->unit)))
            ->orderBy('date', 'desc')
            ->get()
            ->map(fn($r) => [
                $r->date?->format('d/m/Y') ?? '-',
                $r->namaPeserta,
                $r->user?->nip      ?? '-',
                $r->user?->unit     ?? '-',
                $r->diklat?->nama   ?? '-',
                $r->diklat?->jenisDiklat ?? '-',
                $r->durasi . ' menit',
                round($r->durasi / 60, 2) . ' jam',
            ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Peserta',
            'NIK',
            'Unit',
            'Nama Acara',
            'Jenis Diklat',
            'Durasi (Menit)',
            'Durasi (Jam)',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFE87722']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Absensi ' . $this->tahun;
    }
}