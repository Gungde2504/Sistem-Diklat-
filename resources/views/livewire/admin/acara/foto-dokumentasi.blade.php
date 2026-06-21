<div class="space-y-5">

    {{-- Flash Success --}}
    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Flash Error --}}
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-600">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-stone-800 tracking-tight">Foto Dokumentasi</h2>
            <p class="text-sm text-stone-500 mt-0.5">{{ $diklat->nama }}</p>
        </div>
        <a href="{{ route('admin.acara.detail', $diklat) }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-stone-500
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

    {{-- Upload Form --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">

        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
            <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Upload Foto</h3>
            <span class="text-xs text-stone-400">Maksimal 10 foto, masing-masing max 5MB</span>
        </div>

        <div class="p-5">
            <form action="{{ route('admin.acara.foto.upload', $diklat) }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="{
                      previews: [],
                      handleFiles(files) {
                          this.previews = [];
                          Array.from(files).forEach(f => {
                              const r = new FileReader();
                              r.onload = ev => this.previews.push({ src: ev.target.result, name: f.name });
                              r.readAsDataURL(f);
                          });
                      },
                      onDrop(e) {
                          const dt = new DataTransfer();
                          Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
                          this.$refs.fotoInput.files = dt.files;
                          this.handleFiles(dt.files);
                      }
                  }"
                class="space-y-4">
                @csrf

                {{-- Dropzone --}}
                <div @click="$refs.fotoInput.click()"
                    @dragover.prevent="$el.classList.add('!border-orange-400','!bg-orange-50/50')"
                    @dragleave.prevent="$el.classList.remove('!border-orange-400','!bg-orange-50/50')"
                    @drop.prevent="$el.classList.remove('!border-orange-400','!bg-orange-50/50'); onDrop($event)"
                    class="border-2 border-dashed border-stone-200 bg-stone-50 rounded-2xl p-10
                            text-center cursor-pointer
                            hover:border-orange-400 hover:bg-orange-50/50
                            transition-all duration-200">

                    <input type="file" name="fotos[]" multiple accept="image/*"
                        x-ref="fotoInput"
                        @change="handleFiles($event.target.files)"
                        class="hidden" />

                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100
                                border border-orange-200 flex items-center justify-center mx-auto mb-4
                                shadow-[0_4px_14px_-4px_rgba(234,88,12,.2)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-stone-600">Klik atau drag &amp; drop foto di sini</p>
                    <p class="text-xs text-stone-400 mt-1">JPG, PNG, WEBP — maks 5MB per foto</p>
                </div>

                {{-- Preview --}}
                <template x-if="previews.length > 0">
                    <div>
                        <div class="grid grid-cols-4 gap-2.5">
                            <template x-for="(item, i) in previews" :key="i">
                                <div class="relative rounded-xl overflow-hidden bg-stone-100 aspect-square
                                            shadow-[0_2px_8px_-2px_rgba(120,113,108,.15)]">
                                    <img :src="item.src" class="w-full h-full object-cover" />
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent px-2 py-1.5">
                                        <p class="text-[10px] text-white truncate" x-text="item.name"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <p class="text-xs text-orange-500 font-semibold mt-2"
                            x-text="previews.length + ' foto dipilih'"></p>
                    </div>
                </template>

                {{-- Submit --}}
                <button type="submit"
                    class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                           text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                           hover:-translate-y-0.5 hover:scale-[1.02]
                           hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                           active:scale-[.97] transition-all duration-200"
                    style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    <span class="relative">Upload Foto</span>
                </button>

            </form>
        </div>
    </div>

    {{-- Galeri Foto --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">

        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <div class="flex items-center gap-2.5">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-500 to-orange-400"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Galeri Foto</h3>
            </div>
            <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2.5 py-1 rounded-full">{{ $galeri->count() }} foto</span>
        </div>

        @if($galeri->count() > 0)
        <div class="p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($galeri as $foto)
            <div class="group relative rounded-2xl overflow-hidden aspect-square bg-stone-100
                        shadow-[0_2px_8px_-2px_rgba(120,113,108,.12)]
                        hover:shadow-[0_8px_20px_-4px_rgba(120,113,108,.2)]
                        hover:-translate-y-0.5 transition-all duration-250">

                <img src="{{ asset('storage/'.$foto->file) }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    alt="Foto dokumentasi" />

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition-colors duration-200
                            flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <a href="{{ asset('storage/'.$foto->file) }}" target="_blank"
                        class="w-9 h-9 bg-white rounded-full flex items-center justify-center
                              shadow-[0_2px_8px_rgba(0,0,0,.2)]
                              hover:bg-stone-100 hover:scale-110 transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-700" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                    <form action="{{ route('admin.acara.foto.hapus', [$diklat, $foto]) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button
                            type="button"
                            @click="$store.fotoModal.show('{{ asset('storage/'.$foto->file) }}', () => $el.closest('form').submit())"
                            class="w-9 h-9 rounded-full flex items-center justify-center
           shadow-[0_2px_8px_rgba(0,0,0,.2)]
           hover:scale-110 transition-all duration-150"
                            style="background:linear-gradient(135deg,#F97316,#EA580C)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Date badge --}}
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/65 to-transparent px-3 py-2.5">
                    <p class="text-[11px] text-white/90 font-medium">{{ \Carbon\Carbon::parse($foto->created_at)->format('d M Y') }}</p>
                </div>

            </div>
            @endforeach
        </div>

        @else
        <div class="py-14 px-5 text-center">
            <div class="w-16 h-16 rounded-2xl bg-stone-100 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-stone-500 mb-1">Belum ada foto dokumentasi</p>
            <p class="text-xs text-stone-400">Upload foto di atas untuk memulai</p>
        </div>
        @endif

    </div>

</div>