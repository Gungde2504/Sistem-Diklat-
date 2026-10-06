<?php

namespace App\Livewire\Admin\Peserta;

use App\Mail\PesertaStatusNotification;
use App\Models\DetailEksternal;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Karyawan / Peserta')]
class PesertaIndex extends Component
{
    use WithPagination;

    public string $tab           = 'pkl';
    public string $karyawanSubTab = 'pegawai'; // 'pegawai' | 'eksternal'
    public string $search        = '';
    public string $status        = '';
    public string $jenis         = '';
    public string $approval      = '';

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingStatus(): void   { $this->resetPage(); }
    public function updatingJenis(): void    { $this->resetPage(); }
    public function updatingApproval(): void { $this->resetPage(); }

    public function setTab(string $tab): void
    {
        $this->tab      = $tab;
        $this->search   = '';
        $this->status   = '';
        $this->jenis    = '';
        $this->approval = '';
        if ($tab === 'karyawan') {
            $this->karyawanSubTab = 'pegawai';
        }
        $this->resetPage();
    }

    public function setKaryawanSubTab(string $sub): void
    {
        $this->karyawanSubTab = $sub;
        $this->search   = '';
        $this->status   = '';
        $this->jenis    = '';
        $this->approval = '';
        $this->resetPage();
    }

    public function ubahStatus(int $id, string $status): void
    {
        DetailEksternal::findOrFail($id)->update(['status' => $status]);
        session()->flash('success', 'Status peserta berhasil diubah.');
    }

    public function delete(int $id): void
    {
        $detail = DetailEksternal::findOrFail($id);
        User::findOrFail($detail->id_user)->delete();
        $detail->delete();
        session()->flash('success', 'Peserta berhasil dihapus.');
    }

    public function approve(int $id): void
    {
        $detail = DetailEksternal::with('user')->findOrFail($id);
        $detail->update([
            'approval_status' => 'approved',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $detail->user?->update(['isActive' => true]);
        $detail->refresh()->load('user');
        $emailTerkirim = $this->kirimEmailStatus($detail);
        session()->flash('success', $emailTerkirim
            ? 'Peserta berhasil disetujui dan email notifikasi telah dikirim.'
            : 'Peserta berhasil disetujui, tetapi email notifikasi gagal dikirim.');
    }

    public function reject(int $id): void
    {
        $detail = DetailEksternal::with('user')->findOrFail($id);
        $detail->update([
            'approval_status' => 'rejected',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $detail->user?->update(['isActive' => false]);
        $detail->refresh()->load('user');
        $emailTerkirim = $this->kirimEmailStatus($detail);
        session()->flash('success', $emailTerkirim
            ? 'Peserta ditolak dan email notifikasi telah dikirim.'
            : 'Peserta ditolak, tetapi email notifikasi gagal dikirim.');
    }

    private function kirimEmailStatus(DetailEksternal $detail): bool
    {
        if (!$detail->user?->email) {
            return false;
        }

        try {
            Mail::to($detail->user->email)
                ->send(new PesertaStatusNotification($detail));
            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    public function render()
    {
        $karyawanJenis = ['karyawan_iss','karyawan_bss','karyawan_adidaya','karyawan_bayi_tabung','karyawan_koperasi','karyawan_lotus_spa'];
        $pklJenis      = ['pkl','magang','orientasi'];

        if ($this->tab === 'karyawan' && $this->karyawanSubTab === 'pegawai') {
            // ── Sub-tab Pegawai ──────────────────────────────────
            $query = User::where('role', 'pegawai')
                ->when($this->search, fn($q) =>
                    $q->where(fn($w) =>
                        $w->where('nama', 'like', '%'.$this->search.'%')
                          ->orWhere('nip', 'like', '%'.$this->search.'%')
                    )
                )
                ->when($this->status === 'aktif',    fn($q) => $q->where('isActive', true))
                ->when($this->status === 'nonaktif', fn($q) => $q->where('isActive', false));

            $peserta = $query->latest()->paginate(10);
        } elseif ($this->tab === 'karyawan') {
            // ── Sub-tab Karyawan Eksternal ───────────────────────
            $query = DetailEksternal::with(['user','unit','supervisor'])
                ->whereIn('jenis', $karyawanJenis)
                ->when($this->search, fn($q) =>
                    $q->whereHas('user', fn($u) =>
                        $u->where('nama', 'like', '%'.$this->search.'%')
                          ->orWhere('email', 'like', '%'.$this->search.'%')
                    )
                )
                ->when($this->status,   fn($q) => $q->where('status', $this->status))
                ->when($this->approval, fn($q) => $q->where('approval_status', $this->approval))
                ->when($this->jenis,    fn($q) => $q->where('jenis', $this->jenis));

            $peserta = $query->latest()->paginate(10);
        } else {
            // ── Tab Mahasiswa PKL / Magang ───────────────────────
            $query = DetailEksternal::with(['user','unit','supervisor'])
                ->whereIn('jenis', $pklJenis)
                ->when($this->search, fn($q) =>
                    $q->whereHas('user', fn($u) =>
                        $u->where('nama', 'like', '%'.$this->search.'%')
                          ->orWhere('email', 'like', '%'.$this->search.'%')
                    )
                )
                ->when($this->status, fn($q) => $q->where('status', $this->status))
                ->when($this->jenis,  fn($q) => $q->where('jenis', $this->jenis));

            $peserta = $query->latest()->paginate(10);
        }

        // ── Stats Mahasiswa PKL/Magang/Orientasi ────────────────
        $totalPkl        = DetailEksternal::whereIn('jenis', $pklJenis)->count();
        $totalPklAktif   = DetailEksternal::whereIn('jenis', $pklJenis)->where('status', 'aktif')->count();
        $totalPklSelesai = DetailEksternal::whereIn('jenis', $pklJenis)->where('status', 'selesai')->count();
        $totalPklPending = DetailEksternal::whereIn('jenis', $pklJenis)->where('approval_status', 'pending')->count();

        // ── Stats Pegawai ────────────────────────────────────────
        $totalPegawai        = User::where('role', 'pegawai')->count();
        $totalPegawaiAktif   = User::where('role', 'pegawai')->where('isActive', true)->count();
        $totalPegawaiNonaktif = User::where('role', 'pegawai')->where('isActive', false)->count();

        // ── Stats Karyawan Eksternal ─────────────────────────────
        $totalKaryawan         = DetailEksternal::whereIn('jenis', $karyawanJenis)->count();
        $totalKaryawanAktif    = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('status', 'aktif')->count();
        $totalKaryawanApproved = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('approval_status', 'approved')->count();
        $totalKaryawanPending  = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('approval_status', 'pending')->count();

        $totalPending = DetailEksternal::where('approval_status', 'pending')->count();

        return view('livewire.admin.peserta.peserta-index', compact(
            'peserta',
            'totalPkl', 'totalPklAktif', 'totalPklSelesai', 'totalPklPending',
            'totalPegawai', 'totalPegawaiAktif', 'totalPegawaiNonaktif',
            'totalKaryawan', 'totalKaryawanAktif', 'totalKaryawanApproved', 'totalKaryawanPending',
            'totalPending'
        ));
    }
}
