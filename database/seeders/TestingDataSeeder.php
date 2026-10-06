<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\MDiklat;
use App\Models\ElearningModule;
use App\Models\MUnit;

/**
 * Seeder data demo Juli - awal Oktober 2026 untuk sidang Tugas Akhir.
 *
 * Menghapus total data lama di tabel-tabel berikut lalu mengisi ulang
 * dengan data yang realistis:
 *   - users (role=pegawai & peserta_eksternal) + detail_eksternals
 *   - record_absensi_diklats, diklat_mandiris, elearning_progress
 *   - external_daily_attendances, jurnal_eksternals
 *
 * Akun super_admin & admin_diklat (id 1 & 2) TIDAK disentuh.
 * Kegiatan/acara di m_diklats TIDAK dihapus (dipakai sebagai acuan absensi).
 *
 * Jalankan dengan:
 *   php artisan db:seed --class=Database\\Seeders\\TestingDataSeeder
 */
class TestingDataSeeder extends Seeder
{
    /** Cache nama unit (huruf besar) -> ['id' => uuid, 'slug' => slug] */
    private array $unitCache = [];

    /** Daftar email yang sudah dipakai (huruf kecil) agar tidak bentrok unique constraint */
    private array $usedEmails = [];

    /**
     * Daftar nama orang (huruf besar, dinormalisasi) yang SUDAH dibuatkan
     * akun — dipakai lintas pegawai internal, karyawan eksternal vendor,
     * DAN peserta eksternal PKL/Magang/Orientasi, supaya satu orang yang
     * kebetulan tercatat di lebih dari satu sumber data tidak dibuatkan
     * akun dobel (nama dicek berurutan: pegawai -> karyawan vendor ->
     * peserta eksternal; yang lebih dulu dibuat yang dipertahankan).
     */
    private array $namaTerpakai = [];

    /** @var \Illuminate\Support\Carbon */
    private $periodeMulai;
    /** @var \Illuminate\Support\Carbon */
    private $periodeSelesai;

