<div>

    {{-- ── FILTER GLOBAL ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5 mb-5
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-stone-400 to-stone-500"></div>
            <p class="text-sm font-semibold text-stone-700">Filter Laporan</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tahun</label>
                <div class="relative">
                    <select wire:model.live="tahun"
                        class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition">
                        @for($y = now()->year; $y >= now()->year - 4; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                </div>
            </div>
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Bulan</label>
                <div class="relative">
                    <select wire:model.live="bulan"
                        class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition">
                        <option value="">Semua Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                        <option value="{{ $i + 1 }}">{{ $bln }}</option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                </div>
            </div>
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Unit</label>
                <div class="relative">
                    <select wire:model.live="unit"
                        class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition">
                        <option value="">Semua Unit</option>
                        @foreach($units as $u)
                        <option value="{{ $u->slug }}">{{ $u->nama }}</option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                </div>
            </div>
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Target Jam</label>
                <input wire:model.live="target" type="number" min="1"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition"/>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-orange-400
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-orange-500 uppercase tracking-widest">Total Acara</p>
                <div class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-800 mb-1">{{ $totalAcara }}</p>
            <p class="text-xs text-stone-400">Tahun {{ $tahun }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-teal-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-teal-600 uppercase tracking-widest">Total Absensi</p>
                <div class="w-8 h-8 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-800 mb-1">{{ $totalAbsensi }}</p>
            <p class="text-xs text-stone-400">Record kehadiran</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-blue-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-blue-500 uppercase tracking-widest">Karyawan</p>
                <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-800 mb-1">{{ $totalKaryawan }}</p>
            <p class="text-xs text-stone-400">Internal + <span class="text-blue-500 font-semibold">{{ $totalKaryawanExt }} External</span></p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-purple-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-purple-500 uppercase tracking-widest">E-Learning</p>
                <div class="w-8 h-8 rounded-xl bg-purple-50 border border-purple-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-800 mb-1">{{ $totalCompleted }}</p>
            <p class="text-xs text-stone-400">Selesai dari {{ $totalElearning }} progress</p>
        </div>

    </div>

    {{-- ── LAPORAN CARDS ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Rekap Jam Pelatihan --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:shadow-[0_12px_30px_-6px_rgba(100,94,90,.15)] transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                <h3 class="text-sm font-semibold text-stone-800">Rekap Jam Pelatihan</h3>
                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-teal-50 border border-teal-200 text-teal-600 font-semibold">
                    Internal + Karyawan External
                </span>
            </div>
            <div class="p-5">
                <p class="text-xs text-stone-400 leading-relaxed mb-5">
                    Laporan akumulasi jam pelatihan dari 3 sumber: diklat acara, diklat mandiri, dan e-learning.
                    Mencakup karyawan internal dan karyawan external yang telah disetujui.
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button wire:click="eksporRekapJamExcel" wire:loading.attr="disabled"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                               text-green-700 bg-gradient-to-br from-green-50 to-green-100 border border-green-200
                               hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(34,197,94,.25)]
                               active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                        <svg wire:loading.remove wire:target="eksporRekapJamExcel" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        <svg wire:loading wire:target="eksporRekapJamExcel" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                        <span wire:loading.remove wire:target="eksporRekapJamExcel">Excel (.xlsx)</span>
                        <span wire:loading wire:target="eksporRekapJamExcel">Memproses...</span>
                    </button>
                    <button wire:click="eksporRekapJamPdf" wire:loading.attr="disabled"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                               text-red-600 bg-gradient-to-br from-red-50 to-red-100 border border-red-200
                               hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(239,68,68,.25)]
                               active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                        <svg wire:loading.remove wire:target="eksporRekapJamPdf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                        <svg wire:loading wire:target="eksporRekapJamPdf" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                        <span wire:loading.remove wire:target="eksporRekapJamPdf">PDF</span>
                        <span wire:loading wire:target="eksporRekapJamPdf">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Absensi Diklat --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]
                    hover:shadow-[0_12px_30px_-6px_rgba(100,94,90,.15)] transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                <h3 class="text-sm font-semibold text-stone-800">Laporan Absensi Diklat & Seminar</h3>
            </div>
            <div class="p-5">
                <p class="text-xs text-stone-400 leading-relaxed mb-5">
                    Laporan rekap kehadiran peserta di seluruh acara diklat dan seminar
                    berdasarkan filter tahun, bulan, dan unit.
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button wire:click="eksporAbsensiExcel" wire:loading.attr="disabled"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                               text-green-700 bg-gradient-to-br from-green-50 to-green-100 border border-green-200
                               hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(34,197,94,.25)]
                               active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                        <svg wire:loading.remove wire:target="eksporAbsensiExcel" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        <svg wire:loading wire:target="eksporAbsensiExcel" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                        <span wire:loading.remove wire:target="eksporAbsensiExcel">Excel (.xlsx)</span>
                        <span wire:loading wire:target="eksporAbsensiExcel">Memproses...</span>
                    </button>
                    <button wire:click="eksporAbsensiPdf" wire:loading.attr="disabled"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                               text-red-600 bg-gradient-to-br from-red-50 to-red-100 border border-red-200
                               hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(239,68,68,.25)]
                               active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                        <svg wire:loading.remove wire:target="eksporAbsensiPdf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                        <svg wire:loading wire:target="eksporAbsensiPdf" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                        <span wire:loading.remove wire:target="eksporAbsensiPdf">PDF</span>
                        <span wire:loading wire:target="eksporAbsensiPdf">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- ── LAPORAN EKSTERNAL ── --}}
    <div class="mb-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-500 to-purple-700"></div>
            <h3 class="text-sm font-semibold text-stone-700">Laporan Peserta Eksternal</h3>
            <div class="flex-1 h-px bg-stone-100"></div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 p-5
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Tahun</label>
                    <div class="relative">
                        <select wire:model.live="tahunEksternal"
                            class="w-full px-3 py-2.5 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                   focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15 transition">
                            @for($y = now()->year; $y >= now()->year - 4; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                </div>
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Bulan</label>
                    <div class="relative">
                        <select wire:model.live="bulanEksternal"
                            class="w-full px-3 py-2.5 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                   focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15 transition">
                            <option value="">Semua Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                            <option value="{{ $i + 1 }}">{{ $bln }}</option>
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                </div>
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Jenis</label>
                    <div class="flex gap-1.5 bg-stone-100 rounded-xl p-1">
                        @foreach(['semua' => 'Semua', 'pkl' => 'PKL', 'magang' => 'Magang', 'orientasi' => 'Orientasi'] as $key => $label)
                        <button wire:click="$set('jenisEksternal', '{{ $key }}')"
                            class="flex-1 py-1.5 rounded-lg text-[10.5px] font-semibold transition-all duration-200
                                {{ $jenisEksternal === $key
                                    ? 'text-white shadow-[0_2px_6px_-1px_rgba(147,51,234,.35)]'
                                    : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
                            @if($jenisEksternal === $key) style="background:linear-gradient(135deg,#a855f7,#7c3aed)" @endif>
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <button wire:click="eksporEksternalExcel" wire:loading.attr="disabled"
                    class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                           text-green-700 bg-gradient-to-br from-green-50 to-green-100 border border-green-200
                           hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(34,197,94,.25)]
                           active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                    <svg wire:loading.remove wire:target="eksporEksternalExcel" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    <svg wire:loading wire:target="eksporEksternalExcel" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                    <span wire:loading.remove wire:target="eksporEksternalExcel">Excel (.xlsx)</span>
                    <span wire:loading wire:target="eksporEksternalExcel">Memproses...</span>
                </button>
                <button wire:click="eksporEksternalPdf" wire:loading.attr="disabled"
                    class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                           text-red-600 bg-gradient-to-br from-red-50 to-red-100 border border-red-200
                           hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(239,68,68,.25)]
                           active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                    <svg wire:loading.remove wire:target="eksporEksternalPdf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    <svg wire:loading wire:target="eksporEksternalPdf" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                    <span wire:loading.remove wire:target="eksporEksternalPdf">PDF</span>
                    <span wire:loading wire:target="eksporEksternalPdf">Memproses...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── LAPORAN E-LEARNING ── --}}
    <div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-400 to-purple-600"></div>
            <h3 class="text-sm font-semibold text-stone-700">Laporan E-Learning</h3>
            <div class="flex-1 h-px bg-stone-100"></div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 p-5
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Tahun</label>
                    <div class="relative">
                        <select wire:model.live="tahunElearning"
                            class="w-full px-3 py-2.5 pr-8 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                   focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15 transition">
                            @for($y = now()->year; $y >= now()->year - 4; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </div>
                </div>
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Status</label>
                    <div class="flex gap-1.5 bg-stone-100 rounded-xl p-1">
                        @foreach(['semua' => 'Semua', 'completed' => 'Selesai', 'in_progress' => 'Berlangsung', 'failed' => 'Gagal'] as $key => $label)
                        <button wire:click="$set('statusElearning', '{{ $key }}')"
                            class="flex-1 py-1.5 rounded-lg text-[10px] font-semibold transition-all duration-200
                                {{ $statusElearning === $key
                                    ? 'text-white shadow-[0_2px_6px_-1px_rgba(147,51,234,.35)]'
                                    : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
                            @if($statusElearning === $key) style="background:linear-gradient(135deg,#a855f7,#7c3aed)" @endif>
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <p class="text-xs text-stone-400 leading-relaxed mb-4">
                Laporan progress e-learning seluruh karyawan internal dan karyawan external berdasarkan tahun dan status penyelesaian.
            </p>
            <div class="grid grid-cols-2 gap-3">
                <button wire:click="eksporElearningExcel" wire:loading.attr="disabled"
                    class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                           text-green-700 bg-gradient-to-br from-green-50 to-green-100 border border-green-200
                           hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(34,197,94,.25)]
                           active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                    <svg wire:loading.remove wire:target="eksporElearningExcel" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    <svg wire:loading wire:target="eksporElearningExcel" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                    <span wire:loading.remove wire:target="eksporElearningExcel">Excel (.xlsx)</span>
                    <span wire:loading wire:target="eksporElearningExcel">Memproses...</span>
                </button>
                <button wire:click="eksporElearningPdf" wire:loading.attr="disabled"
                    class="flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold
                           text-red-600 bg-gradient-to-br from-red-50 to-red-100 border border-red-200
                           hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(239,68,68,.25)]
                           active:scale-[.97] disabled:opacity-60 transition-all duration-200">
                    <svg wire:loading.remove wire:target="eksporElearningPdf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    <svg wire:loading wire:target="eksporElearningPdf" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path></svg>
                    <span wire:loading.remove wire:target="eksporElearningPdf">PDF</span>
                    <span wire:loading wire:target="eksporElearningPdf">Memproses...</span>
                </button>
            </div>
        </div>
    </div>

</div>