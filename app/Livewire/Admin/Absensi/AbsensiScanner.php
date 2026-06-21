<?php

namespace App\Livewire\Admin\Absensi;

use App\Actions\Absensi\ScanQrAction;
use App\Models\MDiklat;
use App\Models\User;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Scanner Absensi QR')]
class AbsensiScanner extends Component
{
    public string $token       = '';
    public string $message     = '';
    public string $messageType = '';
    public ?int   $diklatId    = null;
    public int    $totalHadir  = 0;
    public int    $totalKuota  = 0;
    public string $namaAcara   = '';

    // Manual absensi by admin
    public string $searchPeserta = '';
    public ?int   $selectedUserId = null;
    public string $selectedNama   = '';
    public string $manualMessage  = '';
    public string $manualMessageType = '';

    public function mount(): void
    {
        $acara = MDiklat::where('IsActive', 1)
            ->where('status', 'Berlangsung')
            ->latest()
            ->first();

        if ($acara) {
            $this->diklatId   = $acara->id;
            $this->namaAcara  = $acara->nama;
            $this->totalKuota = $acara->kuota;
            $this->totalHadir = $acara->absensiDiklats()->count();
        }
    }

    public function processQr(): void
    {
        if (empty(trim($this->token))) {
            $this->setMessage('Token QR tidak boleh kosong.', 'error');
            return;
        }

        $result = app(ScanQrAction::class)->execute(trim($this->token));

        if ($result['success']) {
            $this->setMessage($result['message'], 'success');
            $this->refreshCounter();
        } else {
            $msg  = $result['message'];
            $type = str_contains($msg, 'sudah') ? 'warning' : 'error';
            $this->setMessage($msg, $type);
        }

        $this->token = '';
    }

    public function selectAcara(int $id): void
    {
        $acara = MDiklat::findOrFail($id);
        $this->diklatId   = $acara->id;
        $this->namaAcara  = $acara->nama;
        $this->totalKuota = $acara->kuota;
        $this->refreshCounter();
        $this->message       = '';
        $this->manualMessage = '';
    }

    public function selectUser(int $userId, string $nama): void
    {
        $this->selectedUserId = $userId;
        $this->selectedNama   = $nama;
        $this->searchPeserta  = $nama;
        $this->manualMessage  = '';
    }

    public function absenManual(): void
    {
        if (!$this->diklatId) {
            $this->manualMessage     = 'Pilih acara terlebih dahulu.';
            $this->manualMessageType = 'error';
            return;
        }

        if (!$this->selectedUserId) {
            $this->manualMessage     = 'Pilih peserta terlebih dahulu.';
            $this->manualMessageType = 'error';
            return;
        }

        $acara = MDiklat::find($this->diklatId);
        $user  = User::find($this->selectedUserId);

        if (!$acara || !$user) {
            $this->manualMessage     = 'Data tidak ditemukan.';
            $this->manualMessageType = 'error';
            return;
        }

        // Cek sudah absen
        $sudah = RecordAbsensiDiklat::where('id_diklat', $this->diklatId)
            ->where('id_user', $this->selectedUserId)
            ->exists();

        if ($sudah) {
            $this->manualMessage     = "{$user->nama} sudah tercatat hadir.";
            $this->manualMessageType = 'warning';
            return;
        }

        // Cek kuota
        if ($this->totalHadir >= $acara->kuota) {
            $this->manualMessage     = 'Kuota acara sudah penuh.';
            $this->manualMessageType = 'error';
            return;
        }

        RecordAbsensiDiklat::create([
            'id_diklat'   => $this->diklatId,
            'id_user'     => $this->selectedUserId,
            'namaPeserta' => $user->nama,
            'durasi'      => $acara->durasi * 60,
            'date'        => now(),
        ]);

        $this->manualMessage     = "✅ {$user->nama} berhasil diabsenkan.";
        $this->manualMessageType = 'success';
        $this->searchPeserta     = '';
        $this->selectedUserId    = null;
        $this->selectedNama      = '';
        $this->refreshCounter();
    }

    public function hapusAbsensi(int $recordId): void
    {
        RecordAbsensiDiklat::where('id', $recordId)
            ->where('id_diklat', $this->diklatId)
            ->delete();

        $this->manualMessage     = 'Absensi berhasil dihapus.';
        $this->manualMessageType = 'success';
        $this->refreshCounter();
    }

    public function refreshCounter(): void
    {
        if ($this->diklatId) {
            $this->totalHadir = MDiklat::find($this->diklatId)
                ?->absensiDiklats()->count() ?? 0;
        }
    }

    private function setMessage(string $msg, string $type): void
    {
        $this->message     = $msg;
        $this->messageType = $type;
    }

    public function render()
    {
        $acaraAktif = MDiklat::where('IsActive', 1)->get();

        // Cari peserta internal
        $hasilCari = collect();
        if (strlen($this->searchPeserta) >= 2) {
            $hasilCari = User::where('type', 'internal')
                ->where('isActive', 1)
                ->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->searchPeserta . '%')
                      ->orWhere('nip', 'like', '%' . $this->searchPeserta . '%');
                })
                ->limit(8)
                ->get();
        }

        // Daftar peserta yang sudah absen
        $pesertaHadir = collect();
        if ($this->diklatId) {
            $pesertaHadir = RecordAbsensiDiklat::with('user')
                ->where('id_diklat', $this->diklatId)
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();
        }

        return view('livewire.admin.absensi.absensi-scanner', compact(
            'acaraAktif', 'hasilCari', 'pesertaHadir'
        ));
    }
}