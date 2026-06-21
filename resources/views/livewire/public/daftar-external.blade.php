<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Peserta Eksternal — RSU Prima Medika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gradient-to-br from-[#0F5A8C] via-[#1A78B0] to-[#3B9FD1] py-8 px-4">

<div class="max-w-lg mx-auto">

    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white/30 shadow-lg mx-auto mb-4">
            <img src="{{ asset('images/logo/logo.png') }}" class="w-full h-full object-cover" alt="Logo">
        </div>
        <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-1">RSU Prima Medika</p>
        <h1 class="text-white font-bold text-xl">Pendaftaran Peserta Eksternal</h1>
        <p class="text-white/60 text-sm mt-1">Isi form di bawah untuk mendaftar</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

        <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#3B9FD1,#1A78B0,#0F5A8C)"></div>

        <div class="p-6 space-y-5">

            {{-- Info Akun --}}
            <div>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-3">Informasi Akun</p>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Nama Lengkap *</label>
                        <input wire:model="nama" type="text" placeholder="Nama lengkap"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Email *</label>
                        <input wire:model="email" type="email" placeholder="email@domain.com"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Password *</label>
                            <input wire:model="password" type="password" placeholder="Min. 6 karakter"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Konfirmasi *</label>
                            <input wire:model="konfirmasi" type="password" placeholder="Ulangi password"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">No. HP</label>
                            <input wire:model="hp" type="text" placeholder="08xxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Alamat KTP</label>
                            <input wire:model="alamat" type="text" placeholder="Alamat domisili"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-stone-100">

            {{-- Info Kegiatan --}}
            <div>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-3">Informasi Kegiatan</p>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Jenis *</label>
                        <select wire:model.live="jenis"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition">
                            <option value="">-- Pilih Jenis --</option>
                            <optgroup label="PKL / Magang">
                                <option value="pkl">PKL</option>
                                <option value="magang">Magang</option>
                                <option value="orientasi">Orientasi</option>
                            </optgroup>
                            <optgroup label="Karyawan External">
                                <option value="karyawan_iss">ISS</option>
                                <option value="karyawan_bss">BSS</option>
                                <option value="karyawan_adidaya">PT. Adidaya</option>
                                <option value="karyawan_bayi_tabung">Bayi Tabung</option>
                                <option value="karyawan_koperasi">Koperasi</option>
                                <option value="karyawan_lotus_spa">Lotus SPA</option>
                            </optgroup>
                        </select>
                        @error('jenis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">
                            {{ $isKaryawan ? 'Perusahaan / Vendor' : 'Institusi / Universitas' }} *
                        </label>
                        <input wire:model="institusi" type="text"
                            placeholder="{{ $isKaryawan ? 'Nama perusahaan' : 'Nama institusi asal' }}"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                        @error('institusi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Unit Penempatan</label>
                        <select wire:model="idUnit"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition">
                            <option value="">-- Pilih Unit (opsional) --</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Pembimbing</label>
                        <select wire:model="idSupervisor"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                   focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 transition">
                            <option value="">-- Pilih Pembimbing (opsional) --</option>
                            @foreach($supervisors as $sv)
                            <option value="{{ $sv->id }}">{{ $sv->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Periode — hanya untuk PKL/Magang --}}
                    @if(!$isKaryawan && $jenis)
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Tanggal Mulai *</label>
                            <input wire:model="tanggalMulai" type="date"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                            @error('tanggalMulai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 mb-1.5 uppercase tracking-wider">Tanggal Selesai *</label>
                            <input wire:model="tanggalSelesai" type="date"
                                class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50
                                       focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400/15 focus:bg-white transition"/>
                            @error('tanggalSelesai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Info --}}
            <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl">
                <p class="text-xs text-blue-600">
                    📋 Pendaftaran akan diverifikasi oleh admin terlebih dahulu.
                    Anda akan mendapat konfirmasi setelah akun disetujui.
                </p>
            </div>

            {{-- Submit --}}
            <button wire:click="simpan" wire:loading.attr="disabled"
                class="w-full py-3 rounded-xl text-sm font-bold text-white transition
                       hover:-translate-y-0.5 active:scale-95 disabled:opacity-50
                       shadow-[0_4px_14px_-3px_rgba(15,79,122,.4)]"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span wire:loading.remove wire:target="simpan">Daftar Sekarang</span>
                <span wire:loading wire:target="simpan">Mendaftarkan...</span>
            </button>

            <p class="text-center text-xs text-stone-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Login di sini</a>
            </p>

        </div>
    </div>

    <p class="text-center text-white/30 text-xs mt-4">© {{ date('Y') }} RSU Prima Medika</p>
</div>

@livewireScripts
</body>
</html>