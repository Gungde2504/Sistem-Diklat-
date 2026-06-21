<?php

namespace App\Livewire\Admin\Peserta;

use App\Models\DetailEksternal;
use App\Models\JurnalEksternal;
use Livewire\Component;
use Livewire\WithPagination;

class JurnalPeserta extends Component
{
    use WithPagination;

    public DetailEksternal $detail;
    public string $filterBulan = '';
    public string $filterTahun = '';

    public function mount(DetailEksternal $detail): void
    {
        $this->detail      = $detail;
        $this->filterBulan = (string) now()->month;
        $this->filterTahun = (string) now()->year;
    }

    public function updatingFilterBulan(): void { $this->resetPage(); }
    public function updatingFilterTahun(): void { $this->resetPage(); }

    public function render()
    {
        $jurnals = JurnalEksternal::where('id_user', $this->detail->id_user)
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->when($this->filterTahun, fn($q) => $q->whereYear('tanggal', $this->filterTahun))
            ->orderByDesc('tanggal')
            ->paginate(10);

        $totalJurnal = JurnalEksternal::where('id_user', $this->detail->id_user)->count();

        return view('livewire.admin.peserta.jurnal-peserta', compact('jurnals', 'totalJurnal'));
    }
}