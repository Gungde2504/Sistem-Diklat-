<x-layouts.admin title="Dashboard">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <style>
        .dash-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06), 0 0 1px rgba(0,0,0,0.04);
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .dash-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.10), 0 0 1px rgba(0,0,0,0.04);
        }
        .dist-split { display: flex; align-items: stretch; min-height: 220px; }
        .dist-left {
            flex: 0 0 260px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            background: #fff;
        }
        .dist-right { flex: 1 1 auto; padding: 20px; border-left: 1px solid #f5f5f4; min-width: 0; display: flex; flex-direction: column; }
        .dist-icon-ring {
            width: 48px; height: 48px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            flex-shrink: 0;
        }
        .dist-icon-ring::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 18px;
            border: 1.5px solid var(--ring-color, rgba(249,115,22,0.25));
            pointer-events: none;
        }
        .dist-chip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            transition: transform 0.15s;
        }
        .dist-chip:hover { transform: translateX(2px); }
        @media (max-width: 640px) {
            .dist-split { flex-direction: column; }
            .dist-left { flex: none; }
            .dist-right { border-left: none; border-top: 1px solid #f5f5f4; }
        }
    </style>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
        <div class="stat-card card-orange" style="animation-delay:0s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Acara Aktif</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['acara_aktif'] }}</p>
            <p class="stat-sub">Berlangsung &amp; akan datang</p>
            <span class="stat-badge"><span class="inline-block w-2 h-2 rounded-full bg-white opacity-90 mr-1"></span> Live</span>
        </div>
        <div class="stat-card card-amber" style="animation-delay:0.08s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Total Peserta</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['total_peserta'] }}</p>
            <p class="stat-sub">Terdaftar di semua acara</p>
            <span class="stat-badge">↑ Semua acara</span>
        </div>
        <div class="stat-card card-rose" style="animation-delay:0.16s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Belum 20 Jam</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['karyawan_kurang_jam'] }}</p>
            <p class="stat-sub">Karyawan tahun {{ date('Y') }}</p>
            <span class="stat-badge">⚠ Perlu perhatian</span>
        </div>
        <div class="stat-card card-terracotta" style="animation-delay:0.24s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Eksternal Aktif</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['eksternal_aktif'] }}</p>
            <p class="stat-sub">PKL / Magang / Orientasi</p>
            <span class="stat-badge">● Sedang berjalan</span>
        </div>
    </div>

    {{-- ===== CHARTS ROW 1 ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-5">

        {{-- Ringkasan Bulanan --}}
        <div class="xl:col-span-2 dash-card overflow-hidden">
            <div class="px-6 pt-6 pb-3">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold text-stone-400 uppercase tracking-widest mb-2">Ringkasan Bulanan</p>
                        <div class="flex items-end gap-2">
                            <p class="text-4xl font-extrabold text-stone-800 tracking-tight leading-none" id="totalAcaraTahun">0</p>
                            <p class="text-sm text-stone-400 mb-1">acara di {{ date('Y') }}</p>
                        </div>
                        <div class="flex items-center gap-1 mt-1.5" id="deltaBadge">
                            <svg xmlns="http://www.w3.org/2000/svg" id="deltaArrow" class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
                            <span id="deltaValue" class="text-sm font-semibold text-green-500">0%</span>
                            <span class="text-xs text-stone-400">dari bulan lalu</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="flex items-center gap-1.5 text-xs text-stone-400">
                            <span class="w-2.5 h-2.5 rounded-sm inline-block" style="background:linear-gradient(135deg,#f97316,#ea580c)"></span> Acara
                        </span>
                        <span class="flex items-center gap-1.5 text-xs text-stone-400">
                            <span class="w-2.5 h-2.5 rounded-sm inline-block bg-stone-200"></span> Rata-rata
                        </span>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-5" style="position:relative;height:220px">
                <canvas id="chartBulan"></canvas>
            </div>
        </div>

        {{-- Status Acara --}}
        <div class="dash-card overflow-hidden">
            <div class="px-6 pt-6 pb-3 flex items-center justify-between">
                <p class="text-[11px] font-semibold text-stone-400 uppercase tracking-widest">Status Acara</p>
                <span class="text-xs text-stone-400">{{ date('Y') }}</span>
            </div>
            <div class="px-6 pb-5 flex flex-col items-center">
                <div style="position:relative;width:172px;height:172px" class="mb-2">
                    <canvas id="chartStatus"></canvas>
                    <div style="position:absolute;inset:0" class="flex flex-col items-center justify-center pointer-events-none">
                        <p class="text-3xl font-extrabold text-stone-800 leading-none" id="chartStatusTotal">0</p>
                        <p class="text-[11px] text-stone-400 mt-1">total acara</p>
                    </div>
                </div>
                <div id="chartStatusLegend" class="flex flex-wrap justify-center gap-2 w-full mb-4"></div>
                <div class="w-full p-3.5 rounded-2xl flex items-center gap-3 bg-stone-50" id="statusInfoCard">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 bg-white shadow-sm" id="statusInfoIconWrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="statusInfoIcon" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-stone-700" id="statusInfoTitle">Memuat...</p>
                        <p class="text-[11px] text-stone-400 mt-0.5" id="statusInfoSub">-</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== DISTRIBUSI PESERTA EKSTERNAL — split kiri/kanan ===== --}}
    <div class="mb-5">
        <p class="text-[11px] font-semibold text-stone-400 uppercase tracking-widest mb-4 px-1">Distribusi Peserta Eksternal — {{ $tahun }}</p>

        @php
            $jenisMap = [
                'pkl' => ['label' => 'PKL', 'color' => '#3b82f6', 'light' => '#93c5fd'],
                'magang' => ['label' => 'Magang', 'color' => '#22c55e', 'light' => '#86efac'],
                'orientasi' => ['label' => 'Orientasi', 'color' => '#ec4899', 'light' => '#f9a8d4'],
                'karyawan_iss' => ['label' => 'ISS', 'color' => '#a855f7', 'light' => '#d8b4fe'],
                'karyawan_bss' => ['label' => 'BSS', 'color' => '#f59e0b', 'light' => '#fcd34d'],
                'karyawan_adidaya' => ['label' => 'PT. Adidaya', 'color' => '#ef4444', 'light' => '#fca5a5'],
                'karyawan_bayi_tabung' => ['label' => 'Bayi Tabung', 'color' => '#14b8a6', 'light' => '#5eead4'],
                'karyawan_koperasi' => ['label' => 'Koperasi', 'color' => '#6366f1', 'light' => '#a5b4fc'],
                'karyawan_lotus_spa' => ['label' => 'Lotus SPA', 'color' => '#f43f5e', 'light' => '#fda4af'],
            ];
            $bulanNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

            $groupEksternal = ['pkl', 'magang', 'orientasi'];
            $groupKaryawan  = ['karyawan_iss','karyawan_bss','karyawan_adidaya','karyawan_bayi_tabung','karyawan_koperasi','karyawan_lotus_spa'];

            $buildGroup = function($jenisList) use ($pesertaJenisBulan, $jenisMap) {
                $monthlyTotal = array_fill(0, 12, 0);
                $breakdown = [];
                $datasets = [];
                foreach ($jenisList as $j) {
                    if (!isset($pesertaJenisBulan[$j])) continue;
                    $sum = array_sum($pesertaJenisBulan[$j]);
                    $color = $jenisMap[$j]['color'] ?? '#a8a29e';
                    $light = $jenisMap[$j]['light'] ?? '#d6d3d1';
                    $label = $jenisMap[$j]['label'] ?? $j;
                    if ($sum > 0) {
                        $breakdown[] = ['jenis' => $j, 'label' => $label, 'color' => $color, 'total' => $sum];
                        $datasets[] = ['label' => $label, 'color' => $color, 'light' => $light, 'data' => array_values($pesertaJenisBulan[$j])];
                    }
                    foreach ($pesertaJenisBulan[$j] as $idx => $val) {
                        $monthlyTotal[$idx] += $val;
                    }
                }
                return ['monthly' => $monthlyTotal, 'breakdown' => $breakdown, 'total' => array_sum($monthlyTotal), 'datasets' => $datasets];
            };

            $dataEksternal = $buildGroup($groupEksternal);
            $dataKaryawan  = $buildGroup($groupKaryawan);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Card 1: PKL / Magang / Orientasi --}}
            <div class="dash-card overflow-hidden">
                <div class="dist-split">
                   <div class="dist-left">
                        <div class="flex items-center justify-between mb-4">
                            <div class="dist-icon-ring" style="--ring-color: rgba(249,115,22,0.25); background:linear-gradient(135deg,#fff7ed,#ffedd5)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-full">{{ $tahun }}</span>
                        </div>

                        <p class="text-xs font-bold text-stone-800 leading-snug mb-0.5">PKL · Magang · Orientasi</p>
                        <p class="text-[11px] text-stone-400 mb-3">Total peserta terdaftar</p>

                        <div class="flex items-baseline gap-2 mb-4">
                            <p class="text-4xl font-extrabold text-stone-800 leading-none">{{ $dataEksternal['total'] }}</p>
                            <span class="text-xs font-medium text-stone-400">peserta</span>
                        </div>

                        @if(count($dataEksternal['breakdown']) > 0)
                        <div class="space-y-1.5 mt-auto">
                            @foreach($dataEksternal['breakdown'] as $b)
                            <div class="dist-chip border border-stone-100">
                                <span class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $b['color'] }}"></span>
                                    <span class="truncate text-stone-600">{{ $b['label'] }}</span>
                                </span>
                                <span class="flex-shrink-0 text-stone-700">{{ $b['total'] }}</span>
                            </div>
                            @endforeach
                        </div>
                       @endif
                    </div>
                    <div class="dist-right">
                        @if(count($dataEksternal['datasets']) > 0)
                        <div class="flex items-center justify-end gap-3 mb-2">
                            @foreach($dataEksternal['datasets'] as $ds)
                            <span class="flex items-center gap-1.5 text-xs text-stone-500">
                                <span class="w-2.5 h-2.5 rounded-full inline-block" style="background:{{ $ds['color'] }}"></span>
                                {{ $ds['label'] }}
                            </span>
                            @endforeach
                        </div>
                        <div style="margin-top:auto;position:relative;width:100%;height:160px">
                            <canvas id="chartEksternal"></canvas>
                        </div>
                        @else
                        <div class="h-full flex items-center justify-center" style="min-height:180px">
                            <p class="text-xs text-stone-300">Belum ada data</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card 2: Karyawan External --}}
            <div class="dash-card overflow-hidden">
                <div class="dist-split">
                    <div class="dist-left">
                        <div class="flex items-center justify-between mb-4">
                            <div class="dist-icon-ring" style="--ring-color: rgba(99,102,241,0.25); background:linear-gradient(135deg,#eef2ff,#e0e7ff)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded-full">{{ $tahun }}</span>
                        </div>

                        <p class="text-xs font-bold text-stone-800 leading-snug mb-0.5">Karyawan External</p>
                        <p class="text-[11px] text-stone-400 mb-3">Total karyawan terdaftar</p>

                        <div class="flex items-baseline gap-2 mb-4">
                            <p class="text-4xl font-extrabold text-stone-800 leading-none">{{ $dataKaryawan['total'] }}</p>
                            <span class="text-xs font-medium text-stone-400">karyawan</span>
                        </div>

                        @if(count($dataKaryawan['breakdown']) > 0)
                        <div class="space-y-1.5 mt-auto">
                            @foreach($dataKaryawan['breakdown'] as $b)
                            <div class="dist-chip border border-stone-100">
                                <span class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $b['color'] }}"></span>
                                    <span class="truncate text-stone-600">{{ $b['label'] }}</span>
                                </span>
                                <span class="flex-shrink-0 text-stone-700">{{ $b['total'] }}</span>
                            </div>
                            @endforeach
                        </div>
                      @endif
                    </div>
                    <div class="dist-right">
                        @if(count($dataKaryawan['datasets']) > 0)
                        <div class="flex items-center justify-end gap-3 mb-2">
                            @foreach($dataKaryawan['datasets'] as $ds)
                            <span class="flex items-center gap-1.5 text-xs text-stone-500">
                                <span class="w-2.5 h-2.5 rounded-full inline-block" style="background:{{ $ds['color'] }}"></span>
                                {{ $ds['label'] }}
                            </span>
                            @endforeach
                        </div>
                        <div style="margin-top:auto;position:relative;width:100%;height:160px">
                            <canvas id="chartKaryawan"></canvas>
                        </div>
                        @else
                        <div class="h-full flex items-center justify-center" style="min-height:180px">
                            <p class="text-xs text-stone-300">Belum ada data</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== ACARA MENDATANG + SHORTCUT ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="xl:col-span-2 dash-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-stone-50">
                <h3 class="text-sm font-semibold text-stone-800">Acara Mendatang</h3>
                <a href="#" class="text-xs font-medium text-orange-500 px-3 py-1 rounded-full bg-orange-50 hover:bg-orange-100 transition-all inline-block">Lihat semua →</a>
            </div>
            <div class="divide-y divide-stone-50">
                @forelse($acaraMendatang as $acara)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-stone-50/50 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-stone-800 truncate">{{ $acara->nama }}</p>
                        <p class="text-xs text-stone-400 mt-0.5">{{ $acara->tglJamMulai }} · {{ $acara->tempat }}</p>
                    </div>
                    <span class="text-[11px] px-2.5 py-1 rounded-full font-semibold
                        {{ $acara->status === 'Berlangsung' ? 'bg-green-50 text-green-600' :
                           ($acara->status === 'Terbuka' ? 'bg-blue-50 text-blue-600' : 'bg-stone-100 text-stone-500') }}">
                        {{ $acara->status }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-10 text-center">
                    <p class="text-sm text-stone-400">Tidak ada acara mendatang</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="dash-card overflow-hidden">
            <div class="px-5 py-4 border-b border-stone-50">
                <h3 class="text-sm font-semibold text-stone-800">Akses Cepat</h3>
            </div>
            <div class="p-3.5 grid grid-cols-2 gap-2.5">
                <a href="{{ route('admin.acara.create') }}" class="shortcut-btn sc-teal">
                    <div class="sc-icon-wrap bg-gradient-to-br from-teal-600 to-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <span class="sc-label">Tambah Acara</span>
                </a>
                <a href="{{ route('admin.diklat-mandiri.index') }}" class="shortcut-btn sc-orange">
                    <div class="sc-icon-wrap bg-gradient-to-br from-orange-600 to-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    </div>
                    <span class="sc-label">Diklat Mandiri</span>
                </a>
                <a href="{{ route('admin.peserta.create') }}" class="shortcut-btn sc-green">
                    <div class="sc-icon-wrap bg-gradient-to-br from-green-600 to-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                    </div>
                    <span class="sc-label">Tambah Eksternal</span>
                </a>
                <a href="{{ route('admin.rekap-jam.index') }}" class="shortcut-btn sc-purple">
                    <div class="sc-icon-wrap bg-gradient-to-br from-purple-600 to-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" /></svg>
                    </div>
                    <span class="sc-label">Rekap Jam</span>
                </a>
                @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('admin.konfigurasi.index') }}" class="shortcut-btn sc-red col-span-2 flex-row justify-start gap-3 px-4">
                    <div class="sc-icon-wrap bg-gradient-to-br from-red-600 to-red-400 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                    </div>
                    <span class="sc-label text-left">Konfigurasi Sistem</span>
                </a>
                @endif
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // ── Ringkasan Bulanan ──
        const acaraData = @json($chartAcaraBulan);
        const bulanNow = new Date().getMonth();
        const totalTahun = acaraData.reduce((a,b) => a+b, 0);
        document.getElementById('totalAcaraTahun').textContent = totalTahun;

        const thisMonth = acaraData[bulanNow] || 0;
        const lastMonth = acaraData[bulanNow - 1] || 0;
        let delta = lastMonth > 0 ? Math.round(((thisMonth - lastMonth) / lastMonth) * 100) : (thisMonth > 0 ? 100 : 0);
        document.getElementById('deltaValue').textContent = (delta >= 0 ? '+' : '') + delta + '%';
        if (delta < 0) {
            document.getElementById('deltaValue').className = 'text-sm font-semibold text-red-500';
            const arrow = document.getElementById('deltaArrow');
            arrow.style.transform = 'rotate(180deg)';
            arrow.classList.remove('text-green-500');
            arrow.classList.add('text-red-500');
        }

        const maxVal = Math.max(...acaraData, 1);
        const avgLine = acaraData.filter(v => v > 0);
        const avgVal = avgLine.length > 0 ? Math.ceil(avgLine.reduce((a,b) => a+b, 0) / avgLine.length) : maxVal;
        const bgData = Array(12).fill(Math.max(maxVal, avgVal) + 1);
        const peakIdx = acaraData.indexOf(Math.max(...acaraData));

        const gradientBar = {
            id: 'gradientBar',
            beforeDatasetsDraw(chart) {
                const ds = chart.data.datasets[1];
                if (ds._gradientDone) return;
                const meta = chart.getDatasetMeta(1);
                if (!meta.data.length) return;
                const ctx = chart.ctx;
                const chartArea = chart.chartArea;
                ds.backgroundColor = ds.data.map((v, i) => {
                    if (v === 0) return 'rgba(0,0,0,0)';
                    const g = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    if (i === peakIdx && v > 0) {
                        g.addColorStop(0, 'rgba(251,146,60,0.95)');
                        g.addColorStop(0.5, 'rgba(249,115,22,1)');
                        g.addColorStop(1, 'rgba(234,88,12,1)');
                    } else {
                        g.addColorStop(0, 'rgba(253,186,116,0.6)');
                        g.addColorStop(0.5, 'rgba(249,115,22,0.65)');
                        g.addColorStop(1, 'rgba(234,88,12,0.7)');
                    }
                    return g;
                });
                ds._gradientDone = true;
                chart.update('none');
            }
        };

        const floatingBadge = {
            id: 'floatingBadge',
            afterDatasetsDraw(chart) {
                if (peakIdx < 0 || acaraData[peakIdx] === 0) return;
                const bar = chart.getDatasetMeta(1).data[peakIdx];
                if (!bar) return;
                const {x, y} = bar.tooltipPosition();
                const ctx = chart.ctx;
                const val = String(acaraData[peakIdx]);
                ctx.save();
                ctx.font = '700 11px Inter, system-ui, sans-serif';
                const tw = ctx.measureText(val).width;
                const bw = tw + 18, bh = 24, bx = x - bw/2, by = y - bh - 10;
                ctx.shadowColor = 'rgba(234,88,12,0.25)';
                ctx.shadowBlur = 10;
                ctx.shadowOffsetY = 3;
                ctx.beginPath();
                ctx.roundRect(bx, by, bw, bh, 8);
                ctx.fillStyle = '#EA580C';
                ctx.fill();
                ctx.shadowColor = 'transparent';
                ctx.beginPath();
                ctx.moveTo(x-5, by+bh);
                ctx.lineTo(x+5, by+bh);
                ctx.lineTo(x, by+bh+6);
                ctx.closePath();
                ctx.fillStyle = '#EA580C';
                ctx.fill();
                ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(val, x, by + bh/2 + 0.5);
                ctx.restore();
            }
        };

        new Chart(document.getElementById('chartBulan'), {
            type: 'bar',
            data: {
                labels: bulanLabel,
                datasets: [
                    { label: 'Rata-rata', data: bgData, backgroundColor: 'rgba(245,245,244,0.9)', borderRadius: 10, borderSkipped: false, barPercentage: 0.48, categoryPercentage: 0.72, order: 2 },
                    { label: 'Acara', data: acaraData, backgroundColor: 'rgba(249,115,22,0.7)', borderRadius: 10, borderSkipped: false, barPercentage: 0.48, categoryPercentage: 0.72, order: 1 }
                ]
            },
            plugins: [gradientBar, floatingBadge],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 36 } },
                animation: { duration: 1000, easing: 'easeOutQuart', delay: (ctx) => ctx.dataIndex * 50 },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        filter: (item) => item.datasetIndex === 1,
                        backgroundColor: '#1c1917', padding: 12, cornerRadius: 10, displayColors: false,
                        titleFont: { size: 12, weight: '600' }, bodyFont: { size: 11 },
                        callbacks: {
                            title: ctx => bulanLabel[ctx[0].dataIndex] + ' ' + {{ date('Y') }},
                            label: ctx => ctx.parsed.y + ' acara'
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false },
                        ticks: { color: (ctx) => ctx.index === bulanNow ? '#EA580C' : '#a8a29e',
                                 font: (ctx) => ({ size: 11, weight: ctx.index === bulanNow ? '700' : '400', family: 'Inter, system-ui, sans-serif' }) } },
                    y: { display: false, beginAtZero: true, grace: '5%' }
                },
                onHover: (event, elements, chart) => {
                    const ds = chart.data.datasets[0];
                    ds.backgroundColor = ds.data.map((_, i) => (elements.length > 0 && elements[0].index === i) ? 'rgba(249,115,22,0.08)' : 'rgba(245,245,244,0.9)');
                    chart.update('none');
                }
            }
        });

        // ── Status Acara ──
        const statusData = @json($statusAcara);
        const statusLabels = Object.keys(statusData);
        const statusValues = Object.values(statusData);
        const statusTotal = statusValues.reduce((a,b) => a+b, 0);
        document.getElementById('chartStatusTotal').textContent = statusTotal;

        const sPalette = { 'Berlangsung':'#22c55e', 'Terbuka':'#3b82f6', 'Selesai':'#d6d3d1', 'Draft':'#f97316' };
        const sColors = statusLabels.map(s => sPalette[s] || '#a8a29e');

        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: { labels: statusLabels, datasets: [{ data: statusValues, backgroundColor: sColors, borderWidth: 0, borderRadius: 12, spacing: 4, hoverOffset: 6 }] },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '78%',
                animation: { animateRotate: true, duration: 1100, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#1c1917', padding: 10, cornerRadius: 8, displayColors: false, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } }
                }
            }
        });

        const legend = document.getElementById('chartStatusLegend');
        statusLabels.forEach((label, i) => {
            const el = document.createElement('div');
            el.style.cssText = 'display:flex;align-items:center;gap:5px;font-size:11px;font-weight:500;color:#57534e;padding:4px 9px;border-radius:999px;background:'+sColors[i]+'15;cursor:pointer';
            el.innerHTML = '<span style="width:7px;height:7px;border-radius:50%;background:'+sColors[i]+';display:inline-block"></span>'+label;
            legend.appendChild(el);
        });

        const dominantIdx = statusValues.indexOf(Math.max(...statusValues));
        const dominant = statusLabels[dominantIdx];
        const dominantColor = sColors[dominantIdx];
        const msgMap = {
            'Berlangsung': { title: 'Ada acara sedang berjalan!', icon: 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' },
            'Terbuka':     { title: 'Beberapa acara siap dibuka', icon: 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' },
            'Selesai':     { title: 'Sebagian besar acara selesai', icon: 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' },
            'Draft':       { title: 'Ada acara masih draft', icon: 'M16.862 4.487 18.55 2.8a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z' },
        };
        const msg = msgMap[dominant] || { title: 'Data status acara', icon: 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' };
        document.getElementById('statusInfoTitle').textContent = msg.title;
        document.getElementById('statusInfoSub').textContent = statusValues[dominantIdx] + ' dari ' + statusTotal + ' acara berstatus ' + dominant;
        document.getElementById('statusInfoIcon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="' + msg.icon + '" />';
        document.getElementById('statusInfoIcon').style.color = dominantColor;
        document.getElementById('statusInfoCard').style.background = dominantColor + '10';

        // ── Grouped bar chart builder (modern, gradient, slim bars) ──
        function buildGroupedChart(canvasId, datasets) {
            const canvas = document.getElementById(canvasId);
            if (!canvas || !datasets || datasets.length === 0) return;

            const activeMonths = [];
            for (let i = 0; i < 12; i++) {
                if (datasets.some(ds => ds.data[i] > 0)) activeMonths.push(i);
            }
            const labels = activeMonths.map(i => bulanLabel[i]);

            const chartDatasets = datasets.map(ds => ({
                label: ds.label,
                data: activeMonths.map(i => ds.data[i]),
                backgroundColor: (ctx) => {
                    const chart = ctx.chart;
                    if (!chart.chartArea) return ds.color;
                    const g = chart.ctx.createLinearGradient(0, chart.chartArea.top, 0, chart.chartArea.bottom);
                    g.addColorStop(0, ds.color);
                    g.addColorStop(1, ds.light);
                    return g;
                },
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.55,
                categoryPercentage: 0.55,
                maxBarThickness: 26,
            }));

            new Chart(canvas, {
                type: 'bar',
                data: { labels, datasets: chartDatasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 900, easing: 'easeOutQuart' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1c1917', padding: 10, cornerRadius: 8, displayColors: true, boxWidth: 6, boxHeight: 6, usePointStyle: true,
                            callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}` }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#a8a29e', font: { size: 10 } } },
                        y: { beginAtZero: true, ticks: { stepSize: 1, color: '#a8a29e', font: { size: 10 } }, grid: { color: 'rgba(120,113,108,0.06)' }, border: { display: false } }
                    }
                }
            });
        }

        buildGroupedChart('chartEksternal', @json($dataEksternal['datasets']));
        buildGroupedChart('chartKaryawan', @json($dataKaryawan['datasets']));

    });
    </script>

</x-layouts.admin>