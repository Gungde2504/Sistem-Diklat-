<?php

namespace App\Livewire\Admin\Elearning;

use App\Models\ElearningModule;
use App\Models\ElearningQuiz;
use App\Models\MUnit;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Title('Edit Modul E-Learning')]
class ModulEdit extends Component
{
    use WithFileUploads;

    public ElearningModule $modul;

    public string $judul              = '';
    public string $deskripsi          = '';
    public string $konten             = '';
    public string $kategori           = '';
    public string $link_video         = '';
    public float  $estimasi_durasi_jam = 1;
    public ?float $min_quiz_score     = null;
    public string $id_target_unit     = '';
    public bool   $publish            = false;
    public bool   $ada_kuis           = false;
    public $file  = null;

    public array $soal = [];

    public function mount(ElearningModule $modul): void
    {
        $this->modul               = $modul;
        $this->judul               = $modul->judul;
        $this->deskripsi           = $modul->deskripsi ?? '';
        $this->konten              = $modul->konten ?? '';
        $this->kategori            = $modul->kategori ?? '';
        $this->link_video          = $modul->link_video ?? '';
        $this->estimasi_durasi_jam = $modul->estimasi_durasi_jam;
        $this->min_quiz_score      = $modul->min_quiz_score;
        $this->id_target_unit      = $modul->id_target_unit ?? '';
        $this->publish             = $modul->publish;
        $this->ada_kuis            = $modul->adaKuis();

        $this->soal = $modul->quizzes->map(fn($q) => [
            'id'            => $q->id,
            'pertanyaan'    => $q->pertanyaan,
            'pilihan_a'     => $q->pilihan_a,
            'pilihan_b'     => $q->pilihan_b,
            'pilihan_c'     => $q->pilihan_c ?? '',
            'pilihan_d'     => $q->pilihan_d ?? '',
            'jawaban_benar' => $q->jawaban_benar,
        ])->toArray();

        if (empty($this->soal)) {
            $this->tambahSoal();
        }
    }

    public function tambahSoal(): void
    {
        $this->soal[] = [
            'id'            => null,
            'pertanyaan'    => '',
            'pilihan_a'     => '',
            'pilihan_b'     => '',
            'pilihan_c'     => '',
            'pilihan_d'     => '',
            'jawaban_benar' => 'a',
        ];
    }

    public function hapusSoal(int $index): void
    {
        if (!empty($this->soal[$index]['id'])) {
            ElearningQuiz::find($this->soal[$index]['id'])?->delete();
        }
        unset($this->soal[$index]);
        $this->soal = array_values($this->soal);
    }

    public function hapusFile(): void
    {
        if ($this->modul->file_path) {
            Storage::disk('public')->delete($this->modul->file_path);
            $this->modul->update(['file_path' => null]);
            $this->file = null;
            $this->modul->refresh();
            session()->flash('success', 'File materi berhasil dihapus.');
        }
    }

    public function simpan(): void
    {
        $this->validate([
            'judul'               => 'required|string|max:200',
            'estimasi_durasi_jam' => 'required|numeric|min:0.5',
            'file'                => 'nullable|file|max:20480',
        ]);

        $filePath = $this->modul->file_path;
        if ($this->file) {
            // Hapus file lama jika ada
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $this->file->store('elearning/files', 'public');
        }

        $this->modul->update([
            'judul'               => $this->judul,
            'deskripsi'           => $this->deskripsi,
            'konten'              => $this->konten,
            'kategori'            => $this->kategori,
            'link_video'          => $this->link_video,
            'estimasi_durasi_jam' => $this->estimasi_durasi_jam,
            'min_quiz_score'      => $this->ada_kuis ? $this->min_quiz_score : null,
            'id_target_unit'      => $this->id_target_unit ?: null,
            'publish'             => $this->publish,
            'file_path'           => $filePath,
        ]);

        if ($this->ada_kuis) {
            $existingIds = collect($this->soal)->pluck('id')->filter()->toArray();
            ElearningQuiz::where('id_modul', $this->modul->id)
                ->whereNotIn('id', $existingIds)
                ->delete();

            foreach ($this->soal as $s) {
                if (empty($s['pertanyaan'])) continue;

                ElearningQuiz::updateOrCreate(
                    ['id' => $s['id'] ?? null, 'id_modul' => $this->modul->id],
                    [
                        'id_modul'      => $this->modul->id,
                        'pertanyaan'    => $s['pertanyaan'],
                        'pilihan_a'     => $s['pilihan_a'],
                        'pilihan_b'     => $s['pilihan_b'],
                        'pilihan_c'     => $s['pilihan_c'] ?: null,
                        'pilihan_d'     => $s['pilihan_d'] ?: null,
                        'jawaban_benar' => $s['jawaban_benar'],
                    ]
                );
            }
        } else {
            ElearningQuiz::where('id_modul', $this->modul->id)->delete();
        }

        session()->flash('success', 'Modul berhasil diupdate.');
        $this->redirect(route('admin.elearning.index'));
    }

    public function render()
    {
        $units = MUnit::orderBy('nama')->get();
        return view('livewire.admin.e-learning.modul-edit', compact('units'));
    }
}