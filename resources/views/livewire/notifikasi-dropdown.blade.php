<div class="relative" x-data @click.outside="$wire.tutup()">

    {{-- Bell Button --}}
    <button wire:click="toggleOpen"
        class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @if($jumlahBelumBaca > 0)
        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center font-bold leading-none" style="font-size:9px">
            {{ $jumlahBelumBaca > 9 ? '9+' : $jumlahBelumBaca }}
        </span>
        @endif
    </button>

    {{-- Dropdown --}}
    @if($open)
    <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">

        {{-- Header --}}
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
            @if($jumlahBelumBaca > 0)
            <span class="text-xs px-2 py-0.5 bg-red-100 text-red-600 rounded-full font-medium">
                {{ $jumlahBelumBaca }} baru
            </span>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
            @forelse($notifikasi as $notif)
            <div class="px-4 py-3 hover:bg-gray-50 transition {{ $notif['is_new'] ? 'bg-blue-50/50' : '' }}">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                        {{ $notif['warna'] === 'blue' ? 'bg-blue-100' : 'bg-green-100' }}">
                        <span class="text-sm">{{ $notif['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-800 leading-tight">{{ $notif['judul'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $notif['waktu'] }}</p>
                    </div>
                    @if($notif['is_new'])
                    <div class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0 mt-1"></div>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                <p class="text-xs text-gray-400">Tidak ada notifikasi</p>
            </div>
            @endforelse
        </div>

    </div>
    @endif

</div>