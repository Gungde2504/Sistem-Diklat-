<?php

namespace App\Livewire\Eksternal\Absensi;

use App\Models\ExternalDailyAttendance;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Rekap Kehadiran')]
class RekapKehadiran extends Component
{
    use WithPagination;

    public string $filter = 'bulan'; // semua | bulan
    public string $bulan  = '';
    public string $tahun  = '';

    public function mount(): void
    {
        $this->bulan = (string) now()->month;
        $this->tahun = (string) now()->year;
    }

    public function updatingBulan(): void  { $this->resetPage(); }
    public function updatingTahun(): void  { $this->resetPage(); }
    public function updatingFilter(): void { $this->resetPage(); }

    public function render()
    {
        $userId = auth()->id();

        $query = ExternalDailyAttendance::where('id_user', $userId)
            ->orderByDesc('tanggal');

        if ($this->filter === 'bulan') {
            $query->when($this->bulan, fn($q) => $q->whereMonth('tanggal', $this->bulan))
                  ->when($this->tahun, fn($q) => $q->whereYear('tanggal', $this->tahun));
        }

        $riwayat = $query->paginate(20);

        // Stats
        $statsQuery = ExternalDailyAttendance::where('id_user', $userId);
        if ($this->filter === 'bulan') {
            $statsQuery->whereMonth('tanggal', $this->bulan)
                       ->whereYear('tanggal', $this->tahun);
        }

        $totalHadir   = $statsQuery->count();
        $totalValid   = (clone $statsQuery)->where('is_valid', 1)->count();
        $totalInvalid = $totalHadir - $totalValid;
        $totalMenit   = $statsQuery->whereNotNull('checkout_at')->get()
            ->sum(fn($a) => \Carbon\Carbon::parse($a->checkin_at)
                ->diffInMinutes(\Carbon\Carbon::parse($a->checkout_at)));

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        }

        return view('livewire.eksternal.absensi.rekap-kehadiran', compact(
            'riwayat', 'totalHadir', 'totalValid', 'totalInvalid', 'totalMenit', 'bulanList'
        ));
    }
}