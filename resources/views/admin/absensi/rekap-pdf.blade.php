<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Absensi {{ $diklat->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        h2 { text-align: center; color: #C2410C; margin-bottom: 4px; font-size: 14px; }
        .subtitle { text-align: center; color: #888; font-size: 10px; margin-bottom: 16px; }
        .info-table { width: 100%; margin-bottom: 14px; }
        .info-table td { padding: 3px 6px; font-size: 11px; }
        .info-table .label { color: #888; width: 120px; }
        .stats { display: flex; gap: 10px; margin-bottom: 14px; }
        .stat { flex: 1; text-align: center; border: 1px solid #ddd; border-radius: 6px; padding: 8px; }
        .stat .num { font-size: 20px; font-weight: bold; }
        .stat .num.green { color: #16a34a; }
        .stat .num.red { color: #dc2626; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #C2410C; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        table.data td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        table.data tr:nth-child(even) td { background: #fafafa; }
        .badge-internal { background: #FFF7ED; color: #C2410C; padding: 1px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; }
        .badge-external { background: #EFF6FF; color: #1D4ED8; padding: 1px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; }
        .hadir { color: #16a34a; font-weight: bold; }
        .belum { color: #dc2626; }
        .footer { margin-top: 16px; text-align: right; font-size: 9px; color: #aaa; }
    </style>
</head>
<body>

    <h2>Rekap Absensi Diklat</h2>
    <p class="subtitle">RSU Prima Medika — Sistem Informasi Diklat & Seminar</p>

    <table class="info-table">
        <tr>
            <td class="label">Nama Acara</td>
            <td>: <strong>{{ $diklat->nama }}</strong></td>
            <td class="label">Narasumber</td>
            <td>: {{ $diklat->namaNarasumber }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>: {{ $diklat->tglJamMulai }}</td>
            <td class="label">Tempat</td>
            <td>: {{ $diklat->tempat }}</td>
        </tr>
        <tr>
            <td class="label">Jenis</td>
            <td>: {{ $diklat->jenisDiklat }}</td>
            <td class="label">Durasi</td>
            <td>: {{ $diklat->durasi }} jam</td>
        </tr>
    </table>

    <table style="width:100%; margin-bottom:14px;">
        <tr>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:8px;">
                <div style="font-size:20px; font-weight:bold; color:#1D4ED8;">{{ $absensi->count() }}</div>
                <div style="color:#888; font-size:10px;">Total Peserta</div>
            </td>
            <td style="width:2%;"></td>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:8px;">
                <div style="font-size:20px; font-weight:bold; color:#16a34a;">{{ $totalHadir }}</div>
                <div style="color:#888; font-size:10px;">Hadir</div>
            </td>
            <td style="width:2%;"></td>
            <td style="width:33%; text-align:center; border:1px solid #ddd; border-radius:6px; padding:8px;">
                <div style="font-size:20px; font-weight:bold; color:#dc2626;">{{ $totalBelum }}</div>
                <div style="color:#888; font-size:10px;">Belum Hadir</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIK / Email</th>
                <th>Unit / Institusi</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $i => $record)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $record->namaPeserta }}</td>
                <td>{{ $record->user?->nip ?? $record->user?->email ?? '-' }}</td>
                <td>{{ $record->user?->unit ?? $record->user?->detailEksternal?->institusi ?? '-' }}</td>
                <td>
                    @if($record->user?->type === 'internal')
                    <span class="badge-internal">Internal</span>
                    @else
                    <span class="badge-external">Eksternal</span>
                    @endif
                </td>
                <td class="{{ $record->is_hadir ? 'hadir' : 'belum' }}">
                    {{ $record->is_hadir ? 'Hadir' : 'Belum' }}
                </td>
                <td>
                    {{ $record->is_hadir && $record->date
                        ? \Carbon\Carbon::parse($record->date)->format('H:i')
                        : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#888; padding:16px;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada: {{ now()->format('d M Y, H:i') }}</div>

</body>
</html>