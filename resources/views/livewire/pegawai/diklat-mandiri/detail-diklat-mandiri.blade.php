<div class="space-y-4">

    {{-- ── HEADER BANNER ── --}}
    <div class="rounded-2xl p-5 text-white"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full bg-white/20 border border-white/25">
                Diklat Mandiri
            </span>
            <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm
                {{ $diklat->status === 'Disetujui' ? 'bg-green-400/25 text-green-200 border border-green-400/35'  :
                   ($diklat->status === 'Ditolak'  ? 'bg-red-400/25 text-red-200 border border-red-400/35'        :
                   'bg-yellow-400/25 text-yellow-200 border border-yellow-400/35') }}">
                {{ $diklat->status }}
            </span>
        </div>
        <h2 class="text-lg font-bold tracking-tight mb-1">{{ $diklat->nama }}</h2>
        <p class="text-white/65 text-sm flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            {{ $diklat->tempat }}
        </p>
    </div>

    {{-- ── INFO GRID ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="grid grid-cols-2 gap-2.5 mb-3">
            @foreach([
                ['label' => 'Tanggal Mulai',  'value' => $diklat->tglJamMulai,                                 'color' => ''],
                ['label' => 'Tanggal Selesai','value' => $diklat->tglJamSelesai,                                'color' => ''],
                ['label' => 'Durasi',         'value' => $diklat->durasi.' menit',                             'color' => ''],
                ['label' => 'Setara Jam',     'value' => round((int)$diklat->durasi / 60, 1).' jam',           'color' => 'text-blue-600'],
            ] as $info)
            <div class="bg-stone-50 border border-stone-100 rounded-xl p-3
                        hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                <p class="text-[10.5px] text-stone-400 mb-0.5">{{ $info['label'] }}</p>
                <p class="text-sm font-semibold {{ $info['color'] ?: 'text-stone-800' }}">{{ $info['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="pt-3 border-t border-stone-100 flex items-center justify-between">
            <p class="text-xs text-stone-400">Tanggal Pengajuan</p>
            <p class="text-xs font-semibold text-stone-600">
                {{ \Carbon\Carbon::parse($diklat->created_at)->format('d M Y, H:i') }}
            </p>
        </div>
    </div>

    {{-- ── STATUS INFO ── --}}
    <div class="rounded-2xl p-4 border
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                {{ $diklat->status === 'Disetujui' ? 'bg-green-50 border-green-200'  :
                   ($diklat->status === 'Ditolak'  ? 'bg-red-50 border-red-200'      :
                   'bg-yellow-50 border-yellow-200') }}">
        <div class="flex items-center gap-3">
            @if($diklat->status === 'Disetujui')
            <div class="w-10 h-10 bg-green-100 border border-green-200 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-green-700">Pengajuan Disetujui</p>
                <p class="text-xs text-green-600 mt-0.5">
                    {{ round((int)$diklat->durasi / 60, 1) }} jam telah dikontribusikan ke rekap jam pelatihan Anda.
                </p>
            </div>
            @elseif($diklat->status === 'Ditolak')
            <div class="w-10 h-10 bg-red-100 border border-red-200 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-red-600">Pengajuan Ditolak</p>
                <p class="text-xs text-red-500 mt-0.5">Silakan hubungi Admin Diklat untuk informasi lebih lanjut.</p>
            </div>
            @else
            <div class="w-10 h-10 bg-yellow-100 border border-yellow-200 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-yellow-700">Menunggu Verifikasi</p>
                <p class="text-xs text-yellow-600 mt-0.5">Pengajuan sedang ditinjau oleh Admin Diklat.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ── BUKTI SERTIFIKAT ── --}}
    @if($diklat->sertifikat)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Bukti Sertifikat</p>
        </div>
        <div class="p-4">
            @php $ext = strtolower(pathinfo($diklat->sertifikat, PATHINFO_EXTENSION)); @endphp

            {{-- Preview gambar --}}
            @if(in_array($ext, ['jpg','jpeg','png']))
            <div class="mb-3 rounded-xl overflow-hidden border border-stone-200
                        shadow-[0_2px_8px_-2px_rgba(120,113,108,.12)]">
                <img src="{{ asset('storage/'.$diklat->sertifikat) }}"
                     alt="Bukti Sertifikat"
                     class="w-full object-contain max-h-64"/>
            </div>
            @else
            {{-- PDF preview --}}
            <div class="flex items-center gap-3 p-3.5 bg-red-50 border border-red-200 rounded-xl mb-3">
                <div class="w-10 h-10 bg-red-100 border border-red-200 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-red-700">File PDF</p>
                    <p class="text-xs text-red-400 truncate max-w-48">{{ basename($diklat->sertifikat) }}</p>
                </div>
            </div>
            @endif

            {{-- Tombol Unduh -- gradient biru --}}
            <a href="{{ asset('storage/'.$diklat->sertifikat) }}" target="_blank"
               class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-white text-sm font-bold overflow-hidden
                      shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                      hover:-translate-y-0.5 hover:scale-[1.02]
                      hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                      active:scale-[.97] transition-all duration-200"
               style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span class="relative">Unduh / Lihat Sertifikat</span>
            </a>
        </div>
    </div>
    @endif

    {{-- ── FILE MATERI ── --}}
    @if($diklat->materi)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">File Materi</p>
        </div>
        <div class="p-4">
            <div class="flex items-center gap-3 p-3.5 bg-orange-50 border border-orange-200 rounded-xl mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(234,88,12,.3)]"
                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-orange-700">File Materi</p>
                    <p class="text-xs text-orange-400 truncate">{{ basename($diklat->materi) }}</p>
                </div>
            </div>

            {{-- Tombol Unduh -- gradient biru sama --}}
            <a href="{{ asset('storage/'.$diklat->materi) }}" target="_blank"
               class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-white text-sm font-bold overflow-hidden
                      shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                      hover:-translate-y-0.5 hover:scale-[1.02]
                      hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                      active:scale-[.97] transition-all duration-200"
               style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span class="relative">Unduh File Materi</span>
            </a>
        </div>
    </div>
    @endif

    {{-- ── KEMBALI ── --}}
    <a href="{{ route('pegawai.diklat-mandiri') }}"
       class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-sm font-medium text-stone-500
              bg-white border border-stone-200
              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
              hover:text-stone-700 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
              transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Diklat Mandiri
    </a>

</div>