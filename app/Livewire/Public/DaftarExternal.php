<?php

namespace App\Livewire\Public;

use App\Models\DetailEksternal;
use App\Models\MUnit;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

#[Title('Pendaftaran Peserta Eksternal')]
#[Layout('livewire.public.daftar-external')]
class DaftarExternal extends Component
{
    public string $nama           = '';
    public string $email          = '';
    public string $password       = '';
    public string $konfirmasi     = '';
    public string $hp             = '';
    public string $alamat         = '';
    public string $jenis          = '';
    public string $institusi      = '';
    public string $idUnit         = '';
    public string $idSupervisor   = '';
    public string $tanggalMulai   = '';
    public string $tanggalSelesai = '';

    public bool $isKaryawan = false;

    public function updatedJenis(): void
    {
        $this->isKaryawan = DetailEksternal::isKaryawanExternal($this->jenis);
        if ($this->isKaryawan) {
            $this->tanggalMulai   = '';
            $this->tanggalSelesai = '';
        }
    }

    public function simpan(): void
    {
        $rules = [
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:konfirmasi',
            'hp'       => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'jenis'    => 'required|string',
            'institusi' => 'required|string|max:200',
        ];

        if (!$this->isKaryawan) {
            $rules['tanggalMulai']   = 'required|date';
            $rules['tanggalSelesai'] = 'required|date|after_or_equal:tanggalMulai';
        }

        $this->validate($rules, [
            'email.unique'          => 'Email sudah terdaftar.',
            'password.same'         => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 6 karakter.',
            'tanggalSelesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        // Buat user
        $user = User::create([
            'nama'     => $this->nama,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'hp'       => $this->hp,
            'alamat'   => $this->alamat,
            'type'     => 'external',
            'role'     => 'peserta_eksternal',
            'isActive' => false, // nonaktif sampai di-approve
        ]);

        // Buat detail eksternal
        DetailEksternal::create([
            'id_user'         => $user->id,
            'jenis'           => $this->jenis,
            'institusi'       => $this->institusi,
            'id_unit'         => $this->idUnit ?: null,
            'id_supervisor'   => $this->idSupervisor ?: null,
            'tanggal_mulai'   => $this->isKaryawan ? null : $this->tanggalMulai,
            'tanggal_selesai' => $this->isKaryawan ? null : $this->tanggalSelesai,
            'status'          => 'aktif',
            'approval_status' => 'pending',
            'created_by'      => 1, // system
        ]);

        $this->redirect(route('daftar.external.sukses'));
    }

    public function render()
    {
        $units       = MUnit::orderBy('nama')->get();
        $supervisors = User::where('type', 'internal')
            ->where('isActive', 1)
            ->orderBy('nama')
            ->get();

        return view('livewire.public.daftar-external', compact('units', 'supervisors'));
    }
}