<div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 bg-green-100 border border-green-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 bg-red-100 border border-red-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- ── HEADER BANNER ── --}}
    <div class="relative overflow-hidden rounded-2xl px-6 py-5 mb-5 text-white
                shadow-[0_4px_24px_-4px_rgba(200,61,0,.4),0_1px_0_rgba(255,255,255,.15)_inset]"
         style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">

        {{-- Shine overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
        {{-- Decorative circles --}}
        <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-white/[.06] pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-28 h-28 rounded-full bg-white/[.04] pointer-events-none"></div>
        <div class="absolute top-1/2 right-24 -translate-y-1/2 w-16 h-16 rounded-full bg-white/[.04] pointer-events-none"></div>

        <div class="relative flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                {{-- Badges --}}
                <div class="flex items-center gap-2 mb-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 text-[10.5px] font-semibold px-2.5 py-1 rounded-full
                                 bg-white/20 border border-white/25 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Karyawan External
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[10.5px] font-semibold px-2.5 py-1 rounded-full
                                 bg-white/15 border border-white/25 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        </svg>
                        {{ \App\Models\DetailEksternal::jenisOptions()[$detail->jenis] ?? $detail->jenis }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[10.5px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm
                        {{ $detail->approval_status === 'approved'
                            ? 'bg-green-400/25 text-green-100 border border-green-400/35'
                            : ($detail->approval_status === 'pending'
                                ? 'bg-yellow-400/25 text-yellow-100 border border-yellow-400/35'
                                : 'bg-red-400/25 text-red-100 border border-red-400/35') }}">
                        @if($detail->approval_status === 'approved')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        @elseif($detail->approval_status === 'pending')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        @endif
                        {{ ucfirst($detail->approval_status) }}
                    </span>
                </div>

                {{-- Nama & Info --}}
                <h2 class="text-xl font-bold text-white tracking-tight leading-tight mb-1">{{ $detail->user?->nama }}</h2>
                <div class="flex items-center gap-1.5 mb-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <p class="text-white/65 text-sm">{{ $detail->user?->email }}</p>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21 3 3l18 9-18 9Zm0 0 10.5-4.5" />
                    </svg>
                    <p class="text-white/45 text-xs">{{ $detail->institusi }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                @if($detail->approval_status === 'pending')
                <button wire:click="approve" wire:confirm="Setujui karyawan ini?"
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
                           bg-green-400/20 text-green-100 border border-green-400/30 backdrop-blur-sm
                           hover:bg-green-400/35 hover:-translate-y-px active:scale-95
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Setujui
                </button>
                <button wire:click="reject" wire:confirm="Tolak karyawan ini?"
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
                           bg-red-400/20 text-red-100 border border-red-400/30 backdrop-blur-sm
                           hover:bg-red-400/35 hover:-translate-y-px active:scale-95
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Tolak
                </button>
                @endif
                <a href="{{ route('admin.peserta.index') }}"
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
                           bg-black/15 text-white/70 border border-white/20 backdrop-blur-sm
                           hover:bg-black/25 hover:-translate-y-px active:scale-95
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Stats 3 sejajar --}}
        <div class="relative grid grid-cols-3 gap-3 mt-5">
            <div class="bg-white/10 border border-white/15 rounded-xl p-3 text-center backdrop-blur-sm
                        hover:bg-white/15 transition-all duration-200">
                <div class="flex items-center justify-center gap-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-[10px] text-white/60">Jam Pelatihan</p>
                </div>
                <p class="text-2xl font-bold text-white">{{ round($totalJamPelatihan / 60, 1) }}<span class="text-sm font-medium text-white/60">j</span></p>
            </div>
            <div class="bg-white/10 border border-white/15 rounded-xl p-3 text-center backdrop-blur-sm
                        hover:bg-white/15 transition-all duration-200">
                <div class="flex items-center justify-center gap-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    <p class="text-[10px] text-white/60">E-Learning</p>
                </div>
                <p class="text-2xl font-bold text-white">{{ $totalCompleted }}<span class="text-sm font-medium text-white/60">/{{ $totalElearning }}</span></p>
            </div>
            <div class="bg-white/10 border border-white/15 rounded-xl p-3 text-center backdrop-blur-sm
                        hover:bg-white/15 transition-all duration-200">
                <div class="flex items-center justify-center gap-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <p class="text-[10px] text-white/60">Total Pelatihan</p>
                </div>
                <p class="text-2xl font-bold text-white">{{ $totalAbsensi }}</p>
            </div>
        </div>
    </div>

    {{-- ── DATA KARYAWAN ── --}}
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden mb-5
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full"
                 style="background:linear-gradient(180deg,#FF8C00,#C73D00)"></div>
            <h3 class="text-sm font-semibold text-stone-800">Data Karyawan</h3>
            <a href="{{ route('admin.peserta.edit', $detail->id) }}"
                class="ml-auto flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold
                       text-orange-600 bg-orange-50 border border-orange-200
                       hover:bg-orange-100 hover:-translate-y-px active:scale-95
                       transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
                Edit
            </a>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach([
                ['label' => 'Nama Lengkap',     'value' => $detail->user?->nama],
                ['label' => 'Email',             'value' => $detail->user?->email],
                ['label' => 'No. HP',            'value' => $detail->user?->hp ?? '-'],
                ['label' => 'Alamat Domisili',   'value' => $detail->user?->alamat ?? '-'],
                ['label' => 'Jenis',             'value' => \App\Models\DetailEksternal::jenisOptions()[$detail->jenis] ?? $detail->jenis],
                ['label' => 'Perusahaan',        'value' => $detail->institusi],
                ['label' => 'Status',            'value' => ucfirst($detail->status),
                 'color' => $detail->status === 'aktif' ? 'text-green-600' : 'text-red-500'],
                ['label' => 'Akun Aktif',        'value' => $detail->user?->isActive ? 'Aktif' : 'Nonaktif',
                 'color' => $detail->user?->isActive ? 'text-green-600' : 'text-red-500'],
            ] as $item)
            <div class="bg-stone-50 border border-stone-100 rounded-xl p-3
                        hover:bg-orange-50/40 hover:border-orange-100
                        transition-all duration-200">
                <p class="text-[10.5px] text-stone-400 mb-0.5 uppercase tracking-wider font-medium">{{ $item['label'] }}</p>
                <p class="text-sm font-semibold {{ $item['color'] ?? 'text-stone-700' }}">{{ $item['value'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="flex gap-1.5 bg-stone-100 rounded-2xl p-1.5 mb-5">
        @foreach([
            'pelatihan' => ['label' => 'Jam Pelatihan', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            'elearning' => ['label' => 'E-Learning',    'icon' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25'],
        ] as $key => $item)
        <button wire:click="setTab('{{ $key }}')"
            class="flex-1 flex items-center justify-center gap-2 py-2 rounded-xl text-sm font-medium
                   transition-all duration-200
                   {{ $tab === $key
                       ? 'text-white font-semibold shadow-[0_2px_8px_-2px_rgba(200,61,0,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
            @if($tab === $key) style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
            </svg>
            {{ $item['label'] }}
        </button>
        @endforeach
    </div>

    {{-- ── TAB JAM PELATIHAN ── --}}
    @if($tab === 'pelatihan')
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full"
                 style="background:linear-gradient(180deg,#FF8C00,#C73D00)"></div>
            <p class="text-sm font-semibold text-stone-800">Rekap Jam Pelatihan</p>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-3 divide-x divide-stone-100 border-b border-stone-100">
            @foreach([
                ['label' => 'Hari Hadir',  'value' => $totalHadir,                            'color' => 'text-stone-800'],
                ['label' => 'Total Sesi',  'value' => $totalAbsensi,                           'color' => 'text-stone-800'],
                ['label' => 'Total Jam',   'value' => round($totalJamPelatihan / 60, 1).' jam','color' => 'text-orange-600'],
            ] as $stat)
            <div class="px-5 py-4 text-center">
                <p class="text-[11px] text-stone-400 mb-1">{{ $stat['label'] }}</p>
                <p class="text-xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background:linear-gradient(to right,#fafafa,#f5f5f4)"
                        class="border-b border-stone-100">
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Nama Pelatihan</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Tanggal</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Durasi</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-400 uppercase tracking-widest">Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($absensi as $a)
                    <tr class="hover:bg-orange-50/20 transition-colors duration-150">
                        <td class="px-5 py-3.5">
                            <p class="text-sm font-semibold text-stone-700">{{ $a->diklat?->nama ?? '-' }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">{{ $a->diklat?->jenisDiklat ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center text-sm text-stone-600">
                            {{ $a->date ? \Carbon\Carbon::parse($a->date)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($a->durasi)
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-50 text-orange-600 border border-orange-200">
                                {{ $a->durasi }} menit
                            </span>
                            @else
                            <span class="text-stone-300">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                                {{ $a->is_hadir
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : 'bg-stone-100 text-stone-500 border-stone-200' }}">
                                @if($a->is_hadir)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Hadir
                                @else
                                Terdaftar
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-14 text-center">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 bg-stone-50 border border-stone-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-stone-400">Belum ada data pelatihan</p>
                            <p class="text-xs text-stone-300 mt-0.5">Data akan muncul setelah peserta mengikuti pelatihan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $absensi->links() }}
        </div>
    </div>
    @endif

    {{-- ── TAB E-LEARNING ── --}}
    @if($tab === 'elearning')
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-400 to-purple-600"></div>
            <p class="text-sm font-semibold text-stone-800">Progress E-Learning</p>
            <span class="ml-auto text-xs px-2.5 py-1 rounded-full bg-purple-50 border border-purple-200 text-purple-600 font-semibold">
                {{ $totalCompleted }} / {{ $totalElearning }} selesai
            </span>
        </div>

        @if($totalElearning > 0)
        <div class="px-5 py-4 border-b border-stone-100">
            @php $pct = round(($totalCompleted / max($totalElearning, 1)) * 100); @endphp
            <div class="flex justify-between items-center mb-2">
                <p class="text-xs text-stone-500 font-medium">Progress Keseluruhan</p>
                <p class="text-xs font-bold text-purple-600">{{ $pct }}%</p>
            </div>
            <div class="w-full bg-stone-100 rounded-full h-2 overflow-hidden">
                <div class="h-2 rounded-full transition-all duration-700"
                     style="width:{{ $pct }}%;background:linear-gradient(90deg,#a855f7,#7c3aed)"></div>
            </div>
        </div>
        @endif

        <div class="divide-y divide-stone-50">
            @forelse($elearning as $ep)
            <div class="px-5 py-4 hover:bg-stone-50/60 transition-colors duration-150">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-stone-800 truncate">{{ $ep->modul?->judul ?? '-' }}</p>
                        <p class="text-xs text-stone-400 mt-0.5">
                            {{ $ep->modul?->kategori ?? '-' }}
                            @if($ep->modul?->estimasi_durasi_jam)
                            · {{ $ep->modul->estimasi_durasi_jam }} jam
                            @endif
                        </p>
                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                            @if($ep->started_at)
                            <span class="flex items-center gap-1 text-[10.5px] text-stone-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                </svg>
                                Mulai: {{ \Carbon\Carbon::parse($ep->started_at)->format('d M Y') }}
                            </span>
                            @endif
                            @if($ep->completed_at)
                            <span class="flex items-center gap-1 text-[10.5px] text-stone-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Selesai: {{ \Carbon\Carbon::parse($ep->completed_at)->format('d M Y') }}
                            </span>
                            @endif
                            @if($ep->quiz_score !== null)
                            <span class="flex items-center gap-1 text-[10.5px] font-semibold text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                                Nilai: {{ $ep->quiz_score }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                        {{ $ep->status === 'completed'    ? 'bg-green-50 text-green-700 border-green-200'
                        : ($ep->status === 'in_progress'  ? 'bg-blue-50 text-blue-700 border-blue-200'
                        : 'bg-red-50 text-red-600 border-red-200') }}">
                        @if($ep->status === 'completed')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Selesai
                        @elseif($ep->status === 'in_progress')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                        </svg>
                        Berlangsung
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Gagal
                        @endif
                    </span>
                </div>
            </div>
            @empty
            <div class="px-5 py-14 text-center">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 bg-stone-50 border border-stone-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-stone-400">Belum ada data e-learning</p>
                <p class="text-xs text-stone-300 mt-0.5">Data akan muncul setelah peserta mengikuti e-learning</p>
            </div>
            @endforelse
        </div>
        @if($elearning->hasPages())
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $elearning->links() }}
        </div>
        @endif
    </div>
    @endif

</div>