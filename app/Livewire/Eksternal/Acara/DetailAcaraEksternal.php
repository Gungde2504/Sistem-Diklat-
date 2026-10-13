<?php

namespace App\Livewire\Eksternal\Acara;

use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Acara')]
class DetailAcaraEksternal extends Component
{
    public MDiklat $diklat;
    public bool $sudahTerdaftar = false;
    public bool $sudahPenuh     = false;

    public function mount(MDiklat $diklat): void
    {
        $this->diklat = $diklat;

        $this->sudahTerdaftar = RecordAbsensiDiklat::where('id_user', auth()->id())
            ->where('id_diklat', $diklat->id)
            ->exists();

        $this->sudahPenuh = $diklat->sudahPenuh();
    }

    public function daftar(): void
    {
        $user   = auth()->user();
        $diklat = $this->diklat->fresh();

        $hasil = $diklat->daftarkanPeserta($user);

        if ($hasil === 'penuh') {
            $this->sudahPenuh = true;
            session()->flash('error', $diklat->pesanPenuh());
            return;
        }
        if ($hasil === 'sudah') {
            $this->sudahTerdaftar = true;
            session()->flash('error', 'Anda sudah terdaftar di acara ini.');
            return;
        }

        $this->sudahTerdaftar = true;
        session()->flash('success', 'Berhasil mendaftar ke acara ' . $diklat->nama);
    }

    public function render()
    {
        return view('livewire.eksternal.acara.detail-acara-eksternal');
    }
}