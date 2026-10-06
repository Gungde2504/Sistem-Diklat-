<?php

namespace App\Livewire\Admin\Acara;

use App\Models\MDiklat;
use App\Models\MFileDiklat;
use App\Models\RecordAbsensiDiklat;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Title('Detail Acara')]
class AcaraDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    public MDiklat $diklat;
    public string $searchPeserta = '';
    public string $tab = 'peserta'; // peserta | materi | sertifikat
    public $materiFile = [];

    public function mount(MDiklat $diklat): void
    {
        $this->diklat = $diklat;
    }

    public function toggleQr(): void
    {
        $this->diklat->update(['IsActive' => !$this->diklat->IsActive]);
        $this->diklat->refresh();
    }

    public function hapusPeserta(int $id): void
    {
        RecordAbsensiDiklat::findOrFail($id)->delete();
        session()->flash('success', 'Peserta berhasil dihapus.');
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function updatedMateriFile(): void
    {
        // Bersihkan pesan error lama (mis. dari percobaan upload sebelumnya
        // tanpa memilih file) begitu user memilih file baru.
        $this->resetErrorBag('materiFile');
        $this->resetErrorBag('materiFile.*');
    }

    public function uploadMateri(): void
    {
        $this->validate([
            'materiFile'   => 'required|array|min:1',
            'materiFile.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480',
        ]);

        foreach ($this->materiFile as $file) {
            $path = $file->store('materi/' . $this->diklat->id, 'public');

            MFileDiklat::create([
                'id_diklat'  => $this->diklat->id,
                'file'       => $path,
                'type'       => 'materi',
                'created_by' => auth()->id(),
            ]);
        }

        $jumlah = count($this->materiFile);
        $this->materiFile = [];
        session()->flash('success', $jumlah > 1 ? "{$jumlah} materi berhasil diupload." : 'Materi berhasil diupload.');
    }

    public function hapusMateri(int $id): void
    {
        $materi = MFileDiklat::where('id_diklat', $this->diklat->id)
            ->where('type', 'materi')
            ->findOrFail($id);

        Storage::disk('public')->delete($materi->file);
        $materi->delete();
        session()->flash('success', 'Materi berhasil dihapus.');
    }

    public function render()
    {
        $peserta = RecordAbsensiDiklat::with('user')
            ->where('id_diklat', $this->diklat->id)
            ->when($this->searchPeserta, fn($q) =>
                $q->where('namaPeserta', 'like', '%'.$this->searchPeserta.'%')
            )
            ->paginate(10);

        $allUsers = User::where('type', 'internal')
            ->where('isActive', 1)
            ->whereNotIn('id', RecordAbsensiDiklat::where('id_diklat', $this->diklat->id)->pluck('id_user'))
            ->get();

        return view('livewire.admin.acara.acara-detail', [
            'peserta'  => $peserta,
            'allUsers' => $allUsers,
        ]);
    }
}