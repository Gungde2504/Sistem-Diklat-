<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Sertifikat — RSU Prima Medika</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans min-h-screen p-4">

    <div class="max-w-2xl mx-auto">

        {{-- Logo --}}
        <div class="text-center mb-6 pt-4">
            <img src="{{ asset('images/logo/logo.png') }}"
                class="w-16 h-16 rounded-full mx-auto mb-3 object-cover" alt="Logo">
            <h1 class="text-lg font-bold text-gray-800">RSU Prima Medika</h1>
            <p class="text-sm text-gray-500">Sistem Verifikasi Sertifikat</p>
        </div>

        @if($detail)

        {{-- Status Valid --}}
        <div class="bg-green-500 rounded-2xl px-5 py-4 flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-base">✅ Sertifikat Valid & Terverifikasi</p>
                <p class="text-white/80 text-xs">Dokumen ini tercatat resmi di sistem RSU Prima Medika</p>
            </div>
        </div>

        {{-- Sisi Depan Sertifikat --}}
        @if($detail->cert_file_path)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                <div class="w-6 h-6 bg-[#1B5E7B] rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">A</span>
                </div>
                <p class="text-sm font-semibold text-gray-800">Sertifikat — Sisi Depan</p>
            </div>
            @php $ext = pathinfo($detail->cert_file_path, PATHINFO_EXTENSION); @endphp
            @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
            <img src="{{ asset('storage/'.$detail->cert_file_path) }}"
                alt="Sertifikat Depan"
                class="w-full object-contain" />
            @else
            <div class="p-6 text-center">
                <a href="{{ asset('storage/'.$detail->cert_file_path) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-[#1B5E7B] text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-[#154a63] transition">
                    📄 Lihat Sertifikat Depan (PDF)
                </a>
            </div>
            @endif
        </div>
        @endif

        {{-- Sisi Belakang --}}
        @if($detail->cert_back_path)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                <div class="w-6 h-6 bg-[#E87722] rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">B</span>
                </div>
                <p class="text-sm font-semibold text-gray-800">Sertifikat — Sisi Belakang (Nilai & QR Verifikasi)</p>
            </div>
            @php $extBack = pathinfo($detail->cert_back_path, PATHINFO_EXTENSION); @endphp
            @if(in_array(strtolower($extBack), ['jpg','jpeg','png']))
            <img src="{{ asset('storage/'.$detail->cert_back_path) }}"
                alt="Sertifikat Belakang"
                class="w-full object-contain" />
            @else
            <div class="p-5 text-center">
                <a href="{{ asset('storage/'.$detail->cert_back_path) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-[#E87722] text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-[#c9671a] transition">
                    📊 Lihat Sisi Belakang
                </a>
            </div>
            @endif
        </div>
        @endif 

        {{-- Card Detail Eksternal --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="bg-gradient-to-r from-[#1B5E7B] to-[#154a63] px-5 py-4">
                <p class="text-white/70 text-xs mb-1">Peserta</p>
                <h2 class="text-xl font-bold text-white">{{ $detail->user->nama }}</h2>
                <p class="text-white/70 text-sm mt-0.5">{{ $detail->institusi }}</p>
            </div>
            <div class="p-5 space-y-3">

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Jenis Kegiatan</p>
                        <p class="text-sm font-semibold text-gray-700 capitalize">{{ $detail->jenis }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Unit Penempatan</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $detail->unit?->nama ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Pembimbing</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $detail->supervisor?->nama ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Status</p>
                        <p class="text-sm font-semibold text-green-600 capitalize">{{ $detail->status }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Periode Kegiatan</p>
                    <p class="text-sm font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->translatedFormat('d F Y') }}
                        —
                        {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($detail->tanggal_selesai)) }} hari
                    </p>
                </div>

                @if($detail->nilai_akhir)
                <div class="bg-[#1B5E7B]/10 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Nilai Akhir</p>
                    <p class="text-4xl font-bold text-[#1B5E7B]">{{ number_format($detail->nilai_akhir, 1) }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        @php
                        $n = (float) $detail->nilai_akhir;
                        $kualitas = $n >= 79 ? 'Sangat Baik / Lulus' :
                        ($n >= 68 ? 'Baik / Lulus' :
                        ($n >= 56 ? 'Cukup / Tidak Lulus' :
                        ($n >= 41 ? 'Kurang / Tidak Lulus' : 'Sangat Kurang / Tidak Lulus')));
                        @endphp
                        {{ $kualitas }}
                    </p>
                </div>
                @endif

                <div class="pt-3 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">
                        Diverifikasi oleh sistem RSU Prima Medika<br>
                        {{ now()->translatedFormat('d F Y, H:i') }} WITA
                    </p>
                </div>

            </div>
        </div>

        @else

        {{-- Tidak Valid --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
            <div class="bg-red-500 px-5 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold">❌ Sertifikat Tidak Valid</p>
                    <p class="text-white/80 text-xs">Token tidak ditemukan dalam sistem kami</p>
                </div>
            </div>
            <div class="p-6 text-center">
                <p class="text-sm text-gray-500 mb-2">Sertifikat ini tidak terdaftar dalam sistem RSU Prima Medika.</p>
                <p class="text-xs text-gray-400">Pastikan Anda menscan QR Code dari sertifikat asli yang diterbitkan resmi.</p>
            </div>
        </div>

        @endif

        <p class="text-center text-xs text-gray-400 mt-6 pb-4">
            © {{ date('Y') }} RSU Prima Medika — Sistem Informasi Diklat & Seminar
        </p>

    </div>

</body>

</html>