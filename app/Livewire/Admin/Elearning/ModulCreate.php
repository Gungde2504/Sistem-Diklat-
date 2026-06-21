<?php

namespace App\Livewire\Admin\Elearning;

use App\Models\ElearningModule;
use App\Models\ElearningQuiz;
use App\Models\MUnit;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('Tambah Modul E-Learning')]
class ModulCreate extends Component
{
    use WithFileUploads;

    public string $judul             = '';
    public string $deskripsi         = '';
    public string $konten            = '';
    public string $kategori          = '';
    public string $link_video        = '';
    public float  $estimasi_durasi_jam = 1;
    public ?float $min_quiz_score    = null;
    public string $id_target_unit    = '';
    public bool   $publish           = false;
    public bool   $ada_kuis          = false;
    public $file  = null;

    // Quiz questions
    public array $soal = [];

    public function mount(): void
    {
        $this->tambahSoal();
    }

    public function tambahSoal(): void
    {
        $this->soal[] = [
            'pertanyaan'   => '',
            'pilihan_a'    => '',
            'pilihan_b'    => '',
            'pilihan_c'    => '',
            'pilihan_d'    => '',
            'jawaban_benar' => 'a',
        ];
    }

    public function hapusSoal(int $index): void
    {
        unset($this->soal[$index]);
        $this->soal = array_values($this->soal);
    }

    public function simpan(): void
    {
        $this->validate([
            'judul'              => 'required|string|max:200',
            'estimasi_durasi_jam' => 'required|numeric|min:0.5',
            'file'               => 'nullable|file|max:20480',
        ]);

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('elearning/files', 'public');
        }

        $modul = ElearningModule::create([
            'judul'              => $this->judul,
            'deskripsi'          => $this->deskripsi,
            'konten'             => $this->konten,
            'kategori'           => $this->kategori,
            'link_video'         => $this->link_video,
            'estimasi_durasi_jam' => $this->estimasi_durasi_jam,
            'min_quiz_score'     => $this->ada_kuis ? $this->min_quiz_score : null,
            'id_target_unit'     => $this->id_target_unit ?: null,
            'publish'            => $this->publish,
            'file_path'          => $filePath,
            'created_by'         => auth()->id(),
        ]);

        if ($this->ada_kuis) {
            foreach ($this->soal as $s) {
                if (!empty($s['pertanyaan'])) {
                    ElearningQuiz::create([
                        'id_modul'     => $modul->id,
                        'pertanyaan'   => $s['pertanyaan'],
                        'pilihan_a'    => $s['pilihan_a'],
                        'pilihan_b'    => $s['pilihan_b'],
                        'pilihan_c'    => $s['pilihan_c'] ?: null,
                        'pilihan_d'    => $s['pilihan_d'] ?: null,
                        'jawaban_benar' => $s['jawaban_benar'],
                    ]);
                }
            }
        }

        session()->flash('success', 'Modul berhasil ditambahkan.');
        $this->redirect(route('admin.elearning.index'));
    }

    public function render()
    {
        $units = MUnit::orderBy('nama')->get();
        return view('livewire.admin.e-learning.modul-create', compact('units'));
    }
}