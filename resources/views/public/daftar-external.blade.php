<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Mahasiswa — RSU Prima Medika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f4f7fa] py-4 px-4">

    <div class="max-w-6xl mx-auto">

        {{-- Card Utama: sidebar (logo + step) di kiri, form di kanan --}}
        <div class="bg-white rounded-3xl overflow-hidden
            border border-stone-200
            shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_4px_rgba(0,0,0,.04),0_8px_16px_-4px_rgba(0,0,0,.08),0_24px_48px_-8px_rgba(0,0,0,.1)]
            grid grid-cols-1 md:grid-cols-[230px_1fr]">

            {{-- SIDEBAR --}}
            <div class="relative p-5 border-b md:border-b-0 md:border-r border-stone-100"
                style="background:linear-gradient(180deg,#f3f9fc 0%,#eef6fb 100%)">

                <div class="h-1 w-full absolute top-0 left-0 md:hidden" style="background:linear-gradient(90deg,#3B9FD1,#1A78B0,#0F5A8C)"></div>

                {{-- Logo di atas sidebar --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg overflow-hidden shadow-sm ring-1 ring-stone-200 flex-shrink-0">
                        <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
                    </div>
                    <span class="text-stone-500 text-[10px] font-bold uppercase tracking-[.2em] leading-tight">RSU Prima<br>Medika</span>
                </div>

                <p class="text-stone-400 text-[10px] font-bold uppercase tracking-[.25em] mb-1.5">Pendaftaran</p>
                <h1 class="text-stone-800 font-bold text-lg tracking-tight leading-tight mb-1">Mahasiswa</h1>
                <p class="text-stone-400 text-xs mb-4">PKL · Magang · Orientasi</p>

                {{-- Step list --}}
                <div class="space-y-0">
                    @foreach([
                        ['n' => '1', 'label' => 'Informasi Akun', 'desc' => 'Data diri & akses login'],
                        ['n' => '2', 'label' => 'Informasi Kegiatan', 'desc' => 'Jenis & periode kegiatan'],
                        ['n' => '3', 'label' => 'Konfirmasi', 'desc' => 'Kirim & tunggu verifikasi'],
                    ] as $i => $step)
                    <div class="flex items-start gap-2.5 {{ $i < 2 ? 'pb-3' : '' }} relative">
                        @if($i < 2)
                        <div class="absolute left-[13px] top-7 bottom-0 w-px bg-stone-200"></div>
                        @endif
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 text-[11px] font-bold text-white relative z-10"
                            style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">
                            {{ $step['n'] }}
                        </div>
                        <div class="pt-0.5">
                            <p class="text-stone-700 text-xs font-bold leading-tight">{{ $step['label'] }}</p>
                            <p class="text-stone-400 text-[10px] mt-0.5">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 p-2.5 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="text-[10px] text-blue-600 leading-relaxed">Pendaftaran akan diverifikasi oleh admin. Anda dapat login setelah akun disetujui.</p>
                </div>
            </div>

            {{-- FORM --}}
            <div class="p-5 md:p-6">

                @if($errors->any())
                <div class="p-3 mb-4 bg-red-50 border border-red-200 rounded-2xl">
                    <div class="flex items-center gap-2 mb-1.5">
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

                <form method="POST" action="{{ route('daftar.external.store') }}" id="formDaftar">
                    @csrf

                    <div class="space-y-4">

                        {{-- SEKSI 1 : Akun --}}
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[.2em] mb-2">Informasi Akun</p>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-semibold text-stone-500 mb-1">Nama Lengkap <span class="text-red-400">*</span></label>
                                    <input name="nama" type="text" value="{{ old('nama') }}" placeholder="Nama lengkap sesuai KTP"
                                        class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Email <span class="text-red-400">*</span></label>
                                        <input name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">No. HP</label>
                                        <input name="hp" type="text" value="{{ old('hp') }}" placeholder="08xxxxxxxxxx"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Password <span class="text-red-400">*</span></label>
                                        <input name="password" type="password" placeholder="Min. 6 karakter"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Konfirmasi <span class="text-red-400">*</span></label>
                                        <input name="konfirmasi" type="password" placeholder="Ulangi password"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-stone-500 mb-1">Alamat Domisili / KTP</label>
                                    <textarea name="alamat" rows="1" placeholder="Alamat lengkap sesuai KTP"
                                        class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 resize-none focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="h-px bg-stone-100"></div>

                        {{-- SEKSI 2 : Kegiatan --}}
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[.2em] mb-2">Informasi Kegiatan</p>
                            <div class="space-y-2">

                                {{-- Pilih Jenis --}}
                                <div>
                                    <label class="block text-xs font-semibold text-stone-500 mb-1.5">Jenis Kegiatan <span class="text-red-400">*</span></label>
                                    <div class="grid grid-cols-3 gap-2" id="jenisCards">
                                        @foreach([
                                            'pkl' => ['label' => 'PKL', 'icon' => 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342'],
                                            'magang' => ['label' => 'Magang', 'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0'],
                                            'orientasi' => ['label' => 'Orientasi', 'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                                        ] as $value => $item)
                                        @php $isSelected = old('jenis') === $value; @endphp
                                        <label data-jenis="{{ $value }}"
                                            class="jenis-card flex items-center justify-center gap-1.5 py-2 px-2 rounded-xl border cursor-pointer transition-all duration-200 text-center
                                            {{ $isSelected ? 'border-blue-400 bg-blue-50 shadow-[0_0_0_3px_rgba(59,159,209,0.15)]' : 'border-stone-200 bg-white hover:border-blue-300 hover:bg-blue-50/40' }}">
                                            <input type="radio" name="jenis" value="{{ $value }}" {{ $isSelected ? 'checked' : '' }} class="hidden">
                                            <div class="jenis-icon w-6 h-6 rounded-lg flex items-center justify-center transition-colors duration-200 flex-shrink-0
                                                {{ $isSelected ? 'bg-blue-500' : 'bg-stone-100' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 {{ $isSelected ? 'text-white' : 'text-stone-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                                </svg>
                                            </div>
                                            <span class="text-[11px] font-bold text-stone-700">{{ $item['label'] }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('jenis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Institusi / Universitas <span class="text-red-400">*</span></label>
                                        <input name="institusi" type="text" value="{{ old('institusi') }}" placeholder="Nama institusi asal"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                        @error('institusi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Program Studi <span class="text-red-400">*</span></label>
                                        <input name="program_studi" type="text" value="{{ old('program_studi') }}" placeholder="Mis. D3 Keperawatan"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                        @error('program_studi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Semester <span class="text-red-400">*</span></label>
                                        <input name="semester" type="number" min="1" max="14" value="{{ old('semester') }}" placeholder="Mis. 5"
                                            class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                        @error('semester') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-stone-500 mb-1">Unit Penempatan</label>
                                        <div class="relative">
                                            <select name="id_unit"
                                                class="w-full px-3 py-2 pr-9 text-sm border border-stone-200 rounded-lg bg-white text-stone-700 outline-none appearance-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200">
                                                <option value="">-- Opsional --</option>
                                                @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ old('id_unit') == $unit->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                                                @endforeach
                                            </select>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-stone-500 mb-1">Periode Kegiatan <span class="text-red-400">*</span></label>
                                    <div class="grid grid-cols-2 gap-2.5">
                                        <div>
                                            <input name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai') }}"
                                                class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                            @error('tanggal_mulai') <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <input name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai') }}"
                                                class="w-full px-3 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-800 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition-all duration-200" />
                                            @error('tanggal_selesai') <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4 pt-3 border-t border-stone-100">
                        <p class="text-xs text-stone-400 order-2 sm:order-1">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:text-blue-700 hover:underline transition-colors duration-200">Login di sini</a>
                        </p>
                        <button type="submit"
                            class="order-1 sm:order-2 relative w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-white text-sm font-bold overflow-hidden
                               shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55)]
                               active:scale-[.97] transition-all duration-200"
                            style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                            <span class="relative">Daftar Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <p class="text-center text-stone-400 text-xs mt-3">© {{ date('Y') }} RSU Prima Medika</p>
    </div>

    <script>
        document.querySelectorAll('.jenis-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.jenis-card').forEach(c => {
                    c.classList.remove('border-blue-400', 'bg-blue-50', 'shadow-[0_0_0_3px_rgba(59,159,209,0.15)]');
                    c.classList.add('border-stone-200', 'bg-white');
                    c.querySelector('.jenis-icon').classList.remove('bg-blue-500');
                    c.querySelector('.jenis-icon').classList.add('bg-stone-100');
                    c.querySelector('.jenis-icon svg').classList.remove('text-white');
                    c.querySelector('.jenis-icon svg').classList.add('text-stone-500');
                });

                this.classList.remove('border-stone-200', 'bg-white');
                this.classList.add('border-blue-400', 'bg-blue-50', 'shadow-[0_0_0_3px_rgba(59,159,209,0.15)]');
                this.querySelector('.jenis-icon').classList.remove('bg-stone-100');
                this.querySelector('.jenis-icon').classList.add('bg-blue-500');
                this.querySelector('.jenis-icon svg').classList.remove('text-stone-500');
                this.querySelector('.jenis-icon svg').classList.add('text-white');

                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>

</body>

</html>
