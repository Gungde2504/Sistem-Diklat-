<?php

namespace App\Livewire\Pegawai\Elearning;

use App\Models\ElearningModule;
use App\Models\ElearningProgress;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('E-Learning')]
class ElearningIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'semua'; // semua | belum | selesai

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = auth()->id();

        // Daftar modul tidak lagi dibatasi/difilter berdasarkan unit sama sekali.
        $moduls = ElearningModule::published()
            ->when(
                $this->search,
                fn($q) =>
                $q->where(function ($sub) {
                    $sub->where('judul', 'like', '%' . $this->search . '%')
                        ->orWhere('kategori', 'like', '%' . $this->search . '%');
                })
            )
            ->withCount('quizzes')
            ->orderByDesc('created_at')
            ->get();

        // Ambil progress user
        $progressMap = ElearningProgress::where('id_user', $userId)
            ->pluck('status', 'id_modul')
            ->toArray();

        // Filter
        if ($this->filter === 'belum') {
            $moduls = $moduls->filter(fn($m) => !isset($progressMap[$m->id]));
        } elseif ($this->filter === 'selesai') {
            $moduls = $moduls->filter(fn($m) => ($progressMap[$m->id] ?? '') === 'completed');
        }

        $totalModul    = ElearningModule::published()->count();
        $totalSelesai  = ElearningProgress::where('id_user', $userId)->where('status', 'completed')->count();
        $totalProgress = ElearningProgress::where('id_user', $userId)->where('status', 'in_progress')->count();

        return view('livewire.pegawai.e-learning.elearning-index', compact(
            'moduls',
            'progressMap',
            'totalModul',
            'totalSelesai',
            'totalProgress'
        ));
    }
}
