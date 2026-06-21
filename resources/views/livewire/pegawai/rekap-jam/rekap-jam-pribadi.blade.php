<div class="space-y-4">

    {{-- Filter Tahun --}}
    <div class="flex items-center gap-3">
        <label class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest">Tahun</label>
        <div class="relative">
            <select wire:model.live="tahun"
                class="px-3.5 py-2 pr-8 text-sm border border-stone-200 rounded-xl bg-white text-stone-600 outline-none appearance-none
                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>

    {{-- ── PROGRESS CARD UTAMA ── --}}
    <div class="rounded-2xl p-5 text-white"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <p class="text-white/65 text-sm mb-1">Total Jam Pelatihan {{ $tahun }}</p>
        <div class="flex items-end gap-2 mb-4">
            <p class="text-5xl font-bold tracking-tight">{{ number_format($totalJam, 1) }}</p>
            <p class="text-white/55 text-lg mb-1">/ {{ $target }} jam</p>
        </div>
        <div class="w-full bg-white/20 rounded-full h-3 mb-2.5 overflow-hidden">
            <div class="h-3 rounded-full transition-all duration-700
                        {{ $persen >= 100 ? 'bg-green-400' : ($persen >= 50 ? 'bg-yellow-300' : 'bg-white/80') }}"
                 style="width:{{ min($persen, 100) }}%">
            </div>
        </div>
        <div class="flex items-center justify-between">
            <p class="text-white/55 text-xs">{{ $persen }}% dari target</p>
            @if($persen >= 100)
            <span class="text-xs px-2.5 py-1 rounded-full bg-green-400/20 text-green-200 font-semibold border border-green-400/30">
                ✅ Target Terpenuhi
            </span>
            @else
            <span class="text-xs px-2.5 py-1 rounded-full bg-white/10 text-white/65 border border-white/20">
                Kurang {{ number_format($target - $totalJam, 1) }} jam
            </span>
            @endif
        </div>
    </div>

    {{-- ── 3 SUMBER STAT CARDS ── --}}
    <div class="grid grid-cols-3 gap-3">

        {{-- Acara --}}
        <button wire:click="setTab('acara')"
            class="rounded-2xl p-4 text-center transition-all duration-300 border text-left
                   {{ $tab === 'acara'
                       ? 'bg-blue-50 border-stone-200 border-l-4 border-l-blue-500 shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_20px_-4px_rgba(59,159,209,.25)]'
                       : 'bg-white border-stone-200 border-l-4 border-l-blue-500
                          shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                          hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(59,159,209,.2)]' }}">
            <p class="text-xl font-bold {{ $tab === 'acara' ? 'text-blue-600' : 'text-stone-800' }}">
                {{ number_format($jamAcara, 1) }}
            </p>
            <p class="text-[11px] font-medium mt-0.5 {{ $tab === 'acara' ? 'text-blue-500' : 'text-stone-400' }}">Acara</p>
            <div class="w-full bg-stone-100 rounded-full h-1.5 mt-2 overflow-hidden">
                <div class="h-1.5 rounded-full bg-blue-400 transition-all duration-500"
                     style="width:{{ $target > 0 ? min(round(($jamAcara / $target) * 100), 100) : 0 }}%">
                </div>
            </div>
        </button>

        {{-- Mandiri --}}
        <button wire:click="setTab('mandiri')"
            class="rounded-2xl p-4 text-center transition-all duration-300 border text-left
                   {{ $tab === 'mandiri'
                       ? 'bg-orange-50 border-stone-200 border-l-4 border-l-orange-400 shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_20px_-4px_rgba(249,115,22,.25)]'
                       : 'bg-white border-stone-200 border-l-4 border-l-orange-400
                          shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                          hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(249,115,22,.2)]' }}">
            <p class="text-xl font-bold {{ $tab === 'mandiri' ? 'text-orange-600' : 'text-stone-800' }}">
                {{ number_format($jamMandiri, 1) }}
            </p>
            <p class="text-[11px] font-medium mt-0.5 {{ $tab === 'mandiri' ? 'text-orange-500' : 'text-stone-400' }}">Mandiri</p>
            <div class="w-full bg-stone-100 rounded-full h-1.5 mt-2 overflow-hidden">
                <div class="h-1.5 rounded-full bg-orange-400 transition-all duration-500"
                     style="width:{{ $target > 0 ? min(round(($jamMandiri / $target) * 100), 100) : 0 }}%">
                </div>
            </div>
        </button>

        {{-- E-Learning --}}
        <button wire:click="setTab('elearning')"
            class="rounded-2xl p-4 text-center transition-all duration-300 border text-left
                   {{ $tab === 'elearning'
                       ? 'bg-purple-50 border-stone-200 border-l-4 border-l-purple-500 shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_20px_-4px_rgba(168,85,247,.25)]'
                       : 'bg-white border-stone-200 border-l-4 border-l-purple-500
                          shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                          hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(168,85,247,.2)]' }}">
            <p class="text-xl font-bold {{ $tab === 'elearning' ? 'text-purple-600' : 'text-stone-800' }}">
                {{ number_format($jamElearning, 1) }}
            </p>
            <p class="text-[11px] font-medium mt-0.5 {{ $tab === 'elearning' ? 'text-purple-500' : 'text-stone-400' }}">E-Learning</p>
            <div class="w-full bg-stone-100 rounded-full h-1.5 mt-2 overflow-hidden">
                <div class="h-1.5 rounded-full bg-purple-400 transition-all duration-500"
                     style="width:{{ $target > 0 ? min(round(($jamElearning / $target) * 100), 100) : 0 }}%">
                </div>
            </div>
        </button>

    </div>

    {{-- ── TAB: ACARA ── --}}
    @if($tab === 'acara')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Riwayat Diklat Acara</p>
            <span class="ml-auto text-[10.5px] font-semibold px-2 py-0.5 rounded-full
                         bg-blue-50 text-blue-600 border border-blue-200">
                {{ $riwayatAcara->count() }} kehadiran
            </span>
        </div>
        <div class="divide-y divide-stone-50">
            @forelse($riwayatAcara as $r)
            <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-blue-50/30 transition-colors duration-150">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            bg-blue-50 border border-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800 truncate">{{ $r->diklat?->nama ?? 'Acara' }}</p>
                    <p class="text-xs text-stone-400 mt-0.5">{{ $r->date?->format('d M Y') }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold text-blue-600">{{ round($r->durasi / 60, 1) }} j</p>
                    <p class="text-[10.5px] text-stone-400">{{ $r->durasi }} menit</p>
                </div>
            </div>
            @empty
            <div class="px-4 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5" />
                    </svg>
                </div>
                <p class="text-sm text-stone-400">Belum ada riwayat diklat acara</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ── TAB: MANDIRI ── --}}
    @if($tab === 'mandiri')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Riwayat Diklat Mandiri</p>
            <span class="ml-auto text-[10.5px] font-semibold px-2 py-0.5 rounded-full
                         bg-orange-50 text-orange-500 border border-orange-200">
                {{ $riwayatMandiri->count() }} pengajuan
            </span>
        </div>
        <div class="divide-y divide-stone-50">
            @forelse($riwayatMandiri as $r)
            <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-orange-50/30 transition-colors duration-150">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            bg-orange-50 border border-orange-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800 truncate">{{ $r->nama }}</p>
                    <p class="text-xs text-stone-400 mt-0.5">
                        {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }} · {{ $r->tempat }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0 space-y-1">
                    @if($r->status === 'Disetujui')
                    <p class="text-sm font-bold text-orange-600">{{ round((int)$r->durasi / 60, 1) }} j</p>
                    @endif
                    <span class="text-[10.5px] px-2 py-0.5 rounded-full font-semibold border block
                        {{ $r->status === 'Disetujui' ? 'bg-green-50 text-green-700 border-green-200'  :
                           ($r->status === 'Ditolak'  ? 'bg-red-50 text-red-600 border-red-200'        :
                           'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                        {{ $r->status }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-4 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5" />
                    </svg>
                </div>
                <p class="text-sm text-stone-400">Belum ada riwayat diklat mandiri</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ── TAB: E-LEARNING ── --}}
    @if($tab === 'elearning')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-purple-500 to-purple-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Riwayat E-Learning</p>
            <span class="ml-auto text-[10.5px] font-semibold px-2 py-0.5 rounded-full
                         bg-purple-50 text-purple-600 border border-purple-200">
                {{ $riwayatElearning->count() }} modul selesai
            </span>
        </div>
        <div class="divide-y divide-stone-50">
            @forelse($riwayatElearning as $r)
            <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-purple-50/30 transition-colors duration-150">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            bg-purple-50 border border-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800 truncate">{{ $r->modul?->judul ?? 'Modul' }}</p>
                    <p class="text-xs text-stone-400 mt-0.5">{{ $r->completed_at?->format('d M Y') }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold text-purple-600">{{ $r->jam_dikontribusikan }} j</p>
                    @if($r->quiz_score)
                    <p class="text-[10.5px] text-stone-400">Nilai: {{ $r->quiz_score }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-4 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <p class="text-sm text-stone-400">Belum ada modul e-learning yang diselesaikan</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

</div>