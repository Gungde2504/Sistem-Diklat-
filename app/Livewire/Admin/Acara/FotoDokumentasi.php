<?php

namespace App\Livewire\Admin\Acara;

use App\Models\MDiklat;
use App\Models\MFileDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Title('Foto Dokumentasi')]
class FotoDokumentasi extends Component
{
    use WithFileUploads;

    public MDiklat $diklat;
    public $uploadFotos = [];
    public string $keterangan = '';

    public function mount(MDiklat $diklat): void
    {
        $this->diklat = $diklat;
    }

    public function updatedUploadFotos(): void
    {
        // Pastikan selalu array
        if (!is_array($this->uploadFotos)) {
            $this->uploadFotos = [$this->uploadFotos];
        }
    }

    public function upload(): void
    {
        // Normalize ke array jika single file
        if (!is_array($this->uploadFotos)) {
            $this->uploadFotos = [$this->uploadFotos];
        }

        $this->validate([
            'uploadFotos'   => 'required|array|min:1',
            'uploadFotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $folder = 'dokumentasi/' . $this->diklat->id;
        $count  = 0;

        foreach ($this->uploadFotos as $foto) {
            if (!$foto) continue;

            $path = $foto->store($folder, 'public');

            MFileDiklat::create([
                'id_diklat'  => $this->diklat->id,
                'file'       => $path,
                'type'       => 'foto',
                'created_by' => auth()->id(),
            ]);

            $count++;
        }

        $this->reset('uploadFotos', 'keterangan');
        session()->flash('success', "{$count} foto berhasil diupload.");
    }

    public function hapusFoto(int $id): void
    {
        $foto = MFileDiklat::where('id_diklat', $this->diklat->id)
            ->where('type', 'foto')
            ->findOrFail($id);

        Storage::disk('public')->delete($foto->file);
        $foto->delete();

        session()->flash('success', 'Foto berhasil dihapus.');
    }

    public function render()
    {
        $galeri = MFileDiklat::where('id_diklat', $this->diklat->id)
            ->where('type', 'foto')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.admin.acara.foto-dokumentasi', compact('galeri'));
    }
}