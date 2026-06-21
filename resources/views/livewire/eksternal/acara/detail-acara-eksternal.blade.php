<div class="space-y-4">

    {{-- Flash --}}
    @if(session('success'))
    <div class="p-3.5 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-2.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="p-3.5 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-2.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- ── HEADER BANNER ── --}}
    <div class="rounded-2xl p-5 text-white"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full bg-white/20 border border-white/25 backdrop-blur-sm">
                    {{ $diklat->jenisDiklat }}
                </span>
                <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm
                    {{ $diklat->status === 'Berlangsung'
                        ? 'bg-green-400/25 text-green-200 border border-green-400/35'
                        : 'bg-white/15 text-white/80 border border-white/25' }}">
                    {{ $diklat->status }}
                </span>
            </div>
            <a href="{{ route('eksternal.acara') }}"
               class="flex items-center gap-1 text-white/70 hover:text-white transition text-xs flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
        <h2 class="text-lg font-bold tracking-tight mb-1">{{ $diklat->nama }}</h2>
        <p class="text-white/65 text-sm flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            {{ $diklat->namaNarasumber }}
        </p>
    </div>

    {{-- ── INFO CARD ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="grid grid-cols-2 gap-2.5 mb-3">
            @foreach([
                ['label' => 'Tanggal Mulai',  'value' => $diklat->tglJamMulai],
                ['label' => 'Tanggal Selesai', 'value' => $diklat->tglJamSelesai],
                ['label' => 'Tempat',          'value' => $diklat->tempat],
                ['label' => 'Durasi',          'value' => $diklat->durasi.' jam'],
            ] as $info)
            <div class="bg-stone-50 border border-stone-100 rounded-xl p-3
                        hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                <p class="text-[10.5px] text-stone-400 mb-0.5">{{ $info['label'] }}</p>
                <p class="text-sm font-semibold text-stone-800">{{ $info['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Kuota Progress --}}
        @php
            $hadir = $diklat->absensiDiklats()->count();
            $pctKuota = $diklat->kuota > 0 ? min(round(($hadir / $diklat->kuota) * 100), 100) : 0;
        @endphp
        <div class="bg-stone-50 border border-stone-100 rounded-xl p-3">
            <div class="flex justify-between items-center mb-2">
                <p class="text-[10.5px] text-stone-500 font-medium">Kuota Peserta</p>
                <p class="text-xs font-bold text-stone-700">{{ $hadir }} / {{ $diklat->kuota }}</p>
            </div>
            <div class="w-full bg-stone-200 rounded-full h-2 overflow-hidden">
                <div class="h-2 rounded-full transition-all duration-700"
                     style="width:{{ $pctKuota }}%;background:linear-gradient(90deg,#3B9FD1,#0F5A8C)">
                </div>
            </div>
            <p class="text-[10px] text-stone-400 mt-1">{{ $pctKuota }}% terisi</p>
        </div>
    </div>

    {{-- ── DESKRIPSI ── --}}
    @if($diklat->deskripsi)
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2 mb-2.5">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest">Deskripsi</p>
        </div>
        <p class="text-sm text-stone-700 leading-relaxed">{{ $diklat->deskripsi }}</p>
    </div>
    @endif

    {{-- ── PRE/POST TEST ── --}}
    @if($diklat->linkPretest || $diklat->linkPosttest)
    <div class="bg-white rounded-2xl border border-stone-200 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-teal-500 to-teal-700"></div>
            <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest">Pre / Post Test</p>
        </div>
        <div class="space-y-2">
            @if($diklat->linkPretest)
            <a href="{{ $diklat->linkPretest }}" target="_blank"
               class="group flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-xl
                      hover:bg-blue-100 hover:-translate-y-0.5
                      hover:shadow-[0_4px_12px_-2px_rgba(59,159,209,.25)]
                      transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(15,79,122,.3)]
                            group-hover:scale-105 transition-transform duration-200"
                     style="background:linear-gradient(135deg,#3B9FD1,#1A78B0,#0F5A8C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-blue-700">Buka Link Pretest</p>
                    <p class="text-[10px] text-blue-400 truncate">{{ $diklat->linkPretest }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400 flex-shrink-0 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            @endif
            @if($diklat->linkPosttest)
            <a href="{{ $diklat->linkPosttest }}" target="_blank"
               class="group flex items-center gap-3 p-3 bg-orange-50 border border-orange-200 rounded-xl
                      hover:bg-orange-100 hover:-translate-y-0.5
                      hover:shadow-[0_4px_12px_-2px_rgba(249,115,22,.25)]
                      transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(234,88,12,.3)]
                            group-hover:scale-105 transition-transform duration-200"
                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-orange-700">Buka Link Posttest</p>
                    <p class="text-[10px] text-orange-400 truncate">{{ $diklat->linkPosttest }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 flex-shrink-0 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- ── MATERI DIKLAT ── --}}
    @php
    $materis = \App\Models\MFileDiklat::where('id_diklat', $diklat->id)
        ->where('type', 'materi')
        ->orderByDesc('created_at')
        ->get();
    @endphp
    @if($materis->count() > 0)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Materi Diklat</p>
            <span class="text-[10.5px] font-semibold px-2 py-0.5 rounded-full ml-auto
                         bg-blue-50 text-blue-600 border border-blue-200">
                {{ $materis->count() }} file
            </span>
        </div>
        <div class="divide-y divide-stone-50">
            @foreach($materis as $materi)
            @php
                $ext = strtolower(pathinfo($materi->file, PATHINFO_EXTENSION));
                $extColor = match($ext) {
                    'pdf'        => ['bg' => 'bg-red-50',    'text' => 'text-red-600',    'border' => 'border-red-200'],
                    'doc','docx' => ['bg' => 'bg-blue-50',   'text' => 'text-blue-600',   'border' => 'border-blue-200'],
                    'ppt','pptx' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-200'],
                    'xls','xlsx' => ['bg' => 'bg-green-50',  'text' => 'text-green-600',  'border' => 'border-green-200'],
                    default      => ['bg' => 'bg-stone-50',  'text' => 'text-stone-600',  'border' => 'border-stone-200'],
                };
            @endphp
            <div class="flex items-center gap-3 px-4 py-3 hover:bg-stone-50/60 transition-colors duration-150">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border
                            {{ $extColor['bg'] }} {{ $extColor['border'] }}">
                    <span class="font-bold uppercase text-[9px] {{ $extColor['text'] }}">{{ strtoupper($ext) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-stone-700 truncate">{{ basename($materi->file) }}</p>
                    <p class="text-[10.5px] text-stone-400">{{ \Carbon\Carbon::parse($materi->created_at)->format('d M Y') }}</p>
                </div>
                <a href="{{ asset('storage/'.$materi->file) }}" target="_blank"
                   class="relative flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-white text-[10.5px] font-semibold flex-shrink-0 overflow-hidden
                          shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                          hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(15,79,122,.45)]
                          active:scale-95 transition-all duration-200"
                   style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span class="relative">Unduh</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── FOTO DOKUMENTASI ── --}}
    @php
    $fotos = \App\Models\MFileDiklat::where('id_diklat', $diklat->id)
        ->where('type', 'foto')
        ->orderByDesc('created_at')
        ->limit(9)
        ->get();
    @endphp
    @if($fotos->count() > 0)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Foto Dokumentasi</p>
            <span class="text-[10.5px] font-semibold px-2 py-0.5 rounded-full ml-auto
                         bg-orange-50 text-orange-500 border border-orange-200">
                {{ $fotos->count() }} foto
            </span>
        </div>
        <div class="p-3 grid grid-cols-3 gap-2">
            @foreach($fotos as $foto)
            <a href="{{ asset('storage/'.$foto->file) }}" target="_blank"
               class="group rounded-xl overflow-hidden aspect-square bg-stone-100 block
                      shadow-[0_2px_6px_-1px_rgba(120,113,108,.12)]
                      hover:shadow-[0_6px_16px_-3px_rgba(120,113,108,.2)]
                      hover:-translate-y-0.5 transition-all duration-200">
                <img src="{{ asset('storage/'.$foto->file) }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── TOMBOL DAFTAR (Sticky) ── --}}
    <div class="sticky bottom-20 lg:bottom-4">
        @if($sudahTerdaftar)
        <div class="w-full text-center py-3.5 rounded-2xl text-sm font-semibold
                    bg-green-50 text-green-700 border border-green-200
                    shadow-[0_4px_20px_-4px_rgba(34,197,94,.25),0_1px_0_rgba(255,255,255,.9)_inset]">
            ✅ Anda sudah terdaftar di acara ini
        </div>
        @elseif($sudahPenuh)
        <div class="w-full text-center py-3.5 rounded-2xl text-sm font-semibold
                    bg-stone-100 text-stone-400 border border-stone-200
                    shadow-[0_4px_20px_-4px_rgba(120,113,108,.15)]">
            Kuota Penuh
        </div>
        @elseif(in_array($diklat->status, ['Terbuka', 'Berlangsung']))
        <button wire:click="daftar" wire:loading.attr="disabled"
            class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl border-none cursor-pointer
                   text-white text-sm font-bold overflow-hidden
                   shadow-[0_6px_20px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                   hover:-translate-y-0.5 hover:scale-[1.02]
                   hover:shadow-[0_10px_28px_-4px_rgba(15,79,122,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                   active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                   transition-all duration-200"
            style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            <div wire:loading wire:target="daftar">
                <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                </svg>
            </div>
            <svg wire:loading.remove wire:target="daftar" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span wire:loading.remove wire:target="daftar" class="relative">Daftar Sekarang</span>
            <span wire:loading wire:target="daftar" class="relative">Mendaftarkan...</span>
        </button>
        @else
        <div class="w-full text-center py-3.5 rounded-2xl text-sm font-semibold
                    bg-stone-100 text-stone-400 border border-stone-200
                    shadow-[0_4px_20px_-4px_rgba(120,113,108,.15)]">
            Pendaftaran tidak tersedia
        </div>
        @endif
    </div>

    <div class="h-4"></div>

</div>