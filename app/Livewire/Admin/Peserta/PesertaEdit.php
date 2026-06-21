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
        $this->editIdUnit         = $detail->id_unit ?? '';
        $this->editIdSupervisor   = (string) ($detail->id_supervisor ?? '');
        $this->editStatus         = $detail->status ?? '';
        $this->editTanggalMulai   = $detail->tanggal_mulai?->format('Y-m-d') ?? '';
        $this->editTanggalSelesai = $detail->tanggal_selesai?->format('Y-m-d') ?? '';
    }

    public function simpan(): void
    {
        $this->validate([
            'editNama'           => 'required|string|max:100',
            'editEmail'          => 'required|email|max:100',
            'editJenis'          => 'required|string',
            'editInstitusi'      => 'required|string|max:200',
            'editStatus'         => 'required|string',
            'editTanggalMulai'   => 'required|date',
            'editTanggalSelesai' => 'required|date|after_or_equal:editTanggalMulai',
        ], [
            'editNama.required'                 => 'Nama wajib diisi.',
            'editEmail.required'                => 'Email wajib diisi.',
            'editJenis.required'                => 'Jenis wajib dipilih.',
            'editInstitusi.required'            => 'Institusi wajib diisi.',
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

        $this->detail->update([
            'jenis'           => $this->editJenis,
            'institusi'       => $this->editInstitusi,
            'id_unit'         => $this->editIdUnit ?: null,
            'id_supervisor'   => $this->editIdSupervisor ?: null,
            'status'          => $this->editStatus,
            'tanggal_mulai'   => $this->editTanggalMulai,
            'tanggal_selesai' => $this->editTanggalSelesai,
        ]);

        session()->flash('success', 'Data peserta berhasil diupdate.');
        $this->redirect(route('admin.peserta.detail', $this->detail->id));
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