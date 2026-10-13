<?php

namespace Database\Seeders;

use App\Models\MUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Daftar unit RSU Prima Medika: unit pegawai internal (52) + vendor karyawan eksternal.
 *
 * Aman dijalankan berulang kali (idempotent):
 *  - unit yang sudah ada (cocok slug / nama, tanpa membedakan huruf besar-kecil)
 *    hanya dirapikan penulisan namanya; id dan slug TIDAK diubah;
 *  - unit yang belum ada dibuat baru.
 */
class MUnitSeeder extends Seeder
{
    public const UNITS = [
        'Administrasi',
        'Cafe Alamanda',
        'Café Gardenia',
        'Casemix',
        'CSSD',
        'Dapur Saji Barat',
        'Dapur Saji Timur',
        'Dapur Umum',
        'Diklat',
        'Dokter Umum',
        'Elektromedis',
        'Farmasi',
        'Fisioterapi',
        'FO/OPERATOR',
        'Gardener',
        'Gizi',
        'HD EEG',
        'HOUSEKEEPING',
        'Humas',
        'ICU',
        'IT/PROGRAMER',
        'Kasir',
        'Kesling',
        'Lab PA',
        'Lab PK',
        'Laundry',
        'Manajemen',
        'Marketing',
        'NICU-PICU',
        'OK A & D',
        'OK C',
        'Pajak',
        'Pengadaan',
        'Perinatologi',
        'Piutang',
        'Radiologi',
        'Rawat Jalan/Poliklinik',
        'Rekam Medis',
        'RIA',
        'RIC',
        'RID',
        'Satpam',
        'SDM',
        'Sekretaris',
        'Sopir',
        'SPI',
        'Teknisi',
        'UGD',
        'UPM',
        'PPI',
        'PPRA',
        'VK',
    ];

    /** Vendor / perusahaan penyedia karyawan eksternal. */
    public const UNITS_VENDOR = [
        'ISS',
        'BSS',
        'PT. Adidaya',
        'Bayi Tabung',
        'Koperasi',
        'Lotus SPA',
    ];

    /** Semua unit resmi: unit pegawai internal + vendor karyawan eksternal. */
    public static function semua(): array
    {
        return array_merge(self::UNITS, self::UNITS_VENDOR);
    }

    public function run(): void
    {
        foreach (self::semua() as $nama) {
            $slug = Str::slug($nama);

            $unit = MUnit::where('slug', $slug)
                ->orWhereRaw('UPPER(nama) = ?', [mb_strtoupper($nama)])
                ->first();

            if ($unit) {
                if ($unit->nama !== $nama) {
                    $unit->update(['nama' => $nama]);
                }
                continue;
            }

            MUnit::create(['nama' => $nama]);
        }

        $this->command?->info(count(self::semua()) . ' unit (pegawai internal + vendor) disiapkan.');
    }
}
