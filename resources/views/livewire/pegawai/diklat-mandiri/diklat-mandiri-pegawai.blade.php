<div class="space-y-4">

    {{-- Flash --}}
    @if($berhasil)
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <div class="flex-1">
            <p class="text-sm font-semibold text-green-700">Pengajuan berhasil dikirim!</p>
            <p class="text-xs text-green-600 mt-0.5">Menunggu verifikasi dari Admin Diklat.</p>
        </div>
        <button wire:click="$set('berhasil', false)" class="text-green-300 hover:text-green-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 gap-3">

        {{-- Menunggu --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-yellow-400
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(234,179,8,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-yellow-600 uppercase tracking-widest">Menunggu</p>
                <div class="w-7 h-7 rounded-lg bg-yellow-50 border border-yellow-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-yellow-500 mb-1">{{ $totalPending }}</p>
            <p class="text-xs text-stone-400">Pengajuan pending</p>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-2xl p-4 border border-stone-200 border-l-4 border-l-green-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(34,197,94,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">Disetujui</p>
                <div class="w-7 h-7 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-500 mb-1">{{ $totalDisetujui }}</p>
            <p class="text-xs text-stone-400">Total disetujui</p>
        </div>

    </div>

    {{-- ── TAB SWITCH ── --}}
    <div class="flex gap-1.5 bg-stone-100 rounded-2xl p-1.5">
        <button wire:click="setTab('riwayat')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-2
               {{ $tab === 'riwayat'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab==='riwayat' ) style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 {{ $tab === 'riwayat' ? 'text-white' : 'text-stone-500' }}"
                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg>
            Riwayat
        </button>
        <button wire:click="setTab('form')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-2
               {{ $tab === 'form'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab==='form' ) style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 {{ $tab === 'form' ? 'text-white' : 'text-stone-500' }}"
                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Ajukan Baru
        </button>
    </div>

    {{-- ── TAB: RIWAYAT ── --}}
    @if($tab === 'riwayat')
    <div class="space-y-3">
        @forelse($riwayat as $r)
        <div class="bg-white rounded-2xl border border-stone-200 p-4
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(100,94,90,.15)]
                    hover:-translate-y-0.5 transition-all duration-250">

            {{-- Header --}}
            <div class="flex items-start justify-between gap-3 mb-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800 truncate">{{ $r->nama }}</p>
                    <p class="text-xs text-stone-400 mt-0.5">{{ $r->tempat }}</p>
                </div>
                <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border flex-shrink-0
                    {{ $r->status === 'Disetujui' ? 'bg-green-50 text-green-700 border-green-200'  :
                       ($r->status === 'Ditolak'  ? 'bg-red-50 text-red-600 border-red-200'        :
                       'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                    {{ $r->status }}
                </span>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="bg-stone-50 border border-stone-100 rounded-xl p-2
                            hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                    <p class="text-[10px] text-stone-400 mb-0.5">Durasi</p>
                    <p class="text-sm font-bold text-stone-700">{{ $r->durasi }}m</p>
                </div>
                <div class="bg-stone-50 border border-stone-100 rounded-xl p-2
                            hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                    <p class="text-[10px] text-stone-400 mb-0.5">Jam</p>
                    <p class="text-sm font-bold text-stone-700">{{ round((int)$r->durasi / 60, 1) }}j</p>
                </div>
                <div class="bg-stone-50 border border-stone-100 rounded-xl p-2
                            hover:bg-blue-50/50 hover:border-blue-100 transition-colors duration-200">
                    <p class="text-[10px] text-stone-400 mb-0.5">Tanggal</p>
                    <p class="text-[11px] font-semibold text-stone-700">
                        {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Lihat Sertifikat --}}
            @if($r->sertifikat)
            <div class="mt-3 pt-3 border-t border-stone-100">
                <a href="{{ route('pegawai.diklat-mandiri.detail', $r->id) }}"
                    class="relative inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-white text-xs font-semibold overflow-hidden
                          shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                          hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(15,79,122,.45)]
                          active:scale-95 transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span class="relative">Lihat Bukti Sertifikat</span>
                </a>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
            <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-stone-500 mb-1">Belum ada pengajuan diklat mandiri</p>
            <button wire:click="setTab('form')"
                class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                + Ajukan sekarang
            </button>
        </div>
        @endforelse
    </div>
    @endif

    {{-- ── TAB: FORM ── --}}
    @if($tab === 'form')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Form Pengajuan Diklat Mandiri</p>
        </div>

        <form wire:submit="save" class="p-4 space-y-4">

            {{-- Nama Diklat --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Nama Diklat <span class="text-red-400">*</span>
                </label>
                <input wire:model="nama" type="text" placeholder="Nama pelatihan yang diikuti"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200" />
                @error('nama') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tempat --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Tempat <span class="text-red-400">*</span>
                </label>
                <input wire:model="tempat" type="text" placeholder="Lokasi penyelenggaraan"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200" />
                @error('tempat') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Mulai <span class="text-red-400">*</span>
                    </label>
                    <input wire:model="tglJamMulai" type="datetime-local"
                        class="w-full px-3 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200" />
                    @error('tglJamMulai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Selesai <span class="text-red-400">*</span>
                    </label>
                    <input wire:model="tglJamSelesai" type="datetime-local"
                        class="w-full px-3 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200" />
                    @error('tglJamSelesai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Durasi --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Durasi (Menit) <span class="text-red-400">*</span>
                </label>
                <input wire:model="durasi" type="number" min="1" placeholder="Contoh: 120 menit = 2 jam"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200" />
                @if($durasi > 0)
                <p class="text-xs text-blue-600 font-medium mt-1">≈ {{ round($durasi / 60, 1) }} jam</p>
                @endif
                @error('durasi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Sertifikat --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Bukti Sertifikat <span class="text-red-400">*</span>
                </label>
                <div class="border-2 border-dashed border-stone-200 rounded-2xl p-5 text-center
                            hover:border-blue-400 hover:bg-blue-50/40 transition-all duration-200">
                    <input wire:model="sertifikat" type="file" accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden" id="sertifikat-upload">
                    <label for="sertifikat-upload" class="cursor-pointer">
                        @if($sertifikat)
                        <div class="flex items-center justify-center gap-2 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="text-sm font-semibold">{{ $sertifikat->getClientOriginalName() }}</span>
                        </div>
                        @else
                        <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-stone-600">Tap untuk upload sertifikat</p>
                        <p class="text-xs text-stone-400 mt-0.5">PDF, JPG, PNG (maks. 2MB)</p>
                        @endif
                    </label>
                </div>
                <div wire:loading wire:target="sertifikat">
                    <p class="text-xs text-blue-600 font-medium mt-1 animate-pulse">Mengupload...</p>
                </div>
                @error('sertifikat') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Materi --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    File Materi <span class="text-stone-400 font-normal normal-case text-[10px]">(Opsional)</span>
                </label>
                <div class="border-2 border-dashed border-stone-200 rounded-2xl p-5 text-center
                            hover:border-blue-400 hover:bg-blue-50/40 transition-all duration-200">
                    <input wire:model="materi" type="file" accept=".pdf,.pptx,.docx"
                        class="hidden" id="materi-upload">
                    <label for="materi-upload" class="cursor-pointer">
                        @if($materi)
                        <div class="flex items-center justify-center gap-2 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="text-sm font-semibold">{{ $materi->getClientOriginalName() }}</span>
                        </div>
                        @else
                        <div class="w-10 h-10 rounded-xl bg-stone-100 flex items-center justify-center mx-auto mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-stone-600">Tap untuk upload materi</p>
                        <p class="text-xs text-stone-400 mt-0.5">PDF, PPTX, DOCX (maks. 5MB)</p>
                        @endif
                    </label>
                </div>
                @error('materi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Info --}}
            <div class="p-3.5 bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-xl
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset] flex items-start gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-xs text-blue-700 leading-relaxed">
                    Pengajuan akan diverifikasi oleh Admin Diklat. Jam pelatihan dikontribusikan setelah disetujui.
                </p>
            </div>

            {{-- Submit --}}
            <button type="submit" wire:loading.attr="disabled"
                class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl border-none cursor-pointer
                       text-white text-sm font-bold overflow-hidden
                       shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                       hover:-translate-y-0.5 hover:scale-[1.02]
                       hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                       active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                       transition-all duration-200"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <div wire:loading wire:target="save">
                    <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                    </svg>
                </div>
                <svg wire:loading.remove wire:target="save" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
                <span wire:loading.remove wire:target="save" class="relative">Kirim Pengajuan</span>
                <span wire:loading wire:target="save" class="relative">Mengirim...</span>
            </button>

        </form>
    </div>
    @endif

</div>