<div class="space-y-5 max-w-lg mx-auto">

    {{-- Alert --}}
    @if($message)
    <div class="p-4 rounded-2xl flex items-center gap-3 border
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
        <p class="text-sm font-medium {{ $messageType === 'success' ? 'text-green-700' : 'text-red-700' }}">{{ $message }}</p>
        <button wire:click="$set('message', '')" class="ml-auto text-stone-400 hover:text-stone-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Avatar & Info --}}
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
                    {{ $detail?->jenis ?? 'Eksternal' }}
                </span>
                <span class="text-xs px-3 py-1 rounded-full font-medium
                    {{ $detail?->status === 'aktif' ? 'bg-green-400/30 text-green-100' : 'bg-white/20 text-white/80' }}">
                    {{ ucfirst($detail?->status ?? '-') }}
                </span>
            </div>
        </div>

        {{-- Info Detail --}}
        @if($detail)
        <div class="grid grid-cols-2 divide-x divide-stone-100 border-t border-stone-100">
            <div class="px-5 py-4 text-center">
                <p class="text-xs text-stone-400 mb-1">Institusi</p>
                <p class="text-sm font-semibold text-stone-800">{{ $detail->institusi ?? '-' }}</p>
            </div>
            <div class="px-5 py-4 text-center">
                <p class="text-xs text-stone-400 mb-1">Periode</p>
                <p class="text-sm font-semibold text-stone-800">
                    {{ $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y') : '-' }}
                </p>
            </div>
        </div>
        @endif
    </div>

    {{-- Edit Profil --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full" style="background:linear-gradient(180deg,#3B9FD1,#0F5A8C)"></div>
            <h3 class="text-sm font-semibold text-stone-800">Edit Profil</h3>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                <input wire:model="nama" type="text"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Email</label>
                <input type="text" value="{{ auth()->user()->email }}" disabled
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-100 text-stone-400 outline-none cursor-not-allowed"/>
                <p class="text-xs text-stone-400 mt-1">Email tidak dapat diubah</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">No. HP</label>
                <input wire:model="hp" type="text" placeholder="08xxxxxxxxxx"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
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

    {{-- Ganti Password --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-500 to-orange-400"></div>
            <h3 class="text-sm font-semibold text-stone-800">Ganti Password</h3>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Password Lama</label>
                <input wire:model="passwordLama" type="password" placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
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
                <input wire:model="konfirmasi" type="password" placeholder="Ulangi password baru"
                    class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
                @error('konfirmasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
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
</div>