<div class="space-y-4">

    {{-- ── HEADER BANNER ── --}}
    <div class="rounded-2xl p-5 text-white"
        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                        bg-white/20 border border-white/30 backdrop-blur-sm
                        shadow-[0_2px_8px_rgba(0,0,0,.15)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold tracking-tight">Sertifikat Saya</h2>
                <p class="text-white/65 text-sm mt-0.5">
                    {{ $sertifikatDiklat->count() + $sertifikatMandiri->count() }} sertifikat tersedia
                </p>
            </div>
        </div>
    </div>

    {{-- ── TAB SWITCH ── --}}
    <div class="flex gap-1.5 bg-stone-100 rounded-2xl p-1.5">
        <button wire:click="setTab('diklat')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-1.5
               {{ $tab === 'diklat'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab==='diklat' ) style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            Diklat Acara
            @if($sertifikatDiklat->count() > 0)
            <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold
            {{ $tab === 'diklat' ? 'bg-white/25 text-white' : 'bg-stone-200 text-stone-500' }}">
                {{ $sertifikatDiklat->count() }}
            </span>
            @endif
        </button>
        <button wire:click="setTab('mandiri')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-1.5
               {{ $tab === 'mandiri'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(234,88,12,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab==='mandiri' ) style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            Mandiri
            @if($sertifikatMandiri->count() > 0)
            <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold
            {{ $tab === 'mandiri' ? 'bg-white/25 text-white' : 'bg-stone-200 text-stone-500' }}">
                {{ $sertifikatMandiri->count() }}
            </span>
            @endif
        </button>
    </div>

    {{-- ── TAB: DIKLAT ACARA ── --}}
    @if($tab === 'diklat')
    <div class="space-y-3">
        @forelse($sertifikatDiklat as $s)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(59,159,209,.15)]
                    hover:-translate-y-0.5 transition-all duration-250">

            {{-- Card Header --}}
            <div class="px-4 py-3 flex items-center gap-3
                        bg-gradient-to-r from-blue-50/80 to-sky-50/40 border-b border-stone-100">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_8px_-1px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-stone-800 truncate">{{ $s->diklat?->nama ?? 'Sertifikat Diklat' }}</p>
                    <p class="text-xs text-stone-500 mt-0.5">{{ $s->diklat?->jenisDiklat }}</p>
                </div>
            </div>

            <div class="p-4">
                <div class="grid grid-cols-2 gap-2 mb-3.5">
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                        <p class="text-[10.5px] text-stone-400">Tanggal Acara</p>
                        <p class="text-xs font-semibold text-stone-700 mt-0.5">{{ $s->diklat?->tglJamMulai ?? '-' }}</p>
                    </div>
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                        <p class="text-[10.5px] text-stone-400">Tempat</p>
                        <p class="text-xs font-semibold text-stone-700 truncate mt-0.5">{{ $s->diklat?->tempat ?? '-' }}</p>
                    </div>
                </div>

                {{-- Tombol Unduh biru --}}
                <a href="{{ asset('storage/'.$s->file) }}" target="_blank"
                    class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-white text-sm font-bold overflow-hidden
                          shadow-[0_4px_14px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                          hover:-translate-y-0.5 hover:scale-[1.02]
                          hover:shadow-[0_8px_22px_-4px_rgba(15,79,122,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                          active:scale-[.97] transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span class="relative">Unduh Sertifikat</span>
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
            <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-stone-500 mb-1">Belum Ada Sertifikat Diklat</p>
            <p class="text-xs text-stone-400 mb-4 leading-relaxed">Sertifikat tersedia setelah Admin men-generate untuk acara yang Anda ikuti.</p>
            <a href="{{ route('pegawai.acara') }}"
                class="relative inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-xs font-semibold overflow-hidden
                      shadow-[0_3px_10px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                      hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-3px_rgba(15,79,122,.45)]
                      active:scale-95 transition-all duration-200"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <span class="relative">🗓 Lihat Daftar Acara</span>
            </a>
        </div>
        @endforelse
    </div>
    @endif

    {{-- ── TAB: DIKLAT MANDIRI ── --}}
    @if($tab === 'mandiri')
    <div class="space-y-3">
        @forelse($sertifikatMandiri as $s)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(249,115,22,.15)]
                    hover:-translate-y-0.5 transition-all duration-250">

            {{-- Card Header --}}
            <div class="px-4 py-3 flex items-center gap-3
                        bg-gradient-to-r from-orange-50/80 to-amber-50/40 border-b border-stone-100">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_8px_-1px_rgba(234,88,12,.35),0_1px_0_rgba(255,255,255,.2)_inset]"
                    style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-stone-800 truncate">{{ $s->nama }}</p>
                    <p class="text-xs text-stone-500 mt-0.5">{{ $s->tempat }}</p>
                </div>
                <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold flex-shrink-0
                             bg-green-50 text-green-700 border border-green-200">
                    ✓ Disetujui
                </span>
            </div>

            <div class="p-4">
                <div class="grid grid-cols-2 gap-2 mb-3.5">
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-orange-50/50 hover:border-orange-100 transition-colors duration-200">
                        <p class="text-[10.5px] text-stone-400">Durasi</p>
                        <p class="text-xs font-semibold text-stone-700 mt-0.5">
                            {{ $s->durasi }} menit ({{ round((int)$s->durasi / 60, 1) }} jam)
                        </p>
                    </div>
                    <div class="bg-stone-50 border border-stone-100 rounded-xl p-2.5
                                hover:bg-orange-50/50 hover:border-orange-100 transition-colors duration-200">
                        <p class="text-[10.5px] text-stone-400">Tanggal</p>
                        <p class="text-xs font-semibold text-stone-700 mt-0.5">
                            {{ \Carbon\Carbon::parse($s->tglJamMulai)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- Tombol Unduh orange gradient --}}
                <a href="{{ asset('storage/'.$s->sertifikat) }}" target="_blank"
                    class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-white text-sm font-bold overflow-hidden
                          shadow-[0_4px_14px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                          hover:-translate-y-0.5 hover:scale-[1.02]
                          hover:shadow-[0_8px_22px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                          active:scale-[.97] transition-all duration-200"
                    style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span class="relative">Unduh Bukti Sertifikat</span>
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
            <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-stone-500 mb-1">Belum Ada Sertifikat Mandiri</p>
            <p class="text-xs text-stone-400 mb-4 leading-relaxed">Sertifikat mandiri tersedia setelah pengajuan disetujui Admin.</p>
            <a href="{{ route('pegawai.diklat-mandiri') }}"
                class="relative inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-xs font-semibold overflow-hidden
                      shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                      hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-3px_rgba(234,88,12,.45)]
                      active:scale-95 transition-all duration-200"
                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <span class="relative">📄 Ajukan Diklat Mandiri</span>
            </a>
        </div>
        @endforelse
    </div>
    @endif

</div>