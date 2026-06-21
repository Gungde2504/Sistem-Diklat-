<div class="space-y-4">

    {{-- ── GREETING BANNER ── --}}
    <div class="rounded-2xl p-5 text-white"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <p class="text-white/65 text-sm">Selamat datang,</p>
        <h2 class="text-xl font-bold tracking-tight">{{ auth()->user()->nama }}</h2>
        <p class="text-white/50 text-xs mt-0.5 capitalize">
            {{ $detail?->jenis ?? 'Peserta Eksternal' }} —
            {{ $detail?->institusi ?? '' }}
        </p>

        @if($detail)
        <div class="mt-4">
            <div class="flex items-center justify-between mb-1.5">
                <p class="text-xs text-white/65">Progress Periode</p>
                <p class="text-xs font-bold text-white">{{ $persenPeriode }}%</p>
            </div>
            <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                <div class="h-2.5 rounded-full transition-all duration-700
                            {{ $persenPeriode >= 100 ? 'bg-green-400' : 'bg-white/80' }}"
                     style="width:{{ min($persenPeriode, 100) }}%">
                </div>
            </div>
            <p class="text-xs text-white/55 mt-1.5">
                {{ $hariSudahDilalui }} dari {{ $totalHariPeriode }} hari ·
                @if($sisaHari > 0)
                    Sisa {{ $sisaHari }} hari
                @else
                    Periode selesai
                @endif
            </p>
        </div>
        @endif
    </div>

    {{-- ── ABSENSI HARI INI ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Absensi Hari Ini</p>
            <span class="ml-auto text-xs text-stone-400">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
        <div class="p-4">
            @if($absensiHarini)
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div class="bg-green-50 border border-green-200 rounded-xl p-3 text-center
                            shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                    <p class="text-xs text-green-600 font-semibold mb-1">Check-in</p>
                    <p class="text-lg font-bold text-green-700">
                        {{ $absensiHarini->checkin_at ? \Carbon\Carbon::parse($absensiHarini->checkin_at)->format('H:i') : '-' }}
                    </p>
                </div>
                <div class="rounded-xl p-3 text-center border
                            shadow-[0_1px_0_rgba(255,255,255,.8)_inset]
                            {{ $absensiHarini->checkout_at
                                ? 'bg-blue-50 border-blue-200'
                                : 'bg-stone-50 border-stone-200' }}">
                    <p class="text-xs font-semibold mb-1
                               {{ $absensiHarini->checkout_at ? 'text-blue-600' : 'text-stone-400' }}">
                        Check-out
                    </p>
                    <p class="text-lg font-bold
                               {{ $absensiHarini->checkout_at ? 'text-blue-700' : 'text-stone-400' }}">
                        {{ $absensiHarini->checkout_at ? \Carbon\Carbon::parse($absensiHarini->checkout_at)->format('H:i') : '--:--' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                    {{ $absensiHarini->is_valid
                        ? 'bg-green-50 text-green-700 border-green-200'
                        : 'bg-red-50 text-red-600 border-red-200' }}">
                    {{ $absensiHarini->is_valid ? '✓ GPS Valid' : '⚠ Di luar radius' }}
                </span>
                @if(!$absensiHarini->checkout_at)
                <a href="{{ route('eksternal.absensi') }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1">
                    Checkout sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                @endif
            </div>
            @else
            <div class="text-center py-4">
                <div class="w-14 h-14 bg-orange-50 border border-orange-200 rounded-2xl flex items-center justify-center mx-auto mb-3
                            shadow-[0_2px_8px_-2px_rgba(249,115,22,.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-stone-700 mb-1">Belum Check-in</p>
                <p class="text-xs text-stone-400 mb-4">Lakukan check-in untuk mencatat kehadiran hari ini</p>
                <a href="{{ route('eksternal.absensi') }}"
                   class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl text-white text-sm font-bold overflow-hidden
                          shadow-[0_4px_14px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                          hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(15,79,122,.55)]
                          active:scale-95 transition-all duration-200"
                   style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="relative">Check-in Sekarang</span>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- ── RINGKASAN KEHADIRAN ── --}}
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white rounded-2xl p-4 text-center border border-stone-200 border-l-4 border-l-green-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(34,197,94,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">Hadir Valid</p>
                <div class="w-7 h-7 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-500 mb-1">{{ $totalHadir }}</p>
            <p class="text-xs text-stone-400">Bulan ini</p>
        </div>
        <div class="bg-white rounded-2xl p-4 text-center border border-stone-200 border-l-4 border-l-blue-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(59,159,209,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-blue-600 uppercase tracking-widest">Total</p>
                <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-blue-500 mb-1">{{ $totalAbsensi }}</p>
            <p class="text-xs text-stone-400">Check-in tercatat</p>
        </div>
    </div>

    {{-- ── INFO PERIODE ── --}}
    @if($detail)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Informasi Kegiatan</p>
        </div>
        <div class="px-4 py-3 space-y-0">
            @foreach([
                ['label' => 'Jenis',       'value' => ucfirst($detail->jenis)],
                ['label' => 'Institusi',   'value' => $detail->institusi],
                ['label' => 'Unit',        'value' => $detail->unit?->nama ?? '-'],
                ['label' => 'Pembimbing',  'value' => $detail->supervisor?->nama ?? '-'],
                ['label' => 'Periode',     'value' => \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y').' — '.\Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y')],
                ['label' => 'Status',      'value' => ucfirst($detail->status),
                 'color' => $detail->status === 'aktif' ? 'text-green-600' : ($detail->status === 'selesai' ? 'text-stone-500' : 'text-red-500')],
            ] as $i => $info)
            <div class="flex items-center justify-between py-2.5 {{ $i < 5 ? 'border-b border-stone-50' : '' }}">
                <span class="text-xs text-stone-400">{{ $info['label'] }}</span>
                <span class="text-xs font-semibold {{ $info['color'] ?? 'text-stone-700' }} text-right max-w-44">
                    {{ $info['value'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── AKSES CEPAT ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Akses Cepat</p>
        <div class="grid grid-cols-2 gap-2.5">

            {{-- Absensi GPS --}}
            <a href="{{ route('eksternal.absensi') }}"
               class="group flex items-center gap-2.5 p-3 rounded-2xl border border-blue-100 bg-blue-50/60
                      hover:bg-blue-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(15,79,122,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200"
                     style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-700">Absensi GPS</span>
            </a>

            {{-- Tulis Jurnal --}}
            <a href="{{ route('eksternal.jurnal') }}"
               class="group flex items-center gap-2.5 p-3 rounded-2xl border border-orange-100 bg-orange-50/60
                      hover:bg-orange-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(249,115,22,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(234,88,12,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200"
                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-orange-600">Tulis Jurnal</span>
            </a>

            {{-- Rekap Hadir --}}
            <a href="{{ route('eksternal.rekap') }}"
               class="group flex items-center gap-2.5 p-3 rounded-2xl border border-sky-100 bg-sky-50/60
                      hover:bg-sky-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(14,165,233,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(14,165,233,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200
                            bg-gradient-to-br from-sky-400 to-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-sky-700">Rekap Hadir</span>
            </a>

            {{-- Sertifikat --}}
            <a href="{{ route('eksternal.sertifikat') }}"
               class="group flex items-center gap-2.5 p-3 rounded-2xl border border-purple-100 bg-purple-50/60
                      hover:bg-purple-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(168,85,247,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(147,51,234,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200
                            bg-gradient-to-br from-purple-400 to-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-purple-600">Sertifikat</span>
            </a>

        </div>
    </div>

</div>