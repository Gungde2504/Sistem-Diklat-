<?php

namespace App\Livewire\Pegawai\Acara;

use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Acara')]
class DetailAcara extends Component
{
    public MDiklat $diklat;
    public bool $sudahTerdaftar = false;
    public bool $sudahPenuh    = false;

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
        $user = auth()->user();

        if ($this->sudahTerdaftar) {
            session()->flash('error', 'Anda sudah terdaftar.');
            return;
        }

        if ($this->sudahPenuh) {
            session()->flash('error', 'Kuota sudah penuh.');
            return;
        }

        RecordAbsensiDiklat::create([
            'id_user'     => $user->id,
            'id_diklat'   => $this->diklat->id,
            'namaPeserta' => $user->nama,
            'durasi'      => (int) $this->diklat->durasi * 60,
            'date'        => now()->toDateString(),
        ]);

        $this->sudahTerdaftar = true;
        session()->flash('success', 'Berhasil mendaftar!');
    }

    public function render()
    {
        return view('livewire.pegawai.acara.detail-acara');
    }
}