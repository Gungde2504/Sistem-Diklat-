<?php

namespace Database\Seeders;

use App\Models\MUnit;
use Illuminate\Database\Seeder;

class MUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            'IGD',
            'ICU',
            'Rawat Inap',
            'Rawat Jalan',
            'Farmasi',
            'Laboratorium',
            'Radiologi',
            'Gizi',
            'Rekam Medis',
            'Keperawatan',
            'Kebidanan',
            'Fisioterapi',
            'OK / Bedah',
            'Administrasi',
            'Keuangan',
            'SDM / HRD',
            'IT',
            'Sanitasi',
            'CSSD',
            'Umum & Logistik',
        ];

        foreach ($units as $nama) {
            MUnit::create(['nama' => $nama]);
        }
    }
}