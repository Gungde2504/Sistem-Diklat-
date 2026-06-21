<?php

namespace App\Livewire\Pegawai\RekapJam;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Helpers\RekapHelper;
use App\Models\DiklatMandiri;
use App\Models\ElearningProgress;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Jam Pelatihan')]
class RekapJamPribadi extends Component
{
    public string $tahun  = '';
    public string $tab    = 'acara';
    public float  $target = 20;

    public float $totalJam     = 0;
    public float $jamAcara     = 0;
    public float $jamMandiri   = 0;
    public float $jamElearning = 0;
    public float $persen       = 0;

    public function mount(): void
    {
        $this->tahun = (string) now()->year;
        $this->hitungRekap();
    }

    public function updatedTahun(): void
    {
        $this->hitungRekap();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    private function hitungRekap(): void
    {
        $action = app(CalculateRekapJamAction::class);
        $rekap  = $action->execute(auth()->id(), (int) $this->tahun);

        $this->jamAcara     = $rekap->jamDiklatAcara;
        $this->jamMandiri   = $rekap->jamDiklatMandiri;
        $this->jamElearning = $rekap->jamElearning;
        $this->totalJam     = $rekap->total();
        $this->persen       = RekapHelper::persentaseProgress($this->totalJam, $this->target);
    }

    public function render()
    {
        $userId = auth()->id();

        $riwayatAcara = RecordAbsensiDiklat::with('diklat')
            ->where('id_user', $userId)
            ->whereYear('date', $this->tahun)
            ->orderByDesc('date')
            ->get();

        $riwayatMandiri = DiklatMandiri::where('id_user', $userId)
            ->whereYear('created_at', $this->tahun)
            ->orderByDesc('created_at')
            ->get();

        $riwayatElearning = ElearningProgress::with('modul')
            ->where('id_user', $userId)
            ->where('status', 'completed')
            ->whereYear('completed_at', $this->tahun)
            ->orderByDesc('completed_at')
            ->get();

        return view('livewire.pegawai.rekap-jam.rekap-jam-pribadi', compact(
            'riwayatAcara', 'riwayatMandiri', 'riwayatElearning'
        ));
    }
}