<div>

    {{-- Alert --}}
    @if($message)
    <div class="mb-5 p-4 rounded-2xl flex items-center gap-3 border
        {{ $messageType === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
        @if($messageType === 'success')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @else
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        @endif
        <p class="text-sm font-medium flex-1 {{ $messageType === 'success' ? 'text-green-700' : 'text-red-700' }}">{{ $message }}</p>
        <button wire:click="$set('message', '')" class="text-stone-400 hover:text-stone-600 transition-colors ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Kolom Kiri --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Info Acara --}}
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                <div class="relative overflow-hidden px-6 py-5"
                    style="background:linear-gradient(135deg,#C2410C 0%,#9A3412 55%,#7C2D12 100%)">
                    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/[.05] pointer-events-none"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-white/[.04] pointer-events-none"></div>
                    <div class="relative">
                        <h2 class="text-white font-bold text-base tracking-tight">{{ $diklat->nama }}</h2>
                        <p class="text-white/65 text-sm mt-0.5">{{ $diklat->tglJamMulai }} · {{ $diklat->tempat }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 divide-x divide-stone-100">
                    <div class="p-4 text-center hover:bg-stone-50/70 transition-colors">
                        <p class="text-[11px] text-stone-400 mb-1">Total Peserta</p>
                        <p class="text-2xl font-bold text-stone-800">{{ $totalPeserta }}</p>
                    </div>
                    <div class="p-4 text-center hover:bg-stone-50/70 transition-colors">
                        <p class="text-[11px] text-stone-400 mb-1">Sudah Generate</p>
                        <p class="text-2xl font-bold text-green-600">{{ $sertifikatGenerated }}</p>
                    </div>
                    <div class="p-4 text-center hover:bg-stone-50/70 transition-colors">
                        <p class="text-[11px] text-stone-400 mb-1">Belum Generate</p>
                        <p class="text-2xl font-bold text-orange-500">{{ max(0, $totalPeserta - $sertifikatGenerated) }}</p>
                    </div>
                </div>
            </div>

            {{-- Upload Template --}}
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                        hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                        transition-shadow duration-300">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                    <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Template Sertifikat</h3>
                </div>
                <div class="p-5">
                    @if($templatePath)

                    {{-- Preview dengan fitur klik --}}
                    <div class="mb-4">
                        {{-- Instruksi klik --}}
                        @if($clickMode)
                        <div class="mb-2 p-2.5 rounded-xl flex items-center gap-2
                            {{ $clickMode === 'nama' ? 'bg-orange-50 border border-orange-200' : 'bg-blue-50 border border-blue-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 {{ $clickMode === 'nama' ? 'text-orange-500' : 'text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                            </svg>
                            <p class="text-xs font-semibold {{ $clickMode === 'nama' ? 'text-orange-700' : 'text-blue-700' }}">
                                Klik pada gambar untuk set posisi <strong>{{ $clickMode === 'nama' ? 'Nama Peserta' : 'Tanggal' }}</strong>
                            </p>
                            <button wire:click="setClickMode('{{ $clickMode }}')"
                                class="ml-auto text-xs font-medium text-stone-400 hover:text-stone-600">Batal</button>
                        </div>
                        @endif

                        {{-- Gambar Template --}}
                        <div class="relative rounded-xl overflow-hidden border border-stone-200 shadow-[0_2px_10px_-2px_rgba(120,113,108,.12)]"
                            x-data="{ imgW: 0, imgH: 0 }"
                            x-init="$nextTick(() => { imgW = $refs.tplImg.naturalWidth || $refs.tplImg.offsetWidth; imgH = $refs.tplImg.naturalHeight || $refs.tplImg.offsetHeight; })"
                            @click="
                                 if ('{{ $clickMode }}' !== '') {
                                     const rect = $el.getBoundingClientRect();
                                     const x = Math.round(event.clientX - rect.left);
                                     const y = Math.round(event.clientY - rect.top);
                                     const w = $el.offsetWidth;
                                     const h = $el.offsetHeight;
                                     $wire.setPositionFromClick(x, y, w, h);
                                 }
                             "
                            :class="'{{ $clickMode }}' !== '' ? 'cursor-crosshair' : 'cursor-default'">

                            <img src="{{ asset('storage/'.$templatePath) }}"
                                x-ref="tplImg"
                                alt="Template Sertifikat"
                                class="w-full object-contain" />

                            {{-- Marker posisi nama --}}
                            @if($posX && $posY)
                            <div class="absolute pointer-events-none"
                                style="left: calc({{ $posX }} / {{ $templateW }} * 100%); top: calc({{ $posY }} / {{ $templateH }} * 100%); transform: translate(-50%, -50%)">
                                <div class="flex flex-col items-center">
                                    <div class="w-4 h-4 rounded-full bg-orange-500 border-2 border-white shadow-lg flex items-center justify-center">
                                        <span class="text-white font-bold" style="font-size:8px">N</span>
                                    </div>
                                    <div class="mt-0.5 px-1.5 py-0.5 bg-orange-500 text-white rounded text-center whitespace-nowrap shadow" style="font-size:9px">
                                        Nama ({{ $posX }}, {{ $posY }})
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Marker posisi tanggal --}}
                            @if($includeDate && $posDateX && $posDateY)
                            <div class="absolute pointer-events-none"
                                style="left: calc({{ $posDateX }} / {{ $templateW }} * 100%); top: calc({{ $posDateY }} / {{ $templateH }} * 100%); transform: translate(-50%, -50%)">
                                <div class="flex flex-col items-center">
                                    <div class="w-4 h-4 rounded-full bg-blue-500 border-2 border-white shadow-lg flex items-center justify-center">
                                        <span class="text-white font-bold" style="font-size:8px">T</span>
                                    </div>
                                    <div class="mt-0.5 px-1.5 py-0.5 bg-blue-500 text-white rounded text-center whitespace-nowrap shadow" style="font-size:9px">
                                        Tanggal ({{ $posDateX }}, {{ $posDateY }})
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Tombol Set Posisi --}}
                        <div class="flex gap-2 mt-2">
                            <button wire:click="setClickMode('nama')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200
                                    {{ $clickMode === 'nama'
                                        ? 'bg-orange-500 text-white shadow-md'
                                        : 'bg-orange-50 text-orange-600 border border-orange-200 hover:bg-orange-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                </svg>
                                {{ $clickMode === 'nama' ? '🎯 Klik gambar...' : 'Set Posisi Nama' }}
                            </button>
                            @if($includeDate)
                            <button wire:click="setClickMode('tanggal')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200
                                    {{ $clickMode === 'tanggal'
                                        ? 'bg-blue-500 text-white shadow-md'
                                        : 'bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                </svg>
                                {{ $clickMode === 'tanggal' ? '🎯 Klik gambar...' : 'Set Posisi Tanggal' }}
                            </button>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button
                            @click="$store.deleteModal.show(
                                    'Hapus Template',
                                    'Yakin ingin menghapus template ini?',
                                    () => $wire.deleteTemplate()
                                )"
                                                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl
                                    text-xs font-semibold text-red-500
                                    bg-gradient-to-br from-red-50 to-red-100 border border-red-200
                                    shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                    hover:from-red-100 hover:to-red-200 hover:-translate-y-px
                                    hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.2)]
                                    active:scale-[.97] transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Hapus Template
                        </button>
                        <label class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl
                                      text-xs font-semibold text-stone-600 cursor-pointer
                                      bg-gradient-to-br from-stone-50 to-stone-100 border border-stone-200
                                      shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                      hover:from-stone-100 hover:to-stone-200 hover:-translate-y-px
                                      hover:shadow-[0_4px_10px_-2px_rgba(120,113,108,.15)]
                                      active:scale-[.97] transition-all duration-200">
                            <input wire:model="template" type="file" accept=".jpg,.jpeg,.png" class="hidden"
                                x-on:change="$wire.uploadTemplate()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Ganti Template
                        </label>
                    </div>
                    @else
                    {{-- Upload Area --}}
                    <div class="border-2 border-dashed border-stone-200 rounded-2xl p-10 text-center
                                hover:border-orange-400 hover:bg-orange-50/40 transition-all duration-200">
                        <input wire:model="template" type="file" accept=".jpg,.jpeg,.png"
                            class="hidden" id="template-upload">
                        <label for="template-upload" class="cursor-pointer">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100
                                        border border-orange-200 flex items-center justify-center mx-auto mb-4
                                        shadow-[0_4px_14px_-4px_rgba(234,88,12,.2)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-stone-600 mb-1">Upload Template Sertifikat</p>
                            <p class="text-xs text-stone-400">JPG, PNG — Landscape A4 (1754×1240px) direkomendasikan</p>
                            <div wire:loading wire:target="template">
                                <p class="text-xs text-orange-500 mt-2 animate-pulse font-medium">Mengupload...</p>
                            </div>
                        </label>
                    </div>

                    <button wire:click="uploadTemplate" wire:loading.attr="disabled"
                        class="relative mt-3 w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                               text-white text-sm font-bold overflow-hidden
                               shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                               hover:-translate-y-0.5 hover:scale-[1.02]
                               hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                               active:scale-[.97] disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0
                               transition-all duration-200"
                        style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <div wire:loading wire:target="uploadTemplate">
                            <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                            </svg>
                        </div>
                        <svg wire:loading.remove wire:target="uploadTemplate" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                        <span wire:loading.remove wire:target="uploadTemplate" class="relative">Upload Template</span>
                        <span wire:loading wire:target="uploadTemplate" class="relative">Mengupload...</span>
                    </button>
                    @endif
                </div>
            </div>

            {{-- Pengaturan Posisi Teks --}}
            @if($templatePath)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                        hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                        transition-shadow duration-300">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                    <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Pengaturan Teks</h3>
                    <span class="text-xs text-stone-400">(atau klik langsung di gambar)</span>
                </div>
                <div class="p-5 space-y-4">

                    {{-- Posisi Nama --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest">Posisi Nama Peserta</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-stone-500 mb-1.5">Posisi X (horizontal)</label>
                                <input wire:model.live="posX" type="number"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            </div>
                            <div>
                                <label class="block text-xs text-stone-500 mb-1.5">Posisi Y (vertikal)</label>
                                <input wire:model.live="posY" type="number"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            </div>
                        </div>
                    </div>

                    {{-- Font Settings --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs text-stone-500 mb-1.5">Ukuran Font</label>
                            <input wire:model.live="fontSize" type="number" min="12" max="120"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                        </div>
                        <div>
                            <label class="block text-xs text-stone-500 mb-1.5">Warna Font</label>
                            <input wire:model.live="fontColor" type="color"
                                class="w-full h-10 border border-stone-200 rounded-xl px-1.5 py-1 bg-stone-50 cursor-pointer
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200" />
                        </div>
                        <div>
                            <label class="block text-xs text-stone-500 mb-1.5">Alignment</label>
                            <select wire:model.live="fontAlign"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                <option value="left">Kiri</option>
                                <option value="center">Tengah</option>
                                <option value="right">Kanan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tanggal Toggle --}}
                    <div class="p-3.5 bg-stone-50 border border-stone-200 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-sm font-medium text-stone-700">Tampilkan Tanggal Acara</p>
                                <p class="text-xs text-stone-400 mt-0.5">Overlay tanggal pada sertifikat</p>
                            </div>
                            <button type="button"
                                wire:click="$set('includeDate', {{ $includeDate ? 'false' : 'true' }})"
                                class="relative w-11 h-6 rounded-full border-none cursor-pointer flex-shrink-0 transition-all duration-200"
                                style="{{ $includeDate ? 'background:linear-gradient(135deg,#F97316,#EA580C);box-shadow:0 2px 8px rgba(234,88,12,.35)' : 'background:#D6D3D1' }}">
                                <span class="absolute top-1 w-4 h-4 rounded-full bg-white shadow-[0_1px_4px_rgba(0,0,0,.22)] transition-all duration-200"
                                    style="{{ $includeDate ? 'left:23px' : 'left:4px' }}">
                                </span>
                            </button>
                        </div>
                        @if($includeDate)
                        <div class="grid grid-cols-2 gap-3 pt-2 border-t border-stone-200">
                            <div>
                                <label class="block text-xs text-stone-500 mb-1.5">Posisi X Tanggal</label>
                                <input wire:model.live="posDateX" type="number"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-white text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200" />
                            </div>
                            <div>
                                <label class="block text-xs text-stone-500 mb-1.5">Posisi Y Tanggal</label>
                                <input wire:model.live="posDateY" type="number"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-white text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200" />
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            @endif

        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-4">

            {{-- Panduan --}}
            <div class="bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-2xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                <p class="flex items-center gap-1.5 text-xs font-bold text-blue-700 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                    </svg>
                    Panduan Template
                </p>
                <ol class="space-y-2">
                    @foreach([
                    'Upload template sertifikat format JPG/PNG landscape',
                    'Klik tombol "Set Posisi Nama" lalu klik langsung di gambar',
                    'Dot oranye (N) = posisi nama, dot biru (T) = posisi tanggal',
                    'Sesuaikan ukuran font dan warna sesuai template',
                    'Klik "Generate Bulk" untuk buat semua sertifikat sekaligus',
                    ] as $i => $step)
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-200 text-blue-700 text-[10px] font-bold
                                     flex items-center justify-center flex-shrink-0 mt-0.5">{{ $i + 1 }}</span>
                        <span class="text-xs text-blue-600 leading-relaxed">{{ $step }}</span>
                    </li>
                    @endforeach
                </ol>
            </div>

            {{-- Tips Koordinat --}}
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                <p class="flex items-center gap-1.5 text-xs font-bold text-amber-700 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                    Koordinat Saat Ini
                </p>
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between py-1 border-b border-amber-200/60">
                        <span class="text-xs text-amber-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span> Nama X, Y
                        </span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ $posX }}, {{ $posY }}</span>
                    </div>
                    @if($includeDate)
                    <div class="flex items-center justify-between py-1 border-b border-amber-200/60">
                        <span class="text-xs text-amber-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span> Tanggal X, Y
                        </span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ $posDateX }}, {{ $posDateY }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-1">
                        <span class="text-xs text-amber-600">Ukuran font</span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ $fontSize }}px</span>
                    </div>
                    <div class="flex items-center justify-between py-1">
                        <span class="text-xs text-amber-600">Alignment</span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ $fontAlign }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1">
                        <span class="text-xs text-amber-600">Dimensi template</span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ $templateW }}×{{ $templateH }}</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Generate --}}
            @if($templatePath)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden p-5 space-y-2.5
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

                @if($totalPeserta === 0)
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <p class="text-xs text-amber-700 font-medium">Belum ada peserta yang hadir di acara ini.</p>
                </div>
                @endif

                <button wire:click="generate" wire:loading.attr="disabled"
                    @if($totalPeserta===0) disabled @endif
                    class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl border-none cursor-pointer
                           text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                           hover:-translate-y-0.5 hover:scale-[1.02]
                           hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                           active:scale-[.97] disabled:opacity-50 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                           transition-all duration-200"
                    style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <div wire:loading wire:target="generate">
                        <svg class="w-5 h-5 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                        </svg>
                    </div>
                    <svg wire:loading.remove wire:target="generate" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    <span wire:loading.remove wire:target="generate" class="relative">
                        Generate Bulk ({{ $totalPeserta }} Peserta)
                    </span>
                    <span wire:loading wire:target="generate" class="relative">Generating...</span>
                </button>

                <a href="{{ route('admin.acara.detail', $diklat->id) }}"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border border-stone-200
                          text-stone-400 text-sm font-medium bg-white
                          shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                          hover:text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
                          transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke Detail Acara
                </a>
            </div>
            @endif

        </div>

    </div>

</div>