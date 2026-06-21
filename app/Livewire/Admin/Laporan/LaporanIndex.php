<?php

namespace App\Livewire\Admin\Laporan;

use App\Exports\AbsensiDiklatExport;
use App\Exports\RekapJamExport;
use App\Models\MUnit;
use Livewire\Component;
use Livewire\Attributes\Title;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Models\User;
use App\Models\RecordAbsensiDiklat;
use App\Models\MDiklat;
use App\Models\DetailEksternal;
use App\Models\ElearningProgress;
use App\Models\ElearningModule;

#[Title('Laporan & Ekspor')]
class LaporanIndex extends Component
{
    public string $tahun  = '';
    public string $bulan  = '';
    public string $unit   = '';
    public float  $target = 20;

    // Filter Eksternal
    public string $tahunEksternal = '';
    public string $bulanEksternal = '';
    public string $jenisEksternal = 'semua';

    // Filter E-Learning
    public string $tahunElearning = '';
    public string $statusElearning = 'semua';

    public function mount(): void
    {
        $this->tahun          = (string) now()->year;
        $this->tahunEksternal = (string) now()->year;
        $this->tahunElearning = (string) now()->year;
    }

    // ── Rekap Jam Excel (internal + karyawan external) ──
    public function eksporRekapJamExcel()
    {
        return Excel::download(
            new RekapJamExport((int) $this->tahun, $this->unit, $this->target),
            'rekap-jam-' . $this->tahun . '.xlsx'
        );
    }

