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
                <th>NIK/Gmail</th>
                <th>Nama</th>
                <th>Unit</th>
                <th class="text-center">Diklat (j)</th>
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
                <td>{{ $row['user']->role === 'peserta_eksternal' ? ($row['user']->email ?? '-') : ($row['user']->nip ?? '-') }}</td>
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