<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Karyawan External — RSU Prima Medika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#0a2d3d] via-[#0F5A8C] to-[#1A78B0] py-8 px-4">

<div class="max-w-lg mx-auto">

    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="relative inline-block mb-4">
            <div class="w-20 h-20 rounded-2xl overflow-hidden mx-auto
                        shadow-[0_8px_32px_rgba(0,0,0,.3),0_1px_0_rgba(255,255,255,.15)_inset]
                        ring-2 ring-white/25">
                <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
            </div>
            <div class="absolute -bottom-1.5 -right-1.5 w-5 h-5 rounded-full
                        flex items-center justify-center
                        bg-green-400 ring-2 ring-white/20
                        shadow-[0_2px_8px_rgba(0,0,0,.2)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
        </div>

        <p class="text-white/40 text-[10px] font-bold uppercase tracking-[.25em] mb-1.5">RSU Prima Medika</p>
        <h1 class="text-white font-bold text-xl tracking-tight mb-0.5">Pendaftaran</h1>
        <p class="text-white/60 text-sm font-medium mb-3">Karyawan External</p>

        <div class="flex items-center justify-center gap-2 mb-3">
            <div class="w-8 h-px bg-white/20"></div>
            <div class="w-1 h-1 rounded-full bg-white/30"></div>
            <div class="w-8 h-px bg-white/20"></div>
        </div>

        <div class="flex items-center justify-center gap-1.5 flex-wrap">
            @foreach(['ISS', 'BSS', 'PT. Adidaya', 'Bayi Tabung', 'Koperasi', 'Lotus SPA'] as $badge)
            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-white/60 border border-white/15">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                {{ $badge }}
            </span>
            @endforeach
        </div>
    </div>

    {{-- Card Utama --}}
    <div class="bg-white rounded-2xl overflow-hidden
                border-b border-l border-r border-stone-200
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_4px_rgba(0,0,0,.04),0_8px_16px_-4px_rgba(0,0,0,.12),0_24px_48px_-8px_rgba(0,0,0,.25),0_48px_80px_-16px_rgba(0,0,0,.15)]">

        <div class="h-1 w-full" style="background:linear-gradient(90deg,#3B9FD1,#1A78B0,#0F5A8C)"></div>

        <div class="p-6 space-y-6">

            @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 rounded-2xl shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <p class="text-xs font-bold text-red-600">Terdapat kesalahan:</p>
                </div>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li class="text-xs text-red-500 flex items-start gap-1.5">
                        <span class="w-1 h-1 rounded-full bg-red-400 flex-shrink-0 mt-1.5"></span>
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('daftar.karyawan.external.store') }}" class="space-y-6">
                @csrf

                {{-- SEKSI 1 --}}
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-white"
                             style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">1</div>
                        <p class="text-xs font-bold text-stone-600 uppercase tracking-widest">Informasi Akun</p>
                        <div class="flex-1 h-px bg-stone-100"></div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <input name="nama" type="text" value="{{ old('nama') }}" placeholder="Nama lengkap sesuai KTP"
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            </div>
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Email <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <input name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com"
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            </div>
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Password <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                    <input name="password" type="password" placeholder="Min. 6 karakter"
                                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                                </div>
                                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Konfirmasi <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                    <input name="konfirmasi" type="password" placeholder="Ulangi password"
                                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">No. HP</label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 0a2.25 2.25 0 0 0-2.25 2.25v.75m5.25-3A2.25 2.25 0 0 1 15.75 12v.75" />
                                </svg>
                                <input name="hp" type="text" value="{{ old('hp') }}" placeholder="08xxxxxxxxxx"
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200"/>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Alamat Domisili / KTP</label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-3 w-4 h-4 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <textarea name="alamat" rows="2" placeholder="Alamat lengkap sesuai KTP"
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 resize-none focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition-all duration-200">{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-stone-100"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-stone-200"></div>
                    <div class="flex-1 h-px bg-stone-100"></div>
                </div>

                {{-- SEKSI 2 --}}
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-white"
                             style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">2</div>
                        <p class="text-xs font-bold text-stone-600 uppercase tracking-widest">Pilih Penempatan</p>
                        <div class="flex-1 h-px bg-stone-100"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-2" id="penempatanCards">
                        @foreach([
                            'karyawan_iss'         => ['label' => 'ISS',         'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                            'karyawan_bss'         => ['label' => 'BSS',         'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                            'karyawan_adidaya'     => ['label' => 'PT. Adidaya', 'icon' => 'M3.75 21 3 3l18 9-18 9Zm0 0 10.5-4.5'],
                            'karyawan_bayi_tabung' => ['label' => 'Bayi Tabung', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
                            'karyawan_koperasi'    => ['label' => 'Koperasi',    'icon' => 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z'],
                            'karyawan_lotus_spa'   => ['label' => 'Lotus SPA',   'icon' => 'M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .864-.154 1.698-.433 2.47m5.916-2.47c0 .864.154 1.698.433 2.47m-5.916 0a6.714 6.714 0 0 0 2.916.662 6.714 6.714 0 0 0 2.916-.662m-5.832 0c-.205.767-.205 1.57 0 2.337m5.832-2.337c.205.767.205 1.57 0 2.337'],
                        ] as $value => $item)
                        @php $isSelected = old('jenis') === $value; @endphp
                        <label data-penempatan="{{ $value }}"
                            class="penempatan-card flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all duration-200
                                {{ $isSelected
                                    ? 'border-blue-400 bg-blue-50 shadow-[0_0_0_3px_rgba(59,159,209,0.2)]'
                                    : 'border-stone-200 bg-stone-50 hover:border-blue-300 hover:bg-blue-50/50' }}">
                            <input type="radio" name="jenis" value="{{ $value }}"
                                   {{ $isSelected ? 'checked' : '' }}
                                   class="hidden">
                            <div class="penempatan-icon w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors duration-200
                                        {{ $isSelected ? 'bg-blue-500' : 'bg-stone-200' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-stone-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-sm font-semibold text-stone-700">{{ $item['label'] }}</span>
                                @if($isSelected)
                                <span class="penempatan-check block text-[9px] font-bold text-blue-600">✓ Dipilih</span>
                                @else
                                <span class="penempatan-check block text-[9px] font-bold text-blue-600 hidden">✓ Dipilih</span>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('jenis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-2xl shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 bg-blue-100 border border-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-blue-700 mb-0.5">Informasi Pendaftaran</p>
                        <p class="text-xs text-blue-600 leading-relaxed">Pendaftaran akan diverifikasi oleh admin terlebih dahulu. Anda dapat login setelah akun disetujui.</p>
                    </div>
                </div>

                <button type="submit"
                    class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                           hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55)]
                           active:scale-[.97] transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span class="relative">Daftar Sekarang</span>
                </button>

                <p class="text-center text-xs text-stone-400 mt-1">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:text-blue-700 hover:underline transition-colors duration-200">Login di sini</a>
                </p>

            </form>
        </div>
    </div>

    <p class="text-center text-white/25 text-xs mt-5">© {{ date('Y') }} RSU Prima Medika</p>
</div>

<script>
    document.querySelectorAll('.penempatan-card').forEach(card => {
        card.addEventListener('click', function() {
            // Reset semua card
            document.querySelectorAll('.penempatan-card').forEach(c => {
                c.classList.remove('border-blue-400', 'bg-blue-50', 'shadow-[0_0_0_3px_rgba(59,159,209,0.2)]');
                c.classList.add('border-stone-200', 'bg-stone-50');
                c.querySelector('.penempatan-icon').classList.remove('bg-blue-500');
                c.querySelector('.penempatan-icon').classList.add('bg-stone-200');
                c.querySelector('.penempatan-icon svg').classList.remove('text-white');
                c.querySelector('.penempatan-icon svg').classList.add('text-stone-500');
                c.querySelector('.penempatan-check').classList.add('hidden');
            });

            // Aktifkan card yang diklik
            this.classList.remove('border-stone-200', 'bg-stone-50');
            this.classList.add('border-blue-400', 'bg-blue-50', 'shadow-[0_0_0_3px_rgba(59,159,209,0.2)]');
            this.querySelector('.penempatan-icon').classList.remove('bg-stone-200');
            this.querySelector('.penempatan-icon').classList.add('bg-blue-500');
            this.querySelector('.penempatan-icon svg').classList.remove('text-stone-500');
            this.querySelector('.penempatan-icon svg').classList.add('text-white');
            this.querySelector('.penempatan-check').classList.remove('hidden');

            // Set radio button
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>

</body>
</html>