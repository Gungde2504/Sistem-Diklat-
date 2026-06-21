<?php

namespace App\Livewire\Pegawai\Elearning;

use App\Models\ElearningModule;
use App\Models\ElearningProgress;
use App\Models\ElearningQuiz;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Modul')]
class ElearningDetail extends Component
{
    public ElearningModule $modul;
    public ?ElearningProgress $progress = null;
    public string $tab = 'materi'; // materi | kuis

    // Kuis
    public array  $jawaban   = [];
    public bool   $sudahKuis = false;
    public ?float $nilaiKuis = null;
    public string $kuisMessage = '';

    public function mount(ElearningModule $modul): void
    {
        $this->modul    = $modul;
        $this->progress = ElearningProgress::where('id_user', auth()->id())
            ->where('id_modul', $modul->id)
            ->first();

        if (!$this->progress) {
            $this->progress = ElearningProgress::create([
                'id_user'    => auth()->id(),
                'id_modul'   => $modul->id,
                'started_at' => now(),
                'status'     => 'in_progress',
            ]);
        }

        $this->sudahKuis = $this->progress->status === 'completed' ||
                           $this->progress->status === 'failed';
        $this->nilaiKuis = $this->progress->quiz_score;
    }

    public function selesaiBelajar(): void
    {
        if (!$this->modul->adaKuis()) {
            $this->progress->update([
                'status'              => 'completed',
                'completed_at'        => now(),
                'jam_dikontribusikan' => $this->modul->estimasi_durasi_jam,
            ]);
            session()->flash('success', 'Selamat! Modul berhasil diselesaikan.');
            $this->progress->refresh();
        } else {
            $this->tab = 'kuis';
        }
    }

    public function submitKuis(): void
    {
        $soals  = $this->modul->quizzes;
        $benar  = 0;
        $total  = $soals->count();

        foreach ($soals as $soal) {
            if (($this->jawaban[$soal->id] ?? '') === $soal->jawaban_benar) {
                $benar++;
            }
        }

        $nilai   = $total > 0 ? round(($benar / $total) * 100, 1) : 0;
        $lulus   = $nilai >= ($this->modul->min_quiz_score ?? 70);
        $status  = $lulus ? 'completed' : 'failed';

        $this->progress->update([
            'quiz_score'          => $nilai,
            'status'              => $status,
            'completed_at'        => $lulus ? now() : null,
            'jam_dikontribusikan' => $lulus ? $this->modul->estimasi_durasi_jam : 0,
        ]);

        $this->nilaiKuis  = $nilai;
        $this->sudahKuis  = true;
        $this->kuisMessage = $lulus
            ? "🎉 Selamat! Nilai Anda {$nilai} — Lulus!"
            : "❌ Nilai Anda {$nilai} — Belum mencapai minimum {$this->modul->min_quiz_score}. Coba lagi!";

        $this->progress->refresh();
    }

    public function ulangiKuis(): void
    {
        $this->progress->update([
            'status'              => 'in_progress',
            'quiz_score'          => null,
            'completed_at'        => null,
            'jam_dikontribusikan' => 0,
        ]);

        $this->jawaban    = [];
        $this->sudahKuis  = false;
        $this->nilaiKuis  = null;
        $this->kuisMessage = '';
        $this->progress->refresh();
    }

    public function render()
    {
        $soals = $this->modul->quizzes()->get();
        return view('livewire.pegawai.e-learning.elearning-detail', compact('soals'));
    }
}