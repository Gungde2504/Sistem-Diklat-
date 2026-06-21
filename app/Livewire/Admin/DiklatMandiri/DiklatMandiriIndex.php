<?php

namespace App\Livewire\Admin\DiklatMandiri;

use App\Actions\DiklatMandiri\ApproveDiklatMandiriAction;
use App\Models\DiklatMandiri;
use App\Helpers\RekapHelper;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Diklat Mandiri')]
class DiklatMandiriIndex extends Component
{
    use WithPagination;

    public string $search  = '';
    public string $status  = 'pending';
    public string $tahun   = '';

    public function mount(): void
    {
        $this->tahun = (string) now()->year;
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }

    public function approve(string $id): void
    {
        $diklat = DiklatMandiri::findOrFail($id);
        app(ApproveDiklatMandiriAction::class)->approve($diklat);
        session()->flash('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(string $id): void
    {
        $diklat = DiklatMandiri::findOrFail($id);
        app(ApproveDiklatMandiriAction::class)->reject($diklat);
        session()->flash('success', 'Pengajuan berhasil ditolak.');
    }

    public function render()
    {
        $pengajuan = DiklatMandiri::with('user')
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhereHas('user', fn($u) =>
                      $u->where('nama', 'like', '%'.$this->search.'%')
                  )
            )
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->tahun,  fn($q) => $q->whereYear('created_at', $this->tahun))
            ->latest()
            ->paginate(15);

        $totalPending   = DiklatMandiri::where('status', 'pending')->count();
        $totalDisetujui = DiklatMandiri::where('status', 'Disetujui')->whereYear('created_at', $this->tahun)->count();
        $totalDitolak   = DiklatMandiri::where('status', 'Ditolak')->whereYear('created_at', $this->tahun)->count();

        return view('livewire.admin.diklat-mandiri.diklat-mandiri-index', compact(
            'pengajuan', 'totalPending', 'totalDisetujui', 'totalDitolak'
        ));
    }
}