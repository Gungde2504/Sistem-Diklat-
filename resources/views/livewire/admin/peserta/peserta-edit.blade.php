<div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @php
        $isKaryawanEdit = in_array($editJenis, ['karyawan_iss','karyawan_bss','karyawan_adidaya','karyawan_bayi_tabung','karyawan_koperasi','karyawan_lotus_spa']);
    @endphp

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
                        <input wire:model="editNama" type="text" placeholder="Nama lengkap peserta"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('editNama') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input wire:model="editEmail" type="email" placeholder="email@institusi.com"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('editEmail') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">No. HP</label>
                        <input wire:model="editHp" type="text" placeholder="08xxxxxxxxxx"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                    </div>
                </div>
            </div>

            {{-- Card Data Kegiatan PKL/Magang/Orientasi --}}
            @if(!$isKaryawanEdit)
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
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Jenis Kegiatan <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select wire:model="editJenis"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                <option value="pkl">PKL</option>
                                <option value="magang">Magang</option>
                                <option value="orientasi">Orientasi</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                        @error('editJenis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Status <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select wire:model="editStatus"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Institusi / Universitas <span class="text-red-400">*</span></label>
                        <input wire:model="editInstitusi" type="text" placeholder="Nama institusi asal"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('editInstitusi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Unit Penempatan</label>
                        <div class="relative">
                            <select wire:model="editIdUnit"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tanggal Mulai <span class="text-red-400">*</span></label>
                        <input wire:model="editTanggalMulai" type="date"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('editTanggalMulai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Tanggal Selesai <span class="text-red-400">*</span></label>
                        <input wire:model="editTanggalSelesai" type="date"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('editTanggalSelesai') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>
            @endif

            {{-- Card Data Karyawan External --}}
            @if($isKaryawanEdit)
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

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Status <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select wire:model="editStatus"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-700 outline-none appearance-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-2">Penempatan <span class="text-red-400">*</span></label>
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
                                          {{ $editJenis === $value
                                              ? 'border-blue-400 bg-blue-50 shadow-sm'
                                              : 'border-stone-200 bg-stone-50 hover:border-blue-300 hover:bg-blue-50/50' }}">
                                <input type="radio" wire:model.live="editJenis" value="{{ $value }}" class="accent-blue-600 flex-shrink-0">
                                <span class="text-xs font-semibold text-stone-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('editJenis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
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
                    <button wire:click="simpan" wire:loading.attr="disabled"
                        class="relative w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-none cursor-pointer
                               text-white text-sm font-bold overflow-hidden
                               shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                               hover:-translate-y-0.5 hover:scale-[1.02]
                               hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                               active:scale-[.97] disabled:opacity-50 disabled:cursor-not-allowed
                               transition-all duration-200"
                        style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
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
                        <span wire:loading.remove wire:target="simpan" class="relative">Simpan Perubahan</span>
                        <span wire:loading wire:target="simpan" class="relative">Menyimpan...</span>
                    </button>

                    <a href="{{ route('admin.peserta.detail', $detail->id) }}"
                       class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border border-stone-200
                              text-stone-400 text-sm font-medium bg-white
                              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                              hover:text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
                              transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali ke Detail
                    </a>

                    <a href="{{ route('admin.peserta.index') }}"
                       class="w-full flex items-center justify-center gap-2 py-2.5 rounded-2xl border border-stone-200
                              text-stone-400 text-sm font-medium bg-white
                              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                              hover:text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:-translate-y-px
                              transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Daftar Peserta
                    </a>
                </div>
            </div>

            {{-- Info Card --}}
            @if(!$isKaryawanEdit)
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-2xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                <p class="flex items-center gap-1.5 text-xs font-bold text-orange-700 mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    Catatan Edit
                </p>
                <ul class="space-y-1.5">
                    @foreach([
                        'Password tidak dapat diubah di sini',
                        'Perubahan email mempengaruhi login peserta',
                        'Ubah status ke Selesai untuk generate sertifikat',
                        'Data absensi tidak terpengaruh',
                    ] as $tip)
                    <li class="flex items-start gap-2 text-[11.5px] text-orange-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-300 mt-1 flex-shrink-0"></span>
                        {{ $tip }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-2xl p-4
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                <p class="flex items-center gap-1.5 text-xs font-bold text-blue-700 mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    Catatan Edit Karyawan
                </p>
                <ul class="space-y-1.5">
                    @foreach([
                        'Password tidak dapat diubah di sini',
                        'Perubahan email mempengaruhi login karyawan',
                        'Approval tidak dapat diubah di sini',
                        'Gunakan tombol di halaman detail untuk approve/reject',
                    ] as $tip)
                    <li class="flex items-start gap-2 text-[11.5px] text-blue-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mt-1 flex-shrink-0"></span>
                        {{ $tip }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Info Peserta --}}
            <div class="bg-white rounded-2xl border border-stone-200 p-4
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
                <p class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-3">Info Saat Ini</p>
                <div class="space-y-2">
                    @foreach([
                        ['label' => 'Nama',      'value' => $detail->user?->nama],
                        ['label' => 'Email',     'value' => $detail->user?->email],
                        ['label' => 'Jenis',     'value' => ucfirst(str_replace('_', ' ', $detail->jenis))],
                        ['label' => 'Status',    'value' => ucfirst($detail->status)],
                    ] as $item)
                    <div class="flex items-center justify-between py-1.5 border-b border-stone-50">
                        <span class="text-[11px] text-stone-400">{{ $item['label'] }}</span>
                        <span class="text-xs font-medium text-stone-700 text-right max-w-32 truncate">{{ $item['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>