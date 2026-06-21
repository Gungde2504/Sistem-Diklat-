<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat — Sisi Belakang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            width: 297mm;
            height: 210mm;
            background: #fff;
            color: #1a2a3a;
            font-size: 9pt;
        }
        .page {
            width: 100%;
            height: 100%;
            padding: 12mm 15mm;
        }
        h1 {
            font-size: 11pt;
            text-align: center;
            font-weight: bold;
            margin-bottom: 2mm;
            text-transform: uppercase;
        }
        h2 {
            font-size: 9pt;
            text-align: center;
            font-weight: bold;
            margin-bottom: 1mm;
            text-transform: uppercase;
        }
        .subtitle {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 4mm;
            text-transform: uppercase;
        }
        .info-row {
            display: flex;
            gap: 10mm;
            margin-bottom: 4mm;
        }
        .info-item { font-size: 8.5pt; }
        .info-label { font-weight: bold; }

        /* Tabel Nilai */
        table.nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }
        table.nilai th {
            background: #1B5E7B;
            color: white;
            padding: 2mm 3mm;
            text-align: center;
            font-size: 8pt;
            border: 0.5pt solid #1B5E7B;
        }
        table.nilai td {
            padding: 1.8mm 3mm;
            border: 0.5pt solid #ccc;
            font-size: 8pt;
        }
        table.nilai td.center { text-align: center; }
        table.nilai tr.total td {
            font-weight: bold;
            background: #f0f7fb;
        }
        table.nilai tr.total-mutlak td {
            font-weight: bold;
            font-size: 10pt;
            background: #1B5E7B;
            color: white;
            text-align: center;
        }

        /* Layout bawah: tabel kualitas + QR */
        .bottom-row {
            display: flex;
            gap: 8mm;
            margin-top: 4mm;
            align-items: flex-start;
        }
        .keterangan { flex: 1; }
        .keterangan-title { font-size: 8pt; font-weight: bold; margin-bottom: 1.5mm; }
        table.kualitas {
            width: 100%;
            border-collapse: collapse;
        }
        table.kualitas th {
            background: #1B5E7B;
            color: white;
            padding: 1.5mm 2mm;
            font-size: 7.5pt;
            border: 0.5pt solid #1B5E7B;
            text-align: center;
        }
        table.kualitas td {
            padding: 1.5mm 2mm;
            border: 0.5pt solid #ccc;
            font-size: 7.5pt;
            text-align: center;
        }

        /* QR Section */
        .qr-section {
            width: 50mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 1pt solid #ddd;
            padding-left: 6mm;
        }
        .qr-title {
            font-size: 7pt;
            text-align: center;
            color: #666;
            margin-bottom: 2mm;
            font-weight: bold;
        }
        .qr-img { width: 38mm; height: 38mm; }
        .qr-sub { font-size: 6.5pt; color: #999; text-align: center; margin-top: 1.5mm; }
        .token { font-size: 5.5pt; color: #bbb; text-align: center; word-break: break-all; margin-top: 1mm; }

        /* TTD */
        .ttd-section {
            text-align: right;
            margin-top: 3mm;
            font-size: 8pt;
        }
        .ttd-space { height: 10mm; }
        .ttd-name { font-weight: bold; }
    </style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <h1>Daftar Nilai Praktek Kerja Lapangan</h1>
    <h2>{{ $detail->institusi }}</h2>
    <div class="subtitle">Tahun {{ now()->year }}</div>

    {{-- Info Peserta --}}
    <div class="info-row">
        <div class="info-item">
            <span class="info-label">NAMA PESERTA</span> : {{ strtoupper($detail->user->nama) }}
        </div>
        <div class="info-item">
            <span class="info-label">PROGRAM</span> : {{ strtoupper($detail->jenis) }} — {{ strtoupper($detail->unit?->nama ?? '-') }}
        </div>
    </div>
    <div class="info-row">
        <div class="info-item">
            <span class="info-label">PERIODE</span> :
            {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->translatedFormat('d F Y') }}
            s/d
            {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->translatedFormat('d F Y') }}
        </div>
        <div class="info-item">
            <span class="info-label">PEMBIMBING</span> : {{ $detail->supervisor?->nama ?? '-' }}
        </div>
    </div>

    {{-- Tabel Nilai --}}
    @php
        $nilaiAkhir = (float) ($detail->nilai_akhir ?? 0);
        $aspek = [
            ['no' => 1, 'aspek' => 'Kehadiran',     'nilai' => 100,  'bobot' => '10%',  'hasil' => 10],
            ['no' => 2, 'aspek' => 'Performance',    'nilai' => 86,   'bobot' => '25%',  'hasil' => 21.50],
            ['no' => 3, 'aspek' => 'Uji Kompetensi', 'nilai' => 82.5, 'bobot' => '40%',  'hasil' => 33.0],
            ['no' => 4, 'aspek' => 'Laporan Kasus',  'nilai' => 78,   'bobot' => '25%',  'hasil' => 19.5],
        ];
        $totalAbsolut = collect($aspek)->sum('hasil');
    @endphp

    <table class="nilai">
        <thead>
            <tr>
                <th style="width:8%">NO</th>
                <th style="width:35%">ASPEK PENILAIAN</th>
                <th style="width:15%">NILAI (0-100)</th>
                <th style="width:12%">BOBOT</th>
                <th style="width:15%">NILAI AKHIR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aspek as $a)
            <tr>
                <td class="center">{{ $a['no'] }}</td>
                <td>{{ strtoupper($a['aspek']) }}</td>
                <td class="center">{{ $a['nilai'] }}</td>
                <td class="center">{{ $a['bobot'] }}</td>
                <td class="center">{{ $a['hasil'] }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" style="text-align:right">TOTAL NILAI ABSOLUT (JUMLAH / 4)</td>
                <td class="center">{{ number_format($totalAbsolut, 1) }}</td>
            </tr>
            <tr class="total-mutlak">
                <td colspan="4">TOTAL NILAI MUTLAK</td>
                <td>{{ number_format($nilaiAkhir, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- TTD --}}
    <div class="ttd-section">
        Denpasar, {{ now()->translatedFormat('d F Y') }}<br>
        Ka. Unit {{ $detail->unit?->nama ?? 'RSU Prima Medika' }}<br>
        <div class="ttd-space"></div>
        <div class="ttd-name">{{ $detail->supervisor?->nama ?? '________________' }}</div>
        NIK. ___________
    </div>

    {{-- Bottom: Keterangan Nilai + QR --}}
    <div class="bottom-row">

        {{-- Tabel Keterangan Nilai --}}
        <div class="keterangan">
            <div class="keterangan-title">KETERANGAN NILAI :</div>
            <table class="kualitas">
                <thead>
                    <tr>
                        <th>NILAI</th>
                        <th>KUALITAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>79 - 100</td><td>Sangat Baik / Lulus</td></tr>
                    <tr><td>68 - 78</td><td>Baik / Lulus</td></tr>
                    <tr><td>56 - 67</td><td>Cukup / Tidak Lulus</td></tr>
                    <tr><td>41 - 55</td><td>Kurang / Tidak Lulus</td></tr>
                    <tr><td>0 - 40</td><td>Sangat Kurang / Tidak Lulus</td></tr>
                </tbody>
            </table>
        </div>

        {{-- QR Code --}}
        <div class="qr-section">
            <div class="qr-title">SCAN UNTUK VERIFIKASI<br>KEASLIAN SERTIFIKAT</div>
            <img src="data:image/svg+xml;base64,{{ $qrSvg }}" class="qr-img" alt="QR"/>
            <div class="qr-sub">Verifikasi Online</div>
            <div class="token">{{ substr($token, 0, 20) }}...</div>
        </div>

    </div>

</div>
</body>
</html>