    // ── Rekap Jam PDF (internal + karyawan external) ──
    public function eksporRekapJamPdf()
    {
        $action = app(CalculateRekapJamAction::class);

        $karyawanJenis = [
            'karyawan_iss', 'karyawan_bss', 'karyawan_adidaya',
            'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa',
        ];

        $data = User::where('isActive', 1)
            ->where(function ($q) use ($karyawanJenis) {
                $q->where('type', 'internal')
                  ->orWhere(function ($q2) use ($karyawanJenis) {
                      $q2->where('type', 'external')
                         ->whereHas('detailEksternal', fn($d) =>
                             $d->whereIn('jenis', $karyawanJenis)
                               ->where('approval_status', 'approved')
                         );
                  });
            })
            ->when($this->unit, fn($q) => $q->where('unit', $this->unit))
            ->orderBy('nama')
            ->get()
            ->map(fn(User $user) => [
                'user'        => $user,
                'rekap'       => $action->execute($user->id, (int) $this->tahun),
                'is_karyawan' => $user->type === 'external',
            ]);

        $pdf = Pdf::loadView('admin.laporan.pdf-rekap-jam', [
            'data'   => $data,
            'tahun'  => $this->tahun,
            'target' => $this->target,
            'unit'   => $this->unit,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'rekap-jam-' . $this->tahun . '.pdf'
        );
    }

    // ── Absensi Diklat Excel ──
    public function eksporAbsensiExcel()
    {
        return Excel::download(
            new AbsensiDiklatExport((int) $this->tahun, (int) $this->bulan, $this->unit),
            'absensi-diklat-' . $this->tahun . '.xlsx'
        );
    }

    // ── Absensi Diklat PDF ──
    public function eksporAbsensiPdf()
    {
        $absensi = RecordAbsensiDiklat::with(['user', 'diklat'])
            ->whereYear('date', $this->tahun)
            ->when($this->bulan, fn($q) => $q->whereMonth('date', $this->bulan))
            ->when($this->unit,  fn($q) => $q->whereHas('user', fn($u) => $u->where('unit', $this->unit)))
            ->orderBy('date', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf-absensi', [
            'absensi' => $absensi,
            'tahun'   => $this->tahun,
            'bulan'   => $this->bulan,
            'unit'    => $this->unit,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'absensi-diklat-' . $this->tahun . '.pdf'
        );
    }

    // ── Laporan Eksternal Excel ──
    public function eksporEksternalExcel()
    {
        $query = DetailEksternal::with(['user'])
            ->whereIn('jenis', ['pkl', 'magang', 'orientasi'])
            ->when($this->jenisEksternal !== 'semua', fn($q) => $q->where('jenis', $this->jenisEksternal));

        if ($this->bulanEksternal) {
            $query->where(function ($q) {
                $q->whereMonth('tanggal_mulai', $this->bulanEksternal)
                  ->orWhereMonth('tanggal_selesai', $this->bulanEksternal);
            });
        }

        $query->whereYear('tanggal_mulai', $this->tahunEksternal);
        $data = $query->get();

        $rows = collect();

        $rows->push(['LAPORAN PESERTA EKSTERNAL', null, null, null, null, null, null, null, null]);
        $rows->push(['Periode: Tahun ' . $this->tahunEksternal]);
        $rows->push(['Jenis: ' . ($this->jenisEksternal === 'semua' ? 'Semua' : ucfirst($this->jenisEksternal))]);
        $rows->push(['Dicetak: ' . now()->format('d F Y, H:i') . ' WIB']);
        $rows->push([null]);
        $rows->push(['RINGKASAN', null, null, null]);
        $rows->push(['Total Peserta', 'PKL', 'Magang', 'Orientasi']);
        $rows->push([
            $data->count(),
            $data->where('jenis', 'pkl')->count(),
            $data->where('jenis', 'magang')->count(),
            $data->where('jenis', 'orientasi')->count(),
        ]);
        $rows->push([null]);
        $rows->push(['DATA IDENTITAS & PERIODE PESERTA', null, null, null, null, null, null, null, null]);
        $rows->push(['No', 'Nama', 'Email', 'Jenis', 'Institusi', 'Tgl Mulai', 'Tgl Selesai', 'Durasi', 'Status']);

        foreach ($data as $i => $detail) {
            $mulai   = $detail->tanggal_mulai   ? \Carbon\Carbon::parse($detail->tanggal_mulai)   : null;
            $selesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai) : null;
            $durasi  = ($mulai && $selesai) ? $mulai->diffInDays($selesai) . ' hari' : '-';
            $status  = !$mulai ? '-'
                : (now()->lt($mulai) ? 'Belum Mulai'
                : ($selesai && now()->gt($selesai) ? 'Selesai' : 'Aktif'));

            $rows->push([
                $i + 1,
                $detail->user?->nama ?? '-',
                $detail->user?->email ?? '-',
                ucfirst($detail->jenis ?? '-'),
                $detail->institusi ?? '-',
                $mulai?->format('d M Y') ?? '-',
                $selesai?->format('d M Y') ?? '-',
                $durasi,
                $status,
            ]);
        }

        return Excel::download(
            new class($rows) implements
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithStyles,
                \Maatwebsite\Excel\Concerns\ShouldAutoSize
            {
                public function __construct(private $rows) {}
                public function collection() { return $this->rows; }
                public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
                {
                    $sheet->getStyle(1)->getFont()->setBold(true)->setSize(12);
                    $sheet->getStyle(10)->getFont()->setBold(true);
                    $sheet->getStyle(10)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF374151');
                    $sheet->getStyle(10)->getFont()->getColor()->setARGB('FFFFFFFF');
                }
            },
            'laporan-eksternal-' . $this->tahunEksternal . '.xlsx'
        );
    }

