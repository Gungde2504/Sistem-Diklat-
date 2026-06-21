<?php

namespace App\Livewire\Admin\Acara;

use App\Actions\Event\UpdateEventAction;
use App\DTOs\EventDTO;
use App\Models\MDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

#[Title('Edit Acara')]
class AcaraEdit extends Component
{
    use WithFileUploads;

    public MDiklat $diklat;

    #[Validate('required|string|max:255')]
    public string $nama = '';

    #[Validate('required|in:Diklat Internal,Diklat Eksternal,Seminar')]
    public string $jenisDiklat = '';

    #[Validate('required|string|max:255')]
    public string $namaNarasumber = '';

    #[Validate('required|string|max:255')]
    public string $tempat = '';

    #[Validate('required|string')]
    public string $tglJamMulai = '';

    #[Validate('required|string')]
    public string $tglJamSelesai = '';

    #[Validate('required|integer|min:1')]
    public int $durasi = 1;

    #[Validate('required|integer|min:1')]
    public int $kuota = 30;

    #[Validate('nullable|string')]
    public string $deskripsi = '';

    #[Validate('nullable|url')]
    public string $linkPretest = '';

    #[Validate('nullable|url')]
    public string $linkPosttest = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $img = null;

    public string $imgExisting = '';
    public int    $publish     = 0;
    public bool   $berhasil    = false;

    public function mount(MDiklat $diklat): void
    {
        $this->diklat         = $diklat;
        $this->nama           = $diklat->nama;
        $this->jenisDiklat    = $diklat->jenisDiklat;
        $this->namaNarasumber = $diklat->namaNarasumber;
        $this->tempat         = $diklat->tempat;
        $this->tglJamMulai    = $diklat->tglJamMulai;
        $this->tglJamSelesai  = $diklat->tglJamSelesai;
        $this->durasi         = (int) $diklat->durasi;
        $this->kuota          = (int) $diklat->kuota;
        $this->deskripsi      = $diklat->deskripsi   ?? '';
        $this->linkPretest    = $diklat->linkPretest  ?? '';
        $this->linkPosttest   = $diklat->linkPosttest ?? '';
        $this->publish        = (int) $diklat->publish;
        $this->imgExisting    = $diklat->img          ?? '';
    }

    private function hitungStatus(): string
    {
        if (!$this->tglJamMulai || !$this->tglJamSelesai) {
            return 'Draft';
        }

        if (!$this->publish) {
            return 'Draft';
        }

        $now     = now();
        $mulai   = \Carbon\Carbon::parse($this->tglJamMulai);
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
        Log::info('updatedImg called', ['img' => $this->img]);
    }

    public function simpanSampul(): void
    {
        Log::info('simpanSampul called', [
            'img'         => $this->img,
            'imgExisting' => $this->imgExisting,
        ]);

        if (!$this->img) return;

        $this->validateOnly('img');

        if ($this->imgExisting) {
            Storage::disk('public')->delete($this->imgExisting);
        }

        $imgPath = $this->img->store('sampul', 'public');
        $this->diklat->update(['img' => $imgPath]);
        $this->imgExisting = $imgPath;
        $this->img         = null;

        Log::info('sampul saved', ['path' => $imgPath]);
    }

    public function hapusSampul(): void
    {
        if ($this->imgExisting) {
            Storage::disk('public')->delete($this->imgExisting);
            $this->diklat->update(['img' => null]);
            $this->imgExisting = '';
        }
    }

    public function save(): void
    {
        $this->validate();

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
            'img'            => $this->imgExisting ?: null,
        ]);

        app(UpdateEventAction::class)->execute($this->diklat, $dto);

        $this->img      = null;
        $this->berhasil = true;
    }

    public function render()
    {
        return view('livewire.admin.acara.acara-edit');
    }
}