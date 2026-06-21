<?php

namespace App\Livewire\Eksternal\Jurnal;

use App\Models\JurnalEksternal;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Jurnal Harian')]
class JurnalHarian extends Component
{
    use WithPagination;

    public string $tab = 'tulis';

    // Form fields
    public string $tanggal      = '';
    public string $aktivitas    = '';
    public string $kendala      = '';
    public string $rencanaBesok = '';

    // Edit state
    public ?int $editId = null;

    public bool   $berhasil = false;
    public string $errorMsg = '';

    // Download filter
    public string $filterDownload = 'semua';
    public string $bulanDownload  = '';
    public string $tahunDownload  = '';

    public function mount(): void
    {
        $this->tanggal       = now()->toDateString();
        $this->bulanDownload = (string) now()->month;
        $this->tahunDownload = (string) now()->year;

        $existing = JurnalEksternal::where('id_user', auth()->id())
            ->where('tanggal', $this->tanggal)
            ->first();

        if ($existing) {
            $this->loadForEdit($existing->id);
            $this->tab = 'riwayat';
        }
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function loadForEdit(int $id): void
    {
        $jurnal = JurnalEksternal::where('id_user', auth()->id())->findOrFail($id);
        $this->editId       = $jurnal->id;
        $this->tanggal      = $jurnal->tanggal->toDateString();
        $this->aktivitas    = $jurnal->aktivitas;
        $this->kendala      = $jurnal->kendala ?? '';
        $this->rencanaBesok = $jurnal->rencana_besok ?? '';
        $this->tab          = 'tulis';
    }

    public function resetForm(): void
    {
        $this->editId       = null;
        $this->tanggal      = now()->toDateString();
        $this->aktivitas    = '';
        $this->kendala      = '';
        $this->rencanaBesok = '';
        $this->errorMsg     = '';
    }

    public function save(): void
    {
        $this->validate([
            'tanggal'      => 'required|date',
            'aktivitas'    => 'required|string|min:10',
            'kendala'      => 'nullable|string',
            'rencanaBesok' => 'nullable|string',
        ]);

        $userId = auth()->id();

        if ($this->editId) {
            $jurnal = JurnalEksternal::where('id_user', $userId)->findOrFail($this->editId);

            if (!$jurnal->bisaDiedit()) {
                $this->errorMsg = 'Jurnal hanya dapat diedit dalam 24 jam setelah dibuat.';
                return;
            }

            $jurnal->update([
                'aktivitas'     => $this->aktivitas,
                'kendala'       => $this->kendala ?: null,
                'rencana_besok' => $this->rencanaBesok ?: null,
            ]);
        } else {
            $exists = JurnalEksternal::where('id_user', $userId)
                ->where('tanggal', $this->tanggal)
                ->exists();

            if ($exists) {
                $this->errorMsg = 'Jurnal untuk tanggal ini sudah ada. Silakan edit jurnal yang sudah ada.';
                return;
            }

            JurnalEksternal::create([
                'id_user'       => $userId,
                'tanggal'       => $this->tanggal,
                'aktivitas'     => $this->aktivitas,
                'kendala'       => $this->kendala ?: null,
                'rencana_besok' => $this->rencanaBesok ?: null,
            ]);
        }

        $this->berhasil     = true;
        $this->errorMsg     = '';
        $this->editId       = null;
        $this->aktivitas    = '';
        $this->kendala      = '';
        $this->rencanaBesok = '';
        $this->tab          = 'riwayat';
    }

    public function render()
    {
        $riwayat = JurnalEksternal::where('id_user', auth()->id())
            ->orderByDesc('tanggal')
            ->paginate(10);

        $jurnalHarini = JurnalEksternal::where('id_user', auth()->id())
            ->where('tanggal', now()->toDateString())
            ->first();

        $totalJurnal = JurnalEksternal::where('id_user', auth()->id())->count();

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        }

        return view('livewire.eksternal.jurnal.jurnal-harian', compact(
            'riwayat', 'jurnalHarini', 'totalJurnal', 'bulanList'
        ));
    }
}