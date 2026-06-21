<?php

namespace App\Livewire\Pegawai\DiklatMandiri;

use App\Models\DiklatMandiri;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Diklat Mandiri')]
class DetailDiklatMandiri extends Component
{
    public DiklatMandiri $diklat;

    public function mount(DiklatMandiri $diklat): void
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($diklat->id_user !== auth()->id(), 403);
        $this->diklat = $diklat;
    }

    public function render()
    {
        return view('livewire.pegawai.diklat-mandiri.detail-diklat-mandiri');
    }
}