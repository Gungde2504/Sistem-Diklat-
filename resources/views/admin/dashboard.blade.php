<x-layouts.admin title="Dashboard">

    {{-- Sidebar slot --}}
    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

        {{-- Acara Aktif --}}
        <div class="stat-card card-orange" style="animation-delay:0s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Acara Aktif</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['acara_aktif'] }}</p>
            <p class="stat-sub">Berlangsung &amp; akan datang</p>
            <span class="stat-badge">
                <span class="inline-block w-2 h-2 rounded-full bg-white opacity-90 mr-1"></span> Live
            </span>
        </div>

        {{-- Total Peserta --}}
        <div class="stat-card card-amber" style="animation-delay:0.08s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Total Peserta</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['total_peserta'] }}</p>
            <p class="stat-sub">Terdaftar di semua acara</p>
            <span class="stat-badge">↑ Semua acara</span>
        </div>

        {{-- Belum 20 Jam --}}
        <div class="stat-card card-rose" style="animation-delay:0.16s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Belum 20 Jam</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['karyawan_kurang_jam'] }}</p>
            <p class="stat-sub">Karyawan tahun {{ date('Y') }}</p>
            <span class="stat-badge">⚠ Perlu perhatian</span>
        </div>

        {{-- Eksternal Aktif --}}
        <div class="stat-card card-terracotta" style="animation-delay:0.24s">
            <div class="flex items-start justify-between">
                <p class="stat-label">Eksternal Aktif</p>
                <div class="glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="rgba(255,255,255,0.95)">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
            </div>
            <p class="stat-number">{{ $stats['eksternal_aktif'] }}</p>
            <p class="stat-sub">PKL / Magang / Orientasi</p>
            <span class="stat-badge">● Sedang berjalan</span>
        </div>

    </div>

    {{-- Row 2: Acara Mendatang + Shortcut --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Acara Mendatang --}}
        <div class="xl:col-span-2 card-section animate-fade-up" style="animation-delay:0s">
            <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Acara Mendatang</h3>
                <a href="#" class="text-xs font-medium text-orange-500 px-3 py-1 rounded-full bg-orange-50 border border-orange-200 hover:bg-orange-100 transition-all hover:scale-105 inline-block">
                    Lihat semua →
                </a>
            </div>
            <div class="divide-y divide-stone-50">
                @forelse($acaraMendatang as $index => $acara)
                <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-stone-50/70 transition-colors duration-200 acara-row" style="animation-delay:{{ ($index * 0.05) + 0.05 }}s">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 flex items-center justify-center flex-shrink-0 transition-transform duration-200 group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-stone-800 truncate">{{ $acara->nama }}</p>
                        <p class="text-xs text-stone-400 mt-0.5">{{ $acara->tglJamMulai }} · {{ $acara->tempat }}</p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full font-semibold flex-shrink-0 border
                    {{ $acara->status === 'Berlangsung' ? 'bg-green-50 text-green-700 border-green-200' :
                       ($acara->status === 'Terbuka' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-stone-100 text-stone-500 border-stone-200') }}">
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

        {{-- Shortcut Menu --}}
        <div class="card-section animate-fade-up" style="animation-delay:0.08s">
            <div class="px-5 py-4 border-b border-stone-100">
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Akses Cepat</h3>
            </div>
            <div class="p-3.5 grid grid-cols-2 gap-2.5">

                <a href="{{ route('admin.acara.create') }}" class="shortcut-btn sc-teal">
                    <div class="sc-icon-wrap bg-gradient-to-br from-teal-600 to-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <span class="sc-label">Tambah Acara</span>
                </a>
                <a href="{{ route('admin.diklat-mandiri.index') }}" class="shortcut-btn sc-orange">
                    <div class="sc-icon-wrap bg-gradient-to-br from-orange-600 to-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <span class="sc-label">Diklat Mandiri</span>
                </a>

                <a href="{{ route('admin.peserta.create') }}" class="shortcut-btn sc-green">
                    <div class="sc-icon-wrap bg-gradient-to-br from-green-600 to-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <span class="sc-label">Tambah Eksternal</span>
                </a>

                <a href="{{ route('admin.rekap-jam.index') }}" class="shortcut-btn sc-purple">
                    <div class="sc-icon-wrap bg-gradient-to-br from-purple-600 to-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                        </svg>
                    </div>
                    <span class="sc-label">Rekap Jam</span>
                </a>

                @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('admin.konfigurasi.index') }}" class="shortcut-btn sc-red col-span-2 flex-row justify-start gap-3 px-4">
                    <div class="sc-icon-wrap bg-gradient-to-br from-red-600 to-red-400 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <span class="sc-label text-left">Konfigurasi Sistem</span>
                </a>
                @endif

            </div>
        </div>

    </div>

</x-layouts.admin>