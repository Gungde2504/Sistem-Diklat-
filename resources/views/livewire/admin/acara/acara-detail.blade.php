<div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 animate-pulse-once">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium flex-1">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.acara.index') }}"
        class="inline-flex items-center gap-2 text-sm font-medium text-stone-500 hover:text-stone-800
              px-3 py-2 rounded-xl bg-white border border-stone-200 mb-4
              shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_2px_6px_rgba(120,113,108,.08)]
              hover:border-stone-300 hover:-translate-y-px transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Manajemen Acara
    </a>

    {{-- ── HEADER CARD ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden mb-4
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

        {{-- Banner --}}
        <div class="relative overflow-hidden px-6 py-5"
            style="background: linear-gradient(160deg, #FF8C00 0%, #E85000 60%, #C73D00 100%)">
            {{-- Bubble decorations --}}
            <div class="absolute -top-14 -right-14 w-48 h-48 rounded-full bg-white/[.04] pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-36 h-36 rounded-full bg-white/[.03] pointer-events-none"></div>

            <div class="relative z-10 flex items-start justify-between gap-4">
                <div>
                    {{-- Badges --}}
                    <div class="flex items-center gap-2 mb-2.5">
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full
                                     bg-white/[.18] text-white/95 border border-white/25 backdrop-blur-sm">
                            {{ $diklat->jenisDiklat }}
                        </span>
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm
                                {{ $diklat->status === 'Berlangsung' ? 'bg-white/25 text-white border border-white/40' :
                                ($diklat->status === 'Terbuka'    ? 'bg-white/25 text-white border border-white/40' :
                                ($diklat->status === 'Selesai'    ? 'bg-black/20 text-white/80 border border-white/20' :
                                'bg-white/20 text-white/90 border border-white/30')) }}">
                            {{ $diklat->status }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-white tracking-tight mb-1">{{ $diklat->nama }}</h2>
                    <p class="text-sm text-white/65">{{ $diklat->namaNarasumber }}</p>
                </div>

                {{-- QR Controls --}}
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.absensi.tampil-qr', $diklat->id) }}"
                            class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
                                bg-white/20 text-white border border-white/35
                                hover:bg-white/30 hover:-translate-y-px transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                            Tampil QR
                        </a>
                        <button wire:click="toggleQr"
                            class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all duration-200 hover:-translate-y-px
                                {{ $diklat->IsActive
                                    ? 'bg-white/20 text-white border border-white/35 hover:bg-white/30'
                                    : 'bg-black/15 text-white/70 border border-white/20 hover:bg-black/25' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $diklat->IsActive ? 'bg-white' : 'bg-white/40' }}"></span>
                            QR {{ $diklat->IsActive ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </div>
                    <p class="text-[10.5px] text-white/40 font-mono">{{ $diklat->QRcode }}</p>
                </div>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-stone-100">
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Tanggal Mulai</p>
                <p class="text-sm font-semibold text-stone-800">{{ $diklat->tglJamMulai }}</p>
            </div>
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Tanggal Selesai</p>
                <p class="text-sm font-semibold text-stone-800">{{ $diklat->tglJamSelesai }}</p>
            </div>
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Tempat</p>
                <p class="text-sm font-semibold text-stone-800">{{ $diklat->tempat }}</p>
            </div>
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Peserta</p>
                <p class="text-sm font-semibold text-stone-800">
                    {{ $diklat->absensiDiklats()->count() }}
                    <span class="text-stone-400 font-normal">/ {{ $diklat->kuota }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="flex gap-1 bg-white border border-stone-200 rounded-2xl p-1 mb-4 w-fit
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_3px_10px_rgba(120,113,108,.09)]">
        @foreach(['peserta' => 'Peserta', 'materi' => 'Materi & Foto', 'sertifikat' => 'Sertifikat'] as $key => $label)
        <button wire:click="setTab('{{ $key }}')"
            class="px-5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   {{ $tab === $key
                       ? 'bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 text-white font-semibold shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-800 hover:bg-stone-100' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ── TAB PESERTA ── --}}
    @if($tab === 'peserta')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <div>
                <span class="text-sm font-semibold text-stone-800">Daftar Peserta</span>
                <span class="text-xs text-stone-400 ml-2">{{ $peserta->total() }} peserta</span>
            </div>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-stone-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.300ms="searchPeserta" type="text"
                    placeholder="Cari peserta..."
                    class="pl-8 pr-4 py-2 text-xs border border-stone-200 rounded-xl w-44
                           bg-stone-50 text-stone-800 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                           transition-all duration-200" />
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100">
                        <th class="text-left px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Nama Peserta</th>
                        <th class="text-left px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Unit</th>
                        <th class="text-center px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Durasi</th>
                        <th class="text-center px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-center px-5 py-3 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($peserta as $p)
                    <tr class="hover:bg-stone-50/70 transition-colors duration-150">
                        <td class="px-5 py-3.5 text-sm text-stone-400">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm font-medium text-stone-800">{{ $p->namaPeserta }}</p>
                            <p class="text-xs text-stone-400 mt-0.5">{{ $p->user?->nip ?? $p->user?->email }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-stone-600">{{ $p->user?->unit ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-center text-sm text-stone-700">{{ $p->durasi }} menit</td>
                        <td class="px-5 py-3.5 text-center text-xs text-stone-500">{{ $p->date?->format('d M Y') }}</td>
                        <td class="px-5 py-3.5 text-center">
                            <button
                                @click="$store.deleteModal.show(
                                    'Hapus Peserta',
                                    'Yakin ingin menghapus peserta &quot;{{ addslashes($p->nama) }}&quot; dari daftar?',
                                    () => $wire.hapusPeserta({{ $p->id }})
                                )"
                                                            class="w-8 h-8 rounded-xl inline-flex items-center justify-center
                                    bg-gradient-to-br from-red-50 to-red-100 text-red-500
                                    border border-red-200
                                    shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                                    hover:scale-110 hover:shadow-[0_4px_10px_-2px_rgba(239,68,68,.3)]
                                    transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-sm text-stone-400">
                            Belum ada peserta yang hadir
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peserta->hasPages())
        <div class="px-5 py-4 border-t border-stone-100">{{ $peserta->links() }}</div>
        @endif
    </div>
    @endif

    {{-- ── TAB MATERI & FOTO ── --}}
    @if($tab === 'materi')
    <div class="space-y-4">

        {{-- Foto Dokumentasi --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)] transition-shadow duration-300">
            <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-500 to-orange-400"></div>
                    <h3 class="text-sm font-semibold text-stone-800">Foto Dokumentasi</h3>
                </div>
                <a href="{{ route('admin.acara.foto', $diklat) }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold
                          bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600
                          border border-orange-200
                          shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                          hover:from-orange-100 hover:to-orange-200 hover:-translate-y-px
                          hover:shadow-[0_4px_10px_-2px_rgba(234,88,12,.25)]
                          transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    Kelola Foto
                </a>
            </div>

            @php
            $previewFotos = \App\Models\MFileDiklat::where('id_diklat', $diklat->id)->where('type','foto')->orderByDesc('created_at')->limit(6)->get();
            $totalFoto = \App\Models\MFileDiklat::where('id_diklat', $diklat->id)->where('type','foto')->count();
            @endphp

            @if($previewFotos->count() > 0)
            <div class="p-4 grid grid-cols-3 gap-2.5">
                @foreach($previewFotos as $foto)
                <div class="relative rounded-xl overflow-hidden aspect-square bg-stone-100 group cursor-pointer">
                    <img src="{{ asset('storage/'.$foto->file) }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200"></div>
                </div>
                @endforeach
            </div>
            @if($totalFoto > 6)
            <div class="pb-4 text-center">
                <a href="{{ route('admin.acara.foto', $diklat) }}"
                    class="text-xs text-orange-500 font-semibold hover:text-orange-600 transition-colors">
                    Lihat semua {{ $totalFoto }} foto →
                </a>
            </div>
            @endif
            @else
            <div class="py-10 px-5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <p class="text-sm text-stone-400 mb-3">Belum ada foto dokumentasi</p>
                <a href="{{ route('admin.acara.foto', $diklat) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                          bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600
                          shadow-[0_4px_14px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.2)_inset]
                          hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(234,88,12,.5)]
                          transition-all duration-200">
                    📷 Upload Foto
                </a>
            </div>
            @endif
        </div>

        {{-- Materi Diklat --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)] transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                <h3 class="text-sm font-semibold text-stone-800">Materi Diklat</h3>
            </div>

            {{-- Upload row --}}
            <div class="flex gap-3 items-start px-5 py-4 border-b border-stone-50">
                <input wire:model="materiFile" type="file"
                    accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx"
                    class="flex-1 px-3 py-2 text-xs border border-stone-200 rounded-xl bg-stone-50
                           text-stone-700 outline-none
                           focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15
                           transition-all duration-200" />
                <button wire:click="uploadMateri" wire:loading.attr="disabled"
                    class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600
                           shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                           hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-3px_rgba(234,88,12,.45)]
                           disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0
                           transition-all duration-200">
                    <span wire:loading.remove wire:target="uploadMateri">Upload</span>
                    <span wire:loading wire:target="uploadMateri">...</span>
                </button>
            </div>
            <p class="text-xs text-stone-400 px-5 pb-3 pt-1">PDF, Word, PowerPoint, Excel — maks 20MB</p>

            @php
            $materis = \App\Models\MFileDiklat::where('id_diklat',$diklat->id)->where('type','materi')->orderByDesc('created_at')->get();
            @endphp

            @if($materis->count() > 0)
            <div class="divide-y divide-stone-50">
                @foreach($materis as $materi)
                @php $ext = strtolower(pathinfo($materi->file, PATHINFO_EXTENSION)); @endphp
                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-stone-50/70 transition-colors duration-150">
                    @php
                    $extClass = match(true) {
                    $ext === 'pdf' => 'bg-red-100 text-red-600',
                    in_array($ext,['doc','docx'])=> 'bg-blue-100 text-blue-600',
                    in_array($ext,['ppt','pptx'])=> 'bg-orange-100 text-orange-600',
                    default => 'bg-green-100 text-green-600',
                    };
                    @endphp
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-[9.5px] font-bold {{ $extClass }}">
                        {{ strtoupper($ext) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-stone-800 truncate">{{ basename($materi->file) }}</p>
                        <p class="text-xs text-stone-400 mt-0.5">{{ \Carbon\Carbon::parse($materi->created_at)->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <a href="{{ asset('storage/'.$materi->file) }}" target="_blank"
                            class="text-xs font-semibold text-teal-600 hover:text-teal-700 hover:underline transition-colors">
                            Unduh
                        </a>
                        <button wire:click="hapusMateri({{ $materi->id }})" wire:confirm="Hapus materi ini?"
                            class="text-xs font-semibold text-red-500 hover:text-red-600 transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-10 text-center">
                <p class="text-sm text-stone-400">Belum ada materi yang diupload</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ── TAB SERTIFIKAT ── --}}
    @if($tab === 'sertifikat')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="p-6">

            {{-- Pretest & Posttest --}}
            @if($diklat->linkPretest || $diklat->linkPosttest)
            <div class="grid grid-cols-2 gap-4 mb-6">
                @if($diklat->linkPretest)
                <a href="{{ $diklat->linkPretest }}" target="_blank"
                    class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-2xl
                          hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-4px_rgba(59,130,246,.2)]
                          transition-all duration-200">
                    <div class="w-9 h-9 rounded-xl bg-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-700">Link Pretest</p>
                        <p class="text-xs text-blue-500 truncate max-w-[10rem]">{{ $diklat->linkPretest }}</p>
                    </div>
                </a>
                @endif
                @if($diklat->linkPosttest)
                <a href="{{ $diklat->linkPosttest }}" target="_blank"
                    class="flex items-center gap-3 p-4 bg-orange-50 border border-orange-200 rounded-2xl
                          hover:-translate-y-0.5 hover:shadow-[0_6px_16px_-4px_rgba(234,88,12,.2)]
                          transition-all duration-200">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                        style="background:linear-gradient(135deg,#F97316,#EA580C)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-orange-700">Link Posttest</p>
                        <p class="text-xs text-orange-500 truncate max-w-[10rem]">{{ $diklat->linkPosttest }}</p>
                    </div>
                </a>
                @endif
            </div>
            @endif

            {{-- Generate Sertifikat --}}
            <div class="flex flex-col items-center text-center py-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100
                            border border-orange-200 flex items-center justify-center mb-4
                            shadow-[0_4px_14px_-4px_rgba(234,88,12,.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-stone-700 mb-1">Generate Sertifikat Bulk</p>
                <p class="text-xs text-stone-400 mb-6 max-w-sm">
                    Upload template sertifikat dan generate untuk seluruh
                    <strong class="text-stone-600">{{ $diklat->absensiDiklats()->count() }} peserta</strong>
                    yang hadir sekaligus.
                </p>
                <a href="{{ route('admin.acara.sertifikat', $diklat->id) }}"
                    class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl text-sm font-bold text-white
                          bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600
                          shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                          hover:-translate-y-0.5 hover:scale-[1.02]
                          hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.2)_inset]
                          active:scale-[.97] transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    Buka Halaman Sertifikat
                </a>
            </div>

        </div>
    </div>
    @endif

</div>