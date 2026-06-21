<div class="space-y-4">

    {{-- ── FILTER ── --}}
<div class="bg-white rounded-2xl border border-stone-100
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">

    <div class="px-4 py-3.5 border-b border-stone-100 flex items-center gap-2">
        <div class="w-0.5 h-4 rounded-full"
             style="background:linear-gradient(180deg,#3B9FD1,#0F5A8C)"></div>
        <p class="text-xs font-bold text-stone-600 uppercase tracking-widest">Filter & Unduh</p>
    </div>

    <div class="p-4 space-y-3">

        {{-- Bulan & Tahun --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Bulan</label>
                <div class="relative">
                    <select wire:model.live="bulan"
                        class="w-full px-3 py-2 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                        <option value="{{ $i + 1 }}">{{ $bln }}</option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div>
                <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Tahun</label>
                <div class="relative">
                    <select wire:model.live="tahun"
                        class="w-full px-3 py-2 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Toggle Per Bulan / Semua --}}
        <div class="flex gap-1.5 bg-stone-100 rounded-xl p-1">
            <button wire:click="$set('filter', 'bulan')"
                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg text-xs font-semibold transition-all duration-200
                    {{ $filter === 'bulan'
                        ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                        : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
                @if($filter==='bulan') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                </svg>
                Per Bulan
            </button>
            <button wire:click="$set('filter', 'semua')"
                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg text-xs font-semibold transition-all duration-200
                    {{ $filter === 'semua'
                        ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                        : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
                @if($filter==='semua') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                Semua
            </button>
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-2">
            <div class="flex-1 h-px bg-stone-100"></div>
            <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Unduh</p>
            <div class="flex-1 h-px bg-stone-100"></div>
        </div>

        {{-- Download Buttons --}}
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('eksternal.rekap.download', ['format' => 'pdf', 'filter' => $filter, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="relative group flex items-center justify-center gap-1.5 py-2.5 rounded-xl
                       text-xs font-bold text-white overflow-hidden
                       shadow-[0_3px_10px_-2px_rgba(239,68,68,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                       hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-3px_rgba(239,68,68,.5)]
                       active:scale-[.97] transition-all duration-200"
                style="background:linear-gradient(135deg,#F87171 0%,#EF4444 50%,#DC2626 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative group-hover:translate-y-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span class="relative">PDF</span>
            </a>
            <a href="{{ route('eksternal.rekap.download', ['format' => 'excel', 'filter' => $filter, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="relative group flex items-center justify-center gap-1.5 py-2.5 rounded-xl
                       text-xs font-bold text-white overflow-hidden
                       shadow-[0_3px_10px_-2px_rgba(34,197,94,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                       hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-3px_rgba(34,197,94,.5)]
                       active:scale-[.97] transition-all duration-200"
                style="background:linear-gradient(135deg,#4ade80 0%,#22c55e 50%,#16a34a 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative group-hover:translate-y-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span class="relative">Excel</span>
            </a>
        </div>

    </div>
</div>
    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 gap-3">

        {{-- Total Hadir --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-blue-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(59,159,209,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-blue-600 uppercase tracking-widest">Total Hadir</p>
                <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-600 mb-0.5">{{ $totalHadir }}</p>
            <p class="text-xs text-stone-400">hari</p>
        </div>

        {{-- GPS Valid --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-green-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(34,197,94,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">GPS Valid</p>
                <div class="w-7 h-7 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600 mb-0.5">{{ $totalValid }}</p>
            <p class="text-xs text-stone-400">dalam radius RS</p>
        </div>

        {{-- Di Luar Radius --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-red-400
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(248,113,113,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-red-500 uppercase tracking-widest">Di Luar</p>
                <div class="w-7 h-7 rounded-lg bg-red-50 border border-red-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-400 mb-0.5">{{ $totalInvalid }}</p>
            <p class="text-xs text-stone-400">tidak valid</p>
        </div>

        {{-- Total Jam --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-sky-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(14,165,233,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-sky-600 uppercase tracking-widest">Total Jam</p>
                <div class="w-7 h-7 rounded-lg bg-sky-50 border border-sky-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-sky-600 mb-0.5">{{ floor($totalMenit / 60) }}</p>
            <p class="text-xs text-stone-400">jam {{ $totalMenit % 60 }} menit</p>
        </div>

    </div>

    {{-- ── TABEL RIWAYAT ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Detail Kehadiran</p>
            <span class="ml-auto text-[10.5px] font-semibold px-2 py-0.5 rounded-full
                         bg-blue-50 text-blue-600 border border-blue-200">
                {{ $riwayat->total() }} hari
            </span>
        </div>

        <div class="divide-y divide-stone-50">
            @forelse($riwayat as $r)
            @php
            $durasi = null;
            if ($r->checkin_at && $r->checkout_at) {
            $durasi = \Carbon\Carbon::parse($r->checkin_at)
            ->diffInMinutes(\Carbon\Carbon::parse($r->checkout_at));
            }
            @endphp
            <div class="px-4 py-3.5 hover:bg-stone-50/60 transition-colors duration-150">
                <div class="flex items-center gap-3 mb-2.5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border
                                {{ $r->is_valid
                                    ? 'bg-green-50 border-green-200'
                                    : 'bg-red-50 border-red-200' }}">
                        @if($r->is_valid)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-stone-800">
                            {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                        </p>
                        <span class="text-[10.5px] px-2 py-0.5 rounded-full font-semibold border
                                     {{ $r->is_valid
                                         ? 'bg-green-50 text-green-700 border-green-200'
                                         : 'bg-red-50 text-red-600 border-red-200' }}">
                            {{ $r->is_valid ? '✓ GPS Valid' : '⚠ Di luar radius' }}
                        </span>
                    </div>
                    @if($durasi)
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-bold text-blue-600">{{ floor($durasi / 60) }}j {{ $durasi % 60 }}m</p>
                        <p class="text-[10.5px] text-stone-400">durasi</p>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-2 ml-12">
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-green-50/50 hover:border-green-100 transition-colors duration-200">
                        <p class="text-[10px] text-stone-400 mb-0.5">Check-in</p>
                        <p class="text-sm font-bold {{ $r->checkin_at ? 'text-green-600' : 'text-stone-300' }}">
                            {{ $r->checkin_at ? \Carbon\Carbon::parse($r->checkin_at)->format('H:i') : '--:--' }}
                        </p>
                    </div>
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                        <p class="text-[10px] text-stone-400 mb-0.5">Check-out</p>
                        <p class="text-sm font-bold {{ $r->checkout_at ? 'text-blue-600' : 'text-stone-300' }}">
                            {{ $r->checkout_at ? \Carbon\Carbon::parse($r->checkout_at)->format('H:i') : '--:--' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-4 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <p class="text-sm text-stone-400">Belum ada data kehadiran bulan ini</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($riwayat->hasPages())
        <div class="px-4 py-3 border-t border-stone-100 flex items-center justify-center gap-1.5">
            @if($riwayat->onFirstPage())
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                         bg-stone-50 border border-stone-200 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>
            @else
            <button wire:click="previousPage"
                class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                       bg-white border border-stone-200
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                       hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:-translate-y-px
                       transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            @endif

            <span class="inline-flex items-center justify-center px-4 h-9 rounded-xl text-xs font-bold text-white
                         shadow-[0_3px_10px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                {{ $riwayat->currentPage() }} / {{ $riwayat->lastPage() }}
            </span>

            @if($riwayat->hasMorePages())
            <button wire:click="nextPage"
                class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                       bg-white border border-stone-200
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                       hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:-translate-y-px
                       transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            @else
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                         bg-stone-50 border border-stone-200 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
            @endif
        </div>
        @endif

    </div>

</div>