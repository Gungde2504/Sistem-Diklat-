<?php

namespace App\Livewire\Eksternal\Profil;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

#[Title('Profil Saya')]
class ProfilEksternal extends Component
{
    public string $nama        = '';
    public string $email       = '';
    public string $hp          = '';

    public string $passwordLama  = '';
    public string $passwordBaru  = '';
    public string $konfirmasi    = '';

    public string $message      = '';
    public string $messageType  = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->nama  = $user->nama ?? '';
        $this->email = $user->email ?? '';
        $this->hp    = $user->hp ?? '';
    }

    public function simpanProfil(): void
    {
        $this->validate([
            'nama' => 'required|string|max:100',
            'hp'   => 'nullable|string|max:20',
        ]);

        auth()->user()->update([
            'nama' => $this->nama,
            'hp'   => $this->hp,
        ]);

        $this->message     = 'Profil berhasil disimpan.';
        $this->messageType = 'success';
    }

    public function gantiPassword(): void
    {
        $this->validate([
            'passwordLama' => 'required',
            'passwordBaru' => 'required|min:8',
            'konfirmasi'   => 'required|same:passwordBaru',
        ], [
            'konfirmasi.same'  => 'Konfirmasi password tidak cocok.',
            'passwordBaru.min' => 'Password baru minimal 8 karakter.',
        ]);

        if (!Hash::check($this->passwordLama, auth()->user()->password)) {
            $this->message     = 'Password lama tidak sesuai.';
            $this->messageType = 'error';
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->passwordBaru),
        ]);

        $this->passwordLama = '';
        $this->passwordBaru = '';
        $this->konfirmasi   = '';
        $this->message      = 'Password berhasil diubah.';
        $this->messageType  = 'success';
    }

    public function render()
    {
        $detail = auth()->user()->detailEksternal;
        return view('livewire.eksternal.profil.profil-external', compact('detail'));
    }
}