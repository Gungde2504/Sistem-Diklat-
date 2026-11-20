<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengingat Jam Pelatihan</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family: Arial, Helvetica, sans-serif;">
    @php
        $warna = match ($tingkat) {
            'terakhir' => ['bg' => '#fdecec', 'bd' => '#f5c6c6', 'tx' => '#c0392b', 'label' => 'PENGINGAT TERAKHIR'],
            'tegas'    => ['bg' => '#fff4e5', 'bd' => '#ffd9a8', 'tx' => '#b45309', 'label' => 'PENGINGAT PENTING'],
            default    => ['bg' => '#e8f1fb', 'bd' => '#c5daf0', 'tx' => '#0f4c81', 'label' => 'PENGINGAT JAM PELATIHAN'],
        };
    @endphp
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background-color:#0f4c81; padding:24px 32px;">
                            <span style="color:#ffffff; font-size:18px; font-weight:bold;">RSU Prima Medika</span>
                            <div style="color:#cfe0f0; font-size:13px; margin-top:2px;">Sistem Diklat &amp; Pendidikan</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0;">
                            <div style="background-color:{{ $warna['bg'] }}; padding:14px 32px; border-bottom:1px solid {{ $warna['bd'] }};">
                                <span style="color:{{ $warna['tx'] }}; font-size:14px; font-weight:bold;">{{ $warna['label'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="font-size:15px; color:#222222; margin:0 0 16px 0;">Yth. <strong>{{ $nama }}</strong>,</p>

                            <p style="font-size:14px; color:#444444; line-height:1.6; margin:0 0 16px 0;">
                                Jam pelatihan Anda pada tahun {{ $tahun }} baru
                                <strong>{{ $jamSaatIni }} jam</strong> dari target <strong>{{ $target }} jam</strong>.
                                Masih kurang <strong style="color:{{ $warna['tx'] }};">{{ $kurang }} jam</strong>
                                @if ($sisaBulan > 0)
                                    dengan sisa waktu sekitar {{ $sisaBulan }} bulan lagi.
                                @else
                                    dan tahun ini akan segera berakhir.
                                @endif
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px 0; border:1px solid #eeeeee; border-radius:6px;">
                                <tr>
                                    <td style="padding:10px 14px; font-size:13px; color:#555555; border-bottom:1px solid #f1f1f1;">Diklat / Acara</td>
                                    <td align="right" style="padding:10px 14px; font-size:13px; font-weight:bold; color:#222222; border-bottom:1px solid #f1f1f1;">{{ $jamAcara }} jam</td>
                                </tr>
                                @if ($tampilMandiri)
                                <tr>
                                    <td style="padding:10px 14px; font-size:13px; color:#555555; border-bottom:1px solid #f1f1f1;">Diklat Mandiri</td>
                                    <td align="right" style="padding:10px 14px; font-size:13px; font-weight:bold; color:#222222; border-bottom:1px solid #f1f1f1;">{{ $jamMandiri }} jam</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:10px 14px; font-size:13px; color:#555555;">E-Learning</td>
                                    <td align="right" style="padding:10px 14px; font-size:13px; font-weight:bold; color:#222222;">{{ $jamElearning }} jam</td>
                                </tr>
                            </table>

                            <p style="font-size:14px; color:#444444; line-height:1.6; margin:0 0 8px 0;">Cara menambah jam pelatihan:</p>
                            <ul style="font-size:14px; color:#444444; line-height:1.7; margin:0 0 20px 18px; padding:0;">
                                <li>Ikuti acara diklat atau seminar pada menu <strong>Daftar Acara</strong>.</li>
                                <li>Selesaikan modul pada menu <strong>E-Learning</strong>.</li>
                                @if ($tampilMandiri)
                                <li>Ajukan <strong>Diklat Mandiri</strong> beserta sertifikatnya.</li>
                                @endif
                            </ul>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:8px 0 24px 0;">
                                <tr>
                                    <td style="border-radius:6px; background-color:#0f4c81;">
                                        <a href="{{ $loginUrl }}" style="display:inline-block; padding:12px 28px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:6px;">Masuk ke Sistem</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:13px; color:#777777; line-height:1.6; margin:0;">
                                Jika tombol di atas tidak berfungsi, salin dan buka tautan berikut:<br>
                                <a href="{{ $loginUrl }}" style="color:#0f4c81; word-break:break-all;">{{ $loginUrl }}</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px; background-color:#f8f9fa; border-top:1px solid #eeeeee;">
                            <p style="font-size:12px; color:#999999; margin:0; line-height:1.5;">
                                Email ini dikirim otomatis oleh sistem Diklat RSU Prima Medika. Mohon tidak membalas email ini.
                                Pengingat berhenti otomatis setelah target jam pelatihan Anda terpenuhi.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
