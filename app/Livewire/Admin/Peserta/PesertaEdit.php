<?php

namespace App\Livewire\Admin\Peserta;

use App\Models\DetailEksternal;
use App\Models\MUnit;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Edit Peserta Eksternal')]
class PesertaEdit extends Component
{
    public DetailEksternal $detail;

    public string $editNama           = '';
    public string $editEmail          = '';
    public string $editHp             = '';
    public string $editJenis          = '';
    public string $editInstitusi      = '';
    public string $editProgramStudi   = '';
    public string $editSemester       = '';
    public string $editIdUnit         = '';
    public string $editIdSupervisor   = '';
    public string $editStatus         = '';
    public string $editTanggalMulai   = '';
    public string $editTanggalSelesai = '';

    public function mount(DetailEksternal $detail): void
    {
        $this->detail = $detail->load(['user', 'unit', 'supervisor']);

        $this->editNama           = $detail->user?->nama ?? '';
        $this->editEmail          = $detail->user?->email ?? '';
        $this->editHp             = $detail->user?->hp ?? '';
        $this->editJenis          = $detail->jenis ?? '';
        $this->editInstitusi      = $detail->institusi ?? '';
        $this->editProgramStudi   = $detail->program_studi ?? '';
        $this->editSemester       = (string) ($detail->semester ?? '');
        $this->editIdUnit         = $detail->id_unit ?? '';
        $this->editIdSupervisor   = (string) ($detail->id_supervisor ?? '');
        $this->editStatus         = $detail->status ?? '';
        $this->editTanggalMulai   = $detail->tanggal_mulai?->format('Y-m-d') ?? '';
        $this->editTanggalSelesai = $detail->tanggal_selesai?->format('Y-m-d') ?? '';
    }

    public function simpan(): void
    {
        $isKaryawan = DetailEksternal::isKaryawanExternal($this->editJenis);

        $rules = [
            'editNama'   => 'required|string|max:100',
            'editEmail'  => 'required|email|max:100',
            'editJenis'  => 'required|string',
            'editStatus' => 'required|string',
        ];

        // Institusi, tanggal mulai/selesai, program studi & semester hanya relevan
        // untuk Mahasiswa PKL/Magang/Orientasi — field ini tidak ditampilkan sama
        // sekali di form Karyawan Eksternal, jadi jangan diwajibkan untuknya
        // (kalau tetap 'required', validasi gagal diam-diam karena nilainya kosong).
        if (!$isKaryawan) {
            $rules['editInstitusi']      = 'required|string|max:200';
            $rules['editTanggalMulai']   = 'required|date';
            $rules['editTanggalSelesai'] = 'required|date|after_or_equal:editTanggalMulai';
            $rules['editProgramStudi']   = 'required|string|max:150';
            $rules['editSemester']       = 'required|integer|min:1|max:14';
        } else {
            $rules['editTanggalMulai']   = 'nullable|date';
            $rules['editTanggalSelesai'] = 'nullable|date|after_or_equal:editTanggalMulai';
        }

        $this->validate($rules, [
            'editNama.required'                 => 'Nama wajib diisi.',
            'editEmail.required'                => 'Email wajib diisi.',
            'editJenis.required'                => 'Jenis wajib dipilih.',
            'editInstitusi.required'            => 'Institusi wajib diisi.',
            'editProgramStudi.required'         => 'Program studi wajib diisi.',
            'editSemester.required'             => 'Semester wajib diisi.',
            'editStatus.required'               => 'Status wajib dipilih.',
            'editTanggalMulai.required'         => 'Tanggal mulai wajib diisi.',
            'editTanggalSelesai.required'       => 'Tanggal selesai wajib diisi.',
            'editTanggalSelesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        $this->detail->user?->update([
            'nama'  => $this->editNama,
            'email' => $this->editEmail,
            'hp'    => $this->editHp,
        ]);

        // Isi dulu atribut terbaru ke instance (belum disimpan) supaya
        // hitungStatus() di bawah menghitung berdasarkan tanggal yang BARU
        // diedit, bukan tanggal lama yang masih tersimpan di database.
        $this->detail->status          = $this->editStatus; // dipakai sbg fallback kalau belum approved
        $this->detail->tanggal_mulai   = $isKaryawan ? $this->detail->tanggal_mulai   : $this->editTanggalMulai;
        $this->detail->tanggal_selesai = $isKaryawan ? $this->detail->tanggal_selesai : $this->editTanggalSelesai;

        // Status untuk PKL/Magang/Orientasi dihitung OTOMATIS dari tanggal
        // mulai/selesai (konsisten dengan cara Acara menghitung statusnya) —
        // bukan lagi ikut nilai dropdown yang bisa jadi tidak sinkron begitu
        // tanggalnya diubah. Karyawan eksternal tidak punya tanggal, jadi
        // tetap pakai pilihan dropdown apa adanya.
        $statusFinal = $isKaryawan ? $this->editStatus : $this->detail->hitungStatus();

        $this->detail->update([
            'jenis'     => $this->editJenis,
            // Karyawan eksternal tidak punya field ini di form — pertahankan nilai yang sudah ada.
            'institusi'       => $isKaryawan ? $this->detail->institusi : $this->editInstitusi,
            'program_studi'   => $isKaryawan ? $this->detail->program_studi : $this->editProgramStudi,
            'semester'        => $isKaryawan ? $this->detail->semester : $this->editSemester,
            'id_unit'         => $this->editIdUnit ?: null,
            'id_supervisor'   => $this->editIdSupervisor ?: null,
            'status'          => $statusFinal,
            'tanggal_mulai'   => $this->detail->tanggal_mulai,
            'tanggal_selesai' => $this->detail->tanggal_selesai,
        ]);

        $this->detail->refresh();
        session()->flash('success', 'Data peserta berhasil diupdate.');
    }

    public function render()
    {
        $units       = MUnit::orderBy('nama')->get();
        $supervisors = User::where('type', 'internal')
            ->where('isActive', 1)
            ->orderBy('nama')
            ->get();

        return view('livewire.admin.peserta.peserta-edit', compact('units', 'supervisors'));
    }
}