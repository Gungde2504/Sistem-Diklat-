<?php

namespace App\Livewire\Pegawai\Profil;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title('Profil Saya')]
class ProfilPegawai extends Component
{
    public string $tab = 'profil';

    // Data Profil
    public string $nama  = '';
    public string $email = '';
    public string $hp    = '';
    public string $nip   = '';
    public string $unit  = '';
    public string $profesi  = '';
    public string $jabatan  = '';

    // Ganti Password
    #[Validate('required|string|min:8')]
    public string $passwordLama    = '';

    #[Validate('required|string|min:8|same:passwordKonfirmasi')]
    public string $passwordBaru    = '';

    #[Validate('required|string|min:8')]
    public string $passwordKonfirmasi = '';

    public bool $profilBerhasil  = false;
    public bool $passwordBerhasil = false;
    public string $passwordError  = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->nama     = $user->nama     ?? '';
        $this->email    = $user->email    ?? '';
        $this->hp       = $user->hp       ?? '';
        $this->nip      = $user->nip      ?? '';
        $this->unit     = $user->unit     ?? '';
        $this->profesi  = $user->profesi  ?? '';
        $this->jabatan  = $user->jabatan  ?? '';
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->profilBerhasil  = false;
        $this->passwordBerhasil = false;
        $this->passwordError   = '';
    }

    public function simpanProfil(): void
    {
        $this->validate([
            'nama'  => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'hp'    => 'nullable|string|max:20',
        ]);

        auth()->user()->update([
            'nama'  => $this->nama,
            'name'  => $this->nama,
            'email' => $this->email,
            'hp'    => $this->hp,
        ]);

        $this->profilBerhasil = true;
    }

    public function gantiPassword(): void
    {
        $this->passwordError = '';

        $this->validate([
            'passwordLama'         => 'required|string|min:8',
            'passwordBaru'         => 'required|string|min:8|same:passwordKonfirmasi',
            'passwordKonfirmasi'   => 'required|string|min:8',
        ]);

        if (!Hash::check($this->passwordLama, auth()->user()->password)) {
            $this->passwordError = 'Password lama tidak sesuai.';
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->passwordBaru),
        ]);

        $this->passwordBerhasil = true;
        $this->reset(['passwordLama', 'passwordBaru', 'passwordKonfirmasi']);
    }

    public function render()
    {
        return view('livewire.pegawai.profil.profil-pegawai');
    }
}