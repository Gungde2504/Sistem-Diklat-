<div class="space-y-5">

    {{-- Back --}}
    <a href="{{ route('admin.elearning.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-stone-400 hover:text-orange-600
               hover:translate-x-[-2px] transition-all duration-200 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke E-Learning
    </a>

    {{-- Info Modul --}}
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">

        {{-- Header Orange --}}
        <div class="relative px-6 py-5 overflow-hidden"
             style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full
                                 bg-white/15 border border-white/20 text-white/80 font-medium mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        </svg>
                        {{ $modul->kategori ?? 'Umum' }}
                    </span>
                    <h2 class="text-lg font-bold text-white leading-snug">{{ $modul->judul }}</h2>
                    @if($modul->deskripsi)
                    <p class="text-white/65 text-sm mt-1.5 leading-relaxed">{{ $modul->deskripsi }}</p>
                    @endif
                </div>
                <a href="{{ route('admin.elearning.edit', $modul->id) }}"
                    class="relative flex-shrink-0 flex items-center gap-2 px-3.5 py-2 rounded-xl
                           text-xs font-semibold text-white overflow-hidden
                           border border-white/25 bg-white/15
                           shadow-[0_1px_0_rgba(255,255,255,.15)_inset]
                           hover:bg-white/25 hover:-translate-y-0.5
                           hover:shadow-[0_4px_12px_-2px_rgba(0,0,0,.2)]
                           active:scale-[.97] transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                    </svg>
                    Edit Modul
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-stone-100">
            <div class="group px-5 py-4 text-center hover:bg-stone-50/60 transition-all duration-200">
                <div class="flex items-center justify-center mb-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-[10.5px] text-stone-400 font-medium ml-1">Durasi</p>
                </div>
                <p class="text-base font-bold text-stone-700">{{ $modul->estimasi_durasi_jam }} jam</p>
            </div>
            <div class="group px-5 py-4 text-center hover:bg-green-50/40 transition-all duration-200">
                <div class="flex items-center justify-center mb-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-[10.5px] text-stone-400 font-medium ml-1">Selesai</p>
                </div>
                <p class="text-base font-bold text-green-600">{{ $totalSelesai }}</p>
            </div>
            <div class="group px-5 py-4 text-center hover:bg-orange-50/40 transition-all duration-200">
                <div class="flex items-center justify-center mb-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <p class="text-[10.5px] text-stone-400 font-medium ml-1">Sedang Belajar</p>
                </div>
                <p class="text-base font-bold text-orange-500">{{ $totalProgress }}</p>
            </div>
            <div class="group px-5 py-4 text-center hover:bg-blue-50/40 transition-all duration-200">
                <div class="flex items-center justify-center mb-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    <p class="text-[10.5px] text-stone-400 font-medium ml-1">Rata-rata Nilai</p>
                </div>
                <p class="text-base font-bold text-blue-600">{{ $rataRataNilai ? round($rataRataNilai, 1).'%' : '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 bg-white rounded-2xl border border-stone-100 p-1.5 w-fit
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_8px_-3px_rgba(120,113,108,.1)]">
        @foreach(['peserta' => ['label' => 'Peserta', 'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'], 'soal' => ['label' => 'Soal Kuis', 'icon' => 'M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z']] as $key => $item)
        <button wire:click="setTab('{{ $key }}')"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                {{ $tab === $key
                    ? 'text-white shadow-[0_2px_8px_-2px_rgba(200,61,0,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                    : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
            style="{{ $tab === $key ? 'background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
            </svg>
            {{ $item['label'] }}
        </button>
        @endforeach
    </div>

    {{-- Tab Peserta --}}
    @if($tab === 'peserta')
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-stone-100" style="background:linear-gradient(to right,#fafafa,#f5f5f4)">
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">#</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Nama</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Status</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Nilai</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($peserta as $p)
                    <tr class="group hover:bg-orange-50/20 transition-all duration-150">
                        <td class="px-5 py-4 text-sm text-stone-400 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0
                                            text-white text-xs font-bold
                                            shadow-[0_2px_6px_-1px_rgba(200,61,0,.3)]"
                                     style="background:linear-gradient(135deg,#FF8C00,#C73D00)">
                                    {{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-stone-800">{{ $p->user?->nama }}</p>
                                    <p class="text-xs text-stone-400">{{ $p->user?->nip ?? $p->user?->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full font-semibold border
                                {{ $p->status === 'completed'
                                    ? 'bg-green-50 border-green-200 text-green-700'
                                    : ($p->status === 'failed'
                                        ? 'bg-red-50 border-red-200 text-red-600'
                                        : 'bg-yellow-50 border-yellow-200 text-yellow-700') }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $p->status === 'completed' ? 'bg-green-500' : ($p->status === 'failed' ? 'bg-red-500' : 'bg-yellow-500 animate-pulse') }}">
                                </span>
                                {{ $p->status === 'completed' ? 'Selesai' : ($p->status === 'failed' ? 'Tidak Lulus' : 'Belajar') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($p->quiz_score)
                            <span class="text-sm font-bold
                                {{ $p->quiz_score >= 70 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $p->quiz_score }}%
                            </span>
                            @else
                            <span class="text-sm text-stone-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-xs text-stone-400">
                                {{ $p->completed_at?->format('d M Y') ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 bg-stone-50 border border-stone-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-stone-400">Belum ada peserta</p>
                            <p class="text-xs text-stone-300 mt-0.5">Peserta akan muncul saat mulai belajar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($peserta->hasPages())
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $peserta->links() }}
        </div>
        @endif
    </div>
    @endif

    {{-- Tab Soal --}}
    @if($tab === 'soal')
    <div class="space-y-3">
        @forelse($soals as $i => $soal)
        <div class="bg-white rounded-2xl border border-stone-100 p-5
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]
                    hover:shadow-[0_4px_16px_-4px_rgba(200,61,0,.12)] transition-all duration-200">
            <div class="flex items-start gap-3 mb-4">
                <span class="flex-shrink-0 w-7 h-7 rounded-xl flex items-center justify-center text-xs font-bold text-white
                             shadow-[0_2px_6px_-1px_rgba(200,61,0,.4)]"
                      style="background:linear-gradient(135deg,#FF8C00 0%,#C73D00 100%)">
                    {{ $i + 1 }}
                </span>
                <p class="text-sm font-semibold text-stone-800 leading-snug pt-0.5">{{ $soal->pertanyaan }}</p>
            </div>
            <div class="grid grid-cols-2 gap-2 pl-10">
                @foreach(['a' => $soal->pilihan_a, 'b' => $soal->pilihan_b, 'c' => $soal->pilihan_c, 'd' => $soal->pilihan_d] as $key => $pilihan)
                @if($pilihan)
                <div class="flex items-center gap-2 p-2.5 rounded-xl border transition-all duration-150
                    {{ $soal->jawaban_benar === $key
                        ? 'bg-green-50 border-green-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]'
                        : 'bg-stone-50 border-stone-100' }}">
                    <span class="text-xs font-bold flex-shrink-0
                        {{ $soal->jawaban_benar === $key ? 'text-green-600' : 'text-stone-400' }}">
                        {{ strtoupper($key) }}.
                    </span>
                    <span class="text-xs {{ $soal->jawaban_benar === $key ? 'text-green-700 font-medium' : 'text-stone-600' }} flex-1">
                        {{ $pilihan }}
                    </span>
                    @if($soal->jawaban_benar === $key)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-100 p-12 text-center
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 bg-stone-50 border border-stone-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-stone-400">Modul ini tidak memiliki kuis</p>
        </div>
        @endforelse
    </div>
    @endif

</div>