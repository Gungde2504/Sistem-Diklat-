<?php

namespace App\Livewire\Pegawai\Dashboard;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Helpers\RekapHelper;
use App\Models\DiklatMandiri;
use App\Models\MDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard')]
class DashboardPegawai extends Component
{
    public float  $totalJam      = 0;
    public float  $jamAcara      = 0;
    public float  $jamMandiri    = 0;
    public float  $jamElearning  = 0;
    public float  $target        = 20;
    public float  $persen        = 0;
    public int    $pendingMandiri = 0;

    public function mount(): void
    {
        $user   = auth()->user();
        $tahun  = now()->year;
        $action = app(CalculateRekapJamAction::class);
        $rekap  = $action->execute($user->id, $tahun);

        $this->totalJam     = $rekap->total();
        $this->jamAcara     = $rekap->jamDiklatAcara;
        $this->jamMandiri   = $rekap->jamDiklatMandiri;
        $this->jamElearning = $rekap->jamElearning;
        $this->persen       = RekapHelper::persentaseProgress($this->totalJam, $this->target);

        $this->pendingMandiri = DiklatMandiri::where('id_user', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('created_at', $tahun)
            ->count();
    }

    public function render()
    {
        $user = auth()->user();

        $acaraMendatang = MDiklat::where('publish', 1)
            ->whereIn('status', ['Terbuka', 'Berlangsung'])
            ->orderBy('tglJamMulai')
            ->limit(4)
            ->get();

        $riwayatMandiri = DiklatMandiri::where('id_user', $user->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('livewire.pegawai.dashboard.dashboard-pegawai', compact(
            'acaraMendatang', 'riwayatMandiri'
        ));
    }
}