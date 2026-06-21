<?php

namespace App\Livewire\Eksternal\Sertifikat;

use App\Models\DetailEksternal;
use App\Models\MFileDiklat;
use App\Models\RecordAbsensiDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Sertifikat Saya')]
class SertifikatEksternal extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $detail = DetailEksternal::where('id_user', $userId)
            ->with(['user', 'unit', 'supervisor'])
            ->first();

        // Sertifikat dari acara diklat yang dihadiri
        $diklatIds = RecordAbsensiDiklat::where('id_user', $userId)
            ->pluck('id_diklat')
            ->toArray();

        $sertifikatDiklat = MFileDiklat::with('diklat')
            ->whereIn('id_diklat', $diklatIds)
            ->where('type', 'sertifikat')
            ->latest()
            ->get();

        return view('livewire.eksternal.sertifikat.sertifikat-eksternal', compact(
            'detail', 'sertifikatDiklat'
        ));
    }
}