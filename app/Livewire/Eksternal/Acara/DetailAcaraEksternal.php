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
        if ($this->sudahPenuh) {
            session()->flash('error', 'Kuota acara sudah penuh.');
            return;
        }

        if ($this->sudahTerdaftar) {
            session()->flash('error', 'Anda sudah terdaftar di acara ini.');
            return;
        }

        RecordAbsensiDiklat::create([
            'id_user'     => auth()->id(),
            'id_diklat'   => $this->diklat->id,
            'namaPeserta' => auth()->user()->nama,
            'durasi'      => 0,
            'date'        => now()->toDateString(),
            'is_hadir'    => false,
        ]);

        $this->sudahTerdaftar = true;
        session()->flash('success', 'Berhasil mendaftar ke acara ' . $this->diklat->nama);
    }

    public function render()
    {
        return view('livewire.eksternal.acara.detail-acara-eksternal');
    }
}