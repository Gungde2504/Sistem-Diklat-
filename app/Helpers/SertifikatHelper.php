<?php

namespace App\Helpers;

use App\Models\MDiklat;

class SertifikatHelper
{
    /**
     * Generate nomor sertifikat dinamis (tidak disimpan di DB)
     * Format: SERT/[KODE]/[YYYY]/[MM]/[NO_URUT]
     * Kode: DI=Diklat Internal, DE=Diklat Eksternal, SM=Seminar
     */
    public static function generateNomor(MDiklat $diklat, int $noUrut): string
    {
        $kode = match($diklat->jenisDiklat) {
            'Diklat Internal' => 'DI',
            'Diklat Eksternal' => 'DE',
            'Seminar'         => 'SM',
            default           => 'XX',
        };

        $tahun   = now()->format('Y');
        $bulan   = now()->format('m');
        $urut    = str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        return "SERT/{$kode}/{$tahun}/{$bulan}/{$urut}";
    }

    /**
     * Generate token unik untuk verifikasi sertifikat PKL/Magang
     */
    public static function generateCertToken(): string
    {
        return \Illuminate\Support\Str::uuid()->toString();
    }
}