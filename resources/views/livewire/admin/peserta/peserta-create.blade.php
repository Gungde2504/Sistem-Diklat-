<div>

    {{-- Flash --}}
    @if($berhasil)
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium flex-1">Peserta berhasil ditambahkan!</p>
        <button wire:click="$set('berhasil', false)" class="text-green-300 hover:text-green-600 transition-colors ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Tab Pilih Tipe --}}
    <div class="flex gap-1.5 bg-white border border-stone-200 rounded-2xl p-1.5 mb-5 w-fit
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_3px_10px_rgba(120,113,108,.09)]">
        <button wire:click="$set('tipe', 'eksternal')"
            class="px-5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   {{ $tipe === 'eksternal'
                       ? 'text-white font-semibold shadow-[0_3px_10px_-2px_rgba(234,88,12,.4)]'
                       : 'text-stone-500 hover:text-stone-800 hover:bg-stone-100' }}"
            @if($tipe === 'eksternal') style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)" @endif>
            PKL / Magang / Orientasi
        </button>
        <button wire:click="$set('tipe', 'karyawan')"
            class="px-5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   {{ $tipe === 'karyawan'
                       ? 'text-white font-semibold shadow-[0_3px_10px_-2px_rgba(15,79,122,.4)]'
                       : 'text-stone-500 hover:text-stone-800 hover:bg-stone-100' }}"
            @if($tipe === 'karyawan') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
            Karyawan External
        </button>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Kolom Kiri (2/3) --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Card Data Akun --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Data Akun</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="sm:col-span-2">
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input wire:model="nama" type="text" placeholder="Nama lengkap"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('nama') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Email <span class="text-red-400">*</span></label>
                            <input wire:model="email" type="email" placeholder="email@domain.com"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('email') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Password <span class="text-red-400">*</span></label>
                            <input wire:model="password" type="password" placeholder="Min. 6 karakter"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('password') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">No. HP</label>
                            <input wire:model="hp" type="text" placeholder="08xxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('hp') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Alamat KTP</label>
                            <input wire:model="alamat" type="text" placeholder="Alamat domisili"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        </div>

                    </div>
                </div>

                {{-- Card Data Kegiatan — PKL/Magang --}}
                @if($tipe === 'eksternal')
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Data Kegiatan</h3>
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-orange-50 border border-orange-200 text-orange-600 font-semibold">PKL · Magang · Orientasi</span>
                    </div>
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Jenis <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <select wire:model="jenis"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="pkl">PKL</option>
                                    <option value="magang">Magang</option>
                                    <option value="orientasi">Orientasi</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                            @error('jenis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Unit Penempatan <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <select wire:model="idUnit"
                                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                    <option value="">-- Pilih Unit --</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                    @endforeach
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                            @error('idUnit') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Institusi / Universitas <span class="text-red-400">*</span></label>
                            <input wire:model="institusi" type="text" placeholder="Nama institusi asal"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('institusi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tanggal Mulai <span class="text-red-400">*</span></label>
                            <input wire:model="tanggalMulai" type="date"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('tanggalMulai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tanggal Selesai <span class="text-red-400">*</span></label>
                            <input wire:model="tanggalSelesai" type="date"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('tanggalSelesai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>
                @endif

                {{-- Card Data Karyawan External --}}
                @if($tipe === 'karyawan')
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                            hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                            transition-shadow duration-300">
                    <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-blue-600 to-blue-400"></div>
                        <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Data Karyawan</h3>
                        <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-semibold">ISS · BSS · Adidaya · dll</span>
                    </div>
                    <div class="p-5 space-y-4">

                        {{-- Pilih Vendor --}}
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-2">Vendor / Perusahaan <span class="text-red-400">*</span></label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach([
                                    'karyawan_iss'         => 'ISS',
                                    'karyawan_bss'         => 'BSS',
                                    'karyawan_adidaya'     => 'PT. Adidaya',
                                    'karyawan_bayi_tabung' => 'Bayi Tabung',
                                    'karyawan_koperasi'    => 'Koperasi',
                                    'karyawan_lotus_spa'   => 'Lotus SPA',
                                ] as $value => $label)
                                <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all duration-200
                                              {{ $jenis === $value
                                                  ? 'border-blue-400 bg-blue-50 shadow-sm'
                                                  : 'border-stone-200 bg-stone-50 hover:border-blue-300 hover:bg-blue-50/50' }}">
                                    <input type="radio" wire:model.live="jenis" value="{{ $value }}" class="accent-blue-600 flex-shrink-0">
                                    <span class="text-xs font-semibold text-stone-700">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('jenis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                       
                        {{-- Info approval --}}
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl">
                            <p class="text-xs text-blue-600">
                                💡 Karyawan external perlu disetujui sebelum dapat login. Status approval otomatis <strong>Pending</strong> saat dibuat.
                            </p>
                        </div>

                    </div>
                </div>
                @endif

            </div>

            {{-- Kolom Kanan (1/3) --}}
            <div class="space-y-4">

                {{-- Card Tombol --}}
                <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
                    <div class="p-5 space-y-2.5">
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
                            <span wire:loading.remove wire:target="save" class="relative">Simpan</span>
                            <span wire:loading wire:target="save" class="relative">Menyimpan...</span>
                        </button>

                        <a href="{{ route('admin.peserta.index') }}"
                           class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border border-stone-200
                                  text-stone-400 text-sm font-medium bg-white
                                  shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                  hover:text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
                                  transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Info Card --}}
                @if($tipe === 'eksternal')
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-2xl p-4
                            shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                    <p class="flex items-center gap-1.5 text-xs font-bold text-orange-700 mb-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        PKL / Magang / Orientasi
                    </p>
                    <ul class="space-y-1.5">
                        <li class="flex items-start gap-2 text-[11.5px] text-orange-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-300 mt-1 flex-shrink-0"></span>
                            Login menggunakan Email & Password
                        </li>
                        <li class="flex items-start gap-2 text-[11.5px] text-orange-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-300 mt-1 flex-shrink-0"></span>
                            Absensi GPS aktif setelah akun dibuat
                        </li>
                        <li class="flex items-start gap-2 text-[11.5px] text-orange-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-300 mt-1 flex-shrink-0"></span>
                            Sertifikat di-generate saat status Selesai
                        </li>
                    </ul>
                </div>
                @else
                <div class="bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-2xl p-4
                            shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                    <p class="flex items-center gap-1.5 text-xs font-bold text-blue-700 mb-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Karyawan External
                    </p>
                    <ul class="space-y-1.5">
                        <li class="flex items-start gap-2 text-[11.5px] text-blue-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mt-1 flex-shrink-0"></span>
                            Akun <strong>tidak aktif</strong> sampai disetujui admin
                        </li>
                        <li class="flex items-start gap-2 text-[11.5px] text-blue-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mt-1 flex-shrink-0"></span>
                            Approval di halaman detail peserta
                        </li>
                        <li class="flex items-start gap-2 text-[11.5px] text-blue-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mt-1 flex-shrink-0"></span>
                            Dapat mengikuti diklat & e-learning setelah approved
                        </li>
                        <li class="flex items-start gap-2 text-[11.5px] text-blue-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mt-1 flex-shrink-0"></span>
                            Masuk rekap jam pelatihan internal
                        </li>
                    </ul>
                </div>
                @endif

            </div>
        </div>
    </form>
</div>