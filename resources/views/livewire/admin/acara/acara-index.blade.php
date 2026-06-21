<div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Header & Tombol Tambah --}}
    <div class="flex items-center justify-between mb-5">

        {{-- Total Card --}}
        <div class="relative flex items-center gap-3 px-4 py-3 rounded-2xl overflow-hidden
                    shadow-[0_6px_20px_-4px_rgba(234,88,12,.35)]"
            style="background:linear-gradient(135deg,#F97316 0%,#EA580C 55%,#C2410C 100%)">
            <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full bg-white/[.08] pointer-events-none"></div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                        bg-white/20 border border-white/35 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,.95)">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <div class="relative">
                <div class="text-xl font-bold text-white leading-none">{{ $acaras->total() }}</div>
                <div class="text-[11px] text-white/80 mt-0.5">Acara Terdaftar</div>
            </div>
        </div>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.acara.create') }}"
            class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl text-sm font-semibold text-white overflow-hidden
                  shadow-[0_4px_14px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.2)_inset]
                  hover:-translate-y-0.5 hover:scale-[1.02] hover:shadow-[0_8px_22px_-4px_rgba(234,88,12,.5)]
                  active:scale-[.97] transition-all duration-200"
            style="background:linear-gradient(135deg,#F97316,#EA580C)">
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="relative">Tambah Acara</span>
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4 mb-5
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama acara..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl
                           bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                           transition-all duration-200" />
            </div>
            <select wire:model.live="status"
                class="w-full px-4 py-2.5 text-sm border border-stone-200 rounded-xl
                       bg-stone-50 text-stone-600 outline-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                       transition-all duration-200">
                <option value="">Semua Status</option>
                <option value="Draft">Draft</option>
                <option value="Terbuka">Terbuka</option>
                <option value="Berlangsung">Berlangsung</option>
                <option value="Selesai">Selesai</option>
            </select>
            <select wire:model.live="jenis"
                class="w-full px-4 py-2.5 text-sm border border-stone-200 rounded-xl
                       bg-stone-50 text-stone-600 outline-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                       transition-all duration-200">
                <option value="">Semua Jenis</option>
                <option value="Diklat Internal">Diklat Internal</option>
                <option value="Diklat Eksternal">Diklat Eksternal</option>
                <option value="Seminar">Seminar</option>
            </select>
        </div>
    </div>

    {{-- Grid Card --}}
    @if($acaras->isEmpty())
    <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center
                shadow-[0_2px_12px_-4px_rgba(120,113,108,.1)]">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-stone-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>
        <p class="text-sm text-stone-400 font-medium mb-2">Belum ada acara</p>
        <a href="{{ route('admin.acara.create') }}" class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition-colors">+ Tambah acara pertama</a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($acaras as $index => $acara)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]
                    hover:-translate-y-1.5 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_16px_36px_-8px_rgba(100,94,90,.18)]
                    transition-all duration-300">

            {{-- Sampul --}}
            <div class="relative aspect-video overflow-hidden"
                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">

                @if($acara->img)
                <img src="{{ asset('storage/'.$acara->img) }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-400" />
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white/25" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                @endif

                {{-- Badge Status --}}
                <div class="absolute top-2.5 left-2.5">
                    <span class="text-[10.5px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm border border-white/25 leading-relaxed
                        {{ $acara->status === 'Berlangsung' ? 'bg-green-500/82 text-white'  :
                           ($acara->status === 'Terbuka'    ? 'bg-blue-500/82 text-white'   :
                           ($acara->status === 'Selesai'    ? 'bg-black/45 text-white'      :
                           'bg-yellow-500/85 text-white')) }}">
                        {{ $acara->status }}
                    </span>
                </div>

                {{-- Toggle QR --}}
                <div class="absolute top-2.5 right-2.5">
                    <button wire:click="toggleQr({{ $acara->id }})"
                        class="flex items-center gap-1.5 text-[10.5px] font-bold px-2.5 py-1 rounded-full
                               border border-white/28 backdrop-blur-sm leading-relaxed transition-colors duration-200
                               {{ $acara->IsActive ? 'bg-green-500/82 text-white' : 'bg-black/45 text-white/75' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $acara->IsActive ? 'bg-white' : 'bg-gray-400' }}"></span>
                        QR
                    </button>
                </div>

                {{-- Badge Jenis --}}
                <div class="absolute bottom-2.5 left-2.5">
                    <span class="text-[10px] font-semibold px-2.5 py-1 rounded-full leading-relaxed
                                 bg-black/42 text-white backdrop-blur-sm border border-white/18">
                        {{ $acara->jenisDiklat }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-4">
                <h3 class="text-sm font-bold text-stone-800 mb-1.5 truncate">{{ $acara->nama }}</h3>
                <p class="flex items-center gap-1.5 text-xs text-stone-500 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    {{ $acara->namaNarasumber }}
                </p>
                <p class="flex items-center gap-1.5 text-xs text-stone-400 mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0z" />
                    </svg>
                    {{ $acara->tempat }}
                </p>

                <div class="flex items-center justify-between text-xs text-stone-500 py-2.5 my-2.5 border-y border-stone-100">
                    <span>📅 {{ \Carbon\Carbon::parse($acara->tglJamMulai)->format('d M Y') }}</span>
                    <span class="{{ $acara->absensiDiklats()->count() >= $acara->kuota ? 'text-red-500 font-bold' : '' }}">
                        👥 {{ $acara->absensiDiklats()->count() }}/{{ $acara->kuota }}
                    </span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2">

                    {{-- Detail --}}
                    <a href="{{ route('admin.acara.detail', $acara->id) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold
                              bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600
                              border border-orange-200
                              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                              hover:from-orange-100 hover:to-orange-200 hover:-translate-y-0.5
                              hover:shadow-[0_5px_14px_-3px_rgba(234,88,12,.25)]
                              transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Detail
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route('admin.acara.edit', $acara->id) }}"
                        class="w-9 h-9 flex items-center justify-center rounded-xl
                              bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-600
                              border border-yellow-200
                              shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                              hover:-translate-y-0.5 hover:rotate-6
                              hover:shadow-[0_5px_12px_-3px_rgba(202,138,4,.3)]
                              transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </a>

                    {{-- Delete --}}
                    <button
                                                @click="$store.deleteModal.show(
                                'Hapus Acara',
                                'Yakin ingin menghapus acara &quot;{{ addslashes($acara->nama) }}&quot;?',
                                () => $wire.delete({{ $acara->id }})
                            )"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl
                                bg-gradient-to-br from-red-50 to-red-100 text-red-500
                                border border-red-200
                                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                hover:-translate-y-0.5 hover:scale-105
                                hover:shadow-[0_5px_12px_-3px_rgba(239,68,68,.3)]
                                transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($acaras->hasPages())
    <div class="mt-5">{{ $acaras->links() }}</div>
    @endif
    @endif

</div>