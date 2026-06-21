<div class="space-y-4">

    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <div class="flex items-center gap-2.5">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Jurnal Harian</h3>
                <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2.5 py-1 rounded-full">
                    {{ $totalJurnal }} jurnal
                </span>
            </div>
        </div>

        {{-- Filter --}}
        <div class="px-5 py-3 border-b border-stone-100 flex items-center gap-3">
            <div class="relative">
                <select wire:model.live="filterBulan"
                    class="px-3.5 py-2 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                    <option value="{{ $i + 1 }}">{{ $bln }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            <div class="relative">
                <select wire:model.live="filterTahun"
                    class="px-3.5 py-2 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        {{-- Daftar Jurnal --}}
        <div class="divide-y divide-stone-50">
            @forelse($jurnals as $jurnal)
            <div class="px-5 py-5 hover:bg-stone-50/50 transition-colors duration-150">

                {{-- Jurnal Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-stone-800">
                            {{ $jurnal->tanggal->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-xs text-stone-400 mt-0.5">
                            Ditulis {{ \Carbon\Carbon::parse($jurnal->created_at)->diffForHumans() }}
                        </p>
                    </div>
                    <span class="text-[10.5px] font-bold px-2.5 py-1 rounded-full
                                 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600
                                 border border-orange-200">
                        Hari {{ $jurnal->tanggal->diffInDays(\Carbon\Carbon::parse($detail->tanggal_mulai)) + 1 }}
                    </span>
                </div>

                <div class="space-y-2.5">

                    {{-- Aktivitas --}}
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-3.5">
                        <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                            </svg>
                            Aktivitas
                        </p>
                        <p class="text-sm text-stone-700 leading-relaxed">{{ $jurnal->aktivitas }}</p>
                    </div>

                    {{-- Kendala --}}
                    @if($jurnal->kendala)
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3.5
                                shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                        <p class="text-[10.5px] font-bold text-orange-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Kendala
                        </p>
                        <p class="text-sm text-stone-700 leading-relaxed">{{ $jurnal->kendala }}</p>
                    </div>
                    @endif

                    {{-- Rencana Besok --}}
                    @if($jurnal->rencana_besok)
                    <div class="bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-xl p-3.5
                                shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                        <p class="text-[10.5px] font-bold text-blue-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            Rencana Besok
                        </p>
                        <p class="text-sm text-stone-700 leading-relaxed">{{ $jurnal->rencana_besok }}</p>
                    </div>
                    @endif

                </div>
            </div>
            @empty
            <div class="px-5 py-14 text-center">
                <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-stone-500 mb-0.5">Belum ada jurnal bulan ini</p>
                <p class="text-xs text-stone-400">Jurnal akan muncul setelah peserta mengisinya</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50 flex items-center justify-between">
            <p class="text-xs text-stone-400">
                Halaman <span class="font-semibold text-stone-600">{{ $jurnals->currentPage() }}</span>
                dari <span class="font-semibold text-stone-600">{{ $jurnals->lastPage() }}</span>
            </p>
            <div class="flex items-center gap-1.5">
                {{-- Prev --}}
                @if($jurnals->onFirstPage())
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
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                @endif

                {{-- Page indicator --}}
                <span class="inline-flex items-center justify-center px-3.5 h-9 rounded-xl text-sm font-bold text-white
                             shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
                      style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                    {{ $jurnals->currentPage() }} / {{ $jurnals->lastPage() }}
                </span>

                {{-- Next --}}
                @if($jurnals->hasMorePages())
                <button wire:click="nextPage"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                           bg-white border border-stone-200
                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
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
        </div>

    </div>
</div>