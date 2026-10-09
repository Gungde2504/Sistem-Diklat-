<div class="space-y-4 lg:max-w-5xl lg:mx-auto">

    {{-- ── HEADER PROFIL (gaya sama seperti Peserta Eksternal) ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
        <div class="px-6 py-8 flex flex-col items-center text-center"
             style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mb-3
                        bg-white/20 border-2 border-white/40 shadow-lg">
                <span class="text-white font-bold text-2xl">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                </span>
            </div>
            <p class="text-white font-bold text-lg">{{ auth()->user()->nama }}</p>
            <p class="text-white/70 text-sm">{{ auth()->user()->email }}</p>
            <div class="mt-2 flex items-center gap-2">
                <span class="text-xs px-3 py-1 rounded-full bg-white/20 text-white font-medium capitalize">
                    {{ $profesi ?: 'Pegawai' }}
                </span>
                @if($jabatan)
                <span class="text-xs px-3 py-1 rounded-full font-medium bg-white/20 text-white/80">
                    {{ $jabatan }}
                </span>
                @endif
            </div>
        </div>

        {{-- Info Detail --}}
        <div class="grid grid-cols-2 divide-x divide-stone-100 border-t border-stone-100">
            <div class="px-5 py-4 text-center">
                <p class="text-xs text-stone-400 mb-1">NIK / NIP</p>
                <p class="text-sm font-semibold text-stone-800">{{ $nip ?: '-' }}</p>
            </div>
            <div class="px-5 py-4 text-center">
                <p class="text-xs text-stone-400 mb-1">Unit</p>
                <p class="text-sm font-semibold text-stone-800">{{ $unit ?: '-' }}</p>
            </div>
        </div>
    </div>

    {{-- ── GRID: kiri = form aktif, kanan = menu (sejajar di desktop) ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-5 lg:items-start gap-4">

        {{-- ══════════ KOLOM KIRI ══════════ --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- ── TAB SWITCH ── --}}
            <div class="bg-white rounded-2xl border border-stone-100 p-1.5 flex gap-1.5
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
                <button wire:click="setTab('profil')"
                    class="flex-1 py-2 rounded-xl text-xs font-bold transition-all duration-200
                           {{ $tab === 'profil' ? 'text-white shadow-[0_3px_10px_-2px_rgba(15,79,122,.4)]' : 'text-stone-400 hover:text-stone-600' }}"
                    @if($tab === 'profil') style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)" @endif>
                    Biodata
                </button>
                <button wire:click="setTab('password')"
                    class="flex-1 py-2 rounded-xl text-xs font-bold transition-all duration-200
                           {{ $tab === 'password' ? 'text-white shadow-[0_3px_10px_-2px_rgba(234,88,12,.4)]' : 'text-stone-400 hover:text-stone-600' }}"
                    @if($tab === 'password') style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)" @endif>
                    Ganti Password
                </button>
            </div>

            @if($tab === 'profil')
            {{-- ── EDIT BIODATA ── --}}
            <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-blue-400 to-blue-600"></div>
                    <h3 class="text-sm font-semibold text-stone-800">Edit Biodata</h3>
                </div>
                <div class="p-5 space-y-4">

                    @if($profilBerhasil)
                    <div class="p-3 rounded-xl bg-green-50 border border-green-200 flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="text-xs font-medium text-green-700">Biodata berhasil disimpan.</p>
                    </div>
                    @endif

                    <div class="lg:grid lg:grid-cols-2 lg:gap-4 space-y-4 lg:space-y-0">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                            <input wire:model="nama" type="text"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Email</label>
                            <input wire:model="email" type="email"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="lg:grid lg:grid-cols-2 lg:gap-4 space-y-4 lg:space-y-0">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">No. HP</label>
                            <input wire:model="hp" type="text" placeholder="08xxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            @error('hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">NIK / NIP</label>
                            <input type="text" value="{{ $nip }}" disabled
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-100 text-stone-400 outline-none cursor-not-allowed"/>
                            <p class="text-xs text-stone-400 mt-1">NIK/NIP tidak dapat diubah sendiri</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Unit</label>
                            <input wire:model="unit" type="text" placeholder="Mis. IGD"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            @error('unit') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Profesi</label>
                            <input wire:model="profesi" type="text" placeholder="Mis. Perawat"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            @error('profesi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Jabatan</label>
                        <input wire:model="jabatan" type="text" placeholder="Mis. Kepala Ruangan"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                        @error('jabatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Alamat</label>
                        <textarea wire:model="alamat" rows="2" placeholder="Alamat domisili / KTP"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none resize-none
                                   focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"></textarea>
                        @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button wire:click="simpanProfil" wire:loading.attr="disabled"
                        class="w-full py-2.5 rounded-xl text-sm font-bold text-white transition-all duration-200
                               hover:-translate-y-0.5 active:scale-95 disabled:opacity-50
                               shadow-[0_4px_14px_-3px_rgba(15,79,122,.4)]"
                        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                        <span wire:loading.remove wire:target="simpanProfil">Simpan Perubahan</span>
                        <span wire:loading wire:target="simpanProfil">Menyimpan...</span>
                    </button>
                </div>
            </div>
            @endif

            @if($tab === 'password')
            {{-- ── GANTI PASSWORD ── --}}
            <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-500 to-orange-400"></div>
                    <h3 class="text-sm font-semibold text-stone-800">Ganti Password</h3>
                </div>
                <div class="p-5 space-y-4">

                    @if($passwordBerhasil)
                    <div class="p-3 rounded-xl bg-green-50 border border-green-200 flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="text-xs font-medium text-green-700">Password berhasil diubah.</p>
                    </div>
                    @endif

                    @if($passwordError)
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200">
                        <p class="text-xs font-medium text-red-600">{{ $passwordError }}</p>
                    </div>
                    @endif

                    <div class="lg:grid lg:grid-cols-2 lg:gap-4 space-y-4 lg:space-y-0">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Password Lama</label>
                            <input wire:model="passwordLama" type="password" placeholder="••••••••"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('passwordLama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Password Baru</label>
                            <input wire:model="passwordBaru" type="password" placeholder="Min. 8 karakter"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                            @error('passwordBaru') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                        <input wire:model="passwordKonfirmasi" type="password" placeholder="Ulangi password baru"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                        @error('passwordKonfirmasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button wire:click="gantiPassword" wire:loading.attr="disabled"
                        class="w-full py-2.5 rounded-xl text-sm font-bold text-white transition-all duration-200
                               hover:-translate-y-0.5 active:scale-95 disabled:opacity-50
                               bg-gradient-to-r from-orange-500 to-orange-600
                               shadow-[0_4px_14px_-3px_rgba(234,88,12,.4)]">
                        <span wire:loading.remove wire:target="gantiPassword">Ganti Password</span>
                        <span wire:loading wire:target="gantiPassword">Memproses...</span>
                    </button>
                </div>
            </div>
            @endif

        </div>

        {{-- ══════════ KOLOM KANAN (menu, selalu tampil) ══════════ --}}
        <div class="lg:col-span-1">
             {{-- ── MENU SHORTCUT ── --}}
            <div class="bg-white rounded-2xl border border-stone-100 p-4
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
                <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Menu Lainnya</p>
                <div class="space-y-1.5">

                    {{-- E-Learning --}}
                    <a href="{{ route('pegawai.elearning') }}"
                        class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent
                               hover:bg-purple-50/60 hover:border-purple-100 hover:translate-x-1
                               transition-all duration-200">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                                    shadow-[0_2px_6px_-1px_rgba(147,51,234,.3)]
                                    group-hover:scale-105 group-hover:-rotate-3 transition-all duration-200
                                    bg-gradient-to-br from-purple-400 to-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-stone-800 group-hover:text-purple-700 transition-colors duration-200">E-Learning</p>
                            <p class="text-xs text-stone-400">Akses modul pembelajaran</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-purple-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Diklat Mandiri --}}
                    <a href="{{ route('pegawai.diklat-mandiri') }}"
                        class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent
                               hover:bg-orange-50/60 hover:border-orange-100 hover:translate-x-1
                               transition-all duration-200">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                                    shadow-[0_2px_6px_-1px_rgba(234,88,12,.3)]
                                    group-hover:scale-105 group-hover:-rotate-3 transition-all duration-200"
                             style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-stone-800 group-hover:text-orange-600 transition-colors duration-200">Diklat Mandiri</p>
                            <p class="text-xs text-stone-400">Ajukan & pantau pengajuan</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-orange-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>
