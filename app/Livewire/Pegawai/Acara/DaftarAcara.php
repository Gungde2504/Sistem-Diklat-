<?php

namespace App\Livewire\Pegawai\Acara;

use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Daftar Acara')]
class DaftarAcara extends Component
{
    use WithPagination;

    public string $search = '';
    public string $jenis  = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function daftar(int $diklatId): void
    {
        $user   = auth()->user();
        $diklat = MDiklat::findOrFail($diklatId);

        // Cek kuota
        $hasil = $diklat->daftarkanPeserta($user);

        if ($hasil === 'penuh') {
            session()->flash('error', $diklat->pesanPenuh());
            return;
        }
        if ($hasil === 'sudah') {
            session()->flash('error', 'Anda sudah terdaftar di acara ini.');
            return;
        }

        session()->flash('success', 'Berhasil mendaftar ke acara ' . $diklat->nama);
    }

    public function render()
    {
        $userId = auth()->id();

        $acaras = MDiklat::where('publish', 1)
            ->whereIn('status', ['Terbuka', 'Berlangsung'])
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('namaNarasumber', 'like', '%'.$this->search.'%')
            )
            ->when($this->jenis, fn($q) => $q->where('jenisDiklat', $this->jenis))
            ->orderBy('tglJamMulai')
            ->paginate(9);

        $terdaftar = RecordAbsensiDiklat::where('id_user', $userId)
            ->pluck('id_diklat')
            ->toArray();

        return view('livewire.pegawai.acara.daftar-acara', compact('acaras', 'terdaftar'));
    }
}