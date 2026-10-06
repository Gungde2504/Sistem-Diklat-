<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Diklat {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        h1 { color: #E87722; font-size: 16px; margin-bottom: 2px; }
        p.sub { color: #666; font-size: 11px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #E87722; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .text-center { text-align: center; }

        .acara-block { margin-bottom: 18px; }
        .acara-header-row td {
            background: #fdf1e7;
            border: 1px solid #f3d7b8;
            padding: 8px 10px;
        }
        .acara-header-row .nama { font-size: 12px; font-weight: bold; color: #b85c00; margin-bottom: 3px; }
        .acara-header-row .meta { font-size: 9.5px; color: #555; }
        .acara-header-row .meta span { margin-right: 14px; }
        .acara-header-row .count { font-size: 9.5px; color: #555; margin-top: 3px; }

        .no-data { text-align: center; padding: 24px; color: #999; }

        .ttd-table { width: 100%; margin-top: 28px; }
        .ttd-table td { border: none; padding: 0; vertical-align: top; }
        .ttd-box { text-align: center; width: 220px; }
        .ttd-box p { font-size: 10px; color: #333; margin: 0; }
        .ttd-icon { width: 70px; height: auto; margin: 8px auto 6px; display: block; }
        .ttd-status { color: #16a34a; font-weight: bold; font-size: 11px; letter-spacing: 1px; margin: 0 0 8px; }
        .ttd-name { font-size: 11px; font-weight: bold; text-decoration: underline; margin: 0; }
        .ttd-jabatan { font-size: 9.5px; color: #777; margin: 2px 0 0; }
    </style>
</head>
<body>
    <h1>RSU Prima Medika — Laporan Absensi Diklat & Seminar</h1>
    <p class="sub">
        Tahun: {{ $tahun }}
        @if($bulan) | Bulan: {{ $bulan }} @endif
        @if($unit) | Unit: {{ $unit }} @endif
        | Dicetak: {{ now()->format('d M Y H:i') }}
        | Total: {{ $absensi->count() }} record / {{ $acaraList->count() }} acara
    </p>

    @if($acaraList->isEmpty())
        <div class="no-data">Tidak ada data absensi untuk filter yang dipilih.</div>
    @else
        @foreach($acaraList as $item)
        @php
            $diklat = $item['diklat'];
            $peserta = $item['peserta'];
        @endphp
        <div class="acara-block">
            <table>
                <thead>
                    <tr>
                        <th style="width:24px">#</th>
                        <th>Nama Peserta</th>
                        <th>NIK/Gmail</th>
                        <th>Unit/Instansi</th>
                        <th class="text-center">Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Baris keterangan acara: ditaruh di tbody (bukan thead) supaya
                         hanya tampil sekali di awal, tidak ikut terulang tiap halaman baru --}}
                    <tr class="acara-header-row">
                        <td colspan="5">
                            <div class="nama">{{ $diklat?->nama ?? 'Acara Tidak Diketahui' }}</div>
                            <div class="meta">
                                <span>Tanggal: {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</span>
                                <span>Jenis: {{ $diklat?->jenisDiklat ?? '-' }}</span>
                                <span>Narasumber: {{ $diklat?->namaNarasumber ?? '-' }}</span>
                                <span>Tempat: {{ $diklat?->tempat ?? '-' }}</span>
                            </div>
                            <div class="count">Jumlah peserta hadir: <strong>{{ $peserta->count() }}</strong> orang</div>
                        </td>
                    </tr>
                    @foreach($peserta as $i => $r)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $r->user?->nama ?? $r->namaPeserta }}</td>
                        <td>{{ $r->user?->role === 'peserta_eksternal' ? ($r->user?->email ?? '-') : ($r->user?->nip ?? '-') }}</td>
                        <td>{{ $r->user?->role === 'peserta_eksternal' ? ($r->user?->detailEksternal?->institusi ?? '-') : ($r->user?->unit ?? '-') }}</td>
                        <td class="text-center">{{ $r->durasi }} menit</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    @endif

    {{-- Pengesahan --}}
    <table class="ttd-table">
        <tr>
            <td></td>
            <td class="ttd-box">
                <p>Mengetahui,</p>
                <p>Koordinator Diklat</p>
                <img class="ttd-icon" src="{{ public_path('images/pengesahan/stempel-disahkan.png') }}" alt="Disahkan">
                <p class="ttd-status">DISAHKAN</p>
                <p class="ttd-name">Putu Gita Laksmi, A.Md Keb</p>
                <p class="ttd-jabatan">Koordinator Diklat</p>
            </td>
        </tr>
    </table>
</body>
</html>
