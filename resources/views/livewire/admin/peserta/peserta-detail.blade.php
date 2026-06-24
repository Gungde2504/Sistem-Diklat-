<div>

    {{-- Flash Success --}}
    @if(session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Flash Error --}}
    @if(session('error'))
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- ── HEADER CARD ── --}}
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden mb-5
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">

        {{-- Banner --}}
        <div class="relative overflow-hidden px-6 py-5"
            style="background:linear-gradient(135deg,#FF8C00 0%,#E85000 60%,#C73D00 100%)">
            <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/[.05] pointer-events-none"></div>
            <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-white/[.04] pointer-events-none"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2.5 flex-wrap">
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full uppercase
                                     bg-white/20 text-white border border-white/25 backdrop-blur-sm">
                            {{ $isKaryawan
                                ? (\App\Models\DetailEksternal::jenisOptions()[$detail->jenis] ?? $detail->jenis)
                                : $detail->jenis }}
                        </span>
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm
                            {{ $detail->status === 'aktif'    ? 'bg-green-400/25 text-green-200 border border-green-400/35'  :
                               ($detail->status === 'selesai' ? 'bg-white/20 text-white/80 border border-white/25' :
                               'bg-red-400/25 text-red-200 border border-red-400/35') }}">
                            {{ ucfirst(str_replace('_', ' ', $detail->status)) }}
                        </span>
                        @if($detail->approval_status === 'pending')
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full bg-yellow-400/25 text-yellow-200 border border-yellow-400/35 backdrop-blur-sm">
                            Pending Approval
                        </span>
                        @elseif($detail->approval_status === 'rejected')
                        <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-full bg-red-400/35 text-red-100 border border-red-400/35 backdrop-blur-sm">
                            Ditolak
                        </span>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold text-white tracking-tight mb-0.5">{{ $detail->user?->nama }}</h2>
                    <p class="text-white/65 text-sm">{{ $detail->user?->email }}</p>
                    <p class="text-white/45 text-xs mt-0.5">{{ $detail->institusi }}</p>
                </div>

                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    {{-- ACC / Tolak --}}
                    @if($detail->approval_status === 'pending')
                    @php $namaPeserta = str_replace("'", "\'", $detail->user->nama ?? '-'); @endphp
                    <button
                        @click="$store.deleteModal.show('Setujui Peserta', 'Setujui pendaftaran {{ $namaPeserta }}? Peserta dapat login ke sistem.', () => $wire.approve(), 'approve')"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
               bg-green-400/25 text-green-100 border border-green-400/35 backdrop-blur-sm
               hover:bg-green-400/40 hover:-translate-y-px transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Setujui
                    </button>
                    <button
                        @click="$store.deleteModal.show('Tolak Peserta', 'Tolak pendaftaran {{ $namaPeserta }}? Peserta tidak dapat login ke sistem.', () => $wire.reject(), 'reject')"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
               bg-red-400/25 text-red-100 border border-red-400/35 backdrop-blur-sm
               hover:bg-red-400/40 hover:-translate-y-px transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Tolak
                    </button>
                    @endif

                    @if($detail->status === 'aktif' && !$isKaryawan)
                    @php $namaPeserta = str_replace("'", "\'", $detail->user->nama ?? '-'); @endphp
                    <button
                        @click="$store.deleteModal.show('Tandai Selesai', 'Tandai {{ $namaPeserta }} sebagai selesai? Status peserta akan diubah menjadi selesai.', () => $wire.ubahStatus('selesai'), 'confirm')"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
               bg-white/20 text-white border border-white/35 backdrop-blur-sm
               hover:bg-white/30 hover:-translate-y-px transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tandai Selesai
                    </button>
                    @endif

                    <a href="{{ route('admin.peserta.index') }}"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold
                              bg-black/15 text-white/70 border border-white/20 backdrop-blur-sm
                              hover:bg-black/25 hover:-translate-y-px transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-stone-100">
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Unit</p>
                <p class="text-sm font-semibold text-stone-800">{{ $detail->unit?->nama ?? '-' }}</p>
            </div>
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">{{ $isKaryawan ? 'Perusahaan' : 'Pembimbing' }}</p>
                <p class="text-sm font-semibold text-stone-800">
                    {{ $isKaryawan ? $detail->institusi : ($detail->supervisor?->nama ?? '-') }}
                </p>
            </div>
            @if(!$isKaryawan)
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Periode</p>
                <p class="text-sm font-semibold text-stone-800">
                    {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M') }} —
                    {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y') }}
                </p>
            </div>
            @else
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Approval</p>
                <p class="text-sm font-semibold
                    {{ $detail->approval_status === 'approved' ? 'text-green-600' :
                       ($detail->approval_status === 'pending'  ? 'text-yellow-600' : 'text-red-500') }}">
                    {{ ucfirst($detail->approval_status) }}
                </p>
            </div>
            @endif
            <div class="px-5 py-4 text-center hover:bg-stone-50/70 transition-colors">
                <p class="text-[11px] text-stone-400 mb-1">Kehadiran Valid</p>
                <p class="text-sm font-semibold text-stone-800">{{ $totalHadir }} / {{ $totalAbsensi }} hari</p>
            </div>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="flex gap-1.5 bg-white border border-stone-200 rounded-2xl p-1.5 mb-5 w-fit
                shadow-[0_1px_0_rgba(255,255,255,.9)_inset,0_3px_10px_rgba(120,113,108,.09)]">
        @php
        $tabs = ['absensi' => 'Absensi GPS', 'jurnal' => 'Jurnal'];
        if (!$isKaryawan) $tabs['sertifikat'] = 'Sertifikat';
        @endphp
        @foreach($tabs as $key => $label)
        <button wire:click="setTab('{{ $key }}')"
            class="px-5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                   {{ $tab === $key
                       ? 'text-white font-semibold shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                       : 'text-stone-500 hover:text-stone-800 hover:bg-stone-100' }}"
            @if($tab===$key) style="background:linear-gradient(135deg,#FB923C 0%,#F97316 45%,#EA580C 100%)" @endif>
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ── TAB ABSENSI ── --}}
    @if($tab === 'absensi')
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100">
                        <th class="text-left px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Check-in</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Check-out</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Durasi</th>
                        <th class="text-center px-5 py-3.5 text-[10.5px] font-bold text-stone-500 uppercase tracking-wider">Status GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse($absensi as $a)
                    <tr class="hover:bg-stone-50/70 transition-colors duration-150">
                        <td class="px-5 py-3.5 text-sm text-stone-700 font-medium">
                            {{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-center text-sm text-stone-600">
                            {{ $a->checkin_at ? \Carbon\Carbon::parse($a->checkin_at)->format('H:i') : '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center text-sm text-stone-600">
                            {{ $a->checkout_at ? \Carbon\Carbon::parse($a->checkout_at)->format('H:i') : '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center text-sm text-stone-600">
                            {{ $a->durasi ? $a->durasi . ' menit' : '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-[10.5px] px-2.5 py-1 rounded-full font-semibold border
                                {{ $a->is_valid ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                                {{ $a->is_valid ? 'Valid' : 'Di luar radius' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                </div>
                                <p class="text-sm text-stone-400">Belum ada data absensi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-stone-100 bg-stone-50/50">
            {{ $absensi->links() }}
        </div>
    </div>
    @endif

    {{-- ── TAB JURNAL ── --}}
    @if($tab === 'jurnal')
    <livewire:admin.peserta.jurnal-peserta :detail="$detail" :key="'jurnal-'.$detail->id" />
    @endif

    {{-- ── TAB SERTIFIKAT — hanya PKL/Magang ── --}}
    @if($tab === 'sertifikat' && !$isKaryawan)
    <div class="space-y-4">

        {{-- Data Peserta --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-teal-600 to-teal-500"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Data Peserta</h3>
            </div>
            <div class="p-5 grid grid-cols-2 gap-3 text-xs">
                @foreach([
                ['label' => 'Nama', 'value' => $detail->user?->nama],
                ['label' => 'Institusi', 'value' => $detail->institusi],
                ['label' => 'Jenis', 'value' => ucfirst($detail->jenis)],
                ['label' => 'Unit', 'value' => $detail->unit?->nama ?? '-'],
                ['label' => 'Pembimbing', 'value' => $detail->supervisor?->nama ?? '-'],
                ['label' => 'Periode', 'value' => \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y').' — '.\Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y')],
                ['label' => 'Kehadiran Valid', 'value' => $totalHadir.' / '.$totalAbsensi.' hari'],
                ['label' => 'Status', 'value' => ucfirst($detail->status), 'color' => $detail->status === 'aktif' ? 'text-green-600' : ($detail->status === 'selesai' ? 'text-blue-600' : 'text-red-500')],
                ] as $item)
                <div class="bg-stone-50 border border-stone-100 rounded-xl p-3">
                    <p class="text-stone-400 mb-1">{{ $item['label'] }}</p>
                    <p class="font-semibold {{ $item['color'] ?? 'text-stone-700' }}">{{ $item['value'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Input Nilai --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-600 to-purple-400"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Nilai Akhir Peserta</h3>
            </div>
            <div class="p-5">
                <div class="flex gap-3">
                    <input wire:model="nilaiInput" type="number" min="0" max="100" step="0.1"
                        placeholder="0 - 100"
                        class="flex-1 px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                               focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                    <button wire:click="simpanNilai"
                        class="relative px-5 py-2.5 rounded-xl text-sm font-semibold text-white overflow-hidden flex-shrink-0
                               shadow-[0_3px_12px_-3px_rgba(234,88,12,.45),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 hover:shadow-[0_6px_18px_-4px_rgba(234,88,12,.5)]
                               active:scale-[.97] transition-all duration-200"
                        style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <span class="relative">Simpan Nilai</span>
                    </button>
                </div>
                @if($detail->nilai_akhir)
                <p class="text-xs text-green-600 mt-2 font-medium flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Nilai tersimpan: {{ number_format($detail->nilai_akhir, 1) }}
                </p>
                @endif
            </div>
        </div>

        @if($detail->bisaGenerateSertifikat())

        {{-- Upload Template --}}
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-orange-600 to-orange-400"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Upload Template Sertifikat</h3>
                <span class="text-xs text-stone-400">JPG/PNG</span>
            </div>
            <div class="p-5 grid grid-cols-2 gap-4">

                {{-- Sisi Depan --}}
                <div>
                    <p class="text-xs font-semibold text-stone-600 mb-2 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                            style="background:linear-gradient(135deg,#F97316,#EA580C)">A</span>
                        Sisi Depan
                    </p>
                    @if($templateDepanPath)
                    <div class="rounded-xl overflow-hidden border border-green-200 mb-2
                                shadow-[0_2px_8px_-2px_rgba(34,197,94,.15)]">
                        <img src="{{ asset('storage/'.$templateDepanPath) }}" class="w-full object-contain max-h-32" />
                    </div>
                    <p class="text-xs text-green-600 font-semibold mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Template depan siap
                    </p>
                    @else
                    <div class="border-2 border-dashed border-stone-200 rounded-xl p-4 text-center mb-2
                                hover:border-orange-400 hover:bg-orange-50/40 transition-all duration-200">
                        <input wire:model="templateDepan" type="file" accept=".jpg,.jpeg,.png" class="hidden" id="upload-depan">
                        <label for="upload-depan" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300 mx-auto mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                            </svg>
                            <p class="text-xs text-stone-400">Upload gambar depan</p>
                        </label>
                    </div>
                    <div wire:loading wire:target="templateDepan">
                        <p class="text-xs text-orange-500 animate-pulse mb-2 font-medium">Mengupload...</p>
                    </div>
                    @endif
                    <button wire:click="uploadTemplateDepan" wire:loading.attr="disabled"
                        class="relative w-full py-2 rounded-xl text-xs font-semibold text-white overflow-hidden
                               shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 active:scale-[.97] disabled:opacity-60 transition-all duration-200"
                        style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <span wire:loading.remove wire:target="uploadTemplateDepan" class="relative">
                            {{ $templateDepanPath ? 'Ganti Template' : 'Upload Depan' }}
                        </span>
                        <span wire:loading wire:target="uploadTemplateDepan" class="relative">Uploading...</span>
                    </button>
                </div>

                {{-- Sisi Belakang --}}
                <div>
                    <p class="text-xs font-semibold text-stone-600 mb-2 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                            style="background:linear-gradient(135deg,#FB923C,#EA580C)">B</span>
                        Sisi Belakang
                    </p>
                    @if($templateBelakangPath)
                    <div class="rounded-xl overflow-hidden border border-green-200 mb-2
                                shadow-[0_2px_8px_-2px_rgba(34,197,94,.15)]">
                        <img src="{{ asset('storage/'.$templateBelakangPath) }}" class="w-full object-contain max-h-32" />
                    </div>
                    <p class="text-xs text-green-600 font-semibold mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Template belakang siap
                    </p>
                    @else
                    <div class="border-2 border-dashed border-stone-200 rounded-xl p-4 text-center mb-2
                                hover:border-orange-400 hover:bg-orange-50/40 transition-all duration-200">
                        <input wire:model="templateBelakang" type="file" accept=".jpg,.jpeg,.png" class="hidden" id="upload-belakang">
                        <label for="upload-belakang" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-stone-300 mx-auto mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                            </svg>
                            <p class="text-xs text-stone-400">Upload gambar belakang</p>
                        </label>
                    </div>
                    <div wire:loading wire:target="templateBelakang">
                        <p class="text-xs text-orange-500 animate-pulse mb-2 font-medium">Mengupload...</p>
                    </div>
                    @endif
                    <button wire:click="uploadTemplateBelakang" wire:loading.attr="disabled"
                        class="relative w-full py-2 rounded-xl text-xs font-semibold text-white overflow-hidden
                               shadow-[0_3px_10px_-2px_rgba(234,88,12,.4),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 active:scale-[.97] disabled:opacity-60 transition-all duration-200"
                        style="background:linear-gradient(135deg,#FB923C,#F97316,#EA580C)">
                        <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                        <span wire:loading.remove wire:target="uploadTemplateBelakang" class="relative">
                            {{ $templateBelakangPath ? 'Ganti Template' : 'Upload Belakang' }}
                        </span>
                        <span wire:loading wire:target="uploadTemplateBelakang" class="relative">Uploading...</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Posisi Overlay --}}
        @if($templateDepanPath)
        <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden
                    shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_6px_20px_-4px_rgba(120,113,108,.12),0_2px_6px_-1px_rgba(120,113,108,.07)]
                    hover:shadow-[0_1px_0_rgba(255,255,255,1)_inset,0_12px_30px_-6px_rgba(100,94,90,.15)]
                    transition-shadow duration-300">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-stone-100">
                <div class="w-0.5 h-5 rounded-full bg-gradient-to-b from-purple-600 to-purple-400"></div>
                <h3 class="text-sm font-semibold text-stone-800 tracking-tight">Posisi Overlay Nama di Sisi Depan</h3>
                <span class="text-xs text-stone-400">(atau klik langsung di gambar)</span>
            </div>
            <div class="p-5 space-y-4">
                @if($clickMode)
                <div class="p-2.5 rounded-xl flex items-center gap-2 bg-orange-50 border border-orange-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                    </svg>
                    <p class="text-xs font-semibold text-orange-700 flex-1">Klik pada gambar untuk set posisi <strong>Nama Peserta</strong></p>
                    <button wire:click="$set('clickMode', false)" class="text-xs font-medium text-stone-400 hover:text-stone-600">Batal</button>
                </div>
                @endif

                <div class="relative rounded-xl overflow-hidden border border-stone-200 shadow-[0_2px_10px_-2px_rgba(120,113,108,.12)]"
                    @click="
                         if ({{ $clickMode ? 'true' : 'false' }}) {
                             const rect = $el.getBoundingClientRect();
                             const x = Math.round(event.clientX - rect.left);
                             const y = Math.round(event.clientY - rect.top);
                             $wire.setPositionFromClick(x, y, $el.offsetWidth, $el.offsetHeight);
                         }
                     "
                    style="{{ $clickMode ? 'cursor: crosshair' : 'cursor: default' }}">
                    <img src="{{ asset('storage/'.$templateDepanPath) }}" alt="Template Depan" class="w-full object-contain" />
                    @if($posX && $posY)
                    <div class="absolute pointer-events-none"
                        style="left: calc({{ $posX }} / {{ $templateW }} * 100%); top: calc({{ $posY }} / {{ $templateH }} * 100%); transform: translate(-50%, -50%)">
                        <div class="flex flex-col items-center">
                            <div class="w-4 h-4 rounded-full bg-orange-500 border-2 border-white shadow-lg flex items-center justify-center">
                                <span class="text-white font-bold" style="font-size:8px">N</span>
                            </div>
                            <div class="mt-0.5 px-1.5 py-0.5 bg-orange-500 text-white rounded whitespace-nowrap shadow" style="font-size:9px">
                                ({{ $posX }}, {{ $posY }})
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <button wire:click="$set('clickMode', {{ $clickMode ? 'false' : 'true' }})"
                    class="w-full flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200
                        {{ $clickMode ? 'bg-orange-500 text-white shadow-md' : 'bg-orange-50 text-orange-600 border border-orange-200 hover:bg-orange-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                    </svg>
                    {{ $clickMode ? '🎯 Klik gambar untuk set posisi...' : 'Set Posisi Nama (Klik Gambar)' }}
                </button>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Posisi X <span class="text-orange-500">({{ $posX }})</span></label>
                        <input wire:model.live="posX" type="number"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Posisi Y <span class="text-orange-500">({{ $posY }})</span></label>
                        <input wire:model.live="posY" type="number"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Ukuran Font</label>
                        <input wire:model.live="fontSize" type="number" min="12" max="80"
                            class="w-full px-3.5 py-2.5 text-sm border border-stone-200 rounded-xl bg-stone-50 text-stone-800 outline-none
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 focus:bg-white transition-all duration-200" />
                    </div>
                    <div>
                        <label class="block text-[10.5px] font-bold text-stone-500 uppercase tracking-widest mb-1.5">Warna Font</label>
                        <input wire:model.live="fontColor" type="color"
                            class="w-full h-10 border border-stone-200 rounded-xl px-1.5 py-1 bg-stone-50 cursor-pointer
                                   focus:border-orange-400 focus:ring-2 focus:ring-orange-400/15 transition-all duration-200" />
                    </div>
                </div>

                <div class="p-3.5 bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-xl shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
                    <p class="text-xs text-amber-700 leading-relaxed">
                        💡 Dimensi template: <strong>{{ $templateW }}×{{ $templateH }}px</strong> —
                        Koordinat saat ini: <strong>({{ $posX }}, {{ $posY }})</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- Preview hasil generate --}}
        @if($detail->cert_file_path || $detail->cert_back_path)
        <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p class="text-sm font-semibold text-green-700">Sertifikat sudah digenerate ✅</p>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @if($detail->cert_file_path)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
                <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-lg flex items-center justify-center text-white text-[10px] font-bold" style="background:linear-gradient(135deg,#F97316,#EA580C)">A</span>
                        <p class="text-xs font-semibold text-stone-700">Sisi Depan</p>
                    </div>
                    <a href="{{ asset('storage/'.$detail->cert_file_path) }}" target="_blank" class="text-xs text-orange-500 font-semibold hover:text-orange-600 transition-colors">Unduh</a>
                </div>
                <img src="{{ asset('storage/'.$detail->cert_file_path) }}" class="w-full object-contain max-h-40" />
            </div>
            @endif
            @if($detail->cert_back_path)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_14px_-4px_rgba(120,113,108,.1)]">
                <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-lg flex items-center justify-center text-white text-[10px] font-bold" style="background:linear-gradient(135deg,#FB923C,#EA580C)">B</span>
                        <p class="text-xs font-semibold text-stone-700">Sisi Belakang</p>
                    </div>
                    <a href="{{ asset('storage/'.$detail->cert_back_path) }}" target="_blank" class="text-xs text-orange-500 font-semibold hover:text-orange-600 transition-colors">Unduh</a>
                </div>
                <img src="{{ asset('storage/'.$detail->cert_back_path) }}" class="w-full object-contain max-h-40" />
            </div>
            @endif
        </div>

        @if($detail->cert_qr_token)
        <div class="p-3.5 bg-gradient-to-br from-blue-50 to-sky-50 border border-blue-200 rounded-xl shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
            <p class="text-xs text-blue-700 font-semibold mb-1.5 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                </svg>
                Link Verifikasi Publik
            </p>
            <a href="{{ url('/sertifikat/verify/'.$detail->cert_qr_token) }}" target="_blank"
                class="text-xs text-blue-600 hover:text-blue-700 hover:underline break-all transition-colors">
                {{ url('/sertifikat/verify/'.$detail->cert_qr_token) }}
            </a>
        </div>
        @endif
        @endif

        {{-- Generate Button --}}
        <button wire:click="generateSertifikatPkl" wire:loading.attr="disabled"
            wire:confirm="Generate sertifikat untuk peserta ini? Pastikan kedua template sudah diupload."
            class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl border-none cursor-pointer
                   text-white text-sm font-bold overflow-hidden
                   shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.25)_inset]
                   hover:-translate-y-0.5 hover:scale-[1.02]
                   hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55),0_1px_0_rgba(255,255,255,.25)_inset]
                   active:scale-[.97] disabled:opacity-50 disabled:cursor-not-allowed disabled:translate-y-0 disabled:scale-100
                   transition-all duration-200"
            style="background:linear-gradient(135deg,#FB923C 0%,#F97316 40%,#EA580C 100%)">
            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
            <div wire:loading wire:target="generateSertifikatPkl">
                <svg class="w-4 h-4 animate-spin relative" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                </svg>
            </div>
            <svg wire:loading.remove wire:target="generateSertifikatPkl" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
            </svg>
            <span wire:loading.remove wire:target="generateSertifikatPkl" class="relative">
                🎓 {{ $detail->cert_file_path ? 'Regenerate Sertifikat' : 'Generate Sertifikat PKL/Magang' }}
            </span>
            <span wire:loading wire:target="generateSertifikatPkl" class="relative">Generating... mohon tunggu</span>
        </button>

        @else
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-6 text-center shadow-[0_1px_0_rgba(255,255,255,.8)_inset]">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 border border-amber-200 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-amber-700 mb-1">Sertifikat Belum Dapat Digenerate</p>
            <p class="text-xs text-amber-600">
                Sertifikat hanya tersedia untuk peserta <strong>PKL/Magang</strong> yang berstatus <strong>Selesai</strong>.
            </p>
        </div>
        @endif

    </div>
    @endif

</div>