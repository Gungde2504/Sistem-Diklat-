<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Jam Pelatihan {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        h1 { color: #1B5E7B; font-size: 16px; margin-bottom: 2px; }
        p.sub { color: #666; font-size: 11px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1B5E7B; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .terpenuhi { color: #16a34a; font-weight: bold; }
        .belum { color: #dc2626; font-weight: bold; }
        .total { font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>RSU Prima Medika — Rekap Jam Pelatihan</h1>
    <p class="sub">
        Tahun: {{ $tahun }}
        @if($unit) | Unit: {{ $unit }} @endif
        | Target: {{ $target }} jam/tahun
        | Dicetak: {{ now()->format('d M Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Unit</th>
                <th class="text-center">Acara (j)</th>
                <th class="text-center">Mandiri (j)</th>
                <th class="text-center">E-Learning (j)</th>
                <th class="text-center">Total (j)</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
            @php $total = $row['rekap']->total(); @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $row['user']->nip ?? '-' }}</td>
                <td>{{ $row['user']->nama }}</td>
                <td>{{ $row['user']->unit ?? '-' }}</td>
                <td class="text-center">{{ number_format($row['rekap']->jamDiklatAcara, 1) }}</td>
                <td class="text-center">{{ number_format($row['rekap']->jamDiklatMandiri, 1) }}</td>
                <td class="text-center">{{ number_format($row['rekap']->jamElearning, 1) }}</td>
                <td class="text-center total">{{ number_format($total, 1) }}</td>
                <td class="text-center {{ $total >= $target ? 'terpenuhi' : 'belum' }}">
                    {{ $total >= $target ? 'Terpenuhi' : 'Belum' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>