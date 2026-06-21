<div class="space-y-4">

    {{-- ── HEADER PROFIL ── --}}
    <div class="rounded-2xl p-5 text-white relative overflow-hidden
                shadow-[0_4px_20px_-4px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.15)_inset]"
         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
        <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full bg-white/[.05] pointer-events-none"></div>
        <div class="absolute -bottom-6 -left-6 w-20 h-20 rounded-full bg-white/[.04] pointer-events-none"></div>

        <div class="relative flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0
                        bg-white/20 border border-white/30 backdrop-blur-sm
                        shadow-[0_4px_14px_rgba(0,0,0,.15),0_1px_0_rgba(255,255,255,.15)_inset]">
                <span class="text-2xl font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-bold tracking-tight truncate">{{ auth()->user()->nama }}</h2>
                <p class="text-white/65 text-sm mt-0.5">{{ auth()->user()->profesi ?? 'Pegawai' }}</p>
                <div class="flex items-center gap-1.5 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.17-.789 3.376 3.376 0 0 1 6.34 0Z" />
                    </svg>
                    <p class="text-white/45 text-xs">NIK: {{ auth()->user()->nip ?? '-' }} · {{ auth()->user()->unit ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

     {{-- ── MENU SHORTCUT ── --}}
    <div class="bg-white rounded-2xl border border-stone-100 p-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Menu Lainnya</p>
        <div class="space-y-1.5">

            {{-- E-Learning --}}
            <a href="{{ route('pegawai.elearning') }}"
                class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent
                       hover:bg-purple-50/60 hover:border-purple-100 hover:translate-x-1
                       transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(147,51,234,.3)]
                            group-hover:scale-105 group-hover:-rotate-3 transition-all duration-200
                            bg-gradient-to-br from-purple-400 to-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-stone-800 group-hover:text-purple-700 transition-colors duration-200">E-Learning</p>
                    <p class="text-xs text-stone-400">Akses modul pembelajaran</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-purple-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            {{-- Diklat Mandiri --}}
            <a href="{{ route('pegawai.diklat-mandiri') }}"
                class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent
                       hover:bg-orange-50/60 hover:border-orange-100 hover:translate-x-1
                       transition-all duration-200">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(234,88,12,.3)]
                            group-hover:scale-105 group-hover:-rotate-3 transition-all duration-200"
                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-stone-800 group-hover:text-orange-600 transition-colors duration-200">Diklat Mandiri</p>
                    <p class="text-xs text-stone-400">Ajukan & pantau pengajuan</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-orange-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

        </div>
    </div>


    {{-- ── DETAIL PEGAWAI ── --}}
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1),0_1px_4px_-1px_rgba(120,113,108,.06)]">
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
            <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-blue-400 to-blue-600"></div>
            <h3 class="text-sm font-semibold text-stone-800">Data Diri</h3>
        </div>
        <div class="p-5 space-y-3">
            @foreach([
                ['icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                  'label' => 'Nama Lengkap', 'value' => auth()->user()->nama],
                ['icon' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
                  'label' => 'Email', 'value' => auth()->user()->email],
                ['icon' => 'M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 0a2.25 2.25 0 0 0-2.25 2.25v6.75m5.25-9A2.25 2.25 0 0 1 15.75 12v6.75',
                  'label' => 'No. HP', 'value' => auth()->user()->hp ?? '-'],
                ['icon' => 'M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.17-.789 3.376 3.376 0 0 1 6.34 0Z',
                  'label' => 'NIK / NIP', 'value' => auth()->user()->nip ?? '-'],
                ['icon' => 'M2.25 21 21 3m0 0H8.25M21 3v12.75',
                  'label' => 'Unit', 'value' => auth()->user()->unit ?? '-'],
                ['icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0',
                  'label' => 'Profesi', 'value' => auth()->user()->profesi ?? '-'],
                ['icon' => 'M3.75 21 3 3l18 9-18 9Zm0 0 10.5-4.5',
                  'label' => 'Jabatan', 'value' => auth()->user()->jabatan ?? '-'],
                ['icon' => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z',
                  'label' => 'Status Akun', 'value' => auth()->user()->isActive ? 'Aktif' : 'Nonaktif',
                  'color' => auth()->user()->isActive ? 'text-green-600' : 'text-red-500'],
            ] as $item)
            <div class="flex items-center gap-3 p-3 bg-stone-50 border border-stone-100 rounded-xl
                        hover:bg-blue-50/40 hover:border-blue-100 transition-all duration-200">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-white border border-stone-200
                            shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10.5px] text-stone-400 uppercase tracking-wider font-medium">{{ $item['label'] }}</p>
                    <p class="text-sm font-semibold truncate {{ $item['color'] ?? 'text-stone-700' }}">{{ $item['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

   
</div>