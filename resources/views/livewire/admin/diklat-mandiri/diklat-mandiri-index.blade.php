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

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-3 gap-4 mb-5">

        {{-- Pending --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-yellow-400
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(234,179,8,.2)]
                transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-yellow-500 uppercase tracking-widest">Pending</p>
                <div class="w-8 h-8 rounded-xl bg-yellow-50 border border-yellow-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-yellow-500 mb-1">{{ $totalPending }}</p>
            <p class="text-xs text-stone-400">Menunggu verifikasi</p>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-green-500
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(34,197,94,.2)]
                transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">Disetujui</p>
                <div class="w-8 h-8 rounded-xl bg-green-50 border border-green-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-500 mb-1">{{ $totalDisetujui }}</p>
            <p class="text-xs text-stone-400">Tahun {{ $tahun }}</p>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-red-500
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(239,68,68,.2)]
                transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-red-500 uppercase tracking-widest">Ditolak</p>
                <div class="w-8 h-8 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-red-500 mb-1">{{ $totalDitolak }}</p>
            <p class="text-xs text-stone-400">Tahun {{ $tahun }}</p>
        </div>

    </div>
    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4 mb-5
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

            {{-- Search --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama diklat / karyawan..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
            </div>

            {{-- Status --}}
            <div class="relative">
                <select wire:model.live="status"
                    class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            {{-- Tahun --}}
            <div class="relative">
                <select wire:model.live="tahun"
                    class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

        </div>
    </div>

    {{-- Tabel Card --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                transition-shadow duration-300">

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100">
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Karyawan</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Nama Diklat</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Tempat</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Durasi</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Bukti</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($pengajuan as $p)
                    <tr class="hover:bg-stone-50/70 transition-colors duration-150">

                        <td class="px-5 py-4 text-sm text-stone-400">{{ $loop->iteration }}</td>

                        {{-- Karyawan --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-stone-800">{{ $p->user?->nama }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">{{ $p->user?->nip }} · {{ $p->user?->unit }}</p>
                        </td>

                        {{-- Nama Diklat --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-stone-700">{{ $p->nama }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($p->tglJamMulai)->format('d M Y') }}
                            </p>
                        </td>

                        {{-- Tempat --}}
                        <td class="px-5 py-4 text-sm text-stone-600">{{ $p->tempat }}</td>

                        {{-- Durasi --}}
                        <td class="px-5 py-4 text-center">
                            <p class="text-sm font-semibold text-stone-800">
                                {{ \App\Helpers\RekapHelper::menitKeFormat((int) $p->durasi) }}
                            </p>
                            <p class="text-xs text-stone-400">{{ $p->durasi }} menit</p>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">
                            <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                                {{ $p->status === 'Disetujui' ? 'bg-green-50 text-green-700 border-green-200'  :
                                   ($p->status === 'Ditolak'  ? 'bg-red-50 text-red-600 border-red-200'        :
                                   'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                {{ $p->status }}
                            </span>
                        </td>

                        {{-- Bukti --}}
                        <td class="px-5 py-4 text-center">
                            @if($p->sertifikat)
                            <a href="{{ asset('storage/'.$p->sertifikat) }}" target="_blank"
                                class="inline-flex items-center gap-1 text-xs text-orange-500 font-semibold
                                      hover:text-orange-600 hover:underline transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                Lihat
                            </a>
                            @else
                            <span class="text-xs text-stone-300">—</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($p->status === 'pending')

                                {{-- Setujui --}}
                                <button wire:click="approve('{{ $p->id }}')"
                                    wire:confirm="Setujui pengajuan diklat mandiri ini?"
                                    class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold
                                           bg-gradient-to-br from-green-50 to-green-100 text-green-700
                                           border border-green-200
                                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                           hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(34,197,94,.25)]
                                           transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    Setujui
                                </button>

                                {{-- Tolak --}}
                                <button wire:click="reject('{{ $p->id }}')"
                                    wire:confirm="Tolak pengajuan diklat mandiri ini?"
                                    class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold
                                           bg-gradient-to-br from-red-50 to-red-100 text-red-600
                                           border border-red-200
                                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                           hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.25)]
                                           transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>

                                @else
                                <span class="text-xs text-stone-400 italic">Sudah diproses</span>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-stone-500">Tidak ada pengajuan diklat mandiri</p>
                                    <p class="text-xs text-stone-400 mt-0.5">Pengajuan akan muncul setelah karyawan mengajukan</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $pengajuan->links() }}
        </div>

    </div>

</div>