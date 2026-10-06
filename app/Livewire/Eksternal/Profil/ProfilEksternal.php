<?php

namespace App\Livewire\Eksternal\Profil;

use App\Models\DetailEksternal;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

#[Title('Profil Saya')]
class ProfilEksternal extends Component
{
    public string $nama        = '';
    public string $email       = '';
    public string $hp          = '';
    public string $alamat      = '';
    public string $institusi   = '';
    public string $programStudi = '';
    public string $semester     = '';

    public bool $isMahasiswa = false;

    public string $passwordLama  = '';
    public string $passwordBaru  = '';
    public string $konfirmasi    = '';

    public string $message      = '';
    public string $messageType  = '';

    public function mount(): void
    {
        $user   = auth()->user();
        $detail = $user->detailEksternal;

        $this->nama    = $user->nama ?? '';
        $this->email   = $user->email ?? '';
        $this->hp      = $user->hp ?? '';
        $this->alamat  = $user->alamat ?? '';

        $this->institusi    = $detail?->institusi ?? '';
        $this->programStudi = $detail?->program_studi ?? '';
        $this->semester     = $detail?->semester !== null ? (string) $detail->semester : '';

        $this->isMahasiswa = in_array($detail?->jenis, ['pkl', 'magang', 'orientasi'], true);
    }

    public function simpanProfil(): void
    {
        $rules = [
            'nama'    => 'required|string|max:100',
            'hp'      => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:200',
        ];

        if ($this->isMahasiswa) {
            $rules['programStudi'] = 'required|string|max:150';
            $rules['semester']     = 'required|integer|min:1|max:14';
        }

        $this->validate($rules);

        auth()->user()->update([
            'nama'   => $this->nama,
            'hp'     => $this->hp,
            'alamat' => $this->alamat,
        ]);

        $detail = auth()->user()->detailEksternal;
        if ($detail) {
            $data = ['institusi' => $this->institusi];
            if ($this->isMahasiswa) {
                $data['program_studi'] = $this->programStudi;
                $data['semester']      = $this->semester;
            }
            $detail->update($data);
        }

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
