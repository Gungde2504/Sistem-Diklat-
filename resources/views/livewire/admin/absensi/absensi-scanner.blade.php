<div x-data="qrScanner()" x-init="init()">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Kolom Kiri — Scanner --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Pilih Acara --}}
            @if($acaraAktif->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                    Pilih Acara Aktif
                </label>
                <select wire:change="selectAcara($event.target.value)"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-[#1B5E7B]/30 bg-gray-50">
                    <option value="">-- Pilih Acara --</option>
                    @foreach($acaraAktif as $acara)
                    <option value="{{ $acara->id }}" {{ $diklatId === $acara->id ? 'selected' : '' }}>
                        {{ $acara->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <p class="text-sm text-yellow-700 font-medium">
                    Tidak ada acara dengan QR aktif saat ini.
                    Aktifkan QR dari halaman <a href="{{ route('admin.acara.index') }}" class="underline">Manajemen Acara</a>.
                </p>
            </div>
            @endif

            {{-- Tab Scanner --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                 x-data="{ tab: 'qr' }">

                {{-- Tab Header --}}
                <div class="flex border-b border-gray-100">
                    <button @click="tab = 'qr'"
                        :class="tab === 'qr' ? 'border-b-2 border-[#1B5E7B] text-[#1B5E7B] font-semibold' : 'text-gray-400 hover:text-gray-600'"
                        class="flex-1 py-3.5 text-sm transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                        </svg>
                        Scan QR
                    </button>
                    <button @click="tab = 'manual'"
                        :class="tab === 'manual' ? 'border-b-2 border-[#E87722] text-[#E87722] font-semibold' : 'text-gray-400 hover:text-gray-600'"
                        class="flex-1 py-3.5 text-sm transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Absensi Manual
                    </button>
                </div>

                <div class="p-5">

                    {{-- TAB: Scan QR --}}
                    <div x-show="tab === 'qr'">

                        {{-- Sub-tabs Kamera / Manual Input --}}
                        <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-5 w-fit">
                            <button @click="mode = 'camera'; scanning && stopCamera(); startCamera()"
                                :class="mode === 'camera' ? 'bg-white shadow text-gray-800' : 'text-gray-500'"
                                class="px-4 py-1.5 rounded-lg text-xs font-medium transition">
                                📷 Kamera
                            </button>
                            <button @click="mode = 'manual'; stopCamera()"
                                :class="mode === 'manual' ? 'bg-white shadow text-gray-800' : 'text-gray-500'"
                                class="px-4 py-1.5 rounded-lg text-xs font-medium transition">
                                ⌨️ Input Token
                            </button>
                        </div>

                        {{-- Kamera --}}
                        <div x-show="mode === 'camera'">
                            <div class="relative bg-gray-900 rounded-2xl overflow-hidden aspect-video mb-4">
                                <video id="qr-video" class="w-full h-full object-cover" playsinline></video>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-48 h-48 border-2 border-white/60 rounded-2xl relative">
                                        <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-[#E87722] rounded-tl-lg"></div>
                                        <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-[#E87722] rounded-tr-lg"></div>
                                        <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-[#E87722] rounded-bl-lg"></div>
                                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-[#E87722] rounded-br-lg"></div>
                                        <div class="absolute left-0 right-0 h-0.5 bg-[#E87722]/70"
                                             style="animation: scanLine 2s linear infinite;"
                                             x-show="scanning"></div>
                                    </div>
                                </div>
                                <div x-show="!scanning" class="absolute inset-0 flex flex-col items-center justify-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white/30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    </svg>
                                    <p class="text-white/50 text-sm">Klik tombol untuk memulai kamera</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button @click="startCamera()" x-show="!scanning"
                                    class="flex-1 bg-[#1B5E7B] hover:bg-[#154a63] text-white text-sm font-semibold
                                           py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                    </svg>
                                    Mulai Scan
                                </button>
                                <button @click="stopCamera()" x-show="scanning"
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold
                                           py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
                                    </svg>
                                    Stop Kamera
                                </button>
                            </div>
                        </div>

                        {{-- Input Token --}}
                        <div x-show="mode === 'manual'">
                            <p class="text-sm text-gray-500 mb-3">Masukkan token QR Code secara manual atau gunakan barcode scanner USB.</p>
                            <div class="flex gap-3">
                                <input wire:model="token" type="text" placeholder="Scan atau ketik token QR..."
                                    @keydown.enter="$wire.processQr()" autofocus
                                    class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                                           focus:outline-none focus:ring-2 focus:ring-[#1B5E7B]/30 focus:border-[#1B5E7B]
                                           bg-gray-50 font-mono transition"/>
                                <button wire:click="processQr" wire:loading.attr="disabled"
                                    class="px-5 bg-[#1B5E7B] hover:bg-[#154a63] text-white text-sm font-semibold
                                           rounded-xl transition flex items-center gap-2 disabled:opacity-50">
                                    <div wire:loading wire:target="processQr">
                                        <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                                        </svg>
                                    </div>
                                    <span wire:loading.remove wire:target="processQr">Proses</span>
                                    <span wire:loading wire:target="processQr">...</span>
                                </button>
                            </div>
                        </div>

                        {{-- Notifikasi QR --}}
                        @if($message)
                        <div class="mt-4 p-4 rounded-xl flex items-center gap-3
                            {{ $messageType === 'success' ? 'bg-green-50 border border-green-200' :
                               ($messageType === 'warning' ? 'bg-yellow-50 border border-yellow-200' :
                               'bg-red-50 border border-red-200') }}">
                            @if($messageType === 'success')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $messageType === 'warning' ? 'text-yellow-500' : 'text-red-500' }} flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            @endif
                            <p class="text-sm font-medium {{ $messageType === 'success' ? 'text-green-700' : ($messageType === 'warning' ? 'text-yellow-700' : 'text-red-700') }}">
                                {{ $message }}
                            </p>
                        </div>
                        @endif

                    </div>

                    {{-- TAB: Absensi Manual --}}
                    <div x-show="tab === 'manual'">

                        @if(!$diklatId)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-700">
                            Pilih acara terlebih dahulu di atas.
                        </div>
                        @else

                        {{-- Search Peserta --}}
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                Cari Peserta (Nama / NIK)
                            </label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                <input wire:model.live.debounce.300ms="searchPeserta"
                                    type="text" placeholder="Ketik nama atau NIK..."
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                           focus:outline-none focus:ring-2 focus:ring-[#E87722]/30 focus:border-[#E87722]
                                           bg-gray-50 transition"/>
                            </div>

                            {{-- Dropdown Hasil Cari --}}
                            @if($hasilCari->count() > 0 && !$selectedUserId)
                            <div class="mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden divide-y divide-gray-50">
                                @foreach($hasilCari as $user)
                                <button wire:click="selectUser({{ $user->id }}, '{{ addslashes($user->nama) }}')"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-orange-50 transition text-left">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#E87722] to-[#c9661a] flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $user->nama }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->nip ?? '-' }} · {{ $user->unit ?? '-' }}</p>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            @elseif(strlen($searchPeserta) >= 2 && $hasilCari->count() === 0 && !$selectedUserId)
                            <div class="mt-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-400">
                                Tidak ada peserta ditemukan
                            </div>
                            @endif
                        </div>

                        {{-- Peserta terpilih --}}
                        @if($selectedUserId)
                        <div class="mb-4 p-3.5 bg-orange-50 border border-orange-200 rounded-xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#E87722] to-[#c9661a] flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($selectedNama, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-orange-800">{{ $selectedNama }}</p>
                                <p class="text-xs text-orange-500">Siap diabsenkan</p>
                            </div>
                            <button wire:click="$set('selectedUserId', null); $set('selectedNama', ''); $set('searchPeserta', '')"
                                class="text-orange-400 hover:text-orange-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @endif

                        {{-- Tombol Absen --}}
                        <button wire:click="absenManual" wire:loading.attr="disabled"
                            @if(!$selectedUserId) disabled @endif
                            class="w-full py-3 rounded-xl text-sm font-semibold text-white transition
                                   flex items-center justify-center gap-2
                                   {{ $selectedUserId
                                       ? 'bg-gradient-to-r from-[#E87722] to-[#c9661a] hover:from-[#c9661a] hover:to-[#a85515] shadow-[0_4px_15px_rgba(232,119,34,0.3)] active:scale-95'
                                       : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                            <div wire:loading wire:target="absenManual">
                                <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                                </svg>
                            </div>
                            <svg wire:loading.remove wire:target="absenManual" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span wire:loading.remove wire:target="absenManual">Absenkan Sekarang</span>
                            <span wire:loading wire:target="absenManual">Memproses...</span>
                        </button>

                        {{-- Notifikasi Manual --}}
                        @if($manualMessage)
                        <div class="mt-3 p-3.5 rounded-xl flex items-center gap-3
                            {{ $manualMessageType === 'success' ? 'bg-green-50 border border-green-200' :
                               ($manualMessageType === 'warning' ? 'bg-yellow-50 border border-yellow-200' :
                               'bg-red-50 border border-red-200') }}">
                            <p class="text-sm font-medium {{ $manualMessageType === 'success' ? 'text-green-700' : ($manualMessageType === 'warning' ? 'text-yellow-700' : 'text-red-700') }}">
                                {{ $manualMessage }}
                            </p>
                        </div>
                        @endif

                        {{-- Daftar Peserta Hadir Terbaru --}}
                        @if($pesertaHadir->count() > 0)
                        <div class="mt-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Peserta Hadir Terbaru
                            </p>
                            <div class="space-y-1.5 max-h-60 overflow-y-auto">
                                @foreach($pesertaHadir as $record)
                                <div class="flex items-center gap-3 px-3 py-2.5 bg-gray-50 rounded-xl">
                                    <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-800 truncate">{{ $record->namaPeserta }}</p>
                                        <p class="text-xs text-gray-400">{{ $record->created_at?->format('H:i') }}</p>
                                    </div>
                                    <button wire:click="hapusAbsensi({{ $record->id }})"
                                        wire:confirm="Hapus absensi ini?"
                                        class="text-red-400 hover:text-red-600 transition flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @endif
                    </div>

                </div>
            </div>

        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-5">

            {{-- Counter --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#1B5E7B] to-[#154a63] px-5 py-4">
                    <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-1">Kehadiran</p>
                    <p class="text-white text-sm font-medium truncate">{{ $namaAcara ?: 'Belum ada acara dipilih' }}</p>
                </div>
                <div class="p-5 text-center">
                    <div class="relative inline-flex items-center justify-center mb-3">
                        <svg class="w-28 h-28 -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#1B5E7B" stroke-width="3"
                                stroke-dasharray="{{ $totalKuota > 0 ? round(($totalHadir / $totalKuota) * 100, 1) : 0 }}, 100"
                                stroke-linecap="round"/>
                        </svg>
                        <div class="absolute text-center">
                            <p class="text-2xl font-bold text-gray-800">{{ $totalHadir }}</p>
                            <p class="text-xs text-gray-400">hadir</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">dari <strong class="text-gray-700">{{ $totalKuota }}</strong> kuota</p>
                    <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-[#1B5E7B] h-2 rounded-full transition-all duration-500"
                             style="width: {{ $totalKuota > 0 ? min(round(($totalHadir / $totalKuota) * 100), 100) : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $totalKuota > 0 ? min(round(($totalHadir / $totalKuota) * 100), 100) : 0 }}% terisi
                    </p>
                </div>
                <div class="px-5 pb-4">
                    <button wire:click="refreshCounter"
                        class="w-full flex items-center justify-center gap-2 border border-gray-200
                               hover:bg-gray-50 text-gray-500 text-xs font-medium py-2 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Refresh Counter
                    </button>
                </div>
            </div>

            {{-- Panduan --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-blue-700 mb-3">📋 Panduan Penggunaan</p>
                <ol class="text-xs text-blue-600 space-y-2">
                    <li class="flex gap-2">
                        <span class="w-4 h-4 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold flex-shrink-0">1</span>
                        Pilih acara yang sedang berlangsung
                    </li>
                    <li class="flex gap-2">
                        <span class="w-4 h-4 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold flex-shrink-0">2</span>
                        Tab <strong>Scan QR</strong>: scan kartu peserta via kamera atau input token
                    </li>
                    <li class="flex gap-2">
                        <span class="w-4 h-4 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold flex-shrink-0">3</span>
                        Tab <strong>Absensi Manual</strong>: cari nama/NIK lalu klik absenkan
                    </li>
                    <li class="flex gap-2">
                        <span class="w-4 h-4 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold flex-shrink-0">4</span>
                        Absensi manual bisa dihapus jika terjadi kesalahan
                    </li>
                </ol>
            </div>

        </div>

    </div>

    <style>
        @keyframes scanLine {
            0%   { top: 5%; }
            50%  { top: 90%; }
            100% { top: 5%; }
        }
    </style>

    <script>
    function qrScanner() {
        return {
            mode: 'manual',
            scanning: false,
            stream: null,

            init() {
                if (!window.jsQR) {
                    const script = document.createElement('script');
                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jsqr/1.4.0/jsQR.min.js';
                    document.head.appendChild(script);
                }
            },

            async startCamera() {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment' }
                    });
                    const video = document.getElementById('qr-video');
                    video.srcObject = this.stream;
                    video.play();
                    this.scanning = true;
                    this.scanFrame(video);
                } catch(e) {
                    alert('Tidak dapat mengakses kamera: ' + e.message);
                }
            },

            stopCamera() {
                if (this.stream) {
                    this.stream.getTracks().forEach(t => t.stop());
                    this.stream = null;
                }
                this.scanning = false;
            },

            scanFrame(video) {
                if (!this.scanning) return;
                const canvas = document.createElement('canvas');
                canvas.width  = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                if (window.jsQR) {
                    const code = jsQR(imageData.data, imageData.width, imageData.height);
                    if (code && code.data) {
                        this.stopCamera();
                        @this.set('token', code.data);
                        @this.call('processQr');
                        return;
                    }
                }
                requestAnimationFrame(() => this.scanFrame(video));
            }
        }
    }
    </script>

</div>