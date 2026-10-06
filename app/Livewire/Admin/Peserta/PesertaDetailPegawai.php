<?php

namespace App\Livewire\Admin\Peserta;

use App\Models\DiklatMandiri;
use App\Models\ElearningProgress;
use App\Models\RecordAbsensiDiklat;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Detail Pegawai')]
class PesertaDetailPegawai extends Component
{
    use WithPagination;

    public User $pegawai;
    public string $tab = 'pelatihan';

    public function mount(User $pegawai): void
    {
        abort_unless($pegawai->role === 'pegawai', 404);
        $this->pegawai = $pegawai;
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $absensi = RecordAbsensiDiklat::with('diklat')
            ->where('id_user', $this->pegawai->id)
            ->orderByDesc('date')
            ->paginate(15);

        $totalHadir        = RecordAbsensiDiklat::where('id_user', $this->pegawai->id)
            ->where('is_hadir', true)->count();
        $totalAbsensi      = RecordAbsensiDiklat::where('id_user', $this->pegawai->id)
            ->count();
        $totalJamPelatihan = RecordAbsensiDiklat::where('id_user', $this->pegawai->id)
            ->where('is_hadir', true)->sum('durasi');

        $elearning = ElearningProgress::with('modul')
            ->where('id_user', $this->pegawai->id)
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'elearning_page');

        $totalElearning = ElearningProgress::where('id_user', $this->pegawai->id)->count();
        $totalCompleted = ElearningProgress::where('id_user', $this->pegawai->id)
            ->where('status', 'completed')->count();

        $diklatMandiri = DiklatMandiri::where('id_user', $this->pegawai->id)
            ->orderByDesc('tglJamMulai')
            ->paginate(10, ['*'], 'diklat_mandiri_page');

        $totalDiklatMandiri         = DiklatMandiri::where('id_user', $this->pegawai->id)->count();
        $totalDiklatMandiriApproved = DiklatMandiri::where('id_user', $this->pegawai->id)
            ->where('status', 'Disetujui')->count();
        $totalDiklatMandiriPending  = DiklatMandiri::where('id_user', $this->pegawai->id)
            ->where('status', 'pending')->count();

        return view('livewire.admin.peserta.peserta-detail-pegawai', compact(
            'absensi', 'totalHadir', 'totalAbsensi', 'totalJamPelatihan',
            'elearning', 'totalElearning', 'totalCompleted',
            'diklatMandiri', 'totalDiklatMandiri', 'totalDiklatMandiriApproved', 'totalDiklatMandiriPending'
        ));
    }
}
