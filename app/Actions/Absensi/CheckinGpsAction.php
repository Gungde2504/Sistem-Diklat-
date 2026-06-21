<?php

namespace App\Actions\Absensi;

use App\Helpers\GeoHelper;
use App\Models\ExternalDailyAttendance;
use Illuminate\Support\Facades\Auth;

class CheckinGpsAction
{
    // Koordinat & radius RS — idealnya dari config/DB
    private float $rsLat    = -8.6705;   // ganti dengan koordinat RS
    private float $rsLon    = 115.2126;  // ganti dengan koordinat RS
    private float $radius   = 100;       // meter

    public function execute(float $lat, float $lon, string $type = 'checkin'): array
    {
        $user    = Auth::user();
        $today   = now()->toDateString();
        $isValid = GeoHelper::isWithinRadius($lat, $lon, $this->rsLat, $this->rsLon, $this->radius);

        $record = ExternalDailyAttendance::firstOrNew([
            'id_user' => $user->id,
            'tanggal' => $today,
        ]);

        if ($type === 'checkin') {
            if ($record->checkin_at) {
                return ['success' => false, 'message' => 'Sudah melakukan check-in hari ini.'];
            }
            $record->checkin_at = now();
        } else {
            if (!$record->checkin_at) {
                return ['success' => false, 'message' => 'Belum melakukan check-in.'];
            }
            if ($record->checkout_at) {
                return ['success' => false, 'message' => 'Sudah melakukan check-out hari ini.'];
            }
            $record->checkout_at = now();
        }

        $record->latitude   = $lat;
        $record->longitude  = $lon;
        $record->is_valid   = $isValid;
        $record->mode       = 'online';
        $record->save();

        $msg = $isValid
            ? ucfirst($type) . ' berhasil dicatat.'
            : ucfirst($type) . ' dicatat, namun lokasi di luar radius RS.';

        return ['success' => true, 'message' => $msg, 'is_valid' => $isValid];
    }
}