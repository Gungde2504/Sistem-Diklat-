<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Absensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center p-4
    {{ $status === 'success' ? 'bg-gradient-to-br from-[#0a2d1f] via-[#0d4a2e] to-[#0a3d24]' :
       ($status === 'warning' ? 'bg-gradient-to-br from-[#3d2a00] via-[#5c3d00] to-[#3d2a00]' :
       'bg-gradient-to-br from-[#2d0a0a] via-[#4a0d0d] to-[#2d0a0a]') }}">

    <div class="w-full max-w-sm">

        {{-- Logo & Brand --}}
        <div class="text-center mb-5">
            <div class="relative inline-block mb-3">
                <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-white/20
                            shadow-[0_8px_24px_rgba(0,0,0,.3)] mx-auto">
                    <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white/30
                            flex items-center justify-center shadow-sm
                            {{ $status === 'success' ? 'bg-green-400' : ($status === 'warning' ? 'bg-yellow-400' : 'bg-red-400') }}">
                    @if($status === 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    @elseif($status === 'warning')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    @endif
                </div>
            </div>
            <h1 class="text-white font-bold text-sm tracking-tight">RSU Prima Medika</h1>
            <p class="text-white/40 text-xs mt-0.5">Sistem Informasi Diklat & Seminar</p>
        </div>

        {{-- Status Card --}}
        <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl overflow-hidden mb-4">

            {{-- Status Header --}}
            <div class="px-5 py-4 border-b border-white/10
                        {{ $status === 'success' ? 'bg-green-500/20' : ($status === 'warning' ? 'bg-yellow-500/20' : 'bg-red-500/20') }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                {{ $status === 'success' ? 'bg-green-400/30' : ($status === 'warning' ? 'bg-yellow-400/30' : 'bg-red-400/30') }}">
                        @if($status === 'success')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-300" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        @elseif($status === 'warning')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-300" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-white/50 text-[10px] font-semibold uppercase tracking-widest">
                            {{ $status === 'success' ? 'Absensi Berhasil' : ($status === 'warning' ? 'Perhatian' : 'Absensi Gagal') }}
                        </p>
                        <p class="text-white font-bold text-sm leading-snug">{{ $message }}</p>
                    </div>
                </div>
            </div>

            {{-- Detail Acara --}}
            <div class="px-5 py-4 border-b border-white/10">
                <p class="text-white/40 text-[10px] font-semibold uppercase tracking-widest mb-2.5">Detail Acara</p>
                <div class="flex items-start gap-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5
                                shadow-[0_2px_8px_rgba(200,61,0,.4)]"
                        style="background:linear-gradient(135deg,#FF8C00,#C73D00)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm leading-snug line-clamp-2">{{ $diklat->nama }}</p>
                        <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                            <span class="flex items-center gap-1 text-[10px] text-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{ $diklat->tempat }}
                            </span>
                            <span class="flex items-center gap-1 text-[10px] text-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($diklat->tglJamMulai)->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail User (jika success) --}}
            @if($status === 'success')
            <div class="px-5 py-4 border-b border-white/10">
                <p class="text-white/40 text-[10px] font-semibold uppercase tracking-widest mb-2.5">Data Peserta</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-white/50 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Nama
                        </span>
                        <span class="text-white font-semibold text-xs">{{ $user->nama }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-white/50 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.17-.789 3.376 3.376 0 0 1 6.34 0Z" />
                            </svg>
                            NIK
                        </span>
                        <span class="text-white font-semibold text-xs">{{ $user->nip ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-white/50 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Waktu
                        </span>
                        <span class="text-white font-semibold text-xs">{{ now()->format('H:i, d M Y') }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- CTA ke detail acara --}}
            <div class="px-5 py-4">
                @if($user->type === 'internal')
                <a href="{{ route('pegawai.acara.detail', $diklat->id) }}"
                    class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-semibold
               text-white border border-white/20 bg-white/10 hover:bg-white/20
               transition-all duration-200 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Lihat Detail Acara
                </a>
                @elseif($user->type === 'external')
                <a href="{{ route('eksternal.acara.detail', $diklat->id) }}"
                    class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-semibold
               text-white border border-white/20 bg-white/10 hover:bg-white/20
               transition-all duration-200 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Lihat Detail Acara
                </a>
                @endif
                <p class="text-center text-white/30 text-[10px]">Halaman ini dapat ditutup setelah absen</p>
            </div>
            
</body>

</html>