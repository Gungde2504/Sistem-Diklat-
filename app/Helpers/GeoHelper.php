<?php

namespace App\Helpers;

class GeoHelper
{
    /**
     * Hitung jarak antara dua koordinat GPS menggunakan formula Haversine
     * Return: jarak dalam meter
     */
    public static function haversineDistance(
        float $lat1, float $lon1,
        float $lat2, float $lon2
    ): float {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Cek apakah koordinat dalam radius yang diizinkan
     */
    public static function isWithinRadius(
        float $userLat, float $userLon,
        float $centerLat, float $centerLon,
        float $radiusMeters = 100
    ): bool {
        $distance = self::haversineDistance(
            $userLat, $userLon,
            $centerLat, $centerLon
        );

        return $distance <= $radiusMeters;
    }
}