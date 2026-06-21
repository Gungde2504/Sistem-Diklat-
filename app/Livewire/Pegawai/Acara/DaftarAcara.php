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
        if ($diklat->sudahPenuh()) {
            session()->flash('error', 'Kuota acara sudah penuh.');
            return;
        }

        // Cek sudah terdaftar
        $sudah = RecordAbsensiDiklat::where('id_user', $user->id)
            ->where('id_diklat', $diklatId)
            ->exists();

        if ($sudah) {
            session()->flash('error', 'Anda sudah terdaftar di acara ini.');
            return;
        }

        // Daftar saja — belum absen (durasi 0, is_hadir false)
        RecordAbsensiDiklat::create([
            'id_user'     => $user->id,
            'id_diklat'   => $diklatId,
            'namaPeserta' => $user->nama,
            'durasi'      => 0,
            'date'        => now()->toDateString(),
            'is_hadir'    => false,
        ]);

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