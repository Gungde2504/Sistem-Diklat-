<div class="space-y-4">

    {{-- ── SERTIFIKAT PKL/MAGANG ── --}}
    @if($detail)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-blue-500 to-blue-700"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">
                Sertifikat {{ ucfirst($detail->jenis) }}
            </p>
        </div>
        <div class="p-4">

            {{-- Info Detail Peserta --}}
            <div class="bg-blue-50/60 border border-blue-100 rounded-2xl p-4 mb-4 space-y-0
                        shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                @foreach([
                    ['label' => 'Nama',       'value' => $detail->user->nama],
                    ['label' => 'Institusi',  'value' => $detail->institusi],
                    ['label' => 'Unit',       'value' => $detail->unit?->nama ?? '-'],
                    ['label' => 'Pembimbing', 'value' => $detail->supervisor?->nama ?? '-'],
                    ['label' => 'Periode',    'value' => \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y').' — '.\Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y')],
                ] as $i => $info)
                <div class="flex items-center justify-between py-2 {{ $i < 4 ? 'border-b border-blue-100' : '' }}">
                    <span class="text-xs text-stone-400">{{ $info['label'] }}</span>
                    <span class="text-xs font-semibold text-stone-700 text-right max-w-44">{{ $info['value'] }}</span>
                </div>
                @endforeach
                <div class="flex items-center justify-between py-2 border-b border-blue-100">
                    <span class="text-xs text-stone-400">Status</span>
                    <span class="text-xs font-semibold capitalize
                        {{ $detail->status === 'aktif' ? 'text-green-600' :
                           ($detail->status === 'selesai' ? 'text-blue-600' : 'text-red-500') }}">
                        {{ $detail->status }}
                    </span>
                </div>
                @if($detail->nilai_akhir)
                <div class="flex items-center justify-between pt-2.5 mt-0.5">
                    <span class="text-xs font-bold text-stone-500 uppercase tracking-widest">Nilai Akhir</span>
                    <span class="text-lg font-bold text-blue-700">{{ number_format($detail->nilai_akhir, 1) }}</span>
                </div>
                @endif
            </div>

            @if($detail->bisaGenerateSertifikat() && ($detail->cert_file_path || $detail->cert_back_path))

                <p class="text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-3">Dokumen Sertifikat</p>

                <div class="space-y-3">

                    {{-- ── SISI DEPAN ── --}}
                    @if($detail->cert_file_path)
                    @php $extDepan = strtolower(pathinfo($detail->cert_file_path, PATHINFO_EXTENSION)); @endphp
                    <div class="border border-stone-200 rounded-2xl overflow-hidden
                                shadow-[0_2px_8px_-2px_rgba(120,113,108,.12)]">
                        <div class="bg-stone-50 px-4 py-2.5 flex items-center justify-between border-b border-stone-200">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold
                                            shadow-[0_1px_4px_rgba(15,79,122,.3)]"
                                     style="background:linear-gradient(135deg,#3B9FD1,#0F5A8C)">A</div>
                                <p class="text-xs font-semibold text-stone-700">Sisi Depan</p>
                            </div>
                            <a href="{{ asset('storage/'.$detail->cert_file_path) }}"
                               download
                               class="relative flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-white text-[10.5px] font-semibold overflow-hidden
                                      shadow-[0_2px_6px_-1px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                                      hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(15,79,122,.45)]
                                      active:scale-95 transition-all duration-200"
                               style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span class="relative">Unduh</span>
                            </a>
                        </div>
                        @if(in_array($extDepan, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$detail->cert_file_path) }}"
                             alt="Sertifikat Depan"
                             class="w-full object-contain max-h-56"/>
                        @else
                        <div class="px-4 py-5 flex items-center gap-3 bg-red-50/50">
                            <div class="w-10 h-10 rounded-xl bg-red-100 border border-red-200 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-stone-700">Sertifikat PDF</p>
                                <p class="text-xs text-stone-400">Klik Unduh untuk menyimpan file</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- ── SISI BELAKANG ── --}}
                    @if($detail->cert_back_path)
                    @php $extBelakang = strtolower(pathinfo($detail->cert_back_path, PATHINFO_EXTENSION)); @endphp
                    <div class="border border-stone-200 rounded-2xl overflow-hidden
                                shadow-[0_2px_8px_-2px_rgba(120,113,108,.12)]">
                        <div class="bg-stone-50 px-4 py-2.5 flex items-center justify-between border-b border-stone-200">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold
                                            shadow-[0_1px_4px_rgba(234,88,12,.3)]"
                                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">B</div>
                                <p class="text-xs font-semibold text-stone-700">Sisi Belakang</p>
                                <span class="text-[10px] text-stone-400">(Data + QR)</span>
                            </div>
                            <a href="{{ asset('storage/'.$detail->cert_back_path) }}"
                               download
                               class="relative flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-white text-[10.5px] font-semibold overflow-hidden
                                      shadow-[0_2px_6px_-1px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                                      hover:-translate-y-0.5 hover:shadow-[0_4px_10px_-2px_rgba(234,88,12,.45)]
                                      active:scale-95 transition-all duration-200"
                               style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)">
                                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span class="relative">Unduh</span>
                            </a>
                        </div>

                        {{-- Preview sisi belakang sama seperti depan --}}
                        @if(in_array($extBelakang, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$detail->cert_back_path) }}"
                             alt="Sertifikat Belakang"
                             class="w-full object-contain max-h-56"/>
                        @else
                        <div class="px-4 py-5 flex items-center gap-3 bg-orange-50/50">
                            <div class="w-10 h-10 rounded-xl bg-orange-100 border border-orange-200 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-stone-700">Data Kegiatan + QR Verifikasi</p>
                                <p class="text-xs text-stone-400">Klik Unduh untuk menyimpan file</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                </div>

                {{-- Link Verifikasi Publik --}}
                @if($detail->cert_qr_token)
                <div class="mt-4 p-3.5 bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-xl
                            shadow-[0_1px_0_rgba(255,255,255,.8)_inset] flex items-start gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                    <div class="min-w-0">
                        <p class="text-[10.5px] font-bold text-blue-700 mb-1">Link Verifikasi Publik</p>
                        <a href="{{ url('/sertifikat/verify/'.$detail->cert_qr_token) }}" target="_blank"
                           class="text-xs text-blue-600 hover:text-blue-700 break-all transition-colors">
                            {{ url('/sertifikat/verify/'.$detail->cert_qr_token) }}
                        </a>
                    </div>
                </div>
                @endif

            @elseif($detail->status === 'selesai' && $detail->bisaGenerateSertifikat())
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-yellow-50 border border-yellow-200 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-stone-700 mb-1">Menunggu Generate Sertifikat</p>
                    <p class="text-xs text-stone-400">Status sudah selesai. Admin sedang memproses sertifikat Anda.</p>
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-stone-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-stone-500 mb-1">Sertifikat Belum Tersedia</p>
                    <p class="text-xs text-stone-400 leading-relaxed">
                        Sertifikat PKL/Magang tersedia setelah kegiatan selesai dan admin men-generate sertifikat.
                    </p>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ── SERTIFIKAT DIKLAT & SEMINAR ── --}}
    @if($sertifikatDiklat->count() > 0)
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-stone-100">
            <div class="w-0.5 h-4 rounded-full bg-gradient-to-b from-orange-500 to-orange-600"></div>
            <p class="text-sm font-semibold text-stone-800 tracking-tight">Sertifikat Diklat & Seminar</p>
            <span class="ml-auto text-[10.5px] font-semibold px-2 py-0.5 rounded-full
                         bg-orange-50 text-orange-500 border border-orange-200">
                {{ $sertifikatDiklat->count() }} sertifikat
            </span>
        </div>
        <div class="divide-y divide-stone-50">
            @foreach($sertifikatDiklat as $s)
            <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-stone-50/60 transition-colors duration-150">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                            shadow-[0_2px_6px_-1px_rgba(234,88,12,.3)]"
                     style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-stone-800 truncate">{{ $s->diklat?->nama }}</p>
                    <p class="text-xs text-stone-400 mt-0.5">{{ $s->diklat?->tglJamMulai }} · {{ $s->diklat?->tempat }}</p>
                </div>
                <a href="{{ asset('storage/'.$s->file) }}" download
                   class="relative flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-white text-[10.5px] font-semibold flex-shrink-0 overflow-hidden
                          shadow-[0_2px_8px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                          hover:-translate-y-0.5 hover:shadow-[0_4px_12px_-2px_rgba(15,79,122,.45)]
                          active:scale-95 transition-all duration-200"
                   style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span class="relative">Unduh</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>