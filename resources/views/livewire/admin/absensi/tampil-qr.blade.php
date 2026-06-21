<div
    x-data="{ fullscreen: false }"
    x-on:keydown.escape.window="fullscreen = false">

    {{-- ── TOOLBAR ── --}}
    <div class="flex items-center justify-between mb-5 gap-6" x-show="!fullscreen">
        <div>
            <h2 class="text-lg font-bold text-stone-800 tracking-tight">{{ $diklat->nama }}</h2>
            <p class="text-sm text-stone-500 mt-0.5">{{ $diklat->jenisDiklat }} · {{ $diklat->tempat }}</p>
        </div>
        <div class="flex items-center gap-2.5">

            {{-- Toggle QR --}}
            <button wire:click="toggleQr"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border transition-all duration-200 hover:-translate-y-px
                       {{ $diklat->IsActive
                           ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100 shadow-[0_2px_8px_-2px_rgba(34,197,94,.2)]'
                           : 'bg-stone-50 text-stone-600 border-stone-200 hover:bg-stone-100' }}">
                <span class="w-2 h-2 rounded-full {{ $diklat->IsActive ? 'bg-green-500 animate-pulse' : 'bg-stone-400' }}"></span>
                QR {{ $diklat->IsActive ? 'Aktif' : 'Nonaktif' }}
            </button>

            {{-- Mode Proyektor --}}
            <button @click="fullscreen = true"
                class="relative flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white overflow-hidden
                       shadow-[0_4px_14px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.2)_inset]
                       hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(234,88,12,.5)]
                       active:scale-[.97] transition-all duration-200"
                style="background:linear-gradient(135deg,#F97316,#EA580C)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </svg>
                <span class="relative">Mode Proyektor</span>
            </button>

            {{-- Download QR --}}
            @if($qrSvg)
            <a href="data:image/svg+xml;base64,{{ $qrSvg }}"
                download="QR-{{ $diklat->QRcode }}.svg"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                      bg-gradient-to-r from-[#1B5E7B] to-[#154a63]
                      shadow-[0_4px_14px_-3px_rgba(27,94,123,.4)]
                      hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(27,94,123,.5)]
                      active:scale-[.97] transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Download QR
            </a>
            @endif


            {{-- Kembali --}}
            <a href="{{ route('admin.acara.detail', $diklat->id) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-stone-500
                      bg-white border border-stone-200
                      shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_2px_6px_rgba(120,113,108,.08)]
                      hover:text-stone-800 hover:border-stone-300 hover:-translate-y-px
                      transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── NORMAL VIEW ── --}}
    <div x-show="!fullscreen">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- QR Code Card + Absensi Manual --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- QR Card --}}
                <div class="bg-white rounded-2xl border border-stone-200 p-8 flex flex-col items-center
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">

                    {{-- Status Badge --}}
                    <div class="mb-5 flex items-center gap-2 px-4 py-1.5 rounded-full border
                                {{ $diklat->IsActive
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : 'bg-red-50 text-red-600 border-red-200' }}">
                        <span class="w-2 h-2 rounded-full {{ $diklat->IsActive ? 'bg-green-500 animate-pulse' : 'bg-red-400' }}"></span>
                        <span class="text-xs font-semibold">
                            {{ $diklat->IsActive ? 'QR Code Aktif — Dapat Discan' : 'QR Code Nonaktif' }}
                        </span>
                    </div>

                    {{-- QR Image --}}
                    @if($qrSvg)
                    <div class="p-4 bg-white rounded-2xl transition-all duration-300
                                {{ $diklat->IsActive
                                    ? 'border-4 border-orange-400 shadow-[0_0_0_1px_rgba(249,115,22,.2),0_8px_24px_-4px_rgba(249,115,22,.25)]'
                                    : 'border-4 border-stone-200 opacity-40 grayscale' }}">
                        <img src="data:image/svg+xml;base64,{{ $qrSvg }}"
                            alt="QR Code Absensi"
                            class="w-64 h-64" />
                    </div>
                    @else
                    <div class="w-64 h-64 bg-stone-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-stone-200">
                        <p class="text-stone-400 text-sm">QR Code tidak tersedia</p>
                    </div>
                    @endif

                    {{-- Token --}}
                    <div class="mt-4 px-4 py-2 bg-stone-50 border border-stone-200 rounded-xl">
                        <p class="text-xs text-stone-400 text-center font-mono tracking-wider">{{ $diklat->QRcode }}</p>
                    </div>

                    {{-- Instruksi --}}
                    <div class="mt-4 p-4 bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-xl w-full max-w-sm
                                shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                        <p class="text-xs text-blue-700 text-center font-medium">
                            📱 Peserta: Login ke sistem → Buka menu Absensi → Scan QR ini
                        </p>
                    </div>

                </div>

                {{-- Daftar Absensi --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-500 to-orange-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Daftar Absensi</h3>
                        <span class="ml-auto text-xs px-2.5 py-1 rounded-full bg-orange-50 border border-orange-200 text-orange-600 font-semibold">
                            {{ $totalHadir }} hadir
                        </span>
                    </div>

                    <div class="p-5 space-y-3">

                        {{-- Notifikasi --}}
                        @if($manualMessage)
                        <div class="p-3.5 rounded-xl text-sm font-medium
                                    {{ $manualMessageType === 'success' ? 'bg-green-50 border border-green-200 text-green-700' :
                                    ($manualMessageType === 'warning' ? 'bg-yellow-50 border border-yellow-200 text-yellow-700' :
                                    'bg-red-50 border border-red-200 text-red-700') }}">
                            {{ $manualMessage }}
                        </div>
                        @endif

                        {{-- Filter Row --}}
                        <div class="grid grid-cols-3 gap-2">
                            {{-- Filter Tipe --}}
                            <select wire:model.live="filterTipe"
                                class="px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                                        focus:outline-none focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 text-stone-600">
                                <option value="semua">Semua Tipe</option>
                                <option value="internal">Internal</option>
                                <option value="ekternal">Eksternal</option>
                            </select>

                            {{-- Filter Unit --}}
                            <select wire:model.live="filterUnit"
                                class="px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                                    focus:outline-none focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 text-stone-600">
                                <option value="">Semua Unit</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit->nama }}">{{ $unit->nama }}</option>
                                @endforeach
                            </select>

                            {{-- Filter Status --}}
                            <select wire:model.live="filterStatus"
                                class="px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                                        focus:outline-none focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 text-stone-600">
                                <option value="semua">Semua Status</option>
                                <option value="hadir">Sudah Hadir</option>
                                <option value="belum">Belum Hadir</option>
                            </select>
                        </div>

                        {{-- Download --}}
                        <div class="flex gap-2">
                            <a href="{{ route('admin.absensi.download', ['diklat' => $diklat->id, 'format' => 'pdf', 'tipe' => $filterTipe, 'unit' => $filterUnit, 'status' => $filterStatus]) }}"
                                target="_blank"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold text-white transition
                                    hover:-translate-y-0.5 active:scale-95"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);
                                    box-shadow:0 4px 12px -2px rgba(239,68,68,.35)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                PDF
                            </a>
                            <a href="{{ route('admin.absensi.download', ['diklat' => $diklat->id, 'format' => 'excel', 'tipe' => $filterTipe, 'unit' => $filterUnit, 'status' => $filterStatus]) }}"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold text-white transition
                                    hover:-translate-y-0.5 active:scale-95"
                                style="background:linear-gradient(135deg,#22c55e,#16a34a);
                                    box-shadow:0 4px 12px -2px rgba(34,197,94,.35)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Excel
                            </a>
                        </div>

                        {{-- Absensi By Unit --}}
                        @if($filterUnit)
                        <div class="flex items-center gap-2 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197" />
                            </svg>
                            <p class="text-xs text-orange-700 flex-1 font-medium">Absenkan semua pegawai unit <strong>{{ $filterUnit }}</strong> sekaligus</p>
                            <button wire:click="absenkanSemuaUnit"
                                wire:confirm="Absenkan semua pegawai unit {{ $filterUnit }}?"
                                wire:loading.attr="disabled"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold text-white transition active:scale-95
                                bg-gradient-to-r from-orange-500 to-orange-600
                                shadow-[0_2px_8px_rgba(234,88,12,.3)]">
                                <span wire:loading.remove wire:target="absenkanSemuaUnit">Absenkan Semua</span>
                                <span wire:loading wire:target="absenkanSemuaUnit">Memproses...</span>
                            </button>
                        </div>
                        @endif

                        {{-- Search + Absen Cepat --}}
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input wire:model.live.debounce.300ms="searchPeserta"
                                type="text" placeholder="Cari nama, NIK, atau email peserta..."
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                focus:outline-none focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400
                                 text-stone-700 transition" />
                        </div>

                        {{-- Dropdown hasil cari cepat --}}
                        @if($hasilCari->count() > 0 && !$selectedUserId)
                        <div class="bg-white border border-stone-200 rounded-xl shadow-lg overflow-hidden divide-y divide-stone-50">
                            @foreach($hasilCari as $userItem)
                            <div class="w-full flex items-center gap-3 px-4 py-2.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $userItem->type === 'internal' ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-blue-400 to-blue-600' }}">
                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr($userItem->nama, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-stone-800 truncate">{{ $userItem->nama }}</p>
                                    <p class="text-xs text-stone-400">
                                        {{ $userItem->nip ?? $userItem->email }}
                                        · {{ $userItem->type === 'internal' ? ($userItem->unit ?? '-') : 'Eksternal' }}
                                    </p>
                                </div>
                                <button wire:click="absenSatu({{ $userItem->id }})"
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold text-white transition active:scale-95
                                            bg-gradient-to-r from-orange-500 to-orange-600
                                            shadow-[0_2px_8px_rgba(234,88,12,.25)]">
                                    Absenkan
                                </button>
                            </div>
                            @endforeach
                        </div>
                        @elseif(strlen($searchPeserta) >= 2 && $hasilCari->count() === 0)
                        <div class="px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm text-stone-400">
                            Tidak ada peserta ditemukan
                        </div>
                        @endif

                        {{-- Daftar Absensi --}}
                        <div class="divide-y divide-stone-50 max-h-80 overflow-y-auto rounded-xl border border-stone-100">
                            @forelse($daftarAbsensi as $record)
                            <div class="flex items-center gap-3 px-4 py-3 hover:bg-stone-50/60 transition">
                                {{-- Status icon --}}
                                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $record->is_hadir ? 'bg-green-100' : 'bg-stone-100' }}">
                                    @if($record->is_hadir)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-stone-800 truncate">{{ $record->namaPeserta }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold
                            {{ $record->user?->type === 'internal' ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $record->user?->type === 'internal' ? 'Internal' : 'Eksternal' }}
                                        </span>
                                        <span class="text-xs text-stone-400">{{ $record->user?->unit ?? $record->user?->email ?? '-' }}</span>
                                    </div>
                                </div>

                                {{-- Aksi --}}
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if(!$record->is_hadir)
                                    <button wire:click="absenSatu({{ $record->id_user }})"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-white transition active:scale-95
                               bg-gradient-to-r from-orange-500 to-orange-600">
                                        Absenkan
                                    </button>
                                    @else
                                    <span class="text-xs text-green-600 font-medium">
                                        {{ $record->updated_at ? \Carbon\Carbon::parse($record->updated_at)->format('H:i') : 'Hadir' }}
                                    </span>
                                    <button wire:click="hapusAbsensi({{ $record->id }})" wire:confirm="Hapus absensi ini?"
                                        class="text-red-300 hover:text-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="px-4 py-8 text-center text-sm text-stone-400">
                                Belum ada peserta terdaftar
                            </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($daftarAbsensi->hasPages())
                        <div class="pt-2">
                            {{ $daftarAbsensi->links() }}
                        </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Info Panel --}}
            <div class="space-y-4">

                {{-- Counter --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="relative overflow-hidden px-5 py-4"
                        style="background:linear-gradient(135deg,#C2410C 0%,#9A3412 55%,#7C2D12 100%)">
                        <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-white/[.05] pointer-events-none"></div>
                        <p class="text-white/70 text-xs font-semibold uppercase tracking-wider relative">Kehadiran Real-time</p>
                    </div>
                    <div class="p-5 text-center">
                        <p class="text-5xl font-bold text-orange-500 mb-1">{{ $totalHadir }}</p>
                        <p class="text-sm text-stone-500">dari <strong class="text-stone-700">{{ $diklat->kuota }}</strong> peserta</p>

                        {{-- Progress Bar --}}
                        <div class="mt-3 w-full bg-stone-100 rounded-full h-2.5 overflow-hidden">
                            <div class="h-2.5 rounded-full transition-all duration-500"
                                style="width:{{ $diklat->kuota > 0 ? min(round(($totalHadir / $diklat->kuota) * 100), 100) : 0 }}%;
                                        background:linear-gradient(90deg,#FB923C,#EA580C)">
                            </div>
                        </div>
                        <p class="text-xs text-stone-400 mt-1.5">
                            {{ $diklat->kuota > 0 ? min(round(($totalHadir / $diklat->kuota) * 100), 100) : 0 }}% terisi
                        </p>

                        <button wire:click="refreshCounter"
                            class="mt-4 w-full flex items-center justify-center gap-2 py-2 rounded-xl text-xs font-medium text-stone-500
                                   bg-stone-50 border border-stone-200
                                   shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                   hover:bg-stone-100 hover:-translate-y-px
                                   transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>

                {{-- Info Acara --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-stone-400 to-stone-500"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Info Acara</h3>
                    </div>
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">Narasumber</span>
                            <span class="text-xs font-medium text-stone-700 text-right max-w-[9rem]">{{ $diklat->namaNarasumber }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">Tanggal</span>
                            <span class="text-xs font-medium text-stone-700">{{ $diklat->tglJamMulai }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">Durasi</span>
                            <span class="text-xs font-medium text-stone-700">{{ $diklat->durasi }} jam</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-[11.5px] text-stone-400">Status</span>
                            <span class="text-xs font-semibold
                                {{ $diklat->status === 'Berlangsung' ? 'text-green-600' :
                                   ($diklat->status === 'Terbuka'    ? 'text-blue-600'  : 'text-stone-500') }}">
                                {{ $diklat->status }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Auto Refresh --}}
                <div class="bg-white rounded-2xl border border-stone-200 p-4
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-stone-700">Auto Refresh</p>
                            <p class="text-xs text-stone-400 mt-0.5">Update counter setiap 10 detik</p>
                        </div>
                        <button wire:click="$set('autoRefresh', {{ $autoRefresh ? 'false' : 'true' }})"
                            class="relative w-11 h-6 rounded-full border-none cursor-pointer flex-shrink-0 transition-all duration-200"
                            style="{{ $autoRefresh ? 'background:linear-gradient(135deg,#F97316,#EA580C);box-shadow:0 2px 8px rgba(234,88,12,.35)' : 'background:#D6D3D1' }}">
                            <span class="absolute top-1 w-4 h-4 rounded-full bg-white shadow-[0_1px_4px_rgba(0,0,0,.22)] transition-all duration-200"
                                style="{{ $autoRefresh ? 'left:23px' : 'left:4px' }}">
                            </span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>



    {{-- ── MODE FULLSCREEN / PROYEKTOR ── --}}
    <div x-show="fullscreen"
        x-transition:enter="transition duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center"
        style="background:linear-gradient(135deg,#0f1f2b 0%,#1a3a4a 60%,#0d2535 100%)">

        {{-- Exit button --}}
        <button @click="fullscreen = false"
            class="absolute top-5 right-5 p-2.5 rounded-xl bg-white/10 hover:bg-white/20
                   text-white border border-white/15 transition-all duration-200 hover:-translate-y-px">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Counter fullscreen --}}
        <div class="absolute top-5 left-5 flex items-baseline gap-1.5">
            <span class="text-white font-bold text-3xl">{{ $totalHadir }}</span>
            <span class="text-white/50 text-sm">/ {{ $diklat->kuota }} hadir</span>
        </div>

        {{-- Nama & lokasi --}}
        <h1 class="text-white text-2xl font-bold mb-1.5 text-center px-10 tracking-tight">{{ $diklat->nama }}</h1>
        <p class="text-white/50 text-sm mb-8">📍 {{ $diklat->tempat }} · {{ $diklat->tglJamMulai }}</p>

        {{-- QR Besar --}}
        @if($qrSvg)
        <div class="p-5 bg-white rounded-3xl transition-all duration-300
                    {{ $diklat->IsActive
                        ? 'shadow-[0_0_60px_rgba(249,115,22,.3),0_20px_60px_-10px_rgba(0,0,0,.5)]'
                        : 'opacity-40 grayscale shadow-2xl' }}">
            <img src="data:image/svg+xml;base64,{{ $qrSvg }}"
                alt="QR Code"
                class="w-72 h-72" />
        </div>
        @endif

        {{-- Status badge --}}
        <div class="mt-6 flex items-center gap-2 px-5 py-2 rounded-full border
                    {{ $diklat->IsActive
                        ? 'bg-green-500/15 text-green-300 border-green-500/25'
                        : 'bg-red-500/15 text-red-300 border-red-500/25' }}">
            <span class="w-2.5 h-2.5 rounded-full {{ $diklat->IsActive ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></span>
            <span class="text-sm font-semibold">
                {{ $diklat->IsActive ? 'QR Aktif — Silakan Scan' : 'QR Nonaktif' }}
            </span>
        </div>

        {{-- Instruksi --}}
        <p class="text-white/35 text-xs mt-4 tracking-wide">
            Login ke sistem → Menu Absensi → Scan QR Code ini
        </p>

        {{-- ESC hint --}}
        <p class="absolute bottom-5 text-white/20 text-xs">Tekan ESC untuk keluar mode proyektor</p>

    </div>

    {{-- Auto refresh via Livewire polling --}}
    @if($autoRefresh)
    <div wire:poll.10s="refreshCounter"></div>
    @endif

</div>