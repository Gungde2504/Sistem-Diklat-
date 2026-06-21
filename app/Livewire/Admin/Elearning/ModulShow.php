<?php

namespace App\Livewire\Admin\Elearning;

use App\Models\ElearningModule;
use App\Models\ElearningProgress;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Detail Modul E-Learning')]
class ModulShow extends Component
{
    use WithPagination;

    public ElearningModule $modul;
    public string $tab = 'peserta';

    public function mount(ElearningModule $modul): void
    {
        $this->modul = $modul;
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $peserta = ElearningProgress::with('user')
            ->where('id_modul', $this->modul->id)
            ->orderByDesc('updated_at')
            ->paginate(15);

        $totalSelesai    = ElearningProgress::where('id_modul', $this->modul->id)->where('status', 'completed')->count();
        $totalProgress   = ElearningProgress::where('id_modul', $this->modul->id)->where('status', 'in_progress')->count();
        $totalGagal      = ElearningProgress::where('id_modul', $this->modul->id)->where('status', 'failed')->count();
        $rataRataNilai   = ElearningProgress::where('id_modul', $this->modul->id)->whereNotNull('quiz_score')->avg('quiz_score');
        $soals           = $this->modul->quizzes()->get();

        return view('livewire.admin.e-learning.modul-show', compact(
            'peserta', 'totalSelesai', 'totalProgress', 'totalGagal', 'rataRataNilai', 'soals'
        ));
    }
}