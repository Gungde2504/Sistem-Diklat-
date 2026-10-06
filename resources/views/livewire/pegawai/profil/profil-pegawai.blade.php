<div class="space-y-4">

    {{-- ── HEADER PROFIL ── --}}
    <div class="rounded-2xl p-5 text-white relative overflow-hidden
                shadow-[0_4px_20px_-4px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.15)_inset]"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
        <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-white/[.05] pointer-events-none"></div>
        <div class="absolute -bottom-6 -left-6 w-20 h-20 rounded-full bg-white/[.04] pointer-events-none"></div>

        <div class="relative flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0
                        bg-white/20 border border-white/30 backdrop-blur-sm
                        shadow-[0_4px_14px_rgba(0,0,0,.15),0_1px_0_rgba(255,255,255,.15)_inset]">
                <span class="text-2xl font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-bold tracking-tight truncate">{{ auth()->user()->nama }}</h2>
                <p class="text-white/65 text-sm mt-0.5">{{ auth()->user()->profesi ?? 'Pegawai' }}</p>
                <div class="flex items-center gap-1.5 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.17-.789 3.376 3.376 0 0 1 6.34 0Z" />
                    </svg>
                    <p class="text-white/45 text-xs">NIK: {{ auth()->user()->nip ?? '-' }} · {{ auth()->user()->unit ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

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
