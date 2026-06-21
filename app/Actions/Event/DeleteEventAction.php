<?php

namespace App\Actions\Event;

use App\Models\MDiklat;

class DeleteEventAction
{
    public function execute(MDiklat $diklat): bool
    {
        // Nonaktifkan QR dulu sebelum hapus
        $diklat->update(['IsActive' => 0]);

        return $diklat->delete(); // soft delete
    }
}