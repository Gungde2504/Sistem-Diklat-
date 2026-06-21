<?php

namespace App\Services\Absensi;

use App\Actions\Absensi\CheckinGpsAction;
use App\Actions\Absensi\ScanQrAction;
use App\Models\RecordAbsensiDiklat;
use Illuminate\Pagination\LengthAwarePaginator;

class AbsensiService
{
    public function __construct(
        private readonly ScanQrAction     $scanQrAction,
        private readonly CheckinGpsAction $checkinGpsAction,
    ) {}

    public function scanQr(string $token): array
    {
        return $this->scanQrAction->execute($token);
    }

    public function checkinGps(float $lat, float $lon): array
    {
        return $this->checkinGpsAction->execute($lat, $lon, 'checkin');
    }

    public function checkoutGps(float $lat, float $lon): array
    {
        return $this->checkinGpsAction->execute($lat, $lon, 'checkout');
    }

    public function getRekapByDiklat(int $diklatId): LengthAwarePaginator
    {
        return RecordAbsensiDiklat::with('user')
            ->where('id_diklat', $diklatId)
            ->paginate(20);
    }
}