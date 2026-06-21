<?php

namespace App\Actions\RekapJam;

use App\DTOs\RekapJamDTO;
use App\Helpers\RekapHelper;
use App\Models\DiklatMandiri;
use App\Models\ElearningProgress;
use App\Models\RecordAbsensiDiklat;

class CalculateRekapJamAction
{
    public function execute(int $userId, int $tahun): RekapJamDTO
    {
        // Sumber 1: Diklat Acara — hanya yang is_hadir = true
        $menitAcara = RecordAbsensiDiklat::where('id_user', $userId)
            ->where('is_hadir', true)
            ->whereYear('date', $tahun)
            ->sum('durasi');

        // Sumber 2: Diklat Mandiri (hanya yang disetujui)
        $menitMandiri = DiklatMandiri::where('id_user', $userId)
            ->where('status', 'Disetujui')
            ->whereYear('created_at', $tahun)
            ->sum(\DB::raw('CAST(durasi AS UNSIGNED)'));

        // Sumber 3: E-Learning
        $jamElearning = ElearningProgress::where('id_user', $userId)
            ->where('status', 'completed')
            ->whereYear('completed_at', $tahun)
            ->sum('jam_dikontribusikan');

        return new RekapJamDTO(
            jamDiklatAcara:   RekapHelper::menitKeJam($menitAcara),
            jamDiklatMandiri: RekapHelper::menitKeJam($menitMandiri),
            jamElearning:     (float) $jamElearning,
        );
    }
}