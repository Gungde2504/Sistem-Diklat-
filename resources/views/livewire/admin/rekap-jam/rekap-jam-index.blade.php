<div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

        {{-- Total Karyawan --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-orange-400
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(249,115,22,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-orange-500 uppercase tracking-widest">Total Karyawan</p>
                <div class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-stone-800 mb-1">{{ $totalKaryawan }}</p>
            <p class="text-xs text-stone-400">Internal + Karyawan External</p>
        </div>

        {{-- Terpenuhi --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-green-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(34,197,94,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-green-600 uppercase tracking-widest">Terpenuhi</p>
                <div class="w-8 h-8 rounded-xl bg-green-50 border border-green-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-500 mb-1">{{ $sudahTerpenuhi }}</p>
            <p class="text-xs text-stone-400">≥ {{ $target }} jam / tahun</p>
        </div>

        {{-- Belum Terpenuhi --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-red-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(239,68,68,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-red-500 uppercase tracking-widest">Belum Terpenuhi</p>
                <div class="w-8 h-8 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-red-500 mb-1">{{ $belumTerpenuhi }}</p>
            <p class="text-xs text-stone-400">< {{ $target }} jam / tahun</p>
        </div>

        {{-- Rata-rata Jam --}}
        <div class="bg-white rounded-2xl p-5 border border-stone-200 border-l-4 border-l-blue-500
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:-translate-y-1 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_28px_-6px_rgba(59,130,246,.2)]
                    transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10.5px] font-bold text-blue-500 uppercase tracking-widest">Rata-rata Jam</p>
                <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-blue-500 mb-1">{{ $rataRataJam }}</p>
            <p class="text-xs text-stone-400">jam / karyawan</p>
        </div>

    </div>

    {{-- Progress Bar Overall --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5 mb-5
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        @php $pct = $totalKaryawan > 0 ? round(($sudahTerpenuhi / $totalKaryawan) * 100) : 0; @endphp
        <div class="flex items-center justify-between mb-2.5">
            <p class="text-sm font-semibold text-stone-700">Progress Keseluruhan Tahun {{ $tahun }}</p>
            <span class="text-sm font-bold px-2.5 py-0.5 rounded-full
                         {{ $pct >= 90 ? 'bg-green-50 text-green-600 border border-green-200' :
                            ($pct >= 50 ? 'bg-yellow-50 text-yellow-600 border border-yellow-200' :
                            'bg-red-50 text-red-500 border border-red-200') }}">
                {{ $pct }}%
            </span>
        </div>
        <div class="w-full bg-stone-100 rounded-full h-3 overflow-hidden">
            <div class="h-3 rounded-full transition-all duration-700
                        {{ $pct >= 90 ? 'bg-green-500' : ($pct >= 50 ? 'bg-yellow-400' : 'bg-red-400') }}"
                 style="width:{{ $pct }}%">
            </div>
        </div>
        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-stone-400">
                <span class="font-semibold text-stone-600">{{ $sudahTerpenuhi }}</span>
                dari
                <span class="font-semibold text-stone-600">{{ $totalKaryawan }}</span>
                karyawan telah memenuhi target
                <span class="font-semibold text-stone-600">{{ $target }} jam</span>
            </p>
            <p class="text-xs text-blue-500 font-medium flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                Jika &lt; {{ $target }}j → jam e-learning otomatis dihitung
            </p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4 mb-5
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

            {{-- Search --}}
            <div class="relative lg:col-span-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama / NIK..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200"/>
            </div>

            {{-- Filter Unit --}}
            <div class="relative">
                <select wire:model.live="unit"
                    class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="">Semua Unit</option>
                    @foreach($units as $u)
                    <option value="{{ $u->slug }}">{{ $u->nama }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            {{-- Filter Tahun --}}
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

            {{-- Filter Tipe --}}
            <div class="relative">
                <select wire:model.live="tipe"
                    class="w-full px-3.5 py-2.5 pr-9 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="semua">Semua Tipe</option>
                    <option value="internal">Internal</option>
                    <option value="karyawan">Karyawan External</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

        </div>

        {{-- Filter Status Toggle --}}
        <div class="flex gap-1 bg-stone-100 rounded-xl p-1 mt-3">
            @foreach([
                'semua'     => ['label' => 'Semua',                     'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z', 'color' => 'text-stone-400'],
                'terpenuhi' => ['label' => 'Terpenuhi',                  'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              'color' => 'text-green-500'],
                'kurang'    => ['label' => 'Kurang dari '.$target.'j',   'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z',                                                                                                                                                                                                                                                                                                                                                                                              'color' => 'text-red-400'],
            ] as $val => $item)
            <button wire:click="$set('filter', '{{ $val }}')"
                class="flex-1 flex items-center justify-center gap-1.5 text-xs font-medium py-1.5 rounded-lg transition-all duration-200
                       {{ $filter === $val
                           ? 'bg-white shadow-sm text-stone-800 shadow-stone-200/80'
                           : 'text-stone-500 hover:text-stone-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 {{ $item['color'] }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
            </button>
            @endforeach
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
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Karyawan</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Unit / Tipe</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Acara</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Mandiri</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">E-Learning</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Total Jam</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Progress</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($rekaps as $r)
                    <tr class="transition-colors duration-150
                               {{ !$r['terpenuhi'] ? 'bg-red-50/30 hover:bg-red-50/50' : 'hover:bg-stone-50/70' }}">

                        {{-- Karyawan --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                @if($r['is_karyawan'])
                                <span class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0 text-[8px] font-bold text-white"
                                      style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">K</span>
                                @else
                                <span class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0 text-[8px] font-bold text-white"
                                      style="background:linear-gradient(135deg,#FB923C,#EA580C)">I</span>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-stone-800">{{ $r['user']->nama }}</p>
                                    <p class="text-xs text-stone-400 mt-0.5">{{ $r['is_karyawan'] ? $r['user']->detailEksternal?->institusi : ('NIK: '.($r['user']->nip ?? '-')) }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Unit / Tipe --}}
                        <td class="px-5 py-4">
                            <p class="text-sm text-stone-600">{{ $r['user']->unit ?? '-' }}</p>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-full font-semibold
                                {{ $r['is_karyawan'] ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-orange-50 text-orange-600 border border-orange-200' }}">
                                {{ $r['is_karyawan'] ? 'Karyawan External' : 'Internal' }}
                            </span>
                        </td>

                        {{-- Jam per sumber --}}
                        <td class="px-5 py-4 text-center text-sm text-stone-700 font-medium">{{ number_format($r['jam_acara'], 1) }}j</td>
                        <td class="px-5 py-4 text-center text-sm text-stone-700 font-medium">{{ number_format($r['jam_mandiri'], 1) }}j</td>

                        {{-- E-Learning --}}
                        <td class="px-5 py-4 text-center">
                            <span class="text-sm font-medium {{ $r['jam_elearning'] > 0 ? 'text-purple-600' : 'text-stone-400' }}">
                                {{ number_format($r['jam_elearning'], 1) }}j
                            </span>
                            @if(!$r['terpenuhi'] && $r['jam_elearning'] > 0)
                            <div class="flex items-center justify-center gap-0.5 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <p class="text-[9px] text-purple-500 font-semibold">auto-dihitung</p>
                            </div>
                            @endif
                        </td>

                        {{-- Total Jam --}}
                        <td class="px-5 py-4 text-center">
                            <p class="text-lg font-bold {{ $r['terpenuhi'] ? 'text-green-600' : 'text-red-500' }}">
                                {{ number_format($r['total_jam'], 1) }}
                            </p>
                            <p class="text-xs text-stone-400">dari {{ $target }} jam</p>
                        </td>

                        {{-- Progress Bar --}}
                        <td class="px-5 py-4 min-w-[120px]">
                            <div class="w-full bg-stone-100 rounded-full h-2 mb-1 overflow-hidden">
                                <div class="h-2 rounded-full transition-all duration-500
                                            {{ $r['terpenuhi'] ? 'bg-green-500' : 'bg-red-400' }}"
                                     style="width:{{ min($r['persen'], 100) }}%">
                                </div>
                            </div>
                            <p class="text-xs text-stone-400 text-center">{{ $r['persen'] }}%</p>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">
                            @if($r['terpenuhi'])
                            <span class="inline-flex items-center gap-1 text-[10.5px] px-2.5 py-1 rounded-full font-semibold
                                         bg-green-50 text-green-700 border border-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Terpenuhi
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-[10.5px] px-2.5 py-1 rounded-full font-semibold
                                         bg-red-50 text-red-600 border border-red-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                Kurang {{ number_format($r['kekurangan'], 1) }}j
                            </span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-stone-500">Tidak ada data karyawan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50 flex items-center justify-between">
            <p class="text-xs text-stone-400">
                Menampilkan
                <span class="font-semibold text-stone-600">{{ $rekaps->count() }}</span>
                dari
                <span class="font-semibold text-stone-600">{{ $totalItems }}</span>
                karyawan
            </p>

            @if($totalPages > 1)
            <div class="flex items-center gap-1.5">
                @if($currentPage > 1)
                <button wire:click="previousPage"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                           bg-white border border-stone-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                @else
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                             bg-stone-50 border border-stone-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </span>
                @endif

                <span class="inline-flex items-center justify-center px-3.5 h-9 rounded-xl text-sm font-bold text-white
                             shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
                      style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
                    {{ $currentPage }} / {{ $totalPages }}
                </span>

                @if($currentPage < $totalPages)
                <button wire:click="nextPage"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-600
                           bg-white border border-stone-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 hover:-translate-y-px
                           transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                @else
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm text-stone-300
                             bg-stone-50 border border-stone-200 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
                @endif
            </div>
            @endif
        </div>

    </div>

</div>