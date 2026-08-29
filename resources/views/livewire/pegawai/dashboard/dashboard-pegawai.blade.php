<div class="space-y-4">

    {{-- ── GREETING BANNER ── --}}
    <div class="relative rounded-2xl px-5 py-5"
        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">

        <div class="relative">
            <p class="text-white/65 text-sm">Selamat datang,</p>
            <h2 class="text-xl font-bold text-white tracking-tight">{{ auth()->user()->nama }}</h2>
            <p class="text-white/50 text-xs mt-0.5">{{ auth()->user()->unit ?? 'RSU Prima Medika' }}</p>

            <div class="mt-4">
                <div class="flex items-center justify-between mb-1.5">
                    <p class="text-xs text-white/65">Jam Pelatihan {{ now()->year }}</p>
                    <p class="text-xs font-bold text-white">{{ number_format($totalJam, 1) }} / {{ $target }} jam</p>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full transition-all duration-700
                            {{ $persen >= 100 ? 'bg-green-400' : ($persen >= 50 ? 'bg-yellow-300' : 'bg-white/80') }}"
                        style="width:{{ min($persen, 100) }}%">
                    </div>
                </div>
                <p class="text-xs text-white/55 mt-1.5">
                    {{ $persen >= 100 ? '✅ Target terpenuhi!' : $persen.'% dari target '.$target.' jam' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ── STATS 3 SUMBER ── --}}
    <div class="grid grid-cols-3 gap-3">

        <div class="bg-white rounded-2xl p-3.5 text-center border border-stone-200 border-l-4 border-l-blue-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(59,159,209,.2)]
                    transition-all duration-300">
            <div class="w-8 h-8 bg-blue-50 border border-blue-200 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                </svg>
            </div>
            <p class="text-lg font-bold text-stone-800">{{ number_format($jamAcara, 1) }}</p>
            <p class="text-[11px] text-stone-400 font-medium">Acara</p>
        </div>

        <div class="bg-white rounded-2xl p-3.5 text-center border border-stone-200 border-l-4 border-l-orange-400
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(249,115,22,.2)]
                    transition-all duration-300">
            <div class="w-8 h-8 bg-orange-50 border border-orange-200 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <p class="text-lg font-bold text-stone-800">{{ number_format($jamMandiri, 1) }}</p>
            <p class="text-[11px] text-stone-400 font-medium">Mandiri</p>
        </div>

        <div class="bg-white rounded-2xl p-3.5 text-center border border-stone-200 border-l-4 border-l-purple-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(168,85,247,.2)]
                    transition-all duration-300">
            <div class="w-8 h-8 bg-purple-50 border border-purple-200 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <p class="text-lg font-bold text-stone-800">{{ number_format($jamElearning, 1) }}</p>
            <p class="text-[11px] text-stone-400 font-medium">E-Learning</p>
        </div>

    </div>

    {{-- ── AKSES CEPAT ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Akses Cepat</p>
        <div class="grid grid-cols-4 gap-2">

            <a href="{{ route('pegawai.sertifikat') }}"
                class="group flex flex-col items-center gap-1.5 p-3 rounded-2xl border border-blue-100 bg-blue-50/60
          hover:bg-blue-100 hover:-translate-y-1
          hover:shadow-[0_6px_16px_-3px_rgba(15,79,122,.25)]
          active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center
                shadow-[0_3px_8px_-1px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-blue-700 text-center">Sertifikat</span>
            </a>

            <a href="{{ route('pegawai.acara') }}"
                class="group flex flex-col items-center gap-1.5 p-3 rounded-2xl border border-sky-100 bg-sky-50/60
                      hover:bg-sky-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(14,165,233,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center
                            shadow-[0_3px_8px_-1px_rgba(14,165,233,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200
                            bg-gradient-to-br from-sky-400 to-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-sky-700 text-center">Acara</span>
            </a>

            <a href="{{ route('pegawai.diklat-mandiri') }}"
                class="group flex flex-col items-center gap-1.5 p-3 rounded-2xl border border-orange-100 bg-orange-50/60
                      hover:bg-orange-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(249,115,22,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center
                            shadow-[0_3px_8px_-1px_rgba(234,88,12,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200"
                    style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-orange-600 text-center">Mandiri</span>
            </a>

            <a href="{{ route('pegawai.elearning') }}"
                class="group flex flex-col items-center gap-1.5 p-3 rounded-2xl border border-purple-100 bg-purple-50/60
                      hover:bg-purple-100 hover:-translate-y-1
                      hover:shadow-[0_6px_16px_-3px_rgba(168,85,247,.25)]
                      active:scale-95 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center
                            shadow-[0_3px_8px_-1px_rgba(147,51,234,.35),0_1px_0_rgba(255,255,255,.2)_inset]
                            group-hover:scale-110 group-hover:-rotate-3 transition-all duration-200
                            bg-gradient-to-br from-purple-400 to-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-purple-600 text-center">E-Learning</span>
            </a>

        </div>
    </div>

    {{-- ── ACARA MENDATANG + DIKLAT MANDIRI (sejajar) ── --}}
   <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        {{-- ── ACARA MENDATANG ── --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
                <div class="flex items-center gap-2">
                    <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
                    <p class="text-sm font-semibold text-stone-800 tracking-tight">Acara Mendatang</p>
                </div>
                <a href="{{ route('pegawai.acara') }}"
                    class="text-xs text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                    Lihat semua →
                </a>
            </div>
            <div class="divide-y divide-stone-50">
                @forelse($acaraMendatang as $acara)
                <a href="{{ route('pegawai.acara.detail', $acara->id) }}"
                    class="group flex items-center justify-between gap-3 px-4 py-3.5
                          hover:bg-blue-50/40 transition-all duration-200">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-stone-800 truncate group-hover:text-blue-700 transition-colors duration-200">
                            {{ $acara->nama }}
                        </p>
                        <p class="text-xs text-blue-500 mt-0.5">{{ $acara->tglJamMulai }} · {{ $acara->tempat }}</p>
                    </div>
                    <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border flex-shrink-0
                        {{ $acara->status === 'Berlangsung'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                        {{ $acara->status }}
                    </span>
                </a>
                @empty
                <div class="px-4 py-10 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                        </svg>
                    </div>
                    <p class="text-sm text-stone-400">Tidak ada acara mendatang</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── RIWAYAT DIKLAT MANDIRI ── --}}
        @if($riwayatMandiri->count() > 0)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
                <div class="flex items-center gap-2">
                    <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                    <p class="text-sm font-semibold text-stone-800 tracking-tight">Diklat Mandiri Terbaru</p>
                </div>
                <a href="{{ route('pegawai.diklat-mandiri') }}"
                    class="text-xs text-orange-500 font-semibold hover:text-orange-600 transition-colors">
                    Lihat semua →
                </a>
            </div>
            <div class="divide-y divide-stone-50">
                @foreach($riwayatMandiri as $dm)
                <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-orange-50/40 transition-colors duration-150">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-stone-800 truncate">{{ $dm->nama }}</p>
                        <p class="text-xs text-orange-500 mt-0.5">
                            {{ $dm->durasi }} menit · {{ \Carbon\Carbon::parse($dm->created_at)->format('d M Y') }}
                        </p>
                    </div>
                    <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border flex-shrink-0
                        {{ $dm->status === 'Disetujui' ? 'bg-green-50 text-green-700 border-green-200'  :
                           ($dm->status === 'Ditolak'  ? 'bg-red-50 text-red-600 border-red-200'        :
                           'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                        {{ $dm->status }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</div>