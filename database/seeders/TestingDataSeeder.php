<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestingDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding 150 pegawai...');
        $this->seedPegawai();

        $this->command->info('Seeding 20 acara diklat...');
        $this->seedAcara();

        $this->command->info('Seeding peserta eksternal...');
        $this->seedPesertaEksternal();

        $this->command->info('Seeding 30 diklat mandiri...');
        $this->seedDiklatMandiri();

        $this->command->info('Seeding 30 modul elearning...');
        $this->seedElearning();

        $this->command->info('Seeding 50 pegawai dengan jam pelatihan terpenuhi...');
        $this->seedPegawaiJamTerpenuhi();

        $this->command->info('Selesai!');
    }

    // ── 1. 150 Pegawai ──────────────────────────────────────────
    private function seedPegawai(): void
    {
        $units = ['Keperawatan', 'IGD', 'Radiologi', 'Laboratorium', 'Farmasi', 'Gizi', 'Rekam Medis', 'Administrasi', 'Keuangan', 'IT'];

        for ($i = 1; $i <= 150; $i++) {
            $nik  = str_pad(200000 + $i, 6, '0', STR_PAD_LEFT);
            $nama = $this->namaIndonesia($i);
            DB::table('users')->insert([
                'name'       => $nama,
                'nip'        => $nik,
                'nama'       => $nama,
                'email'      => 'pegawai' . $i . '@rsuprimamedika.com',
                'password'   => Hash::make('password'),
                'role'       => 'pegawai',
                'type'       => 'internal',
                'unit'       => $units[array_rand($units)],
                'hp'         => '08' . rand(100000000, 999999999),
                'isActive'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ── 2. 20 Acara Diklat ──────────────────────────────────────
    private function seedAcara(): void
    {
        $namaAcara = [
            'Pelatihan Bantuan Hidup Dasar (BHD)',
            'Workshop Manajemen Nyeri',
            'Seminar Patient Safety 2026',
            'Pelatihan Komunikasi Efektif Tenaga Medis',
            'Workshop Pencegahan dan Pengendalian Infeksi',
            'Pelatihan Dokumentasi Keperawatan',
            'Seminar Gizi Klinik',
            'Workshop K3 Rumah Sakit Lanjutan',
            'Pelatihan Penggunaan Alat Medis Terbaru',
            'Seminar Etika Profesi Kesehatan',
            'Pelatihan Rekam Medis Elektronik',
            'Workshop Manajemen Stres untuk Tenaga Kesehatan',
            'Pelatihan Triase dan Penanganan Gawat Darurat',
            'Seminar Farmasi Klinik',
            'Workshop Pelayanan Prima Rumah Sakit',
            'Pelatihan Radiologi Diagnostik',
            'Seminar Akreditasi Rumah Sakit',
            'Workshop Pengambilan Sampel Laboratorium',
            'Pelatihan Leadership untuk Kepala Ruang',
            'Seminar Inovasi Layanan Kesehatan 2026',
        ];

        $jenis  = ['Diklat Internal', 'Diklat Eksternal', 'Seminar', 'Workshop'];
        $tempat = ['Aula RSU Prima Medika Lt. 2', 'Ruang Meeting A', 'Ruang Meeting B', 'Aula Utama', 'Ruang Pelatihan Lt. 3'];

        foreach ($namaAcara as $idx => $nama) {
            $mulai  = Carbon::now()->subMonths(rand(1, 6))->addDays(rand(-15, 15));
            $selesai = $mulai->copy()->addHours(rand(2, 8));

            if ($idx < 14)      $st = 'Selesai';
            elseif ($idx < 17)  $st = 'Terbuka';
            elseif ($idx < 19)  $st = 'Berlangsung';
            else                $st = 'Draft';

            DB::table('m_diklats')->insert([
                'img'            => null,
                'nama'           => $nama,
                'deskripsi'      => 'Pelatihan ' . $nama . ' diselenggarakan oleh Bidang Diklat RSU Prima Medika.',
                'namaNarasumber' => $this->namaIndonesia(rand(1, 50)) . ', S.Kes., M.Kes.',
                'jenisDiklat'    => $jenis[array_rand($jenis)],
                'tglJamMulai'    => $mulai->format('Y-m-d\TH:i'),
                'tglJamSelesai'  => $selesai->format('Y-m-d\TH:i'),
                'tempat'         => $tempat[array_rand($tempat)],
                'durasi'         => rand(2, 8),
                'kuota'          => rand(20, 50),
                'publish'        => 1,
                'slug'           => Str::slug($nama) . '-' . Str::random(5),
                'status'         => $st,
                'linkPretest'    => null,
                'linkPosttest'   => null,
                'QRcode'         => strtoupper(Str::random(6)) . '-' . now()->format('YmdHis') . rand(10, 99),
                'IsActive'       => in_array($st, ['Berlangsung', 'Terbuka']) ? 1 : 0,
                'created_at'     => $mulai->copy()->subDays(rand(7, 30)),
                'updated_at'     => now(),
            ]);
        }
    }

    // ── 3. Peserta Eksternal ─────────────────────────────────────
    private function seedPesertaEksternal(): void
    {
        $unitIds      = DB::table('m_units')->pluck('id')->toArray();
        $supervisorIds = DB::table('users')->where('role', 'pegawai')->where('isActive', 1)->limit(10)->pluck('id')->toArray();

        // PKL, Magang, Orientasi — 50 data
        $jenisPKL    = ['pkl', 'pkl', 'pkl', 'magang', 'magang', 'orientasi'];
        $institusiPKL = ['Universitas Udayana', 'ITB STIKOM Bali', 'Politeknik Kesehatan Denpasar', 'STIKES Bali', 'Universitas Warmadewa', 'Undiksha', 'Poltekkes Kemenkes Denpasar'];
        $approvalPool = ['approved', 'approved', 'approved', 'pending', 'rejected'];

        for ($i = 1; $i <= 50; $i++) {
            $nama   = $this->namaIndonesia(300 + $i);
            $userId = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nip'        => null,
                'nama'       => $nama,
                'email'      => 'pkl' . $i . '@external.com',
                'password'   => Hash::make('password'),
                'role'       => 'peserta_eksternal',
                'type'       => 'external',
                'unit'       => null,
                'isActive'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $jenis          = $jenisPKL[array_rand($jenisPKL)];
            $mulai          = Carbon::now()->subMonths(rand(1, 4));
            $selesai        = $mulai->copy()->addMonths(rand(1, 3));
            $approvalStatus = $approvalPool[array_rand($approvalPool)];

            DB::table('detail_eksternals')->insert([
                'id_user'         => $userId,
                'jenis'           => $jenis,
                'institusi'       => $institusiPKL[array_rand($institusiPKL)],
                'vendor'          => null,
                'id_unit'         => !empty($unitIds) ? $unitIds[array_rand($unitIds)] : null,
                'id_supervisor'   => !empty($supervisorIds) ? $supervisorIds[array_rand($supervisorIds)] : null,
                'tanggal_mulai'   => $mulai,
                'tanggal_selesai' => $selesai,
                'status'          => $selesai->isPast() ? 'selesai' : 'aktif',
                'approval_status' => $approvalStatus,
                'cert_qr_token'   => Str::uuid(),
                'created_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // Karyawan Vendor — 50 data
        $jenisKaryawan = ['karyawan_iss', 'karyawan_bss', 'karyawan_adidaya', 'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa'];
        $vendorNama    = ['ISS Indonesia', 'BSS', 'PT. Adidaya', 'Klinik Bayi Tabung', 'Koperasi RSU', 'Lotus SPA'];
        $approvalPool2 = ['approved', 'approved', 'approved', 'pending'];

        for ($i = 1; $i <= 50; $i++) {
            $jenisIdx       = array_rand($jenisKaryawan);
            $nama           = $this->namaIndonesia(400 + $i);
            $approvalStatus = $approvalPool2[array_rand($approvalPool2)];

            $userId = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nip'        => null,
                'nama'       => $nama,
                'email'      => 'vendor' . $i . '@external.com',
                'password'   => Hash::make('password'),
                'role'       => 'peserta_eksternal',
                'type'       => 'external',
                'unit'       => null,
                'isActive'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('detail_eksternals')->insert([
                'id_user'         => $userId,
                'jenis'           => $jenisKaryawan[$jenisIdx],
                'institusi'       => $vendorNama[$jenisIdx],
                'vendor'          => $vendorNama[$jenisIdx],
                'id_unit'         => !empty($unitIds) ? $unitIds[array_rand($unitIds)] : null,
                'id_supervisor'   => null,
                'tanggal_mulai'   => null,
                'tanggal_selesai' => null,
                'status'          => 'aktif',
                'approval_status' => $approvalStatus,
                'cert_qr_token'   => Str::uuid(),
                'created_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }

    // ── 4. 30 Diklat Mandiri ────────────────────────────────────
    private function seedDiklatMandiri(): void
    {
        $pegawaiIds = DB::table('users')->where('role', 'pegawai')->where('isActive', 1)->pluck('id')->toArray();

        $namaDiklat = [
            'Webinar Manajemen Rekam Medis Digital',
            'Kursus Online Farmakologi Dasar',
            'Pelatihan Mandiri BHD Online',
            'Seminar Virtual Keselamatan Pasien',
            'Workshop Online Komunikasi Terapeutik',
            'Kursus Manajemen Nyeri Paliatif',
            'Pelatihan E-Learning Triase',
            'Webinar Nutrisi Enteral dan Parenteral',
            'Kursus Online Etika Keperawatan',
            'Pelatihan Mandiri Penggunaan EHR',
            'Seminar Kesehatan Mental Tenaga Medis',
            'Workshop Virtual K3 Laboratorium',
            'Kursus Online Radiologi Dasar',
            'Pelatihan Mandiri APAR untuk RS',
            'Webinar Manajemen Luka Modern',
            'Kursus Online Pediatri Dasar',
            'Pelatihan Mandiri Sterilisasi Alat',
            'Seminar Virtual Anestesi Dasar',
            'Workshop Online Kebidanan Normal',
            'Kursus Manajemen Sepsis',
            'Pelatihan Mandiri Pengambilan Darah',
            'Webinar Farmasi Klinik Lanjutan',
            'Kursus Online Gizi Olahraga',
            'Pelatihan Mandiri PPGD',
            'Seminar Virtual Psikiatri Komunitas',
            'Workshop Online Perawatan Luka Bakar',
            'Kursus Online Imunisasi Dewasa',
            'Pelatihan Mandiri Ventilator Dasar',
            'Webinar Manajemen Diabetes',
            'Kursus Online Kesehatan Kerja',
        ];

        $statusPool = ['Disetujui', 'Disetujui', 'Disetujui', 'Ditolak', 'pending', 'pending'];

        foreach ($namaDiklat as $nama) {
            $st  = $statusPool[array_rand($statusPool)];
            $tgl = Carbon::now()->subDays(rand(1, 180));

            DB::table('diklat_mandiris')->insert([
                'id'            => Str::uuid(),
                'nama'          => $nama,
                'jenisDiklat'   => 'Diklat Mandiri',
                'tglJamMulai'   => $tgl->format('Y-m-d\TH:i'),
                'tglJamSelesai' => $tgl->copy()->addHours(rand(1, 4))->format('Y-m-d\TH:i'),
                'tempat'        => 'Online / Mandiri',
                'durasi'        => rand(60, 240),
                'sertifikat'    => $st === 'Disetujui' ? 'sertifikat/mandiri/dummy.jpg' : '',
                'materi'        => null,
                'id_user'       => $pegawaiIds[array_rand($pegawaiIds)],
                'status'        => $st,
                'created_at'    => $tgl,
                'updated_at'    => now(),
            ]);
        }
    }

    // ── 5. 30 Modul E-Learning ──────────────────────────────────
    private function seedElearning(): void
    {
        $adminId = DB::table('users')->where('role', 'super_admin')->value('id');
        $units   = DB::table('m_units')->pluck('id')->toArray();

        $modul = [
            ['judul' => 'Pengantar Keselamatan Pasien',          'kategori' => 'keselamatan kerja'],
            ['judul' => 'Manajemen Risiko di Rumah Sakit',        'kategori' => 'manajemen'],
            ['judul' => 'Pencegahan Infeksi Nosokomial',          'kategori' => 'keselamatan kerja'],
            ['judul' => 'Komunikasi Efektif dalam Tim Medis',     'kategori' => 'komunikasi'],
            ['judul' => 'Etika Profesi Kesehatan',                'kategori' => 'etika'],
            ['judul' => 'Dokumentasi Keperawatan Digital',        'kategori' => 'keperawatan'],
            ['judul' => 'Penanganan Limbah Medis',                'kategori' => 'keselamatan kerja'],
            ['judul' => 'Bantuan Hidup Dasar Online',             'kategori' => 'kegawatdaruratan'],
            ['judul' => 'Manajemen Nyeri Komprehensif',           'kategori' => 'klinis'],
            ['judul' => 'Farmakologi untuk Perawat',              'kategori' => 'farmasi'],
            ['judul' => 'Gizi Klinik Dasar',                      'kategori' => 'gizi'],
            ['judul' => 'Rekam Medis Elektronik',                 'kategori' => 'administrasi'],
            ['judul' => 'Sterilisasi dan Desinfeksi Alat',        'kategori' => 'keselamatan kerja'],
            ['judul' => 'Pelayanan Prima Rumah Sakit',            'kategori' => 'pelayanan'],
            ['judul' => 'Penanganan Pasien Agresif',              'kategori' => 'keselamatan kerja'],
            ['judul' => 'Pemantauan Tanda Vital',                 'kategori' => 'keperawatan'],
            ['judul' => 'Triase IGD',                             'kategori' => 'kegawatdaruratan'],
            ['judul' => 'Kesehatan Mental Tenaga Medis',          'kategori' => 'kesehatan'],
            ['judul' => 'Penggunaan APD yang Benar',              'kategori' => 'keselamatan kerja'],
            ['judul' => 'Manajemen Sepsis',                       'kategori' => 'klinis'],
            ['judul' => 'Perawatan Luka Modern',                  'kategori' => 'keperawatan'],
            ['judul' => 'Radiologi Dasar untuk Klinisi',          'kategori' => 'radiologi'],
            ['judul' => 'Pengambilan Sampel Laboratorium',        'kategori' => 'laboratorium'],
            ['judul' => 'Imunisasi Dewasa',                       'kategori' => 'preventif'],
            ['judul' => 'K3 di Laboratorium',                     'kategori' => 'keselamatan kerja'],
            ['judul' => 'Ventilator Mekanik Dasar',               'kategori' => 'klinis'],
            ['judul' => 'Manajemen Diabetes Melitus',             'kategori' => 'klinis'],
            ['judul' => 'Kesehatan dan Keselamatan Kerja RS',     'kategori' => 'keselamatan kerja'],
            ['judul' => 'Akreditasi RS — Standar SNARS',          'kategori' => 'manajemen'],
            ['judul' => 'Pelayanan Pasien Geriatri',              'kategori' => 'klinis'],
        ];

        foreach ($modul as $m) {
            DB::table('elearning_modules')->insert([
                'judul'               => $m['judul'],
                'deskripsi'           => 'Modul e-learning ' . $m['judul'] . ' untuk meningkatkan kompetensi tenaga kesehatan RSU Prima Medika.',
                'konten'              => '<p>Selamat datang di modul <strong>' . $m['judul'] . '</strong>. Silakan pelajari materi berikut dengan seksama.</p>',
                'kategori'            => $m['kategori'],
                'file_path'           => null,
                'link_video'          => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'estimasi_durasi_jam' => round(rand(1, 4) + rand(0, 5) / 10, 1),
                'min_quiz_score'      => rand(0, 1) ? rand(60, 80) : null,
                'id_target_unit'      => rand(0, 1) && !empty($units) ? $units[array_rand($units)] : null,
                'publish'             => 1,
                'created_by'          => $adminId,
                'created_at'          => Carbon::now()->subDays(rand(1, 90)),
                'updated_at'          => now(),
            ]);
        }
    }

    // ── 6. 50 Pegawai dengan Jam Pelatihan Terpenuhi (≥20 jam) ─
    private function seedPegawaiJamTerpenuhi(): void
    {
        $acaraSelesai = DB::table('m_diklats')->where('status', 'Selesai')->get(['id', 'durasi'])->toArray();

        if (empty($acaraSelesai)) {
            $this->command->warn('Tidak ada acara selesai — skip seed jam terpenuhi');
            return;
        }

        $units = ['Keperawatan', 'IGD', 'Farmasi', 'Laboratorium', 'Radiologi'];

        for ($i = 1; $i <= 50; $i++) {
            $nik  = str_pad(300000 + $i, 6, '0', STR_PAD_LEFT);
            $nama = $this->namaIndonesia(500 + $i);

            $userId = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nip'        => $nik,
                'nama'       => $nama,
                'email'      => 'pegawai.aktif' . $i . '@rsuprimamedika.com',
                'password'   => Hash::make('password'),
                'role'       => 'pegawai',
                'type'       => 'internal',
                'unit'       => $units[rand(0, 4)],
                'isActive'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tambahkan absensi hingga total jam ≥ 20 (1200 menit)
            $totalMenit = 0;
            $usedAcara  = [];

            foreach ($acaraSelesai as $acara) {
                if ($totalMenit >= 1200) break;
                if (in_array($acara->id, $usedAcara)) continue;

                $usedAcara[]  = $acara->id;
                $durasi       = $acara->durasi * 60;
                $totalMenit  += $durasi;

                DB::table('record_absensi_diklats')->insert([
                    'id_user'     => $userId,
                    'id_diklat'   => $acara->id,
                    'namaPeserta' => $nama,
                    'durasi'      => $durasi,
                    'date'        => Carbon::now()->subDays(rand(1, 180)),
                    'is_hadir'    => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }

    // ── Helper: Nama Indonesia ───────────────────────────────────
    private function namaIndonesia(int $seed): string
    {
        $depan = [
            'Budi', 'Siti', 'Andi', 'Dewi', 'Made', 'Ni Luh', 'I Wayan', 'Kadek', 'Putu', 'Komang',
            'Agus', 'Rina', 'Dian', 'Fitri', 'Hendra', 'Yuni', 'Bayu', 'Ayu', 'Widi', 'Rudi',
            'Lina', 'Eko', 'Sri', 'Doni', 'Mega', 'Irwan', 'Tuti', 'Sari', 'Wahyu', 'Gede',
            'Nyoman', 'Ketut', 'Wayan', 'Surya', 'Indah', 'Citra', 'Ratna', 'Anita', 'Yanto', 'Hadi',
        ];
        $belakang = [
            'Santoso', 'Wijaya', 'Kusuma', 'Pratama', 'Sari', 'Putri', 'Mahendra', 'Gunawan',
            'Suryani', 'Purnama', 'Dewi', 'Utama', 'Rahayu', 'Wibowo', 'Astuti', 'Setiawan',
            'Lestari', 'Nugroho', 'Hartono', 'Permata', 'Ardiansyah', 'Saputra', 'Kurniawan',
            'Handayani', 'Fitriani', 'Hidayat', 'Susanto', 'Wahyuni', 'Prabowo', 'Anggraini',
        ];

        return $depan[$seed % count($depan)] . ' ' . $belakang[($seed * 3) % count($belakang)];
    }
}