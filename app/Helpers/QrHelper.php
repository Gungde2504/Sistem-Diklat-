<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class QrHelper
{
    /**
     * Generate token unik untuk QR Code acara
     */
    public static function generateToken(): string
    {
        return Str::upper(Str::random(6)) . '-' . now()->format('YmdHis');
    }

    /**
     * Generate URL untuk QR Code (untuk di-encode menjadi gambar QR)
     */
    public static function generateQrUrl(string $token): string
    {
        return route('absensi.scan', ['token' => $token]);
    }
}