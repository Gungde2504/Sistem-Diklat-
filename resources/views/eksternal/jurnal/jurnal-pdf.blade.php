<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        h2 { text-align: center; color: #1B5E7B; margin-bottom: 4px; font-size: 14px; }
        .subtitle { text-align: center; color: #888; font-size: 10px; margin-bottom: 16px; }
        .info-table { width: 100%; margin-bottom: 14px; }
        .info-table td { padding: 3px 6px; font-size: 11px; }
        .info-table .label { color: #888; width: 100px; }
        .jurnal-item { margin-bottom: 14px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; }
        .jurnal-header { background: #1B5E7B; color: white; padding: 6px 10px; font-size: 11px; font-weight: bold; }
        .jurnal-body { padding: 8px 10px; }
        .jurnal-label { font-size: 10px; color: #888; margin-bottom: 2px; font-weight: bold; text-transform: uppercase; }
        .jurnal-value { font-size: 11px; color: #333; margin-bottom: 8px; line-height: 1.5; }
        .footer { margin-top: 16px; text-align: right; font-size: 9px; color: #aaa; }
        .badge { display: inline-block; padding: 1px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; background: #E0F2FE; color: #0369A1; }
    </style>
</head>
<body>

    <h2>{{ $judul }}</h2>
    <p class="subtitle">RSU Prima Medika — Sistem Informasi Diklat & Seminar</p>

    <table class="info-table">
        <tr>
            <td class="label">Nama</td>
            <td>: <strong>{{ $user->nama }}</strong></td>
            <td class="label">Email</td>
            <td>: {{ $user->email }}</td>
        </tr>
        <tr>
            <td class="label">Total Jurnal</td>
            <td>: {{ $jurnal->count() }} entri</td>
            <td class="label">Dicetak</td>
            <td>: {{ now()->format('d M Y, H:i') }}</td>
        </tr>
    </table>

    @forelse($jurnal as $i => $j)
    <div class="jurnal-item">
        <div class="jurnal-header">
            #{{ $i + 1 }} — {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l, d F Y') }}
        </div>
        <div class="jurnal-body">
            <div class="jurnal-label">Aktivitas</div>
            <div class="jurnal-value">{{ $j->aktivitas }}</div>

            @if($j->kendala)
            <div class="jurnal-label">Kendala</div>
            <div class="jurnal-value">{{ $j->kendala }}</div>
            @endif

            @if($j->rencana_besok)
            <div class="jurnal-label">Rencana Besok</div>
            <div class="jurnal-value">{{ $j->rencana_besok }}</div>
            @endif
        </div>
    </div>
    @empty
    <p style="text-align:center; color:#888; padding:20px;">Tidak ada data jurnal</p>
    @endforelse

    <div class="footer">Dicetak pada: {{ now()->format('d M Y, H:i') }}</div>

</body>
</html>