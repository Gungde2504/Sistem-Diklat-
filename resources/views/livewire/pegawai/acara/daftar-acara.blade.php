<div class="space-y-4">

    {{-- Flash Success --}}
    @if(session('success'))
    <div class="p-3.5 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-2.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Flash Error --}}
    @if(session('error'))
    <div class="p-3.5 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-2.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-3
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari acara..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
            </div>
            <div class="relative">
                <select wire:model.live="jenis"
                    class="px-3 py-2.5 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200">
                    <option value="">Semua</option>
                    <option value="Diklat Internal">Internal</option>
                    <option value="Diklat Eksternal">Eksternal</option>
                    <option value="Seminar">Seminar</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Grid Acara --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        @forelse($acaras as $acara)
        @php $isTerdaftar = in_array($acara->id, $terdaftar); @endphp

        <div class="group bg-white rounded-2xl border border-stone-200 overflow-hidden flex flex-col
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-4px_rgba(59,159,209,.18)]
                    hover:-translate-y-1 transition-all duration-300">

            {{-- Sampul --}}
            <div class="relative aspect-video overflow-hidden flex-shrink-0"
                 style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                @if($acara->img)
                <img src="{{ asset('storage/'.$acara->img) }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white/25" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                    </svg>
                </div>
                @endif

                {{-- Status badge --}}
                <div class="absolute top-1.5 left-1.5">
                    <span class="text-white font-semibold px-2 py-0.5 rounded-full backdrop-blur-sm leading-none
                                 {{ $acara->status === 'Berlangsung' ? 'bg-green-500/90' : 'bg-blue-500/90' }}"
                          style="font-size:9px">
                        {{ $acara->status }}
                    </span>
                </div>

                {{-- Jenis badge --}}
                <div class="absolute bottom-1.5 left-1.5">
                    <span class="text-white font-medium px-2 py-0.5 rounded-full bg-black/40 backdrop-blur-sm leading-none"
                          style="font-size:9px">
                        {{ $acara->jenisDiklat === 'Diklat Internal' ? 'Internal' : ($acara->jenisDiklat === 'Diklat Eksternal' ? 'Eksternal' : 'Seminar') }}
                    </span>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-3 flex flex-col flex-1 justify-between">
                <div class="mb-2.5">
                    <h3 class="font-bold text-stone-800 leading-tight line-clamp-2 mb-1 text-[11.5px]">
                        {{ $acara->nama }}
                    </h3>
                    <p class="text-stone-400 truncate text-[10px] mb-1.5">{{ $acara->namaNarasumber }}</p>
                    <div class="space-y-0.5 text-[10px] text-stone-400">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                            </svg>
                            {{ \Carbon\Carbon::parse($acara->tglJamMulai)->format('d M Y') }}
                        </div>
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ $acara->durasi }}j &nbsp;·&nbsp; Sisa {{ $acara->sisaKuota() }} tempat
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('pegawai.acara.detail', $acara->id) }}"
                       class="text-center font-semibold py-1.5 rounded-xl border border-stone-200 text-stone-600
                              bg-white hover:bg-stone-50 hover:border-stone-300 hover:-translate-y-px
                              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                              active:scale-95 transition-all duration-200 text-[10px]">
                        Lihat Detail
                    </a>

                    @if($isTerdaftar)
                    <div class="text-center font-semibold py-1.5 rounded-xl
                                bg-green-50 text-green-700 border border-green-200 text-[10px]">
                        ✓ Terdaftar
                    </div>
                    @elseif($acara->sudahPenuh())
                    <div class="text-center font-semibold py-1.5 rounded-xl
                                bg-stone-100 text-stone-400 border border-stone-200 text-[10px]">
                        Penuh
                    </div>
                    @else
                    <button wire:click="daftar({{ $acara->id }})" wire:loading.attr="disabled"
                        class="relative font-semibold py-1.5 rounded-xl text-white overflow-hidden text-[10px]
                               shadow-[0_3px_10px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 hover:shadow-[0_6px_14px_-3px_rgba(15,79,122,.45)]
                               active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0
                               transition-all duration-200"
                        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <span wire:loading.remove wire:target="daftar({{ $acara->id }})" class="relative">Daftar Sekarang</span>
                        <span wire:loading wire:target="daftar({{ $acara->id }})" class="relative">Mendaftar...</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white rounded-2xl border border-stone-200 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
            <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                </svg>
            </div>
            <p class="text-sm font-medium text-stone-500">Tidak ada acara tersedia</p>
            <p class="text-xs text-stone-400 mt-0.5">Coba ubah filter pencarian</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($acaras->hasPages())
    <div class="flex items-center justify-center gap-1.5 py-2">

        {{-- Prev --}}
        @if($acaras->onFirstPage())
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

        {{-- Page indicator --}}
        <span class="inline-flex items-center justify-center px-4 h-9 rounded-xl text-xs font-bold text-white
                     shadow-[0_3px_10px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
              style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            {{ $acaras->currentPage() }} / {{ $acaras->lastPage() }}
        </span>

        {{-- Next --}}
        @if($acaras->hasMorePages())
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