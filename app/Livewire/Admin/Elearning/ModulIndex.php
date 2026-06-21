<?php

namespace App\Livewire\Admin\Elearning;

use App\Models\ElearningModule;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Manajemen E-Learning')]
class ModulIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function togglePublish(int $id): void
    {
        $modul = ElearningModule::findOrFail($id);
        $modul->update(['publish' => !$modul->publish]);
    }

    public function hapus(int $id): void
    {
        ElearningModule::findOrFail($id)->delete();
        session()->flash('success', 'Modul berhasil dihapus.');
    }

    public function render()
    {
        $moduls = ElearningModule::withCount('progress')
            ->when($this->search, fn($q) =>
                $q->where('judul', 'like', '%'.$this->search.'%')
                  ->orWhere('kategori', 'like', '%'.$this->search.'%')
            )
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.admin.e-learning.modul-index', compact('moduls'));
    }
}