    // ── Laporan Eksternal PDF ──
    public function eksporEksternalPdf()
    {
        $query = DetailEksternal::with(['user'])
            ->whereIn('jenis', ['pkl', 'magang', 'orientasi'])
            ->when($this->jenisEksternal !== 'semua', fn($q) => $q->where('jenis', $this->jenisEksternal));

        if ($this->bulanEksternal) {
            $query->where(function ($q) {
                $q->whereMonth('tanggal_mulai', $this->bulanEksternal)
                  ->orWhereMonth('tanggal_selesai', $this->bulanEksternal);
            });
        }

        $query->whereYear('tanggal_mulai', $this->tahunEksternal);
        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf-eksternal', [
            'data'  => $data,
            'tahun' => $this->tahunEksternal,
            'bulan' => $this->bulanEksternal,
            'jenis' => $this->jenisEksternal,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-eksternal-' . $this->tahunEksternal . '.pdf'
        );
    }

    // ── Laporan E-Learning Excel ──
    public function eksporElearningExcel()
    {
        $progress = ElearningProgress::with(['user', 'modul'])
            ->whereYear('updated_at', $this->tahunElearning)
            ->when($this->statusElearning !== 'semua', fn($q) => $q->where('status', $this->statusElearning))
            ->orderBy('updated_at', 'desc')
            ->get();

        $rows = collect();
        $rows->push(['LAPORAN E-LEARNING', null, null, null, null, null]);
        $rows->push(['Tahun: ' . $this->tahunElearning]);
        $rows->push(['Status: ' . ($this->statusElearning === 'semua' ? 'Semua' : ucfirst($this->statusElearning))]);
        $rows->push(['Dicetak: ' . now()->format('d F Y, H:i') . ' WIB']);
        $rows->push([null]);
        $rows->push(['RINGKASAN', null, null, null]);
        $rows->push(['Total Progress', 'Selesai', 'Berlangsung', 'Gagal']);
        $rows->push([
            $progress->count(),
            $progress->where('status', 'completed')->count(),
            $progress->where('status', 'in_progress')->count(),
            $progress->where('status', 'failed')->count(),
        ]);
        $rows->push([null]);
        $rows->push(['No', 'Nama', 'Email', 'Modul', 'Kategori', 'Status', 'Nilai', 'Jam', 'Selesai']);

        foreach ($progress as $i => $p) {
            $rows->push([
                $i + 1,
                $p->user?->nama ?? '-',
                $p->user?->email ?? '-',
                $p->modul?->judul ?? '-',
                $p->modul?->kategori ?? '-',
                $p->status === 'completed' ? 'Selesai' : ($p->status === 'in_progress' ? 'Berlangsung' : 'Gagal'),
                $p->quiz_score ?? '-',
                $p->jam_dikontribusikan ? $p->jam_dikontribusikan . ' jam' : '-',
                $p->completed_at ? \Carbon\Carbon::parse($p->completed_at)->format('d M Y') : '-',
            ]);
        }

        return Excel::download(
            new class($rows) implements
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithStyles,
                \Maatwebsite\Excel\Concerns\ShouldAutoSize
            {
                public function __construct(private $rows) {}
                public function collection() { return $this->rows; }
                public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
                {
                    $sheet->getStyle(1)->getFont()->setBold(true)->setSize(12);
                    $sheet->getStyle(10)->getFont()->setBold(true);
                    $sheet->getStyle(10)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF7C3AED');
                    $sheet->getStyle(10)->getFont()->getColor()->setARGB('FFFFFFFF');
                }
            },
            'laporan-elearning-' . $this->tahunElearning . '.xlsx'
        );
    }

    // ── Laporan E-Learning PDF ──
    public function eksporElearningPdf()
    {
        $progress = ElearningProgress::with(['user', 'modul'])
            ->whereYear('updated_at', $this->tahunElearning)
            ->when($this->statusElearning !== 'semua', fn($q) => $q->where('status', $this->statusElearning))
            ->orderBy('updated_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf-elearning', [
            'progress' => $progress,
            'tahun'    => $this->tahunElearning,
            'status'   => $this->statusElearning,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'laporan-elearning-' . $this->tahunElearning . '.pdf'
        );
    }

    public function render()
    {
        $units = MUnit::orderBy('nama')->get();

        $karyawanJenis = [
            'karyawan_iss', 'karyawan_bss', 'karyawan_adidaya',
            'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa',
        ];

        $totalAcara      = MDiklat::whereYear('created_at', $this->tahun)->count();
        $totalAbsensi    = RecordAbsensiDiklat::whereYear('date', $this->tahun)->count();
        $totalKaryawan   = User::where('type', 'internal')->where('isActive', 1)->count();
        $totalKaryawanExt = User::where('type', 'external')
            ->whereHas('detailEksternal', fn($d) =>
                $d->whereIn('jenis', $karyawanJenis)->where('approval_status', 'approved')
            )->where('isActive', 1)->count();
        $totalElearning  = ElearningProgress::whereYear('updated_at', $this->tahun)->count();
        $totalCompleted  = ElearningProgress::whereYear('updated_at', $this->tahun)->where('status', 'completed')->count();

        return view('livewire.admin.laporan.laporan-index', compact(
            'units', 'totalAcara', 'totalAbsensi', 'totalKaryawan',
            'totalKaryawanExt', 'totalElearning', 'totalCompleted'
        ));
    }
}