<?php

namespace App\Livewire\Admin\Acara;

use App\Actions\Event\CreateEventAction;
use App\DTOs\EventDTO;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('Tambah Acara')]
class AcaraCreate extends Component
{
    use WithFileUploads;

    public string $nama           = '';
    public string $jenisDiklat    = '';
    public string $namaNarasumber = '';
    public string $tempat         = '';
    public string $tglJamMulai   = '';
    public string $tglJamSelesai  = '';
    public int    $durasi         = 1;
    public int    $kuota          = 30;
    public string $deskripsi      = '';
    public string $linkPretest    = '';
    public string $linkPosttest   = '';
    public $img                   = null;
    public int    $publish        = 0;
    public bool   $berhasil       = false;

    protected function rules(): array
    {
        return [
            'nama'           => 'required|string|max:255',
            'jenisDiklat'    => 'required|in:Diklat Internal,Diklat Eksternal,Seminar',
            'namaNarasumber' => 'required|string|max:255',
            'tempat'         => 'required|string|max:255',
            'tglJamMulai'    => 'required|string',
            'tglJamSelesai'  => 'required|string',
            'durasi'         => 'required|integer|min:1',
            'kuota'          => 'required|integer|min:1',
            'deskripsi'      => 'nullable|string',
            'linkPretest'    => 'nullable|url',
            'linkPosttest'   => 'nullable|url',
            'img'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function hitungStatus(): string
    {
        if (!$this->tglJamMulai || !$this->tglJamSelesai) {
            return 'Draft';
        }

        if (!$this->publish) {
            return 'Draft';
        }

        $now    = now();
        $mulai  = \Carbon\Carbon::parse($this->tglJamMulai);
        $selesai = \Carbon\Carbon::parse($this->tglJamSelesai);

        if ($now->lt($mulai)) {
            return 'Terbuka';
        } elseif ($now->between($mulai, $selesai)) {
            return 'Berlangsung';
        } else {
            return 'Selesai';
        }
    }

    public function updatedImg(): void
    {
        $this->validateOnly('img');
    }

    public function save(): void
    {
        $this->validate();

        $imgPath = null;
        if ($this->img) {
            $imgPath = $this->img->store('sampul', 'public');
        }

        $dto = EventDTO::fromArray([
            'nama'           => $this->nama,
            'jenisDiklat'    => $this->jenisDiklat,
            'namaNarasumber' => $this->namaNarasumber,
            'tempat'         => $this->tempat,
            'tglJamMulai'    => $this->tglJamMulai,
            'tglJamSelesai'  => $this->tglJamSelesai,
            'durasi'         => $this->durasi,
            'kuota'          => $this->kuota,
            'deskripsi'      => $this->deskripsi,
            'linkPretest'    => $this->linkPretest  ?: null,
            'linkPosttest'   => $this->linkPosttest ?: null,
            'publish'        => $this->publish,
            'status'         => $this->hitungStatus(),
            'img'            => $imgPath,
        ]);

        app(CreateEventAction::class)->execute($dto);

        $this->berhasil = true;
        $this->reset([
            'nama', 'jenisDiklat', 'namaNarasumber', 'tempat',
            'tglJamMulai', 'tglJamSelesai', 'durasi', 'kuota',
            'deskripsi', 'linkPretest', 'linkPosttest', 'img',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.acara.acara-create');
    }
}