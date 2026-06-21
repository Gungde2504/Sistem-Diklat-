<?php

namespace App\Livewire\Admin\Acara;

use App\Models\MDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Manajemen Acara')]
class AcaraIndex extends Component
{
    use WithPagination;

    public string $search   = '';
    public string $status   = '';
    public string $jenis    = '';
    public string $sortBy   = 'created_at';
    public string $sortDir  = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function toggleQr(int $id): void
    {
        $diklat = MDiklat::findOrFail($id);
        $diklat->update(['IsActive' => !$diklat->IsActive]);
    }

    public function delete(int $id): void
    {
        MDiklat::findOrFail($id)->delete();
        session()->flash('success', 'Acara berhasil dihapus.');
    }

    public function render()
    {
        $acaras = MDiklat::query()
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('namaNarasumber', 'like', '%'.$this->search.'%')
            )
            ->when($this->status, fn($q) =>
                $q->where('status', $this->status)
            )
            ->when($this->jenis, fn($q) =>
                $q->where('jenisDiklat', $this->jenis)
            )
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        return view('livewire.admin.acara.acara-index', compact('acaras'));
    }
}