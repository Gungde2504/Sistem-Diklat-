<?php

namespace App\Actions\DiklatMandiri;

use App\Models\DiklatMandiri;

class ApproveDiklatMandiriAction
{
    public function approve(DiklatMandiri $diklat): void
    {
        $diklat->update(['status' => 'Disetujui']);
    }

    public function reject(DiklatMandiri $diklat): void
    {
        $diklat->update(['status' => 'Ditolak']);
    }
}