<div class="space-y-5">

    {{-- Flash --}}
    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- ── TABS ── --}}
    <div class="flex gap-1.5 bg-white border border-stone-200 rounded-2xl p-1.5 w-fit
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_3px_10px_rgba(120,113,108,.09)]">
        @foreach([
            'geofencing'    => ['label' => 'Geofencing GPS', 'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
            'jam_pelatihan' => ['label' => 'Jam Pelatihan',  'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            'aplikasi'      => ['label' => 'Aplikasi',       'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'],
        ] as $key => $cfg)
        <button wire:click="setTab('{{ $key }}')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   {{ $tab === $key
                       ? 'text-white font-semibold shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-800 hover:bg-stone-100' }}"
            @if($tab === $key) style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}" />
            </svg>
            {{ $cfg['label'] }}
        </button>
        @endforeach
    </div>

    {{-- ── TAB: GEOFENCING ── --}}
    @if($tab === 'geofencing')
    <div class="space-y-4">

        <div class="p-4 bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-2xl
                    shadow-[0_1px_0_rgba(255,255,255,.8)_inset] flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            <p class="text-sm text-blue-700 leading-relaxed">
                Koordinat ini digunakan untuk validasi absensi GPS peserta eksternal.
                Peserta yang berada dalam radius yang ditentukan akan dianggap hadir secara valid.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Koordinat &amp; Radius Rumah Sakit</h3>
            </div>
            <div class="p-5 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                            Latitude <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="rs_latitude" type="text" placeholder="-8.6705"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('rs_latitude') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                            Longitude <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="rs_longitude" type="text" placeholder="115.2126"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('rs_longitude') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Radius Slider --}}
                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Radius (meter) <span class="text-red-400">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input wire:model.live="rs_radius" type="range" min="50" max="2000" step="50"
                            class="flex-1 accent-orange-500"/>
                        <div class="w-24 border border-stone-200 rounded-xl px-3 py-2 bg-stone-50 text-center
                                    shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                            <span class="text-sm font-bold text-orange-500">{{ $rs_radius }}</span>
                            <span class="text-xs text-stone-400"> m</span>
                        </div>
                    </div>
                    @error('rs_radius') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                        Nama Rumah Sakit <span class="text-red-400">*</span>
                    </label>
                    <input wire:model="rs_nama" type="text" placeholder="RSU Prima Medika"
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                </div>

                <div>
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Alamat</label>
                    <textarea wire:model="rs_alamat" rows="2" placeholder="Alamat lengkap rumah sakit..."
                        class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"></textarea>
                </div>

                {{-- Google Maps --}}
                <div x-data="{
                        mapUrl: 'https://www.google.com/maps?q={{ $rs_latitude }},{{ $rs_longitude }}&output=embed&z=17',
                        refreshMap() {
                            const lat = document.querySelector('[wire\\:model=rs_latitude]').value;
                            const lng = document.querySelector('[wire\\:model=rs_longitude]').value;
                            this.mapUrl = 'https://www.google.com/maps?q=' + lat + ',' + lng + '&output=embed&z=17&t=' + Date.now();
                        }
                    }">
                    <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Preview Lokasi</label>
                    <div class="rounded-xl overflow-hidden border border-stone-200 mb-2.5
                                shadow-[0_2px_10px_-2px_rgba(120,113,108,.12)]" style="height:260px">
                        <iframe :src="mapUrl" width="100%" height="100%" frameborder="0"
                            style="border:0" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-stone-500 font-mono bg-stone-50 border border-stone-200 px-2.5 py-1 rounded-lg">
                            {{ $rs_latitude }}, {{ $rs_longitude }}
                        </span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="refreshMap()"
                                class="text-xs font-semibold text-stone-500 hover:text-stone-700 px-3 py-1.5 rounded-lg
                                       bg-stone-100 hover:bg-stone-200 border border-stone-200
                                       hover:-translate-y-px transition-all duration-200">
                                🔄 Refresh Map
                            </button>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $rs_latitude }},{{ $rs_longitude }}"
                               target="_blank"
                               class="text-xs text-orange-500 font-semibold hover:text-orange-600 hover:underline transition-colors">
                                Buka di Google Maps →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Simpan --}}
                <button wire:click="simpanGeofencing" wire:loading.attr="disabled"
                    class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                           text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                           hover:-translate-y-0.5 hover:scale-[1.02]
                           hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                           active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                           transition-all duration-200"
                    style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <div wire:loading wire:target="simpanGeofencing">
                        <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                        </svg>
                    </div>
                    <svg wire:loading.remove wire:target="simpanGeofencing" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span wire:loading.remove wire:target="simpanGeofencing" class="relative">Simpan Konfigurasi Geofencing</span>
                    <span wire:loading wire:target="simpanGeofencing" class="relative">Menyimpan...</span>
                </button>

            </div>
        </div>
    </div>
    @endif

    {{-- ── TAB: JAM PELATIHAN ── --}}
    @if($tab === 'jam_pelatihan')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
            <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Konfigurasi Jam Pelatihan</h3>
        </div>
        <div class="p-5 space-y-4">

            <div class="p-3.5 bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-xl
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset] flex items-start gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="text-xs text-amber-700">Pengaturan ini mempengaruhi perhitungan progress jam pelatihan tahunan karyawan.</p>
            </div>

            {{-- Target Jam Tahunan --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Target Jam Pelatihan Tahunan <span class="text-red-400">*</span>
                </label>
                <div class="flex items-center gap-3">
                    <input wire:model.live="target_jam_tahunan" type="range" min="5" max="100" step="5"
                        class="flex-1 accent-orange-500"/>
                    <div class="w-24 border border-stone-200 rounded-xl px-3 py-2 bg-stone-50 text-center
                                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                        <span class="text-sm font-bold text-orange-500">{{ $target_jam_tahunan }}</span>
                        <span class="text-xs text-stone-400"> jam</span>
                    </div>
                </div>
                <p class="text-xs text-stone-400 mt-1.5">Setiap karyawan wajib mencapai minimal <span class="font-semibold text-stone-600">{{ $target_jam_tahunan }} jam</span> per tahun</p>
            </div>

            {{-- Maks Diklat Mandiri --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Maksimal Jam dari Diklat Mandiri
                </label>
                <div class="flex items-center gap-3">
                    <input wire:model.live="batas_diklat_mandiri" type="range" min="0" max="50" step="1"
                        class="flex-1 accent-amber-500"/>
                    <div class="w-24 border border-stone-200 rounded-xl px-3 py-2 bg-stone-50 text-center
                                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                        <span class="text-sm font-bold text-amber-500">{{ $batas_diklat_mandiri }}</span>
                        <span class="text-xs text-stone-400"> jam</span>
                    </div>
                </div>
                <p class="text-xs text-stone-400 mt-1.5">Jam dari diklat mandiri yang dihitung maksimal <span class="font-semibold text-stone-600">{{ $batas_diklat_mandiri }} jam</span></p>
            </div>

            {{-- Maks E-Learning --}}
            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Maksimal Jam dari E-Learning
                </label>
                <div class="flex items-center gap-3">
                    <input wire:model.live="batas_elearning" type="range" min="0" max="30" step="1"
                        class="flex-1 accent-purple-500"/>
                    <div class="w-24 border border-stone-200 rounded-xl px-3 py-2 bg-stone-50 text-center
                                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                        <span class="text-sm font-bold text-purple-600">{{ $batas_elearning }}</span>
                        <span class="text-xs text-stone-400"> jam</span>
                    </div>
                </div>
                <p class="text-xs text-stone-400 mt-1.5">Jam dari e-learning yang dihitung maksimal <span class="font-semibold text-stone-600">{{ $batas_elearning }} jam</span></p>
            </div>

            {{-- Summary --}}
            <div class="bg-stone-50 border border-stone-200 rounded-xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Ringkasan Konfigurasi</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between py-1.5 border-b border-stone-100">
                        <span class="text-xs text-stone-500">Target tahunan</span>
                        <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2.5 py-1 rounded-lg border border-orange-200">{{ $target_jam_tahunan }} jam</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-stone-100">
                        <span class="text-xs text-stone-500">Maks. diklat mandiri</span>
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">{{ $batas_diklat_mandiri }} jam</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-xs text-stone-500">Maks. e-learning</span>
                        <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg border border-purple-200">{{ $batas_elearning }} jam</span>
                    </div>
                </div>
            </div>

            {{-- Simpan --}}
            <button wire:click="simpanJamPelatihan" wire:loading.attr="disabled"
                class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                       text-white text-sm font-bold overflow-hidden
                       shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                       hover:-translate-y-0.5 hover:scale-[1.02]
                       hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                       active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                       transition-all duration-200"
                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span wire:loading.remove wire:target="simpanJamPelatihan" class="relative">Simpan Konfigurasi Jam</span>
                <span wire:loading wire:target="simpanJamPelatihan" class="relative">Menyimpan...</span>
            </button>

        </div>
    </div>
    @endif

    {{-- ── TAB: APLIKASI ── --}}
    @if($tab === 'aplikasi')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-stone-400 to-stone-500"></div>
            <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Informasi Aplikasi</h3>
        </div>
        <div class="p-5 space-y-4">

            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Nama Aplikasi <span class="text-red-400">*</span>
                </label>
                <input wire:model="app_nama" type="text" placeholder="Sistem Informasi Diklat & Seminar"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                @error('app_nama') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Nama Instansi <span class="text-red-400">*</span>
                </label>
                <input wire:model="app_instansi" type="text" placeholder="RSU Prima Medika"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                @error('app_instansi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                    Tahun Aktif <span class="text-red-400">*</span>
                </label>
                <input wire:model="app_tahun" type="number" placeholder="{{ now()->year }}"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                @error('app_tahun') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Info Version --}}
            <div class="bg-stone-50 border border-stone-200 rounded-xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Info Server</p>
                <div class="space-y-2">
                    @foreach([
                        ['label' => 'Laravel',      'value' => app()->version()],
                        ['label' => 'PHP',           'value' => PHP_VERSION],
                        ['label' => 'Environment',   'value' => ucfirst(app()->environment())],
                        ['label' => 'Waktu Server',  'value' => now()->format('d M Y, H:i').' WITA'],
                    ] as $info)
                    <div class="flex items-center justify-between py-1.5 {{ !$loop->last ? 'border-b border-stone-100' : '' }}">
                        <span class="text-xs text-stone-500">{{ $info['label'] }}</span>
                        <span class="text-xs font-mono font-medium text-stone-700 bg-white border border-stone-200 px-2 py-0.5 rounded-lg">{{ $info['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Simpan --}}
            <button wire:click="simpanAplikasi" wire:loading.attr="disabled"
                class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                       text-white text-sm font-bold overflow-hidden
                       shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                       hover:-translate-y-0.5 hover:scale-[1.02]
                       hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                       active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                       transition-all duration-200"
                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span wire:loading.remove wire:target="simpanAplikasi" class="relative">Simpan Konfigurasi Aplikasi</span>
                <span wire:loading wire:target="simpanAplikasi" class="relative">Menyimpan...</span>
            </button>

        </div>
    </div>
    @endif

</div>