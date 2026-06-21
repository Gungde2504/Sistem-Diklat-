<div class="space-y-4">

    {{-- Flash Success --}}
    @if($berhasil)
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm font-semibold text-green-700 flex-1">Jurnal berhasil disimpan!</p>
        <button wire:click="$set('berhasil', false)" class="text-green-300 hover:text-green-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Flash Error --}}
    @if($errorMsg)
    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="text-sm font-semibold text-red-600 flex-1">{{ $errorMsg }}</p>
        <button wire:click="$set('errorMsg', '')" class="text-red-300 hover:text-red-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- ── STATUS JURNAL HARI INI ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4 flex items-center gap-3
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 border
                    {{ $jurnalHarini
                        ? 'bg-green-50 border-green-200'
                        : 'bg-orange-50 border-orange-200' }}">
            @if($jurnalHarini)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
            </svg>
            @endif
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-stone-800">
                {{ $jurnalHarini ? 'Jurnal hari ini sudah diisi ✓' : 'Jurnal hari ini belum diisi' }}
            </p>
            <p class="text-xs text-stone-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        @if($jurnalHarini)
        <button wire:click="loadForEdit({{ $jurnalHarini->id }})"
            class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1 flex-shrink-0">
            Edit
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
        @endif
    </div>

    {{-- ── TAB SWITCH ── --}}
    <div class="flex gap-1.5 bg-stone-100 rounded-2xl p-1.5">
        <button wire:click="setTab('tulis')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   flex items-center justify-center gap-2
                   {{ $tab === 'tulis'
                       ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab === 'tulis') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 {{ $tab === 'tulis' ? 'text-white' : 'text-stone-500' }}"
                 fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
            </svg>
            {{ $editId ? 'Edit Jurnal' : 'Tulis Jurnal' }}
        </button>
        <button wire:click="setTab('riwayat')"
            class="flex-1 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   flex items-center justify-center gap-2
                   {{ $tab === 'riwayat'
                       ? 'text-white shadow-[0_2px_8px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-700' }}"
            @if($tab === 'riwayat') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 {{ $tab === 'riwayat' ? 'text-white' : 'text-stone-500' }}"
                 fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg>
            Riwayat
        </button>
    </div>


    {{-- ── DOWNLOAD JURNAL ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]">
        <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
            <div class="flex items-center gap-2.5">
                <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
                <p class="text-sm font-semibold text-stone-800 tracking-tight">Download Jurnal</p>
                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-semibold">
                    {{ $totalJurnal }} entri
                </span>
            </div>
        </div>
        <div class="p-4 space-y-3">

            {{-- Toggle Filter --}}
            <div class="flex gap-1.5 bg-stone-100 rounded-xl p-1">
                <button wire:click="$set('filterDownload', 'semua')"
                    class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition
                        {{ $filterDownload === 'semua' ? 'bg-white shadow text-stone-800' : 'text-stone-500' }}">
                    Semua
                </button>
                <button wire:click="$set('filterDownload', 'bulan')"
                    class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition
                        {{ $filterDownload === 'bulan' ? 'bg-white shadow text-stone-800' : 'text-stone-500' }}">
                    Per Bulan
                </button>
            </div>

            {{-- Filter Bulan & Tahun --}}
            @if($filterDownload === 'bulan')
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Bulan</label>
                    <select wire:model="bulanDownload"
                        class="w-full px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                               focus:outline-none focus:ring-2 focus:ring-blue-400/20 text-stone-600">
                        @foreach($bulanList as $num => $nama)
                        <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Tahun</label>
                    <select wire:model="tahunDownload"
                        class="w-full px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                               focus:outline-none focus:ring-2 focus:ring-blue-400/20 text-stone-600">
                        @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            @endif

            {{-- Tombol Download --}}
            <div class="flex gap-2">
                <a href="{{ route('eksternal.jurnal.download', ['format' => 'pdf', 'filter' => $filterDownload, 'bulan' => $bulanDownload, 'tahun' => $tahunDownload]) }}"
                    target="_blank"
                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold text-white transition
                           hover:-translate-y-0.5 active:scale-95"
                    style="background:linear-gradient(135deg,#ef4444,#dc2626);
                           box-shadow:0 4px 12px -2px rgba(239,68,68,.35)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('eksternal.jurnal.download', ['format' => 'excel', 'filter' => $filterDownload, 'bulan' => $bulanDownload, 'tahun' => $tahunDownload]) }}"
                    class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold text-white transition
                           hover:-translate-y-0.5 active:scale-95"
                    style="background:linear-gradient(135deg,#22c55e,#16a34a);
                           box-shadow:0 4px 12px -2px rgba(34,197,94,.35)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Excel
                </a>
            </div>

        </div>
    </div>
    
    {{-- ── TAB: TULIS JURNAL ── --}}
    @if($tab === 'tulis')
    <form wire:submit="save" class="space-y-4">

        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
            <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                    <p class="text-sm font-semibold text-stone-800 tracking-tight">
                        {{ $editId ? 'Edit Jurnal' : 'Jurnal Baru' }}
                    </p>
                </div>
                @if($editId)
                <button type="button" wire:click="resetForm"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    + Buat baru
                </button>
                @endif
            </div>
            <div class="p-4 space-y-4">

                {{-- Tanggal --}}
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Tanggal <span class="text-red-400">*</span>
                    </label>
                    <input wire:model="tanggal" type="date"
                        @if($editId) readonly @endif
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200
                               {{ $editId ? 'opacity-60 cursor-not-allowed' : '' }}"/>
                    @error('tanggal') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Aktivitas --}}
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Aktivitas Hari Ini <span class="text-red-400">*</span>
                    </label>
                    <textarea wire:model="aktivitas" rows="5"
                        placeholder="Ceritakan aktivitas yang Anda lakukan hari ini..."
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"></textarea>
                    @error('aktivitas') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kendala --}}
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Kendala <span class="text-stone-400 font-normal normal-case text-[10px]">(Opsional)</span>
                    </label>
                    <textarea wire:model="kendala" rows="3"
                        placeholder="Kendala yang dihadapi hari ini (jika ada)..."
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"></textarea>
                </div>

                {{-- Rencana Besok --}}
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Rencana Besok <span class="text-stone-400 font-normal normal-case text-[10px]">(Opsional)</span>
                    </label>
                    <textarea wire:model="rencanaBesok" rows="3"
                        placeholder="Apa yang akan dilakukan besok..."
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                               focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"></textarea>
                </div>

            </div>
        </div>

        {{-- Simpan Button --}}
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span wire:loading.remove wire:target="save" class="relative">
                {{ $editId ? 'Simpan Perubahan' : 'Simpan Jurnal' }}
            </span>
            <span wire:loading wire:target="save" class="relative">Menyimpan...</span>
        </button>

    </form>
    @endif

    {{-- ── TAB: RIWAYAT ── --}}
    @if($tab === 'riwayat')
    <div class="space-y-3">
        @forelse($riwayat as $jurnal)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_10px_24px_-4px_rgba(100,94,90,.15)]
                    hover:-translate-y-0.5 transition-all duration-250">

            <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
                <div>
                    <p class="text-sm font-semibold text-stone-800">
                        {{ $jurnal->tanggal->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-xs text-stone-400 mt-0.5">
                        Ditulis {{ \Carbon\Carbon::parse($jurnal->created_at)->diffForHumans() }}
                    </p>
                </div>
                @if($jurnal->bisaDiedit())
                <button wire:click="loadForEdit({{ $jurnal->id }})"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1 flex-shrink-0 ml-2">
                    Edit
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                @endif
            </div>

            <div class="p-4 space-y-3">
                {{-- Aktivitas --}}
                <div>
                    <p class="text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Aktivitas</p>
                    <p class="text-sm text-stone-700 leading-relaxed">{{ $jurnal->aktivitas }}</p>
                </div>

                {{-- Kendala --}}
                @if($jurnal->kendala)
                <div class="pt-3 border-t border-stone-50">
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-orange-400"></div>
                        <p class="text-[10.5px] font-bold text-orange-500 uppercase tracking-widest">Kendala</p>
                    </div>
                    <p class="text-sm text-stone-600 leading-relaxed">{{ $jurnal->kendala }}</p>
                </div>
                @endif

                {{-- Rencana Besok --}}
                @if($jurnal->rencana_besok)
                <div class="pt-3 border-t border-stone-50">
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                        <p class="text-[10.5px] font-bold text-blue-500 uppercase tracking-widest">Rencana Besok</p>
                    </div>
                    <p class="text-sm text-stone-600 leading-relaxed">{{ $jurnal->rencana_besok }}</p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
            <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-stone-500 mb-1">Belum ada jurnal yang ditulis</p>
            <button wire:click="setTab('tulis')"
                class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                + Tulis jurnal pertama
            </button>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($riwayat->hasPages())
        <div class="flex items-center justify-center gap-1.5 py-2">
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
    @endif

</div>