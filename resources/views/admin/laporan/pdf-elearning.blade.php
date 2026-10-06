<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #374151; margin: 0; padding: 15px; }
        h1 { font-size: 14px; color: #1A78B0; margin-bottom: 2px; }
        .sub { font-size: 9px; color: #6B7280; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #7c3aed; color: white; padding: 6px 8px; text-align: left; font-size: 9px; }
        td { padding: 5px 8px; border-bottom: 1px solid #F3F4F6; }
        tr:nth-child(even) td { background: #F9F5FF; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: bold; }
        .completed { background: #D1FAE5; color: #065F46; }
        .in_progress { background: #DBEAFE; color: #1E40AF; }
        .failed { background: #FEE2E2; color: #991B1B; }
        .pengesahan-table { width: 100%; margin-top: 24px; }
        .pengesahan-box { width: 30%; text-align: center; vertical-align: top; }
        .pengesahan-intro { font-size: 11px; color: #333; margin-bottom: 2px; }
        .stamp-img { width: 72px; height: auto; margin: 8px auto 0 auto; display: block; opacity: 0.92; }
        .stamp-label { font-size: 8px; font-weight: bold; color: #16a34a; letter-spacing: 1px; margin-top: 2px; }
        .pengesahan-name { font-size: 11px; font-weight: bold; text-decoration: underline; margin-top: 10px; }
        .pengesahan-role { font-size: 9px; color: #888; margin-top: 1px; }
    </style>
</head>
<body>
    <h1>Laporan E-Learning — RSU Prima Medika</h1>
    <div class="sub">
        Tahun: {{ $tahun }} |
        Status: {{ $status === 'semua' ? 'Semua' : ucfirst($status) }} |
        Dicetak: {{ now()->format('d F Y, H:i') }} WIB |
        Total: {{ $progress->count() }} data
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Modul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Nilai</th>
                <th>Jam</th>
                <th>Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($progress as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user?->nama ?? '-' }}</td>
                <td>{{ $p->user?->email ?? '-' }}</td>
                <td>{{ $p->modul?->judul ?? '-' }}</td>
                <td>{{ $p->modul?->kategori ?? '-' }}</td>
                <td>
                    <span class="badge {{ $p->status }}">
                        {{ $p->status === 'completed' ? 'Selesai' : ($p->status === 'in_progress' ? 'Berlangsung' : 'Gagal') }}
                    </span>
                </td>
                <td>{{ $p->quiz_score ?? '-' }}</td>
                <td>{{ $p->jam_dikontribusikan ? $p->jam_dikontribusikan.' j' : '-' }}</td>
                <td>{{ $p->completed_at ? \Carbon\Carbon::parse($p->completed_at)->format('d M Y') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#9CA3AF;padding:20px;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="pengesahan-table">
        <tr>
            <td style="width:70%;"></td>
            <td class="pengesahan-box">
                <div class="pengesahan-intro">Mengetahui,</div>
                <div class="pengesahan-intro">Koordinator Diklat</div>

                <img src="{{ public_path('images/pengesahan/stempel-disahkan.png') }}" class="stamp-img" alt="Cap Disahkan">
                <div class="stamp-label">DISAHKAN</div>

                <div class="pengesahan-name">Putu Gita Laksmi, A.Md Keb</div>
                <div class="pengesahan-role">Koordinator Diklat</div>
            </td>
        </tr>
    </table>
</body>
</html>
