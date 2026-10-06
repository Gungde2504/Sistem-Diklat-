<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pendaftaran</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding: 24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border-radius:8px; overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#0f4c81; padding:24px 32px;">
                            <span style="color:#ffffff; font-size:18px; font-weight:bold;">RSU Prima Medika</span>
                            <div style="color:#cfe0f0; font-size:13px; margin-top:2px;">Sistem Diklat &amp; Pendidikan</div>
                        </td>
                    </tr>

                    {{-- Status banner --}}
                    <tr>
                        <td style="padding:0;">
                            <div style="background-color: {{ $isApproved ? '#e7f6ec' : '#fdecec' }}; padding:14px 32px; border-bottom: 1px solid {{ $isApproved ? '#bfe6cc' : '#f5c6c6' }};">
                                <span style="color: {{ $isApproved ? '#1e7e34' : '#c0392b' }}; font-size:14px; font-weight:bold;">
                                    {{ $isApproved ? 'PENDAFTARAN DISETUJUI' : 'PENDAFTARAN DITOLAK' }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="font-size:15px; color:#222222; margin:0 0 16px 0;">
                                Yth. <strong>{{ $nama }}</strong>,
                            </p>

                            @if ($isApproved)
                                <p style="font-size:14px; color:#444444; line-height:1.6; margin:0 0 16px 0;">
                                    Selamat! Pendaftaran Anda sebagai peserta eksternal di RSU Prima Medika telah
                                    <strong style="color:#1e7e34;">disetujui</strong>. Akun Anda sekarang sudah aktif
                                    dan dapat digunakan untuk login ke sistem.
                                </p>

                                <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                                    <tr>
                                        <td style="border-radius:6px; background-color:#0f4c81;">
                                            <a href="{{ $loginUrl }}"
                                               style="display:inline-block; padding:12px 28px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:6px;">
                                                Masuk ke Sistem
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <p style="font-size:13px; color:#777777; line-height:1.6; margin:0;">
                                    Jika tombol di atas tidak berfungsi, salin dan buka tautan berikut di peramban Anda:<br>
                                    <a href="{{ $loginUrl }}" style="color:#0f4c81; word-break:break-all;">{{ $loginUrl }}</a>
                                </p>
                            @else
                                <p style="font-size:14px; color:#444444; line-height:1.6; margin:0 0 16px 0;">
                                    Mohon maaf, pendaftaran Anda sebagai peserta eksternal di RSU Prima Medika
                                    <strong style="color:#c0392b;">belum dapat disetujui</strong> saat ini.
                                </p>
                                <p style="font-size:14px; color:#444444; line-height:1.6; margin:0;">
                                    Apabila Anda merasa ini adalah suatu kekeliruan, silakan menghubungi pihak
                                    Diklat RSU Prima Medika untuk informasi lebih lanjut.
                                </p>
                            @endif
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; background-color:#f8f9fa; border-top:1px solid #eeeeee;">
                            <p style="font-size:12px; color:#999999; margin:0; line-height:1.5;">
                                Email ini dikirim otomatis oleh sistem Diklat RSU Prima Medika. Mohon tidak membalas
                                email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
