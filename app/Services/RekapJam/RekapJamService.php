<?php

namespace App\Services\RekapJam;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\DTOs\RekapJamDTO;
use App\Models\User;
use Illuminate\Support\Collection;

class RekapJamService
{
    public function __construct(
        private readonly CalculateRekapJamAction $calculateAction,
    ) {}

    public function getRekapUser(int $userId, int $tahun): RekapJamDTO
    {
        return $this->calculateAction->execute($userId, $tahun);
    }

    public function getRekapAllKaryawan(int $tahun): Collection
    {
        return User::where('type', 'internal')
            ->where('isActive', 1)
            ->get()
            ->map(function (User $user) use ($tahun) {
                $rekap = $this->calculateAction->execute($user->id, $tahun);
                return [
                    'user'        => $user,
                    'total_jam'   => $rekap->total(),
                    'detail'      => $rekap,
                    'terpenuhi'   => $rekap->sudahMemenuhiTarget(),
                ];
            });
    }
}