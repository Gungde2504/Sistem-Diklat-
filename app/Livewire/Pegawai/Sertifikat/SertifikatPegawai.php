<?php

namespace App\Livewire\Pegawai\Sertifikat;

use App\Models\DiklatMandiri;
use App\Models\MFileDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Sertifikat Saya')]
class SertifikatPegawai extends Component
{
    public string $tab = 'diklat';

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function render()
    {
        $userId = auth()->id();

        // Sertifikat dari acara diklat
        $diklatIds = RecordAbsensiDiklat::where('id_user', $userId)
            ->pluck('id_diklat')
            ->toArray();

        $sertifikatDiklat = MFileDiklat::with('diklat')
            ->whereIn('id_diklat', $diklatIds)
            ->where('type', 'sertifikat')
            ->latest()
            ->get();

        // Sertifikat dari diklat mandiri yang disetujui
        $sertifikatMandiri = DiklatMandiri::where('id_user', $userId)
            ->where('status', 'Disetujui')
            ->whereNotNull('sertifikat')
            ->latest()
            ->get();

        return view('livewire.pegawai.sertifikat.sertifikat-pegawai', compact(
            'sertifikatDiklat', 'sertifikatMandiri'
        ));
    }
}