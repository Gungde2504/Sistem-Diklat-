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

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            {{-- Total Pending Badge --}}
            @if($totalPending > 0)
            <div class="relative flex items-center gap-2 px-3 py-2 rounded-2xl
                        bg-yellow-50 border border-yellow-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="text-xs font-bold text-yellow-700">{{ $totalPending }} menunggu persetujuan</span>
            </div>
            @endif
        </div>
        <a href="{{ route('admin.peserta.create') }}"
            class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl text-sm font-semibold text-white overflow-hidden
                  shadow-[0_4px_14px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.2)_inset]
                  hover:-translate-y-0.5 hover:scale-[1.02]
                  hover:shadow-[0_8px_22px_-4px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                  active:scale-[.97] transition-all duration-200"
            style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="relative">Tambah Peserta</span>
        </a>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 gap-4 mb-4">

        {{-- PKL / Magang --}}
        <div class="bg-white rounded-2xl border border-stone-100 p-4 overflow-hidden relative
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]
            hover:-translate-y-0.5 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_8px_24px_-4px_rgba(249,115,22,.15)]
            transition-all duration-300">

            {{-- Decorative --}}
            <div class="absolute -top-3 -right-3 w-16 h-16 rounded-full pointer-events-none"
                style="background:radial-gradient(circle,rgba(255,140,0,.12),transparent)"></div>

            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                    shadow-[0_2px_8px_-2px_rgba(234,88,12,.35)]"
                    style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342" />
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-orange-50 border border-orange-100 text-orange-600">
                    PKL & Magang
                </span>
            </div>

            <p class="text-3xl font-bold text-stone-800 mb-0.5">{{ $totalPkl }}</p>
            <p class="text-xs text-stone-400">Total peserta terdaftar</p>

            <div class="mt-3 pt-3 border-t border-stone-100 grid grid-cols-3 gap-2">
                <div class="text-center">
                    <p class="text-sm font-bold text-green-600">{{ $totalPklAktif ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Aktif</p>
                </div>
                <div class="text-center border-x border-stone-100">
                    <p class="text-sm font-bold text-blue-600">{{ $totalPklSelesai ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-bold text-yellow-600">{{ $totalPklPending ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Pending</p>
                </div>
            </div>
        </div>

        {{-- Karyawan External --}}
        <div class="bg-white rounded-2xl border border-stone-100 p-4 overflow-hidden relative
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]
            hover:-translate-y-0.5 hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_8px_24px_-4px_rgba(249,115,22,.15)]
            transition-all duration-300">

            {{-- Decorative --}}
            <div class="absolute -top-3 -right-3 w-16 h-16 rounded-full pointer-events-none"
                style="background:radial-gradient(circle,rgba(255,140,0,.12),transparent)"></div>

            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                    shadow-[0_2px_8px_-2px_rgba(234,88,12,.35)]"
                    style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-orange-50 border border-orange-100 text-orange-600">
                    Karyawan External
                </span>
            </div>

            <p class="text-3xl font-bold text-stone-800 mb-0.5">{{ $totalKaryawan }}</p>
            <p class="text-xs text-stone-400">Total karyawan terdaftar</p>

            <div class="mt-3 pt-3 border-t border-stone-100 grid grid-cols-3 gap-2">
                <div class="text-center">
                    <p class="text-sm font-bold text-green-600">{{ $totalKaryawanAktif ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Aktif</p>
                </div>
                <div class="text-center border-x border-stone-100">
                    <p class="text-sm font-bold text-blue-600">{{ $totalKaryawanApproved ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Approved</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-bold text-yellow-600">{{ $totalKaryawanPending ?? 0 }}</p>
                    <p class="text-[10px] text-stone-400 mt-0.5">Pending</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Tab Switch --}}
    <div class="flex gap-1.5 bg-stone-100 rounded-2xl p-1.5 mb-5">
        <button wire:click="setTab('pkl')"
            class="flex-1 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-2
               {{ $tab === 'pkl'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(200,61,0,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
            @if($tab==='pkl' ) style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342" />
            </svg>
            PKL / Magang
        </button>
        <button wire:click="setTab('karyawan')"
            class="flex-1 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
               flex items-center justify-center gap-2
               {{ $tab === 'karyawan'
                   ? 'text-white shadow-[0_2px_8px_-2px_rgba(200,61,0,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                   : 'text-stone-500 hover:text-stone-700 hover:bg-stone-50' }}"
            @if($tab==='karyawan' ) style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)" @endif>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            Karyawan External
        </button>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-4 mb-5
            shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">
        <div class="grid grid-cols-1 sm:grid-cols-2 {{ $tab === 'karyawan' ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-3">

            {{-- Search --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama atau email..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
            </div>

            {{-- Filter Status --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <select wire:model.live="status"
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                    <option value="tidak_lanjut">Tidak Lanjut</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            {{-- Filter Approval — hanya tampil untuk tab karyawan --}}
            @if($tab === 'karyawan')
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <select wire:model.live="approval"
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="">Semua Approval</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            @endif

            {{-- Filter Jenis --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342" />
                </svg>
                <select wire:model.live="jenis"
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-600 outline-none appearance-none
                       focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200">
                    <option value="">Semua Jenis</option>
                    @if($tab === 'pkl')
                    <option value="pkl">PKL</option>
                    <option value="magang">Magang</option>
                    <option value="orientasi">Orientasi</option>
                    @else
                    <option value="karyawan_iss">ISS</option>
                    <option value="karyawan_bss">BSS</option>
                    <option value="karyawan_adidaya">PT. Adidaya</option>
                    <option value="karyawan_bayi_tabung">Bayi Tabung</option>
                    <option value="karyawan_koperasi">Koperasi</option>
                    <option value="karyawan_lotus_spa">Lotus SPA</option>
                    @endif
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
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Peserta</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Jenis</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Institusi</th>
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">
                            {{ $tab === 'pkl' ? 'Periode' : 'Unit' }}
                        </th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Status</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($peserta as $p)
                    <tr class="hover:bg-stone-50/70 transition-colors duration-150">

                        {{-- Peserta --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-stone-800">{{ $p->user?->nama }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">{{ $p->user?->email }}</p>
                            @if($p->user?->hp)
                            <p class="text-xs text-stone-400">{{ $p->user->hp }}</p>
                            @endif
                        </td>

                        {{-- Jenis --}}
                        <td class="px-5 py-4">
                            @php
                            $jenisLabel = \App\Models\DetailEksternal::jenisOptions()[$p->jenis] ?? $p->jenis;
                            $jenisColor = match(true) {
                            $p->jenis === 'pkl' => 'bg-blue-50 text-blue-700 border-blue-200',
                            $p->jenis === 'magang' => 'bg-purple-50 text-purple-700 border-purple-200',
                            $p->jenis === 'orientasi' => 'bg-teal-50 text-teal-700 border-teal-200',
                            default => 'bg-orange-50 text-orange-700 border-orange-200',
                            };
                            @endphp
                            <span class="text-[10.5px] px-2.5 py-1 rounded-full font-bold border {{ $jenisColor }}">
                                {{ $jenisLabel }}
                            </span>
                        </td>

                        {{-- Institusi --}}
                        <td class="px-5 py-4">
                            <p class="text-sm text-stone-700">{{ $p->institusi }}</p>
                            @if($p->supervisor)
                            <p class="text-xs text-stone-400 mt-0.5">Pembimbing: {{ $p->supervisor->nama }}</p>
                            @endif
                        </td>

                        {{-- Periode / Unit --}}
                        <td class="px-5 py-4">
                            @if($tab === 'pkl')
                            @if($p->tanggal_mulai && $p->tanggal_selesai)
                            <p class="text-xs font-medium text-stone-700">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">s/d {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</p>
                            @else
                            <p class="text-xs text-stone-400">-</p>
                            @endif
                            @else
                            <p class="text-xs font-medium text-stone-700">{{ $p->unit?->nama ?? '-' }}</p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                                    {{ $p->status === 'aktif'    ? 'bg-green-50 text-green-700 border-green-200'  :
                                       ($p->status === 'selesai' ? 'bg-stone-100 text-stone-600 border-stone-200' :
                                       'bg-red-50 text-red-600 border-red-200') }}">
                                    {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                </span>
                                {{-- Approval badge --}}
                                @if($p->approval_status === 'pending')
                                <span class="text-[9.5px] px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200 font-semibold">
                                    Pending
                                </span>
                                @elseif($p->approval_status === 'rejected')
                                <span class="text-[9.5px] px-2 py-0.5 rounded-full bg-red-100 text-red-600 border border-red-200 font-semibold">
                                    Ditolak
                                </span>
                                @endif
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            @php $nama = str_replace("'", "\'", $p->user->nama ?? '-'); @endphp
                            <div class="flex items-center justify-center gap-1.5">

                                {{-- Detail --}}
                                <a href="{{ $p->isKaryawan() ? route('admin.peserta.detail.karyawan', $p->id) : route('admin.peserta.detail', $p->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
            bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600
            border border-orange-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
            hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(234,88,12,.25)]
            transition-all duration-200" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.peserta.edit', $p->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                   bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600
                   border border-blue-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                   hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(59,130,246,.25)]
                   transition-all duration-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                    </svg>
                                </a>

                                {{-- ACC / Tolak --}}
                                @if($p->approval_status === 'pending')
                                <button
                                    @click="$store.deleteModal.show('Setujui Peserta', 'Setujui pendaftaran {{ $nama }}? Peserta dapat login ke sistem.', () => $wire.approve({{ $p->id }}))"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                   bg-gradient-to-br from-green-50 to-green-100 text-green-600
                   border border-green-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                   hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(34,197,94,.25)]
                   transition-all duration-200" title="Setujui">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                                <button
                                    @click="$store.deleteModal.show('Tolak Peserta', 'Tolak pendaftaran {{ $nama }}? Peserta tidak dapat login ke sistem.', () => $wire.reject({{ $p->id }}))"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                   bg-gradient-to-br from-red-50 to-red-100 text-red-500
                   border border-red-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                   hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.25)]
                   transition-all duration-200" title="Tolak">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                @endif

                                {{-- Tandai Tidak Aktif — hanya Karyawan External --}}
                                @if($tab === 'karyawan' && $p->status === 'aktif' && $p->approval_status === 'approved')
                                <button
                                    @click="$store.deleteModal.show('Tandai Tidak Aktif', 'Tandai {{ $nama }} sebagai tidak aktif? Karyawan tidak dapat mengakses sistem.', () => $wire.ubahStatus({{ $p->id }}, 'selesai'))"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                   bg-gradient-to-br from-teal-50 to-teal-100 text-teal-600
                   border border-teal-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                   hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(20,184,166,.25)]
                   transition-all duration-200" title="Tandai Tidak Aktif">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                                @endif

                                {{-- Hapus --}}
                                <button
                                    @click="$store.deleteModal.show('Hapus Peserta', 'Yakin hapus peserta {{ $nama }}? Akun user juga akan dihapus.', () => $wire.delete({{ $p->id }}))"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl
                   bg-gradient-to-br from-red-50 to-red-100 text-red-500
                   border border-red-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                   hover:-translate-y-0.5 hover:scale-105
                   hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.25)]
                   transition-all duration-200" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-stone-500">Belum ada data</p>
                                    <a href="{{ route('admin.peserta.create') }}"
                                        class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition-colors">
                                        + Tambah peserta pertama
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $peserta->links() }}
        </div>
    </div>

</div>