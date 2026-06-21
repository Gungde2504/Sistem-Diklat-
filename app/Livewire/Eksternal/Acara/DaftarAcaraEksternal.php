<?php

namespace App\Livewire\Eksternal\Acara;

use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Daftar Acara')]
class DaftarAcaraEksternal extends Component
{
    use WithPagination;

    public string $tab    = 'tersedia';
    public string $search = '';
    public string $jenis  = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingTab(): void    { $this->resetPage(); }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function daftar(int $diklatId): void
    {
        $user   = auth()->user();
        $diklat = MDiklat::findOrFail($diklatId);

        if ($diklat->sudahPenuh()) {
            session()->flash('error', 'Kuota acara sudah penuh.');
            return;
        }

        $sudah = RecordAbsensiDiklat::where('id_user', $user->id)
            ->where('id_diklat', $diklatId)
            ->exists();

        if ($sudah) {
            session()->flash('error', 'Anda sudah terdaftar di acara ini.');
            return;
        }

        // Daftar saja — belum absen (is_hadir false, durasi 0)
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
            ->paginate(8);

        $terdaftarIds = RecordAbsensiDiklat::where('id_user', $userId)
            ->pluck('id_diklat')
            ->toArray();

        $acaraTerdaftar = RecordAbsensiDiklat::with('diklat')
            ->where('id_user', $userId)
            ->whereHas('diklat')
            ->orderByDesc('created_at')
            ->paginate(8, ['*'], 'terdaftar_page');

        $totalTerdaftar = RecordAbsensiDiklat::where('id_user', $userId)->count();

        return view('livewire.eksternal.acara.daftar-acara-eksternal', compact(
            'acaras', 'terdaftarIds', 'acaraTerdaftar', 'totalTerdaftar'
        ));
    }
}