    public function run(): void
    {
        $this->periodeMulai   = Carbon::create(2026, 7, 1, 0, 0, 0);
        $this->periodeSelesai = Carbon::now()->greaterThan(Carbon::create(2026, 10, 2))
            ? Carbon::now()
            : Carbon::create(2026, 10, 2, 23, 59, 59);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->command->info('1/9  Membersihkan data lama...');
        $this->bersihkanDataLama();

        $this->command->info('2/9  Menyiapkan unit (m_units) dari Excel...');
        // unit di-resolve on the fly per baris, tidak perlu langkah terpisah

        $this->command->info('3/9  Membuat 55 pegawai internal dari Excel...');
        $pegawaiIds = $this->seedPegawaiInternal();

        $this->command->info('4/9  Membuat 52 karyawan eksternal (vendor)...');
        $karyawanIds = $this->seedKaryawanEksternal($pegawaiIds);

        $this->command->info('5/9  Membuat 53 peserta eksternal (PKL/Magang/Orientasi)...');
        $pesertaIds = $this->seedPesertaEksternal($pegawaiIds);

        $this->command->info('6/9  Membuat acara diklat baru (Jul-Okt 2026)...');
        $this->seedAcara($pegawaiIds);

        $this->command->info('7/9  Mengisi absensi diklat per-acara...');
        $this->seedAbsensiDiklat($pegawaiIds, $pesertaIds, $karyawanIds);

        $this->command->info('8/9  Mengisi diklat mandiri & progress e-learning pegawai...');
        $this->seedDiklatMandiri($pegawaiIds);
        $this->seedElearningProgress($pegawaiIds);

        $this->command->info('9/9  Mengisi absensi harian & jurnal peserta eksternal...');
        $this->seedAbsensiHarianDanJurnal(array_merge($pesertaIds, $karyawanIds), $pesertaIds);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Selesai! Data demo Juli-Oktober 2026 siap dipakai.');
        $this->tampilkanContohLogin($pegawaiIds, $karyawanIds, $pesertaIds);
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: tampilkan beberapa contoh akun untuk login saat demo.
    // Semua user (pegawai, karyawan eksternal, peserta eksternal)
    // memakai password yang sama: "password".
    //   - Pegawai login pakai NIK
    //   - Karyawan eksternal & peserta eksternal login pakai email
    // ────────────────────────────────────────────────────────────────
    private function tampilkanContohLogin(array $pegawaiIds, array $karyawanIds, array $pesertaIds): void
    {
        $this->command->info('');
        $this->command->info('=== Contoh akun untuk demo (password semua: "password") ===');

        $this->command->info('-- Pegawai (login pakai NIK) --');
        foreach (array_slice($pegawaiIds, 0, 3) as $p) {
            $this->command->info("  NIK: {$p['nip']}  | {$p['nama']} ({$p['unit']})");
        }

        $this->command->info('-- Karyawan Eksternal / Vendor (login pakai email) --');
        foreach (array_slice($karyawanIds, 0, 3) as $k) {
            $this->command->info("  Email: {$k['email']}  | {$k['nama']} ({$k['jenis']})");
        }

        $this->command->info('-- Peserta Eksternal PKL/Magang/Orientasi (login pakai email) --');
        foreach (array_slice($pesertaIds, 0, 3) as $pe) {
            $this->command->info("  Email: {$pe['email']}  | {$pe['nama']} ({$pe['jenis']})");
        }

        $this->command->info('=============================================================');
    }

    // ────────────────────────────────────────────────────────────────
    // 0. Bersihkan data lama
    // ────────────────────────────────────────────────────────────────
    private function bersihkanDataLama(): void
    {
        DB::table('record_absensi_diklats')->truncate();
        DB::table('diklat_mandiris')->truncate();
        DB::table('elearning_progress')->truncate();
        DB::table('external_daily_attendances')->truncate();
        DB::table('jurnal_eksternals')->truncate();
        DB::table('detail_eksternals')->truncate();

        // Hapus semua user KECUALI super_admin & admin_diklat (id 1 & 2 / role tsb)
        DB::table('users')->whereNotIn('role', ['super_admin', 'admin_diklat'])->delete();
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: resolve / buat unit di m_units (via model MUnit, supaya
    // slug & field lain yang di-generate otomatis oleh model tetap konsisten
    // dengan cara MUnitSeeder bawaan membuat data), kembalikan slug
    // ────────────────────────────────────────────────────────────────
    private function resolveUnitSlug(string $namaUnit): string
    {
        $key = mb_strtoupper(trim($namaUnit));

        if (isset($this->unitCache[$key])) {
            return $this->unitCache[$key]['slug'];
        }

        $existing = MUnit::whereRaw('UPPER(nama) = ?', [$key])->first();

        if ($existing) {
            $this->unitCache[$key] = ['id' => $existing->id, 'slug' => $existing->slug];
            return $existing->slug;
        }

        $namaRapi = mb_convert_case(mb_strtolower($namaUnit), MB_CASE_TITLE, 'UTF-8');
        $unit     = MUnit::create(['nama' => $namaRapi]);

        $this->unitCache[$key] = ['id' => $unit->id, 'slug' => $unit->slug];
        return $unit->slug;
    }

    private function resolveUnitId(string $namaUnit): string
    {
        $this->resolveUnitSlug($namaUnit); // memastikan cache terisi
        $key = mb_strtoupper(trim($namaUnit));
        return $this->unitCache[$key]['id'];
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: pastikan email unik (beberapa nama muncul di lebih dari
    // satu sumber Excel — misal pegawai yang juga tercatat di daftar
    // karyawan vendor). Duplikat akan diberi suffix +2, +3, dst.
    // ────────────────────────────────────────────────────────────────
    private function uniqueEmail(string $email): string
    {
        $email = mb_strtolower(trim($email));

        if (!isset($this->usedEmails[$email])) {
            $this->usedEmails[$email] = 1;
            return $email;
        }

        $this->usedEmails[$email]++;
        $n = $this->usedEmails[$email];

        [$local, $domain] = array_pad(explode('@', $email, 2), 2, 'gmail.com');
        return $local . '+' . $n . '@' . $domain;
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: hilangkan tanda titik di bagian sebelum "@" pada email
    // karyawan/peserta eksternal (mis. "ni.putu.aditya3@..." jadi
    // "niputuaditya3@..."). Tidak dipakai untuk pegawai internal
    // karena emailnya data asli dari Excel.
    // ────────────────────────────────────────────────────────────────
    private function noDotLocalPart(string $email): string
    {
        [$local, $domain] = array_pad(explode('@', $email, 2), 2, 'gmail.com');
        return str_replace('.', '', $local) . '@' . $domain;
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: cek & catat nama orang supaya 1 orang yang sama tidak
    // dibuatkan akun dobel walau tercatat di sumber data berbeda
    // (pegawai / karyawan vendor / peserta eksternal).
    // ────────────────────────────────────────────────────────────────
    private function isNamaDobel(string $nama): bool
    {
        return in_array(mb_strtoupper(trim($nama)), $this->namaTerpakai, true);
    }

    private function tandaiNamaDipakai(string $nama): void
    {
        $this->namaTerpakai[] = mb_strtoupper(trim($nama));
    }

    // ────────────────────────────────────────────────────────────────
    // Helper: bangun email dari nama tengah & nama belakang saja (tanpa
    // nama depan, tanpa domain kampus, tanpa titik). Dipakai khusus
    // untuk peserta eksternal PKL/Magang/Orientasi. Gelar/prefix seperti
    // "I", "Ni", "Dr", "Ns." dibuang dulu sebelum mengambil 2 kata
    // terakhir sebagai bahan email.
    // ────────────────────────────────────────────────────────────────
    private function emailFromMiddleLastName(string $nama): string
    {
        $prefixBuang = ['I', 'NI', 'IDA', 'AYU', 'AA', 'DR', 'NS', 'APT', 'DRG', 'BDN'];

        $kata = preg_split('/\s+/', trim($nama));
        $kata = array_values(array_filter(
            $kata,
            fn($w) => !in_array(mb_strtoupper(rtrim($w, '.')), $prefixBuang, true)
        ));

        if (count($kata) < 2) {
            $local = mb_strtolower($kata[0] ?? 'peserta');
            return $local . '@gmail.com';
        }

        // Ambil 2 kata terakhir = nama tengah & nama belakang
        $dipakai = array_slice($kata, -2);
        $local   = mb_strtolower(implode('', $dipakai));

        return $local . '@gmail.com';
    }

    // ────────────────────────────────────────────────────────────────
    // 1. Pegawai Internal (55 dari Excel sdm_user.xlsx)
    // ────────────────────────────────────────────────────────────────
    private function seedPegawaiInternal(): array
    {
        $pegawaiExcel = [
            ['Putu Agus Setiawan,S.Kom', 'ptagus20@gmail.com', 'IT'],
            ['NI MADE CINTYA PRADNYA P.', 'ni.made.cintya@rsuprimamedika.co.id', 'KASIR'],
            ['dr. KEZIA DEVINA DEODATIS', 'keziadeodatis02@gmail.com', 'UGD DAN POLI UMUM'],
            ['dr Made Adi Suryadarma', 'surya_moo@yahoo.co.id', 'UGD DAN POLI UMUM'],
            ['Ni Wayan Darmini', 'darminiprima@gmail.com', 'FARMASI'],
            ['Ni Wayan Putri Marheni,A.Md.Kep', 'Putri.marheni100@gmail.com', 'RIA'],
            ['Ni Ketut Yuni Widiantari,Amd.Rad', 'widiantari_y@yahoo.com', 'RADIOLOGI'],
            ['NI WAYAN DESWITA SANI DEWI, A.Md.Farm', 'wayandesy03@gmail.com', 'FARMASI'],
            ['Ns. Ni Kadek Trisnawati, S.Kep', 'nienhatrisnawati@gmail.com', 'FRONT OFFICE'],
            ['Ns. Ni Putu Adhytia Wulandari, S.Kep', 'adhytiawulandari96@gmail.com', 'FRONT OFFICE'],
            ['Wayan Mudiarsa', 'moodyedwin7@gmail.com', 'HOUSE KEEPING'],
            ['Ns. VINA MESA DEWI, S.Kep', 'vinamessadewi@gmail.com', 'FRONT OFFICE'],
            ['Ns. NI KOMANG NIA GITAWINDARI, S.Kep', 'niagitawindari97@gmail.com', 'RID'],
            ['AA Ngurah Roy Kesuma, ST.MM', 'rykmrth@gmail.com', 'SPI'],
            ['Ns.NI LUH PUTU SANDRA DEWI S.Kep', 'psandradewi10@gmail.com', 'UGD'],
            ['I Dewa Gede Wisesa Budiman, A.Md.Farm', 'wisesawisesi@gmail.com', 'FARMASI'],
            ['NI LUH PUTU NITA AGUSTINI', 'ni.luh.putu@rsuprimamedika.co.id', 'FARMASI'],
            ['I GUSTI AYU CITRA KUSMALA DEWI', 'gusti.ayu.citra@rsuprimamedika.co.id', 'RIA'],
            ['MADE WIDYASIH', 'made.widyasih@rsuprimamedika.co.id', 'FARMASI'],
            ['Kt Suci Widi Astrini', 'Erlinasurya83@gmail.com', 'DAPUR SAJI A'],
            ['dr Tjokorda Istri Agung  Pemayun, M.Kes,FISQua', 'tjokdoktermmr@gmail.com', 'MANAJEMEN'],
            ['I Made Rudy Antara', 'imaderudyantara@gmail.com', 'RID'],
            ['Luh Diari Danis', 'luhdiaridanis@gmail.com', 'OPERATOR'],
            ['I PUTU PANDE WAHYU GITAWIARSA, Amd. Rad', 'putu.pande.wahyu@rsuprimamedika.co.id', 'RADIOLOGI'],
            ['Bdn Ni Komang Kartika Ningsih,S.Tr.Keb', 'komangkartika23@gmail.com', 'RIC'],
            ['I Gusti Agung Bagus Putu Aryawan', 'aryawanbagus9@gmail.com', 'GARDENER'],
            ['I Wayan Wiratmaka', 'wiraawica@gmail.com', 'CASEMIX'],
            ['Ni Luh Kadek Novayanti, S.Tr.Keb', 'novaderavk@gmail.com', 'VK'],
            ['SITI MURTININGSIH, Amd.Rad', 'siti.murtiningsih@rsuprimamedika.co.id', 'RADIOLOGI'],
            ['Ni Kadek Yogi Melawati', 'yogimelawati24@gmail.com', 'RID'],
            ['Dr Ni Nyoman Risana Dewi, MARS.', 'risana.yukta@gmail.com', 'MANAJEMEN'],
            ['Gede Wisnu Arisaputra,A.Md.Kep', 'wisnurock121189@gmail.com', 'UGD'],
            ['I Made Sutha Nuriawan', 'suthanuriawan02@gmail.com', 'RADIOLOGI'],
            ['Sarah Andriani Putri, S.Farm., Apt.', 'sarah.putri@hotmail.com', 'FARMASI'],
            ['I Made Dion Aptama Putra', 'dionap98@gmail.com', 'REKAM MEDIS'],
            ['Ni Nyoman Rahayu Utami, A.Md.Keb', 'putuvaniaputriwirmantara@gmail.com', 'FRONT OFFICE'],
            ['ATIK BUDIYANI', 'atik.budiyani@rsuprimamedika.co.id', 'PAJAK'],
            ['I PUTU DIKI KRISNAWAN', 'dikikris@gmail.com', 'HD'],
            ['NI LUH KOMANG DESIANI', 'ni.luh.komang@rsuprimamedika.co.id', 'NICU'],
            ['apt.Ni Made Rahayu Nusarini,S.Farm.', 'rahayunusarini@gmail.com', 'FARMASI'],
            ['Ni Putu Diah Artikawati, A.Md.Kep', 'diahartikawati@gmail.com', 'RAWAT JALAN'],
            ['Putu Widiastari, A.Md.Keb', 'putuwidiastari1993@gmail.com', 'RAWAT JALAN'],
            ['PUTU NOVITA SUGIARTINI A.Md.Keb', 'Novita@Gmail.com', 'KND'],
            ['I Dewa Ayu Putri Andayani, S.Kep', 'putriandayani1712@gmail.com', 'CASEMIX'],
            ['I Wayan Mudiarta', 'wayanmudiartasandi@gmail.com', 'LAUNDRY'],
            ['Ns. Ni Luh Sumartini, S.Kep', 'niluhsumartini561@gmail.com', 'RIC'],
            ['Ns. Kadek Ayu Dwi Astari, S.Kep', 'ayudwiastari53@gmail.com', 'UGD'],
            ['Ni Made Indrayanti, A.Md.Farm', 'indrayanti01@gmail.com', 'FARMASI'],
            ['I Wayan Suardika (Satpam)', 'suardikavandichi@gmail.com', 'SATPAM'],
            ['I Ketut Wirnata', 'ketutwinarta1986@gmail.com', 'SATPAM'],
            ['Ni Putu Sri Rahayu', 'tanayakinandari@gmail.com', 'VK'],
            ['Ida Ayu Septya Dewi', 'idaayuseptyadewi@gmail.com', 'KASIR'],
            ['Ketut Labayasa', 'yasalaba8@gmail.com', 'SOPIR'],
            ['SYURYANA ZULFAN FADLI', 'syuryana.zulfan.fadli@rsuprimamedika.co.id', 'ELEKTRO MEDIS'],
            ['I Gusti Ayu Yully Eka Dewi A. Md. Farm', 'ayuekadewi.ad2015@gmail.com', 'FARMASI'],
        ];
        $ids = [];
        $nipCounter = 100001;

        foreach ($pegawaiExcel as $row) {
            [$namaRaw, $email, $namaUnit] = $row;
            $nama = trim(preg_replace('/\s+/', ' ', $namaRaw));

            if ($this->isNamaDobel($nama)) {
                // Nama dobel di dalam daftar pegawai itu sendiri — lewati.
                continue;
            }

            $slug = $this->resolveUnitSlug($namaUnit);
            $nip  = (string) $nipCounter++;

            $id = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nama'       => $nama,
                'nip'        => $nip,
                'email'      => $this->uniqueEmail($email),
                'password'   => Hash::make('password'),
                'role'       => 'pegawai',
                'type'       => 'internal',
                'unit'       => $slug,
                'hp'         => '08' . rand(100000000, 999999999),
                'alamat'     => 'Denpasar, Bali',
                'isActive'   => 1,
                'created_at' => $this->periodeMulai->copy()->subDays(rand(30, 400)),
                'updated_at' => now(),
            ]);

            $this->tandaiNamaDipakai($nama);

            $ids[] = ['id' => $id, 'nama' => $nama, 'unit' => $slug, 'nip' => $nip];
        }

        return $ids;
    }

    // ────────────────────────────────────────────────────────────────
    // 2. Karyawan Eksternal Vendor (52 dari Excel sdm_karyawan.xlsx)
    //    Dibagi: ISS 9, BSS 8, Adidaya 8, Bayi Tabung 5, Koperasi 10, Lotus SPA 12
    // ────────────────────────────────────────────────────────────────
    private function seedKaryawanEksternal(array $pegawaiIds): array
    {
        $karyawanExcel = [
            ['DAVIS KHOIRUL AKMAL, A.Md.Kep', 'davisakmal123@gmail.com', 'L', 'KND', 'iss'],
            ['REGITA FITRA ARYANINGSIH, A.Md.Kes', 'rere.regitaf19@gmail.com', 'P', 'LAB.PK', 'iss'],
            ['Mariana Yovita Shindy Gero', 'shindygero@gmail.com', 'P', 'FRONT OFFICE', 'iss'],
            ['I Made Sutha Nuriawan', 'suthanuriawan02@gmail.com', 'L', 'RADIOLOGI', 'iss'],
            ['Ni Komang Triani, A.Md.Kep', 'komangtriani86@gmail.com', 'P', 'OK A', 'iss'],
            ['Ni Luh Putu Suryaningsih', 'putusuryaningsih20@gmail.com', 'P', 'HOUSE KEEPING', 'iss'],
            ['I MADE MEGA PURNAMA', 'made.mega.purnama@gmail.com', 'P', 'RIA', 'iss'],
            ['FARIZ AGAM FADLILAH', 'fariz@gmail.com', 'L', 'REKAM MEDIS', 'iss'],
            ['Kadek Dwi Yuliastuti, A.Md.Kep', 'dwiyuliastuti1989@gmail.com', 'P', 'ICU', 'iss'],
            ['Komang Adi Swandana', 'Swandanaadi534@gmail.com', 'L', 'SOPIR', 'bss'],
            ['DEWA MADE WIGUNA', 'dewa.made.wiguna@gmail.com', 'L', 'ICU', 'bss'],
            ['Muhammad Amwad Bakur H', 'Dayakmaster4@gmail.com', 'L', 'PETUGAS PARKIR', 'bss'],
            ['I Putu Hery Saputra', 'herysaputra24@gmail.com', 'P', 'UGD', 'bss'],
            ['Ni Luh Anik Widhiani Agusthini', 'aniekhyos@gmail.com', 'P', 'KND', 'bss'],
            ['Putu Dewik Hustaria, S.S', 'hustharia@gmail.com', 'P', 'OPERATOR', 'bss'],
            ['I Gede Arma Reka Prima Yoga, A.Md', 'rekayoga@gmail.com', 'L', 'LAB.PA', 'bss'],
            ['Ni Kadek Ariani', 'kadekariani9986@gmail.com', 'P', 'CSSD', 'bss'],
            ['dr. I GUSTI NGURAH PRATAMA YUDA ATMAJA', 'pyuda74@gmail.com', 'L', 'UGD DAN POLI UMUM', 'adidaya'],
            ['dr Tjokorda Istri Agung  Pemayun, M.Kes,FISQua', 'tjokdoktermmr@gmail.com', 'P', 'MANAJEMEN', 'adidaya'],
            ['Gusti Ayu Putu Suci Aris Purwanti,Amd.Kep', 'suciarispurwanti@gmail.com', 'P', 'RAWAT JALAN', 'adidaya'],
            ['Apt. PUTU EKA CITA, S.Farm', 'eka.cita92@gmail.com', 'L', 'FARMASI', 'adidaya'],
            ['Ni Made Kartalina Lestari, Amd.Far', 'Kartalina06@gmail.com', 'P', 'FARMASI', 'adidaya'],
            ['I Putu Indra Setiawan, S.M.', 'indra.setiawan.iputu@gmail.com', 'L', 'REKAM MEDIS', 'adidaya'],
            ['Ns. PUTU WIDI PURNAMA GIRI, S.Kep', 'primadana838@gmail.com', 'L', 'RID', 'adidaya'],
            ['PUTU ASMIRAHATI, S.KM', 'putuasmirahati421@gmail.com', 'P', 'UPM', 'adidaya'],
            ['Putu Rika Rosita Dewi,A.Md.Kep', 'icadewi039@gmail.com', 'P', 'RAWAT JALAN', 'bayi_tabung'],
            ['Drg Femmy Wahyuni Surya, MPH', 'drgfemmy@gmail.com', 'P', 'SPI', 'bayi_tabung'],
            ['dr.Maria Saulina Wahyuningtyas Malelak, S.Ked', 'mariasaulinamalelak@gmail.com', 'P', 'UGD DAN POLI UMUM', 'bayi_tabung'],
            ['Ida Ayu Komang Trisanti,A.Md.Kep', 'idaayukomangtrisanti@gmail.com', 'P', 'RIA', 'bayi_tabung'],
            ['Apt. NI LUH CINTYA DARMIA PUTRI, S.Farm', 'cintya@gmail.com', 'P', 'FARMASI', 'bayi_tabung'],
            ['NI KOMANG INDAH CAHYANI', 'ni.komang.indah@gmail.com', 'P', 'KASIR', 'koperasi'],
            ['Mas Ayu Oka Adi Junilasari, A.Md.Keb', 'okajunilasari@gmail.co.id', 'P', 'NICU', 'koperasi'],
            ['I Made Darmawan', 'darmawan12394@gmail.com', 'L', 'FARMASI', 'koperasi'],
            ['Ns. I Dewa Gede Ngurah Ari Baskara. S.Kep. MM', 'kabagperencanaanrspm@gmail.com', 'L', 'MANAJEMEN', 'koperasi'],
            ['I Dewa Putu Suwantara', 'dewasuwantara61@gmail.com', 'L', 'TEKNISI', 'koperasi'],
            ['Ni Putu Sri Budiastuti, SH', 'putusriastuti26@gmail.com', 'P', 'PENGADAAN', 'koperasi'],
            ['dr. Putu Sarjana, Sp.OG.Subsp.ObgynSos, CHPRM, CHAE, MH.Kes., FisQua', 'drputusarjana@gmail.com', 'L', 'MANAJEMEN', 'koperasi'],
            ['Ni Ketut Pitma Dewi', 'pitmadewi140785@gmail.com', 'P', 'PENGADAAN', 'koperasi'],
            ['I GUSTI AYU AGUNG HESTY PRABAWANTI', 'gusti.ayu.agung@gmail.com', 'P', 'NICU', 'koperasi'],
            ['Ni Putu Eka Senjayanti, A.Md.Keb', 'ekasenjayanti86@gmail.com', 'P', 'RIC', 'koperasi'],
            ['Nyoman Samescaya', 'nsamescaya@gmail.com', 'L', 'SATPAM', 'lotus_spa'],
            ['Ns. NI WAYAN ARI UTAMI, S.Kep', 'ariutami57@gmail.com', 'P', 'RIC', 'lotus_spa'],
            ['MADE GITA CANDRA DEWI, A.Md,Kes', 'gitacandra@gmail.com', 'P', 'LAB.PA', 'lotus_spa'],
            ['dr I Gusti Nyoman Trianantha Jaya, S.Ked', 'drgustri@gmail.com', 'L', 'UGD DAN POLI UMUM', 'lotus_spa'],
            ['Ns. NI KOMANG SINDY OCTAVIANA DEWI, S.Kep', 'sindyoctavina@gmail.com', 'P', 'UGD', 'lotus_spa'],
            ['Ns. Ni Putu Adhytia Wulandari, S.Kep', 'adhytiawulandari96@gmail.com', 'P', 'FRONT OFFICE', 'lotus_spa'],
            ['I PUTU MAS MAHAPUTRA WIBAWA', 'masmahaputra@gmail.com', 'L', 'KASIR', 'lotus_spa'],
            ['PUTU ARY CENDANI L', 'putu.ary.cendani@gmail.com', 'P', 'RID', 'lotus_spa'],
            ['Ni Luh Karmini', 'niluhkarmini06@gmail.com', 'P', 'LAUNDRY', 'lotus_spa'],
            ['dr. KASPAR T.KAKUM', 'kaspartkakum@gmail.com', 'L', 'UGD DAN POLI UMUM', 'lotus_spa'],
            ['I GEDE YODHI TRISMAWAN', 'gede.yodhi.trismawan@gmail.com', 'P', 'FARMASI', 'lotus_spa'],
            ['Ni Putu dewi sumitri', 'dewisumitri@gmail.com', 'P', 'CAFÉ GARDENIA', 'lotus_spa'],
        ];
        // Vendor per baris sudah ditulis langsung di kolom ke-5 setiap
        // karyawan di atas (bukan ditentukan dari posisi/urutan lagi).
        $vendorMap = [
            'iss'         => ['jenis' => 'karyawan_iss',         'vendor' => 'ISS'],
            'bss'         => ['jenis' => 'karyawan_bss',         'vendor' => 'BSS'],
            'adidaya'     => ['jenis' => 'karyawan_adidaya',     'vendor' => 'PT. Adidaya'],
            'bayi_tabung' => ['jenis' => 'karyawan_bayi_tabung', 'vendor' => 'Bayi Tabung'],
            'koperasi'    => ['jenis' => 'karyawan_koperasi',    'vendor' => 'Koperasi'],
            'lotus_spa'   => ['jenis' => 'karyawan_lotus_spa',   'vendor' => 'Lotus SPA'],
        ];

        $supervisorPool = array_column($pegawaiIds, 'id');
        $ids = [];

        foreach ($karyawanExcel as $row) {
            [$namaRaw, $email, , $namaUnit, $vendorKey] = $row;
            $blok = $vendorMap[$vendorKey];

            $nama = trim(preg_replace('/\s+/', ' ', $namaRaw));

            if ($this->isNamaDobel($nama)) {
                // Orang ini sudah terdaftar sebelumnya (sebagai pegawai
                // internal, atau karyawan vendor lain) — lewati supaya
                // tidak dobel.
                continue;
            }

            // Unit untuk karyawan vendor BUKAN nama departemen rumah sakit
            // (itu identik dengan unit pegawai) — tapi nama vendornya
            // sendiri (ISS, BSS, PT. Adidaya, dst), supaya pada laporan
            // ekspor & rekap jam langsung kelihatan kalau orang ini
            // karyawan vendor, bukan pegawai RS.
            $slug       = $this->resolveUnitSlug($blok['vendor']);
            $idUnit     = $this->resolveUnitId($blok['vendor']);
            $emailUnik  = $this->uniqueEmail($this->noDotLocalPart($email));

            $userId = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nama'       => $nama,
                'nip'        => null,
                'email'      => $emailUnik,
                'password'   => Hash::make('password'),
                'role'       => 'peserta_eksternal',
                'type'       => 'external',
                'unit'       => $slug,
                'isActive'   => 1,
                'created_at' => $this->periodeMulai->copy()->subDays(rand(10, 200)),
                'updated_at' => now(),
            ]);

            $mulai = $this->periodeMulai->copy()->subDays(rand(30, 300));

            DB::table('detail_eksternals')->insert([
                'id_user'         => $userId,
                'jenis'           => $blok['jenis'],
                'institusi'       => $blok['vendor'],
                'vendor'          => $blok['vendor'],
                'id_unit'         => $idUnit,
                'id_supervisor'   => $supervisorPool[array_rand($supervisorPool)],
                'tanggal_mulai'   => $mulai,
                'tanggal_selesai' => null,
                'status'          => 'aktif',
                'approval_status' => 'approved',
                'approval_note'   => null,
                'cert_qr_token'   => (string) Str::uuid(),
                'created_by'      => 1,
                'created_at'      => $mulai,
                'updated_at'      => now(),
            ]);

            $this->tandaiNamaDipakai($nama);

            $ids[] = ['id' => $userId, 'nama' => $nama, 'jenis' => $blok['jenis'], 'vendor' => $blok['vendor'], 'unit' => $slug, 'email' => $emailUnik, 'mulai' => $mulai];
        }

        return $ids;
    }

    // ────────────────────────────────────────────────────────────────
    // 3. Peserta Eksternal PKL / Magang / Orientasi (53, nama realistis)
    // ────────────────────────────────────────────────────────────────
    private function seedPesertaEksternal(array $pegawaiIds): array
    {
        $pesertaEksternalExcel = [
            ['pkl', 'I Made Suartini Lanang', 'i.made.suartini1@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Made Suartini Yasa', 'made.suartini.yasa2@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'Ni Putu Aditya Sari', 'ni.putu.aditya3@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Sinta Kencana Putra', 'sinta.kencana.putra4@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Ahmad Wardani Widnyana', 'ahmad.wardani.widnyana5@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Putu Hartati Sudiarta', 'putu.hartati.sudiarta6@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'Made Puspita Wiguna', 'made.puspita.wiguna7@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'Indra Wira Pradnyani', 'indra.wira.pradnyani8@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'Ni Putu Suartini Mahardika', 'ni.putu.suartini9@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'Ni Nyoman Arimbawa Diah', 'ni.nyoman.arimbawa10@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'I Gede Surya Giri', 'i.gede.surya11@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Muhammad Wira Candra', 'muhammad.wira.candra12@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Indra Darmayanti Pradnyani', 'indra.darmayanti.pradnyani13@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'Reza Hartati Sari', 'reza.hartati.sari14@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
            ['pkl', 'Putu Wardani Candra', 'putu.wardani.candra15@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Yoga Krisnanda Dewi', 'yoga.krisnanda.dewi16@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Yoga Kusuma Lanang', 'yoga.kusuma.lanang17@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'Yoga Puspita Suandewi', 'yoga.puspita.suandewi18@poltekkes-denpasar.ac.id', 'Poltekkes Kemenkes Denpasar'],
            ['pkl', 'Made Oka Utami', 'made.oka.utami19@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Ayu Udayana Candra', 'ayu.udayana.candra20@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'Made Dharma Suandewi', 'made.dharma.suandewi21@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'I Ketut Saputra Wijaya', 'i.ketut.saputra22@poltekkes-denpasar.ac.id', 'Poltekkes Kemenkes Denpasar'],
            ['pkl', 'Indra Kusuma Sukmawati', 'indra.kusuma.sukmawati23@unmas.ac.id', 'Universitas Mahasaraswati Denpasar'],
            ['pkl', 'Ni Wayan Suryani Yasa', 'ni.wayan.suryani24@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Ni Luh Sastra Sudiarta', 'ni.luh.sastra25@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
            ['pkl', 'Ni Wayan Suartini Lanang', 'ni.wayan.suartini26@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
            ['pkl', 'Bayu Wisnawa Narayana', 'bayu.wisnawa.narayana27@stikesbali.ac.id', 'STIKES Bali'],
            ['pkl', 'Fadli Krisnanda Wijaya', 'fadli.krisnanda.wijaya28@student.unud.ac.id', 'Universitas Udayana'],
            ['pkl', 'Sinta Aditya Yasa', 'sinta.aditya.yasa29@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['pkl', 'Dimas Surya Giri', 'dimas.surya.giri30@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['pkl', 'Dinda Pratama Krisna', 'dinda.pratama.krisna31@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
            ['pkl', 'Lestari Arimbawa Wijaya', 'lestari.arimbawa.wijaya32@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['pkl', 'Muhammad Arimbawa Antara', 'muhammad.arimbawa.antara33@warmadewa.ac.id', 'Universitas Warmadewa'],
            ['magang', 'Indra Wardani Narayana', 'indra.wardani.narayana34@unmas.ac.id', 'Universitas Mahasaraswati Denpasar'],
            ['magang', 'Ahmad Wulandari Sari', 'ahmad.wulandari.sari35@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['magang', 'Wulan Wulandari Widnyana', 'wulan.wulandari.widnyana36@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'I Gede Hartati Dewi', 'i.gede.hartati37@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'I Putu Yudha Sari', 'i.putu.yudha38@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'Sinta Puspita Krisna', 'sinta.puspita.krisna39@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
            ['magang', 'Dimas Febriyanti Sudiarta', 'dimas.febriyanti.sudiarta40@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'I Nyoman Suryani Sudiarta', 'i.nyoman.suryani41@undiksha.ac.id', 'Universitas Pendidikan Ganesha (Undiksha)'],
            ['magang', 'Novi Wardani Dewi', 'novi.wardani.dewi42@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['magang', 'Dewi Suartini Wiguna', 'dewi.suartini.wiguna43@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['magang', 'Komang Puspita Krisna', 'komang.puspita.krisna44@unmas.ac.id', 'Universitas Mahasaraswati Denpasar'],
            ['magang', 'Novi Darmayanti Lanang', 'novi.darmayanti.lanang45@unmas.ac.id', 'Universitas Mahasaraswati Denpasar'],
            ['magang', 'I Gede Wardani Krisna', 'i.gede.wardani46@stikom-bali.ac.id', 'ITB STIKOM Bali'],
            ['magang', 'Anggun Aditya Sari', 'anggun.aditya.sari47@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'Rani Febriyanti Suandewi', 'rani.febriyanti.suandewi48@stikesbali.ac.id', 'STIKES Bali'],
            ['magang', 'Ni Komang Darmayanti Candra', 'ni.komang.darmayanti49@student.unud.ac.id', 'Universitas Udayana'],
            ['magang', 'Reza Wardani Diah', 'reza.wardani.diah50@poltekkes-denpasar.ac.id', 'Poltekkes Kemenkes Denpasar'],
            ['orientasi', 'Made Puspita Diah', 'made.puspita.diah51@stikesbali.ac.id', 'STIKES Bali'],
            ['orientasi', 'Anggun Surya Wiguna', 'anggun.surya.wiguna52@student.unud.ac.id', 'Universitas Udayana'],
            ['orientasi', 'Lestari Dharma Narayana', 'lestari.dharma.narayana53@poltekkes-denpasar.ac.id', 'Politeknik Kesehatan Denpasar'],
        ];
        $supervisorPool = array_column($pegawaiIds, 'id');
        $unitPool       = array_values($this->unitCache);
        $ids = [];

        foreach ($pesertaEksternalExcel as $row) {
            [$jenis, $namaRaw, $email, $institusi] = $row;
            $nama = trim(preg_replace('/\s+/', ' ', $namaRaw));

            if ($this->isNamaDobel($nama)) {
                // Orang ini sudah terdaftar sebelumnya sebagai pegawai
                // internal atau karyawan vendor — lewati supaya tidak dobel.
                continue;
            }

            // Email dibangun dari nama tengah & nama belakang saja (tanpa
            // nama depan, tanpa domain kampus, tanpa titik) — bukan dari
            // kolom email di Excel lagi.
            $emailUnik = $this->uniqueEmail($this->emailFromMiddleLastName($nama));

            $userId = DB::table('users')->insertGetId([
                'name'       => $nama,
                'nama'       => $nama,
                'nip'        => null,
                'email'      => $emailUnik,
                'password'   => Hash::make('password'),
                'role'       => 'peserta_eksternal',
                'type'       => 'external',
                'unit'       => null,
                'isActive'   => 1,
                'created_at' => $this->periodeMulai->copy()->subDays(rand(5, 60)),
                'updated_at' => now(),
            ]);

            $durasiHari = $jenis === 'orientasi' ? rand(5, 14) : ($jenis === 'magang' ? rand(60, 90) : rand(30, 75));
            $mulai      = $this->periodeMulai->copy()->addDays(rand(0, 45));
            $selesai    = $mulai->copy()->addDays($durasiHari);
            $sudahLewat = $selesai->lessThan($this->periodeSelesai);

            $unit = !empty($unitPool) ? $unitPool[array_rand($unitPool)] : null;

            DB::table('detail_eksternals')->insert([
                'id_user'         => $userId,
                'jenis'           => $jenis,
                'institusi'       => $institusi,
                'vendor'          => null,
                'id_unit'         => $unit['id'] ?? null,
                'id_supervisor'   => $supervisorPool[array_rand($supervisorPool)],
                'tanggal_mulai'   => $mulai,
                'tanggal_selesai' => $selesai,
                'status'          => $sudahLewat ? 'selesai' : 'aktif',
                'approval_status' => 'approved',
                'approval_note'   => null,
                'cert_qr_token'   => (string) Str::uuid(),
                'created_by'      => 1,
                'created_at'      => $mulai->copy()->subDays(rand(1, 5)),
                'updated_at'      => now(),
            ]);

            $this->tandaiNamaDipakai($nama);

            $ids[] = [
                'id' => $userId, 'nama' => $nama, 'jenis' => $jenis, 'email' => $emailUnik,
                'mulai' => $mulai, 'selesai' => $selesai,
            ];
        }

        return $ids;
    }

    // ────────────────────────────────────────────────────────────────
    // 3b. Acara Diklat baru (m_diklats) dalam periode Jul-Okt 2026.
    //     m_diklats TIDAK di-truncate — ini menambah acara baru supaya
    //     rekap jam & absensi diklat punya cukup data di periode demo
    //     (termasuk awal Oktober, yang sebelumnya belum ada acara sama
    //     sekali). Narasumber dipilih dari pegawai Excel yang baru.
    // ────────────────────────────────────────────────────────────────
    private function seedAcara(array $pegawaiIds): void
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
        $now    = Carbon::now();

        foreach ($namaAcara as $nama) {
            $mulai   = $this->periodeMulai->copy()->addDays(rand(0, max(1, $this->periodeMulai->diffInDays($this->periodeSelesai))));
            $mulai->setTime(rand(8, 13), [0, 15, 30, 45][array_rand([0, 15, 30, 45])]);
            $selesai = $mulai->copy()->addHours(rand(2, 8));

            if ($now->greaterThan($selesai)) {
                $st = 'Selesai';
            } elseif ($now->between($mulai, $selesai)) {
                $st = 'Berlangsung';
            } else {
                $st = 'Terbuka';
            }

            $narasumber = $pegawaiIds[array_rand($pegawaiIds)]['nama'];

            DB::table('m_diklats')->insert([
                'img'            => null,
                'nama'           => $nama,
                'deskripsi'      => 'Pelatihan ' . $nama . ' diselenggarakan oleh Bidang Diklat RSU Prima Medika.',
                'namaNarasumber' => $narasumber,
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

    // ────────────────────────────────────────────────────────────────
    // 4. Absensi Diklat per-acara (acara m_diklats yang jatuh pada
    //    periode Jul-Okt 2026). Dipakai utk Rekap Jam & Absensi Diklat.
    // ────────────────────────────────────────────────────────────────
    private function seedAbsensiDiklat(array $pegawaiIds, array $pesertaIds, array $karyawanIds): void
    {
        // Pakai LEFT(..., 10) supaya aman baik tglJamMulai tersimpan sebagai
        // datetime asli maupun string "Y-m-d\TH:i" (menghindari masalah
        // perbandingan string yang ada suffix waktu/"T").
        $acaraList = DB::table('m_diklats')
            ->whereRaw('LEFT(tglJamMulai, 10) >= ?', [$this->periodeMulai->format('Y-m-d')])
            ->whereRaw('LEFT(tglJamMulai, 10) <= ?', [$this->periodeSelesai->format('Y-m-d')])
            ->get(['id', 'tglJamMulai', 'durasi']);

        if ($acaraList->isEmpty()) {
            $this->command->warn('Tidak ada acara m_diklats pada periode Jul-Okt 2026 — lewati seedAbsensiDiklat.');
            return;
        }

        foreach ($acaraList as $acara) {
            $jumlahHadir  = max(5, (int) round(count($pegawaiIds) * (rand(40, 85) / 100)));
            $pesertaAcara = collect($pegawaiIds)->shuffle()->take($jumlahHadir);

            // Selipkan sebagian peserta eksternal (misal acara orientasi/K3)
            if (!empty($pesertaIds) && rand(0, 1)) {
                $pesertaAcara = $pesertaAcara->merge(collect($pesertaIds)->shuffle()->take(rand(3, 8)));
            }

            $tglAcara = Carbon::parse($acara->tglJamMulai);

            foreach ($pesertaAcara as $peserta) {
                $hadir = rand(1, 100) <= 90; // 90% hadir

                DB::table('record_absensi_diklats')->insert([
                    'id_user'     => $peserta['id'],
                    'id_diklat'   => $acara->id,
                    'namaPeserta' => $peserta['nama'],
                    'durasi'      => $hadir ? ((int) $acara->durasi * 60) : 0,
                    'date'        => $tglAcara->format('Y-m-d'),
                    'is_hadir'    => $hadir,
                    'created_at'  => $tglAcara,
                    'updated_at'  => now(),
                ]);
            }
        }
    }

    // ────────────────────────────────────────────────────────────────
    // 5. Diklat Mandiri pegawai (webinar/kursus online eksternal)
    // ────────────────────────────────────────────────────────────────
    private function seedDiklatMandiri(array $pegawaiIds): void
    {
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

        $statusPool  = ['Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Ditolak', 'pending'];
        $rentangHari = max(1, $this->periodeMulai->diffInDays($this->periodeSelesai));

        foreach ($namaDiklat as $nama) {
            $pegawai = $pegawaiIds[array_rand($pegawaiIds)];
            $st      = $statusPool[array_rand($statusPool)];
            $tgl     = $this->periodeMulai->copy()->addDays(rand(0, $rentangHari));

            DB::table('diklat_mandiris')->insert([
                'id'            => (string) Str::uuid(),
                'nama'          => $nama,
                'jenisDiklat'   => 'Diklat Mandiri',
                'tglJamMulai'   => $tgl->format('Y-m-d\TH:i'),
                'tglJamSelesai' => $tgl->copy()->addHours(rand(1, 4))->format('Y-m-d\TH:i'),
                'tempat'        => 'Online / Mandiri',
                'durasi'        => (string) rand(60, 240),
                'sertifikat'    => $st === 'Disetujui' ? 'sertifikat/mandiri/dummy.jpg' : '',
                'materi'        => null,
                'id_user'       => $pegawai['id'],
                'status'        => $st,
                'created_at'    => $tgl,
                'updated_at'    => now(),
            ]);
        }
    }

    // ────────────────────────────────────────────────────────────────
    // 6. Progress E-Learning pegawai (pakai modul elearning_modules
    //    yang sudah ada, tidak di-truncate)
    // ────────────────────────────────────────────────────────────────
    private function seedElearningProgress(array $pegawaiIds): void
    {
        $modules = DB::table('elearning_modules')->get(['id', 'estimasi_durasi_jam']);

        if ($modules->isEmpty()) {
            $this->command->warn('Tidak ada elearning_modules — lewati seedElearningProgress.');
            return;
        }

        // Enum asli kolom status: 'in_progress', 'completed', 'failed'
        // (tidak ada 'not_started').
        $statusPool  = ['completed', 'completed', 'completed', 'completed', 'in_progress', 'failed'];
        $rentangHari = max(1, $this->periodeMulai->diffInDays($this->periodeSelesai) - 5);

        foreach ($pegawaiIds as $pegawai) {
            $jumlahModul  = rand(2, 6);
            $modulDipilih = $modules->shuffle()->take($jumlahModul);

            foreach ($modulDipilih as $modul) {
                $status = $statusPool[array_rand($statusPool)];
                $mulai  = $this->periodeMulai->copy()->addDays(rand(0, $rentangHari));
                $selesaiProgress = in_array($status, ['completed', 'failed'])
                    ? $mulai->copy()->addDays(rand(1, 5))
                    : null;

                DB::table('elearning_progress')->insert([
                    'id_user'             => $pegawai['id'],
                    'id_modul'            => $modul->id,
                    'started_at'          => $mulai,
                    'completed_at'        => $selesaiProgress,
                    'quiz_score'          => $status === 'completed' ? rand(70, 100) : ($status === 'failed' ? rand(30, 59) : null),
                    'status'              => $status,
                    'jam_dikontribusikan' => $status === 'completed' ? ($modul->estimasi_durasi_jam ?? rand(1, 4)) : 0,
                    'created_at'          => $mulai,
                    'updated_at'          => now(),
                ]);
            }
        }
    }

    // ────────────────────────────────────────────────────────────────
    // 7. Absensi harian + jurnal harian peserta eksternal
    //    - Absensi harian: semua eksternal (peserta PKL/Magang/Orientasi
    //      & karyawan vendor)
    //    - Jurnal harian: hanya peserta PKL/Magang/Orientasi
    // ────────────────────────────────────────────────────────────────
    private function seedAbsensiHarianDanJurnal(array $allExternalIds, array $pesertaIdsOnly): void
    {
        $aktivitasPool = [
            'Mengikuti orientasi ruangan dan observasi pelayanan',
            'Membantu kegiatan administrasi di unit terkait',
            'Melakukan observasi tindakan keperawatan dengan supervisor',
            'Mengikuti bimbingan dari pembimbing lapangan',
            'Mempelajari SOP unit dan dokumentasi rekam medis',
            'Membantu kegiatan pelayanan pasien di bawah supervisi',
            'Menyusun laporan kegiatan harian',
            'Diskusi kasus dengan pembimbing lapangan',
        ];
        $kendalaPool = [
            'Tidak ada kendala berarti',
            'Masih menyesuaikan dengan SOP yang berlaku',
            'Perlu lebih banyak bimbingan teknis',
            '-',
        ];
        $rencanaPool = [
            'Melanjutkan observasi di unit yang sama',
            'Mengikuti rotasi ke unit berikutnya',
            'Menyelesaikan laporan praktik',
            'Melanjutkan tugas yang diberikan pembimbing',
        ];

        $pesertaIdSet = array_column($pesertaIdsOnly, 'id');

        foreach ($allExternalIds as $peserta) {
            $mulai   = isset($peserta['mulai']) ? Carbon::parse($peserta['mulai']) : $this->periodeMulai->copy();
            $selesai = isset($peserta['selesai']) && $peserta['selesai'] ? Carbon::parse($peserta['selesai']) : $this->periodeSelesai->copy();

            $awal  = $mulai->greaterThan($this->periodeMulai) ? $mulai->copy() : $this->periodeMulai->copy();
            $akhir = $selesai->lessThan($this->periodeSelesai) ? $selesai->copy() : $this->periodeSelesai->copy();

            if ($awal->greaterThan($akhir)) {
                continue;
            }

            $isJurnalPeserta = in_array($peserta['id'], $pesertaIdSet);

            $tgl = $awal->copy();
            while ($tgl->lessThanOrEqualTo($akhir)) {
                if ($tgl->isWeekend()) {
                    $tgl->addDay();
                    continue;
                }

                if (rand(1, 100) <= 85) { // 85% hadir
                    $checkin  = $tgl->copy()->setTime(rand(7, 8), rand(0, 59));
                    $checkout = $tgl->copy()->setTime(rand(15, 17), rand(0, 59));

                    DB::table('external_daily_attendances')->insert([
                        'id_user'     => $peserta['id'],
                        'tanggal'     => $tgl->format('Y-m-d'),
                        'checkin_at'  => $checkin,
                        'checkout_at' => $checkout,
                        'mode'        => 'gps',
                        'latitude'    => -8.65 + (rand(-50, 50) / 10000),
                        'longitude'   => 115.21 + (rand(-50, 50) / 10000),
                        'is_valid'    => 1,
                        'device_info' => 'Android - Chrome Mobile',
                        'catatan'     => null,
                        'created_at'  => $checkin,
                        'updated_at'  => $checkout,
                    ]);

                    if ($isJurnalPeserta) {
                        DB::table('jurnal_eksternals')->insert([
                            'id_user'       => $peserta['id'],
                            'tanggal'       => $tgl->format('Y-m-d'),
                            'aktivitas'     => $aktivitasPool[array_rand($aktivitasPool)],
                            'kendala'       => $kendalaPool[array_rand($kendalaPool)],
                            'rencana_besok' => $rencanaPool[array_rand($rencanaPool)],
                            'created_at'    => $tgl->copy()->setTime(17, rand(0, 59)),
                            'updated_at'    => now(),
                        ]);
                    }
                }

                $tgl->addDay();
            }
        }
    }
}
