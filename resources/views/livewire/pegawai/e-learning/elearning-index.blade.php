<div class="space-y-5">

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3">

        {{-- Total Modul --}}
        <div class="group relative bg-white rounded-2xl border-l-4 border-l-[#3B9FD1] overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]
                hover:shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_24px_-4px_rgba(27,94,123,.2)]
                hover:-translate-y-0.5 transition-all duration-200">
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10.5px] font-bold text-[#3B9FD1] uppercase tracking-widest">Total Modul</p>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center border border-[#3B9FD1]/20 bg-[#3B9FD1]/10
                            group-hover:bg-[#3B9FD1]/20 group-hover:scale-110 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#3B9FD1]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-[#3B9FD1] leading-none">{{ $totalModul }}</p>
                <p class="text-[11px] text-stone-400 mt-1">Total tersedia</p>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="group relative bg-white rounded-2xl border-l-4 border-l-green-500 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]
                hover:shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_24px_-4px_rgba(34,197,94,.2)]
                hover:-translate-y-0.5 transition-all duration-200">
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">Selesai</p>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center border border-green-200 bg-green-50
                            group-hover:bg-green-100 group-hover:scale-110 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-green-600 leading-none">{{ $totalSelesai }}</p>
                <p class="text-[11px] text-stone-400 mt-1">Total disetujui</p>
            </div>
        </div>

        {{-- Sedang Belajar --}}
        <div class="group relative bg-white rounded-2xl border-l-4 border-l-orange-400 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]
                hover:shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_8px_24px_-4px_rgba(249,115,22,.2)]
                hover:-translate-y-0.5 transition-all duration-200">
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10.5px] font-bold text-orange-500 uppercase tracking-widest">Sedang Belajar</p>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center border border-orange-200 bg-orange-50
                            group-hover:bg-orange-100 group-hover:scale-110 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-orange-500 leading-none">{{ $totalProgress }}</p>
                <p class="text-[11px] text-stone-400 mt-1">Sedang berlangsung</p>
            </div>
        </div>

    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-2xl border border-stone-100 p-4 flex gap-3
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari modul..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white
                       transition-all duration-200" />
        </div>
        <select wire:model.live="filter"
            class="px-3 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700
                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15
                   transition-all duration-200">
            <option value="semua">Semua</option>
            <option value="belum">Belum Mulai</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    {{-- Modul Grid --}}
    @if($moduls->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($moduls as $modul)
        @php $status = $progressMap[$modul->id] ?? null; @endphp
        <a href="{{ route('pegawai.elearning.detail', $modul->id) }}"
            class="group bg-white rounded-2xl border border-stone-100 overflow-hidden block
               shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]
               hover:shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_12px_32px_-6px_rgba(15,79,122,.18)]
               hover:-translate-y-1 transition-all duration-200">

            {{-- Header Card --}}
            <div class="relative px-5 py-4 overflow-hidden"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                {{-- Shine --}}
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>

                <div class="relative flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-bold text-sm leading-tight line-clamp-2">{{ $modul->judul }}</p>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            </svg>
                            <p class="text-white/60 text-xs">{{ $modul->kategori ?? 'Umum' }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 rounded-full flex-shrink-0 font-bold border
                    @if($status === 'completed') bg-green-400/20 text-green-200 border-green-400/30
                    @elseif($status === 'in_progress') bg-yellow-400/20 text-yellow-200 border-yellow-400/30
                    @elseif($status === 'failed') bg-red-400/20 text-red-200 border-red-400/30
                    @else bg-white/10 text-white/70 border-white/20
                    @endif">
                        @if($status === 'completed') Selesai
                        @elseif($status === 'in_progress') Belajar
                        @elseif($status === 'failed') Tidak Lulus
                        @else Belum Mulai
                        @endif
                    </span>
                </div>
            </div>

            {{-- Body Card --}}
            <div class="px-5 py-4">
                @if($modul->deskripsi)
                <p class="text-xs text-stone-500 mb-3 line-clamp-2 leading-relaxed">{{ $modul->deskripsi }}</p>
                @endif

                <div class="flex items-center gap-2 flex-wrap">
                    <span class="flex items-center gap-1.5 text-xs text-stone-400 bg-stone-50 border border-stone-100 px-2.5 py-1 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ $modul->estimasi_durasi_jam }} jam
                    </span>
                    @if($modul->quizzes_count > 0)
                    <span class="flex items-center gap-1.5 text-xs text-stone-400 bg-stone-50 border border-stone-100 px-2.5 py-1 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                        {{ $modul->quizzes_count }} soal
                    </span>
                    @endif
                    @if($modul->link_video)
                    <span class="flex items-center gap-1.5 text-xs text-stone-400 bg-stone-50 border border-stone-100 px-2.5 py-1 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Video
                    </span>
                    @endif
                </div>

                {{-- CTA --}}
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        @if($status === 'completed')
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                        <span class="text-xs text-green-600 font-semibold">Selesai dipelajari</span>
                        @elseif($status === 'in_progress')
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                        <span class="text-xs text-yellow-600 font-semibold">Lanjutkan belajar</span>
                        @else
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-300"></span>
                        <span class="text-xs text-stone-400 font-medium">Mulai belajar</span>
                        @endif
                    </div>

                    {{-- Arrow CTA --}}
                    <div class="relative flex items-center justify-center w-7 h-7 rounded-lg overflow-hidden
                            shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:shadow-[0_4px_12px_-2px_rgba(15,79,122,.5)]
                            group-hover:scale-110 transition-all duration-200"
                        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5 text-white relative group-hover:translate-x-0.5 transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl border border-stone-100 p-12 text-center
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4
                shadow-[0_4px_14px_-3px_rgba(15,79,122,.2),0_1px_0_rgba(255,255,255,.2)_inset]"
            style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        </div>
        <p class="text-sm font-semibold text-stone-500">Belum ada modul tersedia</p>
        <p class="text-xs text-stone-400 mt-1">Modul e-learning akan muncul di sini</p>
    </div>
    @endif

</div>