<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Peserta Eksternal {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #fff;
            padding: 24px 32px;
        }

        /* Kop */
        .kop-table {
            width: 100%;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 10px;
            margin-bottom: 4px;
        }

        .kop-table td {
            vertical-align: top;
        }

        .kop-right {
            text-align: right;
            font-size: 9px;
            color: #555;
        }

        .kop-left h1 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }

        .kop-left p {
            font-size: 9px;
            color: #555;
            line-height: 1.6;
        }

        .divider-thin {
            height: 1px;
            background: #999;
            margin-bottom: 14px;
        }

        /* Judul */
        .judul {
            text-align: center;
            margin-bottom: 12px;
        }

        .judul h2 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 3px;
        }

        .judul .sub {
            font-size: 9px;
            color: #555;
        }

        /* Info Row */
        .info-table {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 12px;
            border-collapse: collapse;
            background: #fafafa;
        }

        .info-table td {
            padding: 7px 12px;
            border-right: 1px solid #ccc;
            vertical-align: top;
            width: 25%;
        }

        .info-table td:last-child {
            border-right: none;
        }

        .info-table .lbl {
            font-size: 7.5px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 2px;
        }

        .info-table .val {
            font-size: 10px;
            font-weight: bold;
            color: #1a1a1a;
        }

        /* Stats — pakai table agar sejajar di DomPDF */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 14px;
        }

        .stats-table td {
            width: 25%;
            border: 1px solid #d1d5db;
            border-radius: 3px;
            padding: 8px 10px;
            text-align: center;
            background: #fff;
        }

        .stats-table .s-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .stats-table .s-value {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            line-height: 1;
        }

        .stats-table .s-sub {
            font-size: 8px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .stat-total {
            border-top: 3px solid #374151 !important;
        }

        .stat-pkl {
            border-top: 3px solid #1d4ed8 !important;
        }

        .stat-magang {
            border-top: 3px solid #be185d !important;
        }

        .stat-orientasi {
            border-top: 3px solid #057a55 !important;
        }

        /* Main Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .main-table thead tr {
            background: #374151;
        }

        .main-table thead th {
            color: #fff;
            padding: 7px 8px;
            text-align: left;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border: 1px solid #374151;
        }

        .main-table thead th.tc {
            text-align: center;
        }

        .main-table tbody td {
            padding: 6px 8px;
            font-size: 9px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            color: #374151;
        }

        .main-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .tc {
            text-align: center;
        }

        .bold {
            font-weight: bold;
            color: #111;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: bold;
            border: 1px solid;
        }

        .b-pkl {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .b-magang {
            background: #fdf2f8;
            color: #be185d;
            border-color: #fbcfe8;
        }

        .b-orientasi {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .b-lain {
            background: #f9fafb;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        .b-aktif {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .b-selesai {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .b-belum {
            background: #f9fafb;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        /* Section title */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #374151;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* TTD */
        .ttd-table {
            width: 100%;
            margin-bottom: 16px;
        }

        .ttd-table td {
            vertical-align: top;
        }

        .ttd-box {
            text-align: center;
            width: 180px;
        }

        .ttd-box p {
            font-size: 9px;
            color: #333;
            line-height: 1.6;
        }

        .ttd-space {
            height: 44px;
        }

        .ttd-line {
            border-bottom: 1px solid #333;
            margin-bottom: 4px;
        }

        .ttd-name {
            font-size: 9px;
            font-weight: bold;
        }

        .ttd-nip {
            font-size: 8.5px;
            color: #555;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            border-top: 1px solid #d1d5db;
            padding-top: 6px;
            margin-top: 8px;
        }

        .footer-table td {
            font-size: 8px;
            color: #9ca3af;
        }

        .footer-table .fr {
            text-align: right;
        }

        .no-data {
            text-align: center;
            padding: 24px;
            color: #9ca3af;
            border: 1px dashed #d1d5db;
            font-size: 10px;
        }
    </style>
</head>

<body>

    {{-- Kop --}}
    <table class="kop-table">
        <tr>
            <td class="kop-left">
                <h1>Rumah Sakit Umum Prima Medika</h1>
                <p>Jl. Teknologi &mdash; Denpasar, Bali 80361</p>
                <p>Telp. (0361) 000000 &nbsp;|&nbsp; Email: info@rsupm.co.id</p>
            </td>
            <td class="kop-right">
                <p>No. Dok: LAP-EKS/{{ $tahun }}</p>
                <p>Tgl Cetak: {{ now()->format('d F Y') }}</p>
            </td>
        </tr>
    </table>
    <div class="divider-thin"></div>

    {{-- Judul --}}
    <div class="judul">
        <h2>Laporan Peserta Eksternal</h2>
        <div class="sub">
            Periode Tahun {{ $tahun }}
            @if($bulan) &mdash; Bulan {{ ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][(int)$bulan] }} @endif
            &mdash; {{ $jenis === 'semua' ? 'Semua Jenis Peserta' : 'Jenis: '.ucfirst($jenis) }}
        </div>
    </div>

    {{-- Info Row --}}
    <table class="info-table">
        <tr>
            <td>
                <div class="lbl">Periode</div>
                <div class="val">Tahun {{ $tahun }}{{ $bulan ? ' / '.['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'][(int)$bulan] : '' }}</div>
            </td>
            <td>
                <div class="lbl">Jenis Peserta</div>
                <div class="val">{{ $jenis === 'semua' ? 'Semua Jenis' : ucfirst($jenis) }}</div>
            </td>
            <td>
                <div class="lbl">Total Peserta</div>
                <div class="val">{{ $data->count() }} orang</div>
            </td>
            <td>
                <div class="lbl">Tanggal Cetak</div>
                <div class="val">{{ now()->format('d F Y, H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    {{-- Stats 4 sejajar --}}
    <table class="stats-table">
        <tr>
            <td class="stat-total">
                <div class="s-label">Total Peserta</div>
                <div class="s-value">{{ $data->count() }}</div>
                <div class="s-sub">orang</div>
            </td>
            <td class="stat-pkl">
                <div class="s-label">PKL</div>
                <div class="s-value">{{ $data->where('jenis', 'pkl')->count() }}</div>
                <div class="s-sub">peserta</div>
            </td>
            <td class="stat-magang">
                <div class="s-label">Magang</div>
                <div class="s-value">{{ $data->where('jenis', 'magang')->count() }}</div>
                <div class="s-sub">peserta</div>
            </td>
            <td class="stat-orientasi">
                <div class="s-label">Orientasi</div>
                <div class="s-value">{{ $data->where('jenis', 'orientasi')->count() }}</div>
                <div class="s-sub">peserta</div>
            </td>
        </tr>
    </table>

    {{-- Data Peserta --}}
    @if($data->count() > 0)

    {{-- 1. Data Identitas --}}
    <div class="section-title">1. Data Identitas & Periode Peserta</div>
    <table class="main-table" style="margin-bottom:16px;">
        <thead>
            <tr>
                <th class="tc" style="width:22px">No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th class="tc">Jenis</th>
                <th>Institusi</th>
                <th class="tc">Tgl Mulai</th>
                <th class="tc">Tgl Selesai</th>
                <th class="tc">Durasi</th>
                <th class="tc">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $detail)
            @php
            $mulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai) : null;
            $selesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai) : null;
            $durasi = ($mulai && $selesai) ? $mulai->diffInDays($selesai).' hari' : '-';
            $now = now();
            $status = !$mulai ? '-'
            : ($now->lt($mulai) ? 'Belum Mulai'
            : ($selesai && $now->gt($selesai) ? 'Selesai' : 'Aktif'));
            @endphp
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="bold">{{ $detail->user?->nama ?? '-' }}</td>
                <td>{{ $detail->user?->email ?? '-' }}</td>
                <td class="tc"><span class="badge b-{{ $detail->jenis ?? 'lain' }}">{{ ucfirst($detail->jenis ?? '-') }}</span></td>
                <td>{{ $detail->institusi ?? '-' }}</td>
                <td class="tc">{{ $mulai?->format('d M Y') ?? '-' }}</td>
                <td class="tc">{{ $selesai?->format('d M Y') ?? '-' }}</td>
                <td class="tc">{{ $durasi }}</td>
                <td class="tc"><span class="badge b-{{ $status === 'Aktif' ? 'aktif' : ($status === 'Selesai' ? 'selesai' : 'belum') }}">{{ $status }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 2. Rekap Kehadiran --}}
    <div class="section-title">2. Rekap Kehadiran & Absensi</div>
    <table class="main-table" style="margin-bottom:16px;">
        <thead>
            <tr>
                <th class="tc" style="width:22px">No</th>
                <th>Nama Peserta</th>
                <th class="tc">Total Hadir</th>
                <th class="tc">Hadir Valid</th>
                <th class="tc">Check-in Pertama</th>
                <th class="tc">Check-in Terakhir</th>
                <th class="tc">Di Luar Radius</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $detail)
            @php
            $user = $detail->user;
            $absensi = $user ? \App\Models\ExternalDailyAttendance::where('id_user', $user->id)->get() : collect();
            $totalHadir = $absensi->count();
            $hadirValid = $absensi->where('is_valid', true)->count();
            $diLuar = $absensi->where('is_valid', false)->count();
            $pertama = $absensi->sortBy('tanggal')->first()?->tanggal;
            $terakhir = $absensi->sortByDesc('tanggal')->first()?->tanggal;
            @endphp
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="bold">{{ $detail->user?->nama ?? '-' }}</td>
                <td class="tc">{{ $totalHadir }}</td>
                <td class="tc">{{ $hadirValid }}</td>
                <td class="tc">{{ $pertama ? \Carbon\Carbon::parse($pertama)->format('d M Y') : '-' }}</td>
                <td class="tc">{{ $terakhir ? \Carbon\Carbon::parse($terakhir)->format('d M Y') : '-' }}</td>
                <td class="tc">{{ $diLuar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 3. Rekap Jurnal --}}
    <div class="section-title">3. Rekap Jurnal Harian</div>
    <table class="main-table" style="margin-bottom:16px;">
        <thead>
            <tr>
                <th class="tc" style="width:22px">No</th>
                <th>Nama Peserta</th>
                <th class="tc">Total Jurnal</th>
                <th class="tc">Jurnal Pertama</th>
                <th class="tc">Jurnal Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $detail)
            @php
            $user = $detail->user;
            $jurnal = $user ? \App\Models\JurnalEksternal::where('id_user', $user->id)->get() : collect();
            $totalJurnal = $jurnal->count();
            $jPertama = $jurnal->sortBy('tanggal')->first()?->tanggal;
            $jTerakhir = $jurnal->sortByDesc('tanggal')->first()?->tanggal;
            @endphp
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="bold">{{ $detail->user?->nama ?? '-' }}</td>
                <td class="tc">{{ $totalJurnal }} entri</td>
                <td class="tc">{{ $jPertama ? \Carbon\Carbon::parse($jPertama)->format('d M Y') : '-' }}</td>
                <td class="tc">{{ $jTerakhir ? \Carbon\Carbon::parse($jTerakhir)->format('d M Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 4. Kegiatan & Acara --}}
    <div class="section-title">4. Kegiatan & Acara yang Diikuti</div>
    <table class="main-table" style="margin-bottom:16px;">
        <thead>
            <tr>
                <th class="tc" style="width:22px">No</th>
                <th>Nama Peserta</th>
                <th class="tc">Total Acara</th>
                <th>Acara Terakhir</th>
                <th class="tc">Total Jam Diklat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $detail)
            @php
            $user = $detail->user;
            $absensiDiklat = $user
            ? \App\Models\RecordAbsensiDiklat::with('diklat')
            ->where('id_user', $user->id)->get()
            : collect();
            $totalAcara = $absensiDiklat->pluck('id_diklat')->unique()->count();
            $acaraTerakhir = $absensiDiklat->sortByDesc('date')->first()?->diklat?->nama ?? '-';
            $totalJam = round($absensiDiklat->sum('durasi') / 60, 1);
            @endphp
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="bold">{{ $detail->user?->nama ?? '-' }}</td>
                <td class="tc">{{ $totalAcara }}</td>
                <td>{{ $acaraTerakhir }}</td>
                <td class="tc">{{ $totalJam }} jam</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <div class="no-data">Tidak ada data peserta eksternal untuk filter yang dipilih.</div>
    @endif

    {{-- TTD --}}
    <table class="ttd-table">
        <tr>
            <td></td>
            <td style="width:200px; text-align:center;">
                <p style="font-size:9px;">Denpasar, {{ now()->format('d F Y') }}</p>
                <p style="font-size:9px;">Kepala Bagian Diklat</p>
                <div class="ttd-space"></div>
                <div class="ttd-line"></div>
                <div class="ttd-name">( _________________________ )</div>
                <div class="ttd-nip">NIP. ___________________</div>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <table class="footer-table">
        <tr>
            <td>RSU Prima Medika &mdash; Sistem Informasi Diklat &amp; Seminar</td>
            <td class="fr">Dicetak: {{ now()->format('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

</body>

</html>