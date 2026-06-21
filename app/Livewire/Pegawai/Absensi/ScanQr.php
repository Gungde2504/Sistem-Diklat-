<?php

namespace App\Livewire\Pegawai\Absensi;

use Livewire\Component;
use App\Services\Absensi\AbsensiService;
use App\DTOs\AbsensiDTO;

class ScanQr extends Component
{
    public $event_id;
    public $lat;
    public $lng;

    public AbsensiService $absensiService;

    public function mount(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    public function submit()
    {
        $this->validate([
            'event_id' => 'required|integer',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        try {
            $dto = new AbsensiDTO(
                user_id: auth()->id(),
                event_id: $this->event_id,
                latitude: $this->lat,
                longitude: $this->lng
            );

            $this->absensiService->scanQR($dto);

            session()->flash('success', 'Absensi berhasil');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pegawai.absensi.scan-qr');
    }
}