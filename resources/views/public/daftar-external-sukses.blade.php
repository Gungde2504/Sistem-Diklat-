<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#0F5A8C] via-[#1A78B0] to-[#3B9FD1] flex items-center justify-center p-4">
<div class="max-w-sm mx-auto text-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-stone-800 mb-2">Pendaftaran Berhasil!</h2>
        <p class="text-sm text-stone-500 mb-6">
            Data Anda telah diterima. Admin akan memverifikasi pendaftaran Anda.
            Anda akan dapat login setelah akun disetujui.
        </p>
        <a href="{{ route('login') }}"
            class="block w-full py-2.5 rounded-xl text-sm font-bold text-white text-center
                   shadow-[0_4px_14px_-3px_rgba(15,79,122,.4)]"
            style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">
            Ke Halaman Login
        </a>
    </div>
</div>
</body>
</html>