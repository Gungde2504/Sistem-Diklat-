<?php

namespace App\Exports;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class RekapJamExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private int    $tahun,
        private string $unit  = '',
        private float  $target = 20
    ) {}

    public function collection(): Collection
    {
        $action = app(CalculateRekapJamAction::class);

        return User::where('type', 'internal')
            ->where('isActive', 1)
            ->when($this->unit, fn($q) => $q->where('unit', $this->unit))
            ->orderBy('nama')
            ->get()
            ->map(function (User $user) use ($action) {
                $rekap    = $action->execute($user->id, $this->tahun);
                $total    = $rekap->total();
                $terpenuhi = $total >= $this->target ? 'Terpenuhi' : 'Belum Terpenuhi';

                return [
                    $user->nip      ?? '-',
                    $user->nama,
                    $user->unit     ?? '-',
                    $user->profesi  ?? '-',
                    number_format($rekap->jamDiklatAcara,   2),
                    number_format($rekap->jamDiklatMandiri, 2),
                    number_format($rekap->jamElearning,     2),
                    number_format($total, 2),
                    $this->target,
                    $terpenuhi,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Unit',
            'Profesi',
            'Jam Diklat Acara',
            'Jam Diklat Mandiri',
            'Jam E-Learning',
            'Total Jam',
            'Target Jam',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1B5E7B']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Rekap Jam ' . $this->tahun;
    }
}