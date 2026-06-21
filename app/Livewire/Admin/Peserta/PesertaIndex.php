<?php

namespace App\Livewire\Admin\Peserta;

use App\Models\DetailEksternal;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Peserta Eksternal')]
class PesertaIndex extends Component
{
    use WithPagination;

    public string $tab      = 'pkl';
    public string $search   = '';
    public string $status   = '';
    public string $jenis    = '';
    public string $approval = '';

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
        $detail = DetailEksternal::findOrFail($id);
        $detail->update([
            'approval_status' => 'approved',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $detail->user?->update(['isActive' => true]);
        session()->flash('success', 'Peserta berhasil disetujui.');
    }

    public function reject(int $id): void
    {
        $detail = DetailEksternal::findOrFail($id);
        $detail->update([
            'approval_status' => 'rejected',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $detail->user?->update(['isActive' => false]);
        session()->flash('success', 'Peserta ditolak.');
    }

    public function render()
    {
        $karyawanJenis = ['karyawan_iss','karyawan_bss','karyawan_adidaya','karyawan_bayi_tabung','karyawan_koperasi','karyawan_lotus_spa'];
        $pklJenis      = ['pkl','magang','orientasi'];

        $query = DetailEksternal::with(['user','unit','supervisor'])
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($u) =>
                    $u->where('nama', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                )
            )
            ->when($this->status,   fn($q) => $q->where('status', $this->status))
            ->when($this->approval, fn($q) => $q->where('approval_status', $this->approval))
            ->when($this->jenis,    fn($q) => $q->where('jenis', $this->jenis));

        if ($this->tab === 'karyawan') {
            $query->whereIn('jenis', $karyawanJenis);
        } else {
            $query->whereIn('jenis', $pklJenis);
        }

        $peserta = $query->latest()->paginate(10);

        // ── Stats PKL ──────────────────────────────────────────
        $totalPkl        = DetailEksternal::whereIn('jenis', $pklJenis)->count();
        $totalPklAktif   = DetailEksternal::whereIn('jenis', $pklJenis)->where('status', 'aktif')->count();
        $totalPklSelesai = DetailEksternal::whereIn('jenis', $pklJenis)->where('status', 'selesai')->count();
        $totalPklPending = DetailEksternal::whereIn('jenis', $pklJenis)->where('approval_status', 'pending')->count();

        // ── Stats Karyawan ─────────────────────────────────────
        $totalKaryawan         = DetailEksternal::whereIn('jenis', $karyawanJenis)->count();
        $totalKaryawanAktif    = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('status', 'aktif')->count();
        $totalKaryawanApproved = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('approval_status', 'approved')->count();
        $totalKaryawanPending  = DetailEksternal::whereIn('jenis', $karyawanJenis)->where('approval_status', 'pending')->count();

        $totalPending = DetailEksternal::where('approval_status', 'pending')->count();

        return view('livewire.admin.peserta.peserta-index', compact(
            'peserta',
            'totalPkl', 'totalPklAktif', 'totalPklSelesai', 'totalPklPending',
            'totalKaryawan', 'totalKaryawanAktif', 'totalKaryawanApproved', 'totalKaryawanPending',
            'totalPending'
        ));
    }
}