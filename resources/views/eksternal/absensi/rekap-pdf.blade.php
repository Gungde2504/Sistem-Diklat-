<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; color: #1B5E7B; margin-bottom: 5px; }
        .info { margin-bottom: 15px; }
        .info table { width: 100%; }
        .info td { padding: 2px 5px; }
        .stats { display: flex; gap: 10px; margin-bottom: 15px; }
        .stat-box { flex: 1; border: 1px solid #ddd; border-radius: 6px; padding: 8px; text-align: center; }
        .stat-box .num { font-size: 20px; font-weight: bold; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #1B5E7B; color: white; padding: 7px 10px; text-align: left; font-size: 11px; }
        table.data td { padding: 6px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        table.data tr:nth-child(even) { background: #f9f9f9; }
        .valid { color: #16a34a; font-weight: bold; }
        .invalid { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <h2>{{ $judul }}</h2>
    <p style="text-align:center; color:#888; margin-bottom:15px;">RSU Prima Medika — Sistem Informasi Diklat & Seminar</p>

    <div class="info">
        <table>
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $user->nama }}</td>
                <td><strong>Institusi</strong></td>
                <td>: {{ $detail?->institusi ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>: {{ $user->email }}</td>
                <td><strong>Jenis</strong></td>
                <td>: {{ ucfirst($detail?->jenis ?? '-') }}</td>
            </tr>
        </table>
    </div>

    <table style="width:100%; margin-bottom:15px;">
        <tr>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:10px;">
                <div style="font-size:22px; font-weight:bold; color:#1B5E7B;">{{ $absensi->count() }}</div>
                <div style="color:#888; font-size:11px;">Total Hari</div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:10px;">
                <div style="font-size:22px; font-weight:bold; color:#16a34a;">{{ $totalHadir }}</div>
                <div style="color:#888; font-size:11px;">Hadir Valid</div>
            </td>
            <td style="width:5%;"></td>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:10px;">
                <div style="font-size:22px; font-weight:bold; color:#dc2626;">{{ $totalTidak }}</div>
                <div style="color:#888; font-size:11px;">Di Luar Radius</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Durasi</th>
                <th>Status GPS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                <td>{{ $a->checkin_at ? \Carbon\Carbon::parse($a->checkin_at)->format('H:i') : '-' }}</td>
                <td>{{ $a->checkout_at ? \Carbon\Carbon::parse($a->checkout_at)->format('H:i') : '-' }}</td>
                <td>{{ $a->durasi ? $a->durasi . ' menit' : '-' }}</td>
                <td class="{{ $a->is_valid ? 'valid' : 'invalid' }}">
                    {{ $a->is_valid ? 'Valid' : 'Di luar radius' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#888; padding:20px;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y, H:i') }}
    </div>

</body>
</html>