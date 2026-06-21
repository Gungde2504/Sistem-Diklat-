<?php

namespace App\Livewire\Admin\Peserta;

use App\Models\DetailEksternal;
use App\Models\MUnit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Peserta Eksternal')]
class PesertaCreate extends Component
{
    public string $tipe = 'eksternal';

    // Data User
    public string $nama     = '';
    public string $email    = '';
    public string $password = '';
    public string $hp       = '';
    public string $alamat   = '';

    // Data Detail
    public string $jenis          = '';
    public string $institusi      = '';
    public string $idUnit         = '';
    public string $idSupervisor   = '';
    public string $tanggalMulai   = '';
    public string $tanggalSelesai = '';

    public bool $berhasil = false;

    protected function rules(): array
    {
        $rules = [
            'nama'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'hp'       => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:255',
        ];

        if ($this->tipe === 'eksternal') {
            $rules['jenis']          = 'required|in:pkl,magang,orientasi';
            $rules['institusi']      = 'required|string|max:200';
            $rules['idUnit']         = 'required|exists:m_units,id';
            $rules['tanggalMulai']   = 'required|date';
            $rules['tanggalSelesai'] = 'required|date|after_or_equal:tanggalMulai';
        } else {
            $rules['jenis'] = 'required|in:karyawan_iss,karyawan_bss,karyawan_adidaya,karyawan_bayi_tabung,karyawan_koperasi,karyawan_lotus_spa';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'nama.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.min'           => 'Password minimal 6 karakter.',
            'jenis.required'         => 'Jenis wajib dipilih.',
            'jenis.in'               => 'Pilih jenis yang valid.',
            'institusi.required'     => 'Institusi wajib diisi.',
            'idUnit.required'        => 'Unit penempatan wajib dipilih.',
            'tanggalMulai.required'  => 'Tanggal mulai wajib diisi.',
            'tanggalSelesai.required'=> 'Tanggal selesai wajib diisi.',
            'tanggalSelesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }

    public function updatedTipe(): void
    {
        $this->reset(['jenis', 'institusi', 'idUnit', 'idSupervisor', 'tanggalMulai', 'tanggalSelesai']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $jenisLabel = [
            'karyawan_iss'         => 'ISS',
            'karyawan_bss'         => 'BSS',
            'karyawan_adidaya'     => 'PT. Adidaya',
            'karyawan_bayi_tabung' => 'Bayi Tabung',
            'karyawan_koperasi'    => 'Koperasi',
            'karyawan_lotus_spa'   => 'Lotus SPA',
        ];

        $user = User::create([
            'type'     => 'external',
            'role'     => 'peserta_eksternal',
            'name'     => $this->nama,
            'nama'     => $this->nama,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'hp'       => $this->hp,
            'alamat'   => $this->alamat,
            'isActive' => $this->tipe === 'eksternal' ? true : false,
        ]);

        DetailEksternal::create([
            'id_user'         => $user->id,
            'jenis'           => $this->jenis,
            'institusi'       => $this->tipe === 'eksternal'
                                    ? $this->institusi
                                    : ($jenisLabel[$this->jenis] ?? $this->jenis),
            'id_unit'         => $this->idUnit ?: null,
            'id_supervisor'   => $this->idSupervisor ?: null,
            'tanggal_mulai'   => $this->tipe === 'eksternal' ? $this->tanggalMulai : null,
            'tanggal_selesai' => $this->tipe === 'eksternal' ? $this->tanggalSelesai : null,
            'status'          => 'aktif',
            'approval_status' => $this->tipe === 'karyawan' ? 'pending' : 'approved',
            'created_by'      => auth()->id(),
        ]);

        $this->berhasil = true;
        $this->reset([
            'nama', 'email', 'password', 'hp', 'alamat',
            'jenis', 'institusi', 'idUnit', 'idSupervisor',
            'tanggalMulai', 'tanggalSelesai',
        ]);
    }

    public function render()
    {
        $units       = MUnit::orderBy('nama')->get();
        $supervisors = User::where('type', 'internal')
            ->where('isActive', 1)
            ->orderBy('nama')
            ->get();

        return view('livewire.admin.peserta.peserta-create', compact('units', 'supervisors'));
    }
}