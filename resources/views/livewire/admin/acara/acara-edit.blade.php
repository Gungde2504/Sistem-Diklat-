<div>

    {{-- Flash session --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium flex-1">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Flash livewire --}}
    @if($berhasil)
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium flex-1">Acara berhasil diperbarui!</p>
        <button wire:click="$set('berhasil', false)" class="text-green-300 hover:text-green-600 transition-colors ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Card Info Dasar --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Informasi Dasar</h3>
                    </div>
                    <div class="p-5 space-y-4">

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Nama Acara <span class="text-red-400">*</span></label>
                            <input wire:model="nama" type="text" placeholder="Nama acara"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            @error('nama') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Jenis Diklat <span class="text-red-400">*</span></label>
                                <select wire:model="jenisDiklat"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Diklat Internal">Diklat Internal</option>
                                    <option value="Diklat Eksternal">Diklat Eksternal</option>
                                    <option value="Seminar">Seminar</option>
                                </select>
                                @error('jenisDiklat') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Status Acara</label>
                                <select wire:model="status"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                    <option value="Draft">Draft</option>
                                    <option value="Terbuka">Terbuka</option>
                                    <option value="Berlangsung">Berlangsung</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Narasumber <span class="text-red-400">*</span></label>
                            <input wire:model="namaNarasumber" type="text" placeholder="Nama narasumber"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            @error('namaNarasumber') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tempat <span class="text-red-400">*</span></label>
                            <input wire:model="tempat" type="text" placeholder="Lokasi penyelenggaraan"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            @error('tempat') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Mulai <span class="text-red-400">*</span></label>
                                <input wire:model="tglJamMulai" type="datetime-local"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                                @error('tglJamMulai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Selesai <span class="text-red-400">*</span></label>
                                <input wire:model="tglJamSelesai" type="datetime-local"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                                @error('tglJamSelesai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Durasi (Jam) <span class="text-red-400">*</span></label>
                                <input wire:model="durasi" type="number" min="1"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                                @error('durasi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Kuota Peserta <span class="text-red-400">*</span></label>
                                <input wire:model="kuota" type="number" min="1"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                                @error('kuota') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Deskripsi</label>
                            <textarea wire:model="deskripsi" rows="4" placeholder="Deskripsi acara (opsional)"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"></textarea>
                        </div>

                    </div>
                </div>

                {{-- Card Pretest & Posttest --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Link Pretest &amp; Posttest</h3>
                        <span class="text-xs text-stone-400">(Opsional)</span>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Link Pretest</label>
                            <input wire:model="linkPretest" type="url" placeholder="https://forms.google.com/..."
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            @error('linkPretest') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Link Posttest</label>
                            <input wire:model="linkPosttest" type="url" placeholder="https://forms.google.com/..."
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                            @error('linkPosttest') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">

                {{-- Card Sampul --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300" wire:ignore>
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-pink-500 to-pink-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Gambar Sampul</h3>
                        <span class="text-xs text-stone-400">(Opsional)</span>
                    </div>
                    <div class="p-5"
                        x-data="{
                             preview: null, uploading: false, saved: false, fileName: '',
                             handleFile(e) {
                                 const file = e.target.files[0];
                                 if (!file) return;
                                 this.fileName = file.name;
                                 const r = new FileReader();
                                 r.onload = ev => this.preview = ev.target.result;
                                 r.readAsDataURL(file);
                                 this.uploading = true; this.saved = false;
                                 $wire.upload('img', file,
                                     () => {
                                         this.uploading = false;
                                         $wire.simpanSampul().then(() => { this.saved = true; });
                                     },
                                     () => { this.uploading = false; alert('Gagal upload gambar'); },
                                     () => {}
                                 );
                             }
                         }">

                        {{-- Preview existing --}}
                        @if($imgExisting)
                        <div class="aspect-video rounded-xl overflow-hidden mb-2.5
                                    shadow-[0_1px_0_rgba(255,255,255,.8)_inset,0_4px_14px_-4px_rgba(120,113,108,.18)]">
                            <img src="{{ asset('storage/'.$imgExisting) }}" class="w-full h-full object-cover" />
                        </div>
                        <button type="button" wire:click="hapusSampul" wire:confirm="Hapus gambar sampul ini?"
                            class="w-full flex items-center justify-center gap-1.5 py-2 mb-2.5 rounded-xl border border-red-200 cursor-pointer
                                   text-xs font-semibold text-red-500
                                   bg-gradient-to-br from-red-50 to-red-100
                                   shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_2px_6px_rgba(239,68,68,.08)]
                                   hover:from-red-100 hover:to-red-200 hover:-translate-y-px
                                   hover:shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_5px_12px_rgba(239,68,68,.2)]
                                   active:scale-[.97] transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Hapus Sampul
                        </button>
                        @else
                        <template x-if="!preview">
                            <div class="aspect-video rounded-xl border-2 border-dashed border-stone-200 bg-stone-50
                                        flex items-center justify-center mb-3
                                        hover:border-orange-300 hover:bg-orange-50/50 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center text-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-stone-300 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <p class="text-xs text-stone-400">Belum ada gambar</p>
                                </div>
                            </div>
                        </template>
                        <template x-if="preview">
                            <div class="aspect-video rounded-xl overflow-hidden mb-3 relative
                                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset,0_4px_14px_-4px_rgba(120,113,108,.18)]">
                                <img :src="preview" class="w-full h-full object-cover" />
                                <div x-show="saved" class="absolute inset-0 bg-green-500/20 flex items-center justify-center">
                                    <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-md">✓ Tersimpan</span>
                                </div>
                            </div>
                        </template>
                        @endif

                        <p x-show="uploading" class="text-xs text-pink-500 animate-pulse text-center mt-1 mb-2">Mengupload &amp; menyimpan gambar...</p>

                        {{-- Choose File — gradient primary --}}
                        <label class="relative flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl cursor-pointer
                                      text-white text-[12.5px] font-semibold overflow-hidden mt-1
                                      shadow-[0_3px_12px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.22)_inset]
                                      hover:-translate-y-0.5 hover:scale-[1.02]
                                      hover:shadow-[0_7px_20px_-4px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.22)_inset]
                                      active:scale-[.97] transition-all duration-200"
                            style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                            <span class="relative">{{ $imgExisting ? 'Ganti Gambar' : 'Pilih Gambar' }}</span>
                            <input type="file" accept="image/jpeg,image/png,image/webp" @change="handleFile($event)" class="sr-only" />
                        </label>

                        @error('img') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-stone-400 mt-2 text-center">JPG, PNG — maks 2MB. Rasio 16:9 disarankan.</p>
                    </div>
                </div>

                {{-- Info Acara --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-stone-400 to-stone-500"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Info Acara</h3>
                    </div>
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">QR Code</span>
                            <span class="text-[11px] font-medium text-stone-600 font-mono bg-stone-100 px-2 py-0.5 rounded-md">{{ $diklat->QRcode ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">Status QR</span>
                            <span class="text-xs font-semibold {{ $diklat->IsActive ? 'text-green-600' : 'text-stone-400 font-normal' }}">
                                {{ $diklat->IsActive ? '● Aktif' : '○ Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-stone-100">
                            <span class="text-[11.5px] text-stone-400">Peserta Hadir</span>
                            <span class="text-xs font-semibold text-stone-800">{{ $diklat->absensiDiklats()->count() }} / {{ $diklat->kuota }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-[11.5px] text-stone-400">Dibuat</span>
                            <span class="text-xs text-stone-500">{{ $diklat->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-600 to-purple-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Pengaturan</h3>
                    </div>
                    <div class="p-5 space-y-3">

                        {{-- Info Status Otomatis --}}
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl">
                            <div class="flex items-center gap-1.5 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                                </svg>
                                <p class="text-xs font-semibold text-blue-700">Status Otomatis</p>
                            </div>
                            <ul class="space-y-1.5">
                                @foreach([
                                ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z', 'label' => 'Draft', 'desc' => 'sebelum dipublikasikan'],
                                ['icon' => 'M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z', 'label' => 'Terbuka', 'desc' => 'setelah publish, sebelum mulai'],
                                ['icon' => 'M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z', 'label' => 'Berlangsung', 'desc' => 'saat acara berlangsung'],
                                ['icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'label' => 'Selesai', 'desc' => 'setelah waktu selesai'],
                                ] as $item)
                                <li class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                    </svg>
                                    <p class="text-[11px] text-blue-600">
                                        <strong>{{ $item['label'] }}</strong> — {{ $item['desc'] }}
                                    </p>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Toggle Publikasi --}}
                        <div class="flex items-center justify-between p-3 bg-stone-50 border border-stone-200 rounded-xl">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0
                            {{ $publish ? 'bg-orange-50 border border-orange-200' : 'bg-stone-100 border border-stone-200' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $publish ? 'text-orange-500' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-stone-700">Publikasikan</p>
                                    <p class="text-xs text-stone-400 mt-0.5">Tampilkan ke portal pegawai</p>
                                </div>
                            </div>
                            <button type="button"
                                wire:click="$set('publish', {{ $publish ? 0 : 1 }})"
                                class="relative w-11 h-6 rounded-full border-none cursor-pointer flex-shrink-0 transition-all duration-200"
                                style="{{ $publish ? 'background:linear-gradient(135deg,#F97316,#EA580C);box-shadow:0 2px 8px rgba(234,88,12,.35)' : 'background:#D6D3D1' }}">
                                <span class="absolute top-1 w-4 h-4 rounded-full bg-white shadow-[0_1px_4px_rgba(0,0,0,.22)] transition-all duration-200"
                                    style="{{ $publish ? 'left:23px' : 'left:4px' }}"></span>
                            </button>
                        </div>

                    </div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="p-5 space-y-2.5">

                        {{-- Simpan Perubahan --}}
                        <button type="submit"
                            class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                                   text-white text-sm font-bold overflow-hidden
                                   shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                                   hover:-translate-y-0.5 hover:scale-[1.02]
                                   hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                                   active:scale-[.97] transition-all duration-200"
                            style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
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
                            <span wire:loading.remove wire:target="save" class="relative">Simpan Perubahan</span>
                            <span wire:loading wire:target="save" class="relative">Menyimpan...</span>
                        </button>

                        {{-- Kembali --}}
                        <a href="{{ route('admin.acara.index') }}"
                            class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border border-stone-200
                                  text-stone-400 text-sm font-medium bg-white
                                  shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                  hover:text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
                                  transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>