<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi — {{ $diklat->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#1B5E7B] to-[#0d2535] flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white/30 shadow-lg mx-auto mb-4">
                <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
            </div>
            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-1">RSU Prima Medika</p>
            <p class="text-white/80 text-xs">Sistem Informasi Diklat & Seminar</p>
        </div>

        {{-- Header Absensi --}}
        <div class="bg-gradient-to-r from-[#E87722] to-[#c9661a] rounded-2xl p-4 mb-4 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white/70 text-xs font-medium uppercase tracking-wider">Absensi Diklat</p>
                    <p class="text-white font-bold text-sm leading-tight line-clamp-2">{{ $diklat->nama }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-white/20 grid grid-cols-2 gap-2">
                <div>
                    <p class="text-white/50 text-xs">Tempat</p>
                    <p class="text-white text-xs font-semibold truncate">{{ $diklat->tempat }}</p>
                </div>
                <div>
                    <p class="text-white/50 text-xs">Tanggal</p>
                    <p class="text-white text-xs font-semibold">{{ \Carbon\Carbon::parse($diklat->tglJamMulai)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Form Absensi --}}
        <div class="bg-white rounded-2xl shadow-2xl p-6">
            <h2 class="text-gray-800 font-bold text-base mb-0.5">Masukkan Data Anda</h2>
            <p class="text-gray-400 text-xs mb-5">
                Pegawai internal gunakan <strong>NIK</strong> · Peserta eksternal gunakan <strong>Email</strong>
            </p>

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-xs text-red-600 font-medium">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('absensi.scan.login', $token) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                        NIK / NIP / Email
                    </label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                        placeholder="NIK untuk pegawai / Email untuk eksternal"
                        autofocus autocomplete="off"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-[#1B5E7B]/30 focus:border-[#1B5E7B]
                               bg-gray-50 transition"/>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Password</label>
                    <input type="password" name="password"
                        placeholder="Masukkan password"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-[#1B5E7B]/30 focus:border-[#1B5E7B]
                               bg-gray-50 transition"/>
                </div>
                <button type="submit"
                    class="w-full py-3.5 rounded-xl text-sm font-bold text-white transition active:scale-95
                           bg-gradient-to-r from-[#E87722] to-[#c9661a]
                           hover:from-[#c9661a] hover:to-[#a85515]
                           shadow-[0_4px_15px_rgba(232,119,34,0.4)]
                           flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Absen Sekarang
                </button>
            </form>
        </div>

        <p class="text-center text-white/30 text-xs mt-4">© RSU Prima Medika</p>
    </div>

</body>
</html>