<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi — {{ $diklat->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        h1 { color: #E87722; font-size: 16px; margin: 0 0 2px; }
        p.sub { color: #666; font-size: 11px; margin: 0 0 12px; }
        table.info td { border: 0; padding: 1px 6px 1px 0; font-size: 11px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #E87722; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
        table.data td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        .center { text-align: center; }
        .hadir { color: #15803d; font-weight: bold; }
        .belum { color: #b45309; }
    </style>
</head>
<body>
    <h1>RSU Prima Medika — Rekap Absensi Acara</h1>
    <p class="sub">Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table class="info">
        <tr><td><strong>Nama Acara</strong></td><td>: {{ $diklat->nama }}</td></tr>
        <tr><td><strong>Tanggal</strong></td><td>: {{ $diklat->tglJamMulai ? \Carbon\Carbon::parse($diklat->tglJamMulai)->format('d M Y H:i') : '-' }}</td></tr>
        <tr><td><strong>Tempat</strong></td><td>: {{ $diklat->tempat ?? '-' }}</td></tr>
        <tr><td><strong>Narasumber</strong></td><td>: {{ $diklat->namaNarasumber ?? '-' }}</td></tr>
        <tr><td><strong>Total Hadir</strong></td><td>: {{ $totalHadir }} &nbsp; | &nbsp; <strong>Belum Hadir</strong>: {{ $totalBelum }}</td></tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th class="center">No</th>
                <th>Nama</th>
                <th>NIK/Email</th>
                <th>Unit/Institusi</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Waktu Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $i => $r)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $r->namaPeserta }}</td>
                <td>{{ $r->user?->nip ?? $r->user?->email ?? '-' }}</td>
                <td>{{ $r->user?->unit ?? $r->user?->detailEksternal?->institusi ?? '-' }}</td>
                <td>{{ $r->user?->type === 'internal' ? 'Internal' : 'Eksternal' }}</td>
                <td class="{{ $r->is_hadir ? 'hadir' : 'belum' }}">{{ $r->is_hadir ? 'Hadir' : 'Belum Hadir' }}</td>
                <td>{{ $r->is_hadir && $r->date ? \Carbon\Carbon::parse($r->date)->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="center">Belum ada data absensi.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
