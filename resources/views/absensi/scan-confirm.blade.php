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

        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white/30 shadow-lg mx-auto mb-4">
                <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
            </div>
            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-1">RSU Prima Medika</p>
            <p class="text-white/80 text-xs">Sistem Informasi Diklat & Seminar</p>
        </div>

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

        <div class="bg-white rounded-2xl shadow-2xl p-6">

            <p class="text-gray-400 text-xs mb-4 text-center">Konfirmasi identitas untuk melanjutkan absensi</p>

            <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-100 rounded-2xl mb-5">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0
                            bg-gradient-to-br from-green-400 to-green-500 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-bold text-sm truncate">{{ $user->nama }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                            {{ $user->type === 'internal' ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600' }}">
                            {{ $user->type === 'internal' ? 'Internal' : 'Eksternal' }}
                        </span>
                        <span class="text-gray-400 text-xs truncate">{{ $user->unit ?? $user->detailEksternal?->institusi ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('absensi.scan.confirm', $token) }}">
                @csrf
                <button type="submit"
                    class="w-full py-3.5 rounded-xl text-sm font-bold text-white transition active:scale-95
                           bg-gradient-to-r from-[#E87722] to-[#c9661a]
                           hover:from-[#c9661a] hover:to-[#a85515]
                           shadow-[0_4px_15px_rgba(232,119,34,0.4)]
                           flex items-center justify-center gap-2 mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Mulai Absen
                </button>
            </form>

            <a href="{{ $user->type === 'internal' ? route('pegawai.dashboard') : route('eksternal.dashboard') }}"
                class="w-full py-3 rounded-xl text-sm font-semibold text-gray-500 transition active:scale-95
                       border border-gray-200 hover:bg-gray-50
                       flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                Batal
            </a>
        </div>

        <p class="text-center text-white/30 text-xs mt-4">© RSU Prima Medika</p>
    </div>

</body>
</html>
