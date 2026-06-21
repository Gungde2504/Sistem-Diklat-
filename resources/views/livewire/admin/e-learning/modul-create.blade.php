<div class="space-y-5">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.elearning.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-stone-400 hover:text-orange-600
                   hover:translate-x-[-2px] transition-all duration-200 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
        <span class="text-stone-200">/</span>
        <h2 class="text-base font-bold text-gray-800 tracking-tight">Tambah Modul E-Learning</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Form Utama --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Info Dasar --}}
            <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full"
                        style="background:linear-gradient(180deg,#FF8C00,#C73D00)"></div>
                    <h3 class="text-sm font-semibold text-gray-800">Informasi Modul</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                            Judul Modul <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="judul" type="text" placeholder="Judul modul pembelajaran"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                   focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                   transition-all duration-200" />
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Kategori</label>
                            <input wire:model="kategori" type="text" placeholder="Contoh: Keselamatan Kerja"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                       focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                       transition-all duration-200" />
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">
                                Estimasi Durasi (jam) <span class="text-red-400">*</span>
                            </label>
                            <input wire:model="estimasi_durasi_jam" type="number" step="0.5" min="0.5"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                       focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                       transition-all duration-200" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Target Unit</label>
                        <select wire:model="id_target_unit"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700
                                   focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                                   transition-all duration-200">
                            <option value="">Semua Unit</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="3" placeholder="Deskripsi singkat modul..."
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                   focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                   transition-all duration-200 resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- Konten --}}
            <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-blue-400 to-blue-600"></div>
                    <h3 class="text-sm font-semibold text-gray-800">Konten Pembelajaran</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Link Video (YouTube/Drive)</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <input wire:model="link_video" type="url" placeholder="https://youtube.com/..."
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                       focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                       transition-all duration-200" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Upload File Materi</label>
                        <div
                            x-data="{
        isDragging: false,
        fileName: null,
        fileSize: null,
        fileType: null,
        handleDrop(e) {
            this.isDragging = false;
            const file = e.dataTransfer.files[0];
            if (file) this.setFile(file);
        },
        handleChange(e) {
            const file = e.target.files[0];
            if (file) this.setFile(file);
        },
        setFile(file) {
            this.fileName = file.name;
            this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            const ext = file.name.split('.').pop().toLowerCase();
            this.fileType = ext;
        },
        getIcon() {
            const ext = this.fileType;
            if (ext === 'pdf') return 'pdf';
            if (['doc','docx'].includes(ext)) return 'word';
            if (['ppt','pptx'].includes(ext)) return 'ppt';
            return 'file';
        },
        clearFile() {
            this.fileName = null;
            this.fileSize = null;
            this.fileType = null;
            document.getElementById('fileInput').value = '';
            @this.set('file', null);
        }
    }"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            class="relative">

                            {{-- Drop Zone --}}
                            <div x-show="!fileName"
                                :class="isDragging
            ? 'border-orange-400 bg-orange-50/50 scale-[1.01]'
            : 'border-stone-200 hover:border-orange-300 hover:bg-orange-50/30'"
                                class="border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200 cursor-pointer"
                                @click="document.getElementById('fileInput').click()">

                                <div :class="isDragging ? 'scale-110' : ''"
                                    class="transition-transform duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="isDragging ? 'text-orange-400' : 'text-stone-300'"
                                        class="w-10 h-10 mx-auto mb-3 transition-colors duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                </div>

                                <p x-show="!isDragging" class="text-sm font-semibold text-stone-500 mb-1">
                                    Drag & drop file di sini
                                </p>
                                <p x-show="isDragging" class="text-sm font-bold text-orange-500 mb-1">
                                    Lepaskan untuk upload!
                                </p>
                                <p class="text-xs text-stone-400 mb-3">PDF, Word, PowerPoint — maks 20MB</p>

                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-orange-600
                     bg-orange-50 border border-orange-200 px-3 py-1.5 rounded-lg
                     hover:bg-orange-100 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Pilih File
                                </span>
                            </div>

                            {{-- Preview File --}}
                            <div x-show="fileName" x-cloak
                                class="border border-stone-200 rounded-xl p-4 bg-white
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_8px_-3px_rgba(120,113,108,.08)]">
                                <div class="flex items-center gap-3">

                                    {{-- Icon berdasarkan tipe file --}}
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 relative overflow-hidden">
                                        {{-- PDF --}}
                                        <template x-if="getIcon() === 'pdf'">
                                            <div class="w-full h-full flex items-center justify-center rounded-xl bg-red-50 border border-red-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                        </template>
                                        {{-- Word --}}
                                        <template x-if="getIcon() === 'word'">
                                            <div class="w-full h-full flex items-center justify-center rounded-xl bg-blue-50 border border-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                        </template>
                                        {{-- PPT --}}
                                        <template x-if="getIcon() === 'ppt'">
                                            <div class="w-full h-full flex items-center justify-center rounded-xl bg-orange-50 border border-orange-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5" />
                                                </svg>
                                            </div>
                                        </template>
                                        {{-- Default --}}
                                        <template x-if="getIcon() === 'file'">
                                            <div class="w-full h-full flex items-center justify-center rounded-xl bg-stone-50 border border-stone-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Info File --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-stone-800 truncate" x-text="fileName"></p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs text-stone-400" x-text="fileSize"></span>
                                            <span class="w-1 h-1 rounded-full bg-stone-300"></span>
                                            <span class="text-xs font-semibold uppercase"
                                                :class="{
                              'text-red-500': fileType === 'pdf',
                              'text-blue-500': ['doc','docx'].includes(fileType),
                              'text-orange-500': ['ppt','pptx'].includes(fileType),
                              'text-stone-500': !['pdf','doc','docx','ppt','pptx'].includes(fileType)
                          }"
                                                x-text="fileType"></span>
                                        </div>
                                        <div class="flex items-center gap-1 mt-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                            <span class="text-[10px] text-green-600 font-medium">Siap diupload</span>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <button type="button"
                                            @click="document.getElementById('fileInput').click()"
                                            class="text-xs font-semibold text-blue-600 hover:text-blue-800
                           bg-blue-50 hover:bg-blue-100 border border-blue-200
                           px-2.5 py-1.5 rounded-lg transition-all duration-200">
                                            Ganti
                                        </button>
                                        <button type="button"
                                            @click="clearFile()"
                                            class="text-xs font-semibold text-red-500 hover:text-red-700
                           bg-red-50 hover:bg-red-100 border border-red-200
                           px-2.5 py-1.5 rounded-lg transition-all duration-200">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Input file tersembunyi --}}
                            <input id="fileInput"
                                wire:model="file"
                                type="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx"
                                class="hidden"
                                @change="handleChange($event)" />
                        </div>
                        @error('file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Konten / Materi Teks</label>
                        <textarea wire:model="konten" rows="6" placeholder="Tulis materi pembelajaran di sini..."
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                   focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                                   transition-all duration-200 resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- Kuis --}}
            <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-400 to-purple-600"></div>
                        <h3 class="text-sm font-semibold text-gray-800">Kuis</h3>
                        @if($ada_kuis)
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-50 border border-purple-100 text-purple-600 font-semibold">Aktif</span>
                        @endif
                    </div>
                    <button type="button" wire:click="$set('ada_kuis', {{ $ada_kuis ? 'false' : 'true' }})"
                        class="relative w-11 h-6 rounded-full border-none cursor-pointer transition-all duration-300
                               shadow-[0_1px_4px_rgba(0,0,0,.1)_inset]"
                        style="{{ $ada_kuis ? 'background:linear-gradient(135deg,#FF8C00,#C73D00)' : 'background:#D6D3D1' }}">
                        <span class="absolute top-1 w-4 h-4 rounded-full bg-white shadow-[0_1px_4px_rgba(0,0,0,.15)] transition-all duration-300"
                            style="{{ $ada_kuis ? 'left:23px' : 'left:4px' }}"></span>
                    </button>
                </div>

                @if($ada_kuis)
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Nilai Minimum Lulus (%)</label>
                        <input wire:model="min_quiz_score" type="number" min="0" max="100" placeholder="70"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                   focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15 focus:bg-white
                                   transition-all duration-200" />
                    </div>

                    @foreach($soal as $i => $s)
                    <div class="border border-stone-100 rounded-2xl p-4 space-y-3
                                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_8px_-3px_rgba(120,113,108,.08)]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-bold text-white
                                             shadow-[0_2px_6px_-1px_rgba(147,51,234,.3)]
                                             bg-gradient-to-br from-purple-400 to-purple-600">
                                    {{ $i + 1 }}
                                </span>
                                <p class="text-xs font-bold text-stone-600 uppercase tracking-wide">Soal {{ $i + 1 }}</p>
                            </div>
                            @if(count($soal) > 1)
                            <button wire:click="hapusSoal({{ $i }})"
                                class="flex items-center gap-1 text-xs text-red-400 hover:text-red-600
                                       hover:bg-red-50 px-2 py-1 rounded-lg transition-all duration-200 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                Hapus
                            </button>
                            @endif
                        </div>
                        <textarea wire:model="soal.{{ $i }}.pertanyaan" rows="2" placeholder="Tulis pertanyaan..."
                            class="w-full px-3 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                   focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15 focus:bg-white
                                   transition-all duration-200 resize-none"></textarea>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[10px] font-bold
                                             bg-stone-100 text-stone-500 flex-shrink-0">{{ $label }}</span>
                                <input wire:model="soal.{{ $i }}.pilihan_{{ $key }}" type="text"
                                    placeholder="Pilihan {{ $label }}"
                                    class="flex-1 px-3 py-2 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800
                                           focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15
                                           transition-all duration-200" />
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Jawaban Benar</label>
                            <select wire:model="soal.{{ $i }}.jawaban_benar"
                                class="w-full px-3 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700
                                       focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-400/15
                                       transition-all duration-200">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    @endforeach

                    <button wire:click="tambahSoal" type="button"
                        class="w-full flex items-center justify-center gap-2 py-3 border-2 border-dashed border-purple-200 rounded-2xl
                               text-sm font-semibold text-purple-500
                               hover:border-purple-400 hover:bg-purple-50/50 hover:text-purple-600
                               active:scale-[.98] transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Soal
                    </button>
                </div>
                @else
                <div class="p-8 text-center">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 bg-stone-50 border border-stone-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <p class="text-sm text-stone-400 font-medium">Aktifkan toggle untuk menambahkan kuis</p>
                </div>
                @endif
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">

            {{-- Publish & Simpan --}}
            <div class="bg-white rounded-2xl border border-stone-100 p-5
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-sm font-semibold text-stone-800">Status Publikasi</p>
                        <p class="text-xs text-stone-400 mt-0.5">
                            {{ $publish ? 'Tampil ke pegawai' : 'Masih draft' }}
                        </p>
                    </div>
                    <button type="button" wire:click="$set('publish', {{ $publish ? 'false' : 'true' }})"
                        class="relative w-11 h-6 rounded-full border-none cursor-pointer transition-all duration-300
                               shadow-[0_1px_4px_rgba(0,0,0,.1)_inset]"
                        style="{{ $publish ? 'background:linear-gradient(135deg,#22c55e,#16a34a)' : 'background:#D6D3D1' }}">
                        <span class="absolute top-1 w-4 h-4 rounded-full bg-white shadow-[0_1px_4px_rgba(0,0,0,.15)] transition-all duration-300"
                            style="{{ $publish ? 'left:23px' : 'left:4px' }}"></span>
                    </button>
                </div>

                <button wire:click="simpan" wire:loading.attr="disabled"
                    class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl
                           text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(200,61,0,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                           hover:-translate-y-0.5 hover:scale-[1.01]
                           hover:shadow-[0_8px_24px_-4px_rgba(200,61,0,.55)]
                           active:scale-[.97] disabled:opacity-50 disabled:cursor-not-allowed
                           disabled:translate-y-0 disabled:scale-100
                           transition-all duration-200"
                    style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <div wire:loading wire:target="simpan">
                        <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                        </svg>
                    </div>
                    <svg wire:loading.remove wire:target="simpan" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span wire:loading.remove wire:target="simpan" class="relative">Simpan Modul</span>
                    <span wire:loading wire:target="simpan" class="relative">Menyimpan...</span>
                </button>
            </div>

            {{-- Tips --}}
            <div class="bg-white rounded-2xl border border-stone-100 p-5
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-xl flex items-center justify-center
                                bg-blue-50 border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-stone-700">Tips Membuat Modul</p>
                </div>
                <ul class="space-y-2">
                    @foreach([
                    'Sertakan video atau file materi agar lebih mudah dipahami',
                    'Tambahkan kuis untuk memvalidasi pemahaman peserta',
                    'Nilai minimum kuis default 70%',
                    'Modul draft tidak akan terlihat oleh pegawai'
                    ] as $tip)
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 flex-shrink-0 mt-1.5"></span>
                        <p class="text-xs text-stone-500 leading-relaxed">{{ $tip }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>

</div>