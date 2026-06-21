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
    </style>
</head>
<body>
    <h1>RSU Prima Medika — Laporan Absensi Diklat & Seminar</h1>
    <p class="sub">
        Tahun: {{ $tahun }}
        @if($bulan) | Bulan: {{ $bulan }} @endif
        @if($unit) | Unit: {{ $unit }} @endif
        | Dicetak: {{ now()->format('d M Y H:i') }}
        | Total: {{ $absensi->count() }} record
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nama Peserta</th>
                <th>NIK</th>
                <th>Unit</th>
                <th>Nama Acara</th>
                <th>Jenis</th>
                <th class="text-center">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $i => $r)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $r->date?->format('d/m/Y') }}</td>
                <td>{{ $r->namaPeserta }}</td>
                <td>{{ $r->user?->nip ?? '-' }}</td>
                <td>{{ $r->user?->unit ?? '-' }}</td>
                <td>{{ $r->diklat?->nama ?? '-' }}</td>
                <td>{{ $r->diklat?->jenisDiklat ?? '-' }}</td>
                <td class="text-center">{{ $r->durasi }} menit</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>