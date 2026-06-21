<div
    x-data="gpsAbsensi()"
    x-init="init()"
    class="space-y-4">

    {{-- Alert --}}
    @if($message)
    <div class="p-4 rounded-2xl flex items-center gap-3 border
        {{ $messageType === 'success' ? 'bg-green-50 border-green-200' :
           ($messageType === 'warning' ? 'bg-yellow-50 border-yellow-200' :
           'bg-red-50 border-red-200') }}"
        wire:key="msg-{{ now() }}">
        @if($messageType === 'success')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @elseif($messageType === 'warning')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        @else
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        @endif
        <p class="text-sm font-medium flex-1
            {{ $messageType === 'success' ? 'text-green-700' :
               ($messageType === 'warning' ? 'text-yellow-700' : 'text-red-600') }}">
            {{ $message }}
        </p>
        <button wire:click="$set('message', '')"
            class="text-stone-400 hover:text-stone-600 transition-colors ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- ── GPS STATUS CARD ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Status GPS</p>
            <span class="ml-auto text-xs text-stone-400">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
        <div class="p-4">

            {{-- GPS Indicator --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 transition-all duration-300
                            shadow-[0_2px_8px_-2px_rgba(120,113,108,.15)]"
                    :class="loading ? 'bg-stone-100' : (valid ? 'bg-green-50 border border-green-200' : (ready ? 'bg-red-50 border border-red-200' : 'bg-stone-100'))">
                    <template x-if="loading">
                        <svg class="w-8 h-8 text-stone-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                        </svg>
                    </template>
                    <template x-if="!loading && valid">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </template>
                    <template x-if="!loading && !valid && ready">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </template>
                    <template x-if="!loading && !ready">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </template>
                </div>
                <div>
                    <p class="text-sm font-bold transition-colors duration-200"
                        :class="loading ? 'text-stone-500' : (valid ? 'text-green-700' : (ready ? 'text-red-600' : 'text-stone-600'))">
                        <span x-text="loading ? 'Mendeteksi lokasi...' : (ready ? (valid ? '✓ Dalam Radius RS' : '⚠ Di Luar Radius RS') : 'GPS Belum Aktif')"></span>
                    </p>
                    <p class="text-xs text-stone-400 mt-0.5"
                        x-text="ready ? `Jarak: ${jarak.toFixed(0)} meter dari RS` : 'Klik tombol untuk deteksi lokasi'">
                    </p>
                    <p class="text-xs text-stone-300 mt-0.5 font-mono"
                        x-show="ready"
                        x-text="`${lat.toFixed(6)}, ${lng.toFixed(6)}`">
                    </p>
                </div>
            </div>

            {{-- Refresh GPS Button --}}
            <button @click="getLocation()" :disabled="loading"
                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-medium
                       border border-stone-200 text-stone-600 bg-stone-50
                       shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                       hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:-translate-y-px
                       disabled:opacity-50 disabled:cursor-not-allowed disabled:translate-y-0
                       transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                <span x-text="loading ? 'Mendeteksi...' : 'Refresh Lokasi GPS'"></span>
            </button>
        </div>
    </div>

    {{-- ── CHECK-IN / CHECK-OUT BUTTONS ── --}}
    <div class="grid grid-cols-2 gap-3">

        {{-- Check-in --}}
        <button wire:click="checkin" wire:loading.attr="disabled"
            x-bind:disabled="!ready"
            @if($absensiHarini) disabled @endif
            class="relative flex flex-col items-center gap-2 py-5 rounded-2xl font-semibold text-sm
               overflow-hidden transition-all duration-200 active:scale-95
               {{ $absensiHarini
                   ? 'bg-green-50 text-green-600 cursor-not-allowed'
                   : 'text-white cursor-pointer
                      shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                      hover:-translate-y-0.5 hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55)]' }}"
            @if(!$absensiHarini) style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            @if(!$absensiHarini)
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            @endif
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
            </svg>
            @if($absensiHarini)
            <span class="relative">✓ Sudah Check-in</span>
            <span class="text-xs font-normal relative">
                {{ \Carbon\Carbon::parse($absensiHarini->checkin_at)->format('H:i') }}
            </span>
            @else
            <span class="relative">Check-in</span>
            <span class="text-xs font-normal opacity-75 relative">Pagi hari</span>
            @endif
        </button>

        {{-- Check-out --}}
        <button wire:click="checkout" wire:loading.attr="disabled"
            x-bind:disabled="!ready"
            @if(!$absensiHarini || $absensiHarini?->checkout_at) disabled @endif
            class="relative flex flex-col items-center gap-2 py-5 rounded-2xl font-semibold text-sm
            overflow-hidden transition-all duration-200 active:scale-95
            {{ $absensiHarini?->checkout_at
               ? 'bg-blue-50 text-blue-600 cursor-not-allowed'
               : ($absensiHarini
                   ? 'text-white cursor-pointer
                      shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                      hover:-translate-y-0.5 hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55)]'
                   : 'bg-stone-50 text-stone-300 cursor-not-allowed') }}"
            @if($absensiHarini && !$absensiHarini?->checkout_at)
            style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)"
            @endif>
            @if($absensiHarini && !$absensiHarini?->checkout_at)
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            @endif
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
            </svg>
            @if($absensiHarini?->checkout_at)
            <span class="relative">✓ Sudah Check-out</span>
            <span class="text-xs font-normal relative">
                {{ \Carbon\Carbon::parse($absensiHarini->checkout_at)->format('H:i') }}
            </span>
            @else
            <span class="relative">Check-out</span>
            <span class="text-xs font-normal opacity-75 relative">Sore hari</span>
            @endif
        </button>

    </div>

    {{-- ── DURASI HARI INI ── --}}
    @if($absensiHarini?->checkin_at && $absensiHarini?->checkout_at)
    @php
    $durasi = \Carbon\Carbon::parse($absensiHarini->checkin_at)
    ->diffInMinutes(\Carbon\Carbon::parse($absensiHarini->checkout_at));
    $jam = floor($durasi / 60);
    $menit = $durasi % 60;
    @endphp
    <div class="bg-white rounded-2xl border border-stone-200 p-4 flex items-center gap-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.12)]">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                    shadow-[0_2px_8px_-1px_rgba(15,79,122,.3),0_1px_0_rgba(255,255,255,.2)_inset]"
            style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-stone-400">Durasi Kehadiran Hari Ini</p>
            <p class="text-lg font-bold text-blue-700 mt-0.5">{{ $jam }} jam {{ $menit }} menit</p>
        </div>
    </div>
    @endif

    {{-- ── RIWAYAT 7 HARI ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">
        <div class="flex items-center justify-between px-4 py-3.5 border-b border-stone-100">
            <div class="flex items-center gap-2.5">
                <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
                <p class="text-sm font-semibold text-stone-800 tracking-tight">Riwayat 7 Hari Terakhir</p>
            </div>
            <a href="{{ route('eksternal.rekap') }}"
                class="text-xs text-blue-600 font-semibold hover:text-blue-700 transition-colors flex items-center gap-1">
                Lihat semua
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
        <div class="divide-y divide-stone-50">
            @forelse($riwayat as $r)
            <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-stone-50/60 transition-colors duration-150">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 border
                            {{ $r->is_valid
                                ? 'bg-green-50 border-green-200'
                                : 'bg-red-50 border-red-200' }}">
                    @if($r->is_valid)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800">
                        {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d M Y') }}
                    </p>
                    <p class="text-xs text-stone-400 mt-0.5">
                        {{ $r->checkin_at ? \Carbon\Carbon::parse($r->checkin_at)->format('H:i') : '--:--' }}
                        —
                        {{ $r->checkout_at ? \Carbon\Carbon::parse($r->checkout_at)->format('H:i') : '--:--' }}
                    </p>
                </div>
                <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border flex-shrink-0
                            {{ $r->is_valid
                                ? 'bg-green-50 text-green-700 border-green-200'
                                : 'bg-red-50 text-red-600 border-red-200' }}">
                    {{ $r->is_valid ? 'Valid' : 'Invalid' }}
                </span>
            </div>
            @empty
            <div class="px-4 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <p class="text-sm text-stone-400">Belum ada riwayat absensi</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Alpine.js GPS Logic --}}
    <script>
        function gpsAbsensi() {
            return {
                lat: 0,
                lng: 0,
                ready: false,
                valid: false,
                loading: false,
                jarak: 0,
                rsLat: -8.678252,
                rsLng: 115.213500,
                radius: 300,
                init() {
                    this.getLocation();
                },
                getLocation() {
                    if (!navigator.geolocation) {
                        alert('Browser tidak mendukung GPS.');
                        return;
                    }
                    this.loading = true;
                    this.ready = false;
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            this.lat = pos.coords.latitude;
                            this.lng = pos.coords.longitude;
                            this.jarak = this.haversine(this.lat, this.lng, this.rsLat, this.rsLng);
                            this.valid = this.jarak <= this.radius;
                            this.ready = true;
                            this.loading = false;
                            @this.call('setLocation', this.lat, this.lng, this.valid, this.jarak);
                        },
                        (err) => {
                            this.loading = false;
                            alert('Gagal mendapatkan lokasi: ' + err.message);
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000
                        }
                    );
                },
                haversine(lat1, lng1, lat2, lng2) {
                    const R = 6371000;
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLng = (lng2 - lng1) * Math.PI / 180;
                    const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
                    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                }
            }
        }
    </script>

</div>