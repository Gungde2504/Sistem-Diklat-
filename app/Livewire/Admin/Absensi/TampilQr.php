<?php

namespace App\Livewire\Admin\Absensi;

use App\Models\MDiklat;
use App\Models\MUnit;
use App\Models\User;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

#[Title('Tampil QR Absensi')]
class TampilQr extends Component
{
    use WithPagination;

    public MDiklat $diklat;
    public string  $qrSvg       = '';
    public int     $totalHadir  = 0;
    public bool    $autoRefresh = true;

    // Absensi manual
    public string  $searchPeserta     = '';
    public ?int    $selectedUserId    = null;
    public string  $selectedNama      = '';
    public string  $manualMessage     = '';
    public string  $manualMessageType = '';

    // Filter daftar absensi
    public string  $filterUnit        = '';
    public string  $filterTipe        = 'semua'; // semua | internal | external
    public string  $filterStatus      = 'semua'; // semua | hadir | belum

    public function mount(MDiklat $diklat): void
    {
        $this->diklat = $diklat;
        $this->generateQr();
        $this->refreshCounter();
    }

    public function updatingFilterUnit(): void
    {
        $this->resetPage();
    }
    public function updatingFilterTipe(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingSearchPeserta(): void
    {
        $this->resetPage();
    }

    public function generateQr(): void
    {
        if (!$this->diklat->QRcode) return;

        $url = route('absensi.scan', ['token' => $this->diklat->QRcode]);

        $this->qrSvg = base64_encode(
            QrCode::format('svg')
                ->size(400)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($url)
        );
    }

    public function toggleQr(): void
    {
        $this->diklat->update(['IsActive' => !$this->diklat->IsActive]);
        $this->diklat->refresh();
    }

    public function refreshCounter(): void
    {
        $this->totalHadir = $this->diklat->absensiDiklats()
            ->where('is_hadir', true)
            ->count();
    }

    public function selectUser(int $userId, string $nama): void
    {
        $this->selectedUserId = $userId;
        $this->selectedNama   = $nama;
        $this->searchPeserta  = $nama;
        $this->manualMessage  = '';
    }

    public function absenSatu(int $userId): void
    {
        $user = User::find($userId);
        if (!$user) return;

        $record = RecordAbsensiDiklat::where('id_diklat', $this->diklat->id)
            ->where('id_user', $userId)
            ->first();

        if ($record && $record->is_hadir) {
            $this->manualMessage     = "{$user->nama} sudah tercatat hadir.";
            $this->manualMessageType = 'warning';
            return;
        }

        $hadir = RecordAbsensiDiklat::where('id_diklat', $this->diklat->id)
            ->where('is_hadir', true)->count();

        if ($hadir >= $this->diklat->kuota) {
            $this->manualMessage     = 'Kuota acara sudah penuh.';
            $this->manualMessageType = 'error';
            return;
        }

        if ($record) {
            $record->update([
                'is_hadir' => true,
                'durasi'   => $this->diklat->durasi * 60,
                'date'     => now(),
            ]);
        } else {
            RecordAbsensiDiklat::create([
                'id_diklat'   => $this->diklat->id,
                'id_user'     => $userId,
                'namaPeserta' => $user->nama,
                'durasi'      => $this->diklat->durasi * 60,
                'date'        => now(),
                'is_hadir'    => true,
            ]);
        }

        $this->manualMessage     = "✅ {$user->nama} berhasil diabsenkan.";
        $this->manualMessageType = 'success';
        $this->refreshCounter();
    }

    public function absenManual(): void
    {
        if (!$this->selectedUserId) {
            $this->manualMessage     = 'Pilih peserta terlebih dahulu.';
            $this->manualMessageType = 'error';
            return;
        }

        $this->absenSatu($this->selectedUserId);

        $this->searchPeserta  = '';
        $this->selectedUserId = null;
        $this->selectedNama   = '';
    }

    public function absenkanSemuaUnit(): void
    {
        if (!$this->filterUnit) return;

        $pegawai = User::where('type', 'internal')
            ->where('isActive', 1)
            ->where('unit', $this->filterUnit)
            ->get();

        if ($pegawai->isEmpty()) {
            $this->manualMessage     = 'Tidak ada pegawai aktif di unit ini.';
            $this->manualMessageType = 'error';
            return;
        }

        $hadir = RecordAbsensiDiklat::where('id_diklat', $this->diklat->id)
            ->where('is_hadir', true)->count();

        $count = 0;
        foreach ($pegawai as $user) {
            if ($hadir >= $this->diklat->kuota) break;

            $record = RecordAbsensiDiklat::where('id_diklat', $this->diklat->id)
                ->where('id_user', $user->id)->first();

            if ($record && $record->is_hadir) continue;

            if ($record) {
                $record->update([
                    'is_hadir' => true,
                    'durasi'   => $this->diklat->durasi * 60,
                    'date'     => now(),
                ]);
            } else {
                RecordAbsensiDiklat::create([
                    'id_diklat'   => $this->diklat->id,
                    'id_user'     => $user->id,
                    'namaPeserta' => $user->nama,
                    'durasi'      => $this->diklat->durasi * 60,
                    'date'        => now(),
                    'is_hadir'    => true,
                ]);
            }
            $hadir++;
            $count++;
        }

        $this->manualMessage     = "✅ {$count} pegawai dari unit {$this->filterUnit} berhasil diabsenkan.";
        $this->manualMessageType = 'success';
        $this->filterUnit        = '';
        $this->refreshCounter();
    }

    public function hapusAbsensi(int $recordId): void
    {
        RecordAbsensiDiklat::where('id', $recordId)
            ->where('id_diklat', $this->diklat->id)
            ->delete();

        $this->manualMessage     = 'Absensi berhasil dihapus.';
        $this->manualMessageType = 'success';
        $this->refreshCounter();
    }

    public function downloadAbsensi(string $format = 'pdf'): mixed
    {
        return redirect()->route('admin.absensi.download', [
            'diklat' => $this->diklat->id,
            'format' => $format,
            'tipe'   => $this->filterTipe,
            'unit'   => $this->filterUnit,
            'status' => $this->filterStatus,
        ]);
    }

    public function render()
    {
        $hasilCari = collect();
        if (strlen($this->searchPeserta) >= 2 && !$this->selectedUserId) {
            $hasilCari = User::where('isActive', 1)
                ->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->searchPeserta . '%')
                        ->orWhere('nip', 'like', '%' . $this->searchPeserta . '%')
                        ->orWhere('email', 'like', '%' . $this->searchPeserta . '%');
                })
                ->limit(8)
                ->get();
        }

        $daftarAbsensi = RecordAbsensiDiklat::with('user')
            ->where('id_diklat', $this->diklat->id)
            ->when($this->filterStatus === 'hadir', fn($q) => $q->where('is_hadir', true))
            ->when($this->filterStatus === 'belum', fn($q) => $q->where('is_hadir', false))
            ->when($this->filterTipe !== 'semua', function ($q) {
                if ($this->filterTipe === 'internal') {
                    $q->whereHas('user', fn($u) => $u->where('type', 'internal'));
                } else {
                    $q->whereHas('user', fn($u) => $u->where('type', 'external'));
                }
            })
            ->when($this->filterUnit, function ($q) {
                $q->whereHas('user', fn($u) => $u->where('unit', $this->filterUnit));
            })
            ->orderByDesc('is_hadir')
            ->orderByDesc('created_at')
            ->paginate(15);

        $units = MUnit::orderBy('nama')->get();

        return view('livewire.admin.absensi.tampil-qr', compact(
            'hasilCari',
            'daftarAbsensi',
            'units'
        ));
    }
}
