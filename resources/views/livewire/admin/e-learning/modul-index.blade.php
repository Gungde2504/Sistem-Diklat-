<div class="space-y-5">

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-gray-800 tracking-tight">Manajemen E-Learning</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola modul pembelajaran online</p>
        </div>
        <a href="{{ route('admin.elearning.create') }}"
            class="relative flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white overflow-hidden
                   shadow-[0_4px_14px_-3px_rgba(200,61,0,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                   hover:-translate-y-0.5 hover:scale-[1.02]
                   hover:shadow-[0_8px_20px_-4px_rgba(200,61,0,.55)]
                   active:scale-[.97] transition-all duration-200"
            style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="relative">Tambah Modul</span>
        </a>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari modul..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                       focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white
                       transition-all duration-200"/>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100" style="background:linear-gradient(to right, #fafafa, #f5f5f4)">
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">#</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Judul</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Durasi</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Peserta</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($moduls as $modul)
                    <tr class="group hover:bg-orange-50/30 transition-all duration-150">

                        {{-- No --}}
                        <td class="px-5 py-4 text-sm text-gray-400 font-medium">{{ $loop->iteration }}</td>

                        {{-- Judul --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $modul->judul }}</p>
                            <div class="flex items-center gap-1.5 mt-1">
                                @if($modul->adaKuis())
                                <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-purple-50 border border-purple-100 text-purple-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>
                                    Kuis · min. {{ $modul->min_quiz_score }}%
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-stone-50 border border-stone-100 text-stone-400 font-medium">
                                    Tanpa Kuis
                                </span>
                                @endif
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full font-semibold
                                         bg-blue-50 border border-blue-100 text-blue-600">
                                {{ $modul->kategori ?? '-' }}
                            </span>
                        </td>

                        {{-- Durasi --}}
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 text-xs text-stone-600 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ $modul->estimasi_durasi_jam }} jam
                            </span>
                        </td>

                        {{-- Peserta --}}
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 text-xs text-stone-600 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                {{ $modul->progress_count }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">
                            <button wire:click="togglePublish({{ $modul->id }})"
                                class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full font-semibold border transition-all duration-200
                                    {{ $modul->publish
                                        ? 'bg-green-50 border-green-200 text-green-700 hover:bg-green-100 hover:shadow-[0_2px_8px_-2px_rgba(34,197,94,.3)]'
                                        : 'bg-stone-50 border-stone-200 text-stone-500 hover:bg-stone-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $modul->publish ? 'bg-green-500' : 'bg-stone-400' }}"></span>
                                {{ $modul->publish ? 'Published' : 'Draft' }}
                            </button>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1.5">

                                {{-- Detail --}}
                                <a href="{{ route('admin.elearning.show', $modul->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                                           bg-gradient-to-br from-stone-50 to-stone-100 text-stone-500
                                           border border-stone-200
                                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                           hover:-translate-y-0.5 hover:scale-105
                                           hover:shadow-[0_4px_10px_-2px_rgba(120,113,108,.25)]
                                           transition-all duration-200"
                                    title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.elearning.edit', $modul->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                                           bg-gradient-to-br from-blue-50 to-blue-100 text-blue-500
                                           border border-blue-200
                                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                           hover:-translate-y-0.5 hover:scale-105
                                           hover:shadow-[0_4px_10px_-2px_rgba(59,159,209,.3)]
                                           transition-all duration-200"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                    </svg>
                                </a>

                                {{-- Hapus --}}
                                <button
                                    @click="$store.deleteModal.show(
                                        'Hapus Modul',
                                        'Yakin ingin menghapus modul &quot;{{ addslashes($modul->judul) }}&quot;?',
                                        () => $wire.hapus({{ $modul->id }})
                                    )"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                                           bg-gradient-to-br from-red-50 to-red-100 text-red-500
                                           border border-red-200
                                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                           hover:-translate-y-0.5 hover:scale-105
                                           hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.3)]
                                           transition-all duration-200"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3
                                        bg-stone-50 border border-stone-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-stone-400">Belum ada modul e-learning</p>
                            <p class="text-xs text-stone-300 mt-0.5">Klik tombol Tambah Modul untuk memulai</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($moduls->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-stone-50/50">
            {{ $moduls->links() }}
        </div>
        @endif
    </div>

</div>