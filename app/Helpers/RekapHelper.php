<?php

namespace App\Helpers;

class RekapHelper
{
    /**
     * Konversi menit ke jam (desimal)
     * Contoh: 90 menit → 1.5 jam
     */
    public static function menitKeJam(int|float $menit): float
    {
        return round($menit / 60, 2);
    }

    /**
     * Konversi menit ke format jam:menit
     * Contoh: 90 menit → "1j 30m"
     */
    public static function menitKeFormat(int $menit): string
    {
        $jam   = intdiv($menit, 60);
        $sisa  = $menit % 60;

        if ($jam === 0) return "{$sisa}m";
        if ($sisa === 0) return "{$jam}j";
        return "{$jam}j {$sisa}m";
    }

    /**
     * Cek apakah sudah memenuhi target jam
     */
    public static function sudahMemenuhiTarget(float $totalJam, float $target = 20): bool
    {
        return $totalJam >= $target;
    }

    /**
     * Hitung persentase progress dari target
     */
    public static function persentaseProgress(float $totalJam, float $target = 20): float
    {
        return min(round(($totalJam / $target) * 100, 1), 100);
    }
}