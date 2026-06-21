<div class="space-y-4 ">

    {{-- Back --}}
    <a href="{{ route('pegawai.elearning') }}"
        class="inline-flex items-center gap-1.5 text-sm text-stone-400 hover:text-blue-600
               hover:translate-x-[-2px] transition-all duration-200 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Kembali ke E-Learning
    </a>

    {{-- Info Modul --}}
    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden
                shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_16px_-4px_rgba(120,113,108,.1)]">

        {{-- Header --}}
        <div class="relative px-6 py-5 overflow-hidden"
             style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>

            <div class="relative flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-white/15 border border-white/20 text-white/80 font-medium mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        </svg>
                        {{ $modul->kategori ?? 'Umum' }}
                    </span>
                    <h2 class="text-lg font-bold text-white leading-snug">{{ $modul->judul }}</h2>
                    @if($modul->deskripsi)
                    <p class="text-white/65 text-sm mt-1.5 leading-relaxed">{{ $modul->deskripsi }}</p>
                    @endif
                </div>
                <div class="flex-shrink-0 text-right">
                    <div class="bg-white/15 border border-white/20 rounded-xl px-3 py-2 text-center">
                        <p class="text-white/60 text-[10px] font-medium uppercase tracking-wide">Estimasi</p>
                        <p class="text-white font-bold text-sm mt-0.5">{{ $modul->estimasi_durasi_jam }} jam</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Bar --}}
        <div class="px-5 py-3 border-b border-stone-100 flex items-center justify-between bg-stone-50/50">
            <div class="flex items-center gap-2">
                @if($progress?->status === 'completed')
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    <span class="text-xs font-semibold text-green-600">Selesai</span>
                @elseif($progress?->status === 'failed')
                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                    <span class="text-xs font-semibold text-red-500">Tidak Lulus</span>
                @elseif($progress?->status === 'in_progress')
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    <span class="text-xs font-semibold text-yellow-600">Sedang Belajar</span>
                @else
                    <span class="w-2 h-2 rounded-full bg-stone-300"></span>
                    <span class="text-xs font-medium text-stone-400">Belum Mulai</span>
                @endif
                @if($progress?->quiz_score)
                <span class="text-xs text-stone-400 ml-1">· Nilai: <span class="font-semibold text-stone-600">{{ $progress->quiz_score }}%</span></span>
                @endif
            </div>
            @if($progress?->status === 'completed')
            <span class="text-xs text-stone-400">
                Selesai {{ $progress->completed_at?->format('d M Y') }}
            </span>
            @endif
        </div>

        {{-- Tab --}}
        <div class="flex border-b border-stone-100">
            <button wire:click="$set('tab', 'materi')"
                class="flex-1 flex items-center justify-center gap-2 py-3 text-sm font-semibold transition-all duration-200
                    {{ $tab === 'materi'
                        ? 'border-b-2 text-blue-700'
                        : 'text-stone-400 hover:text-stone-600' }}"
                style="{{ $tab === 'materi' ? 'border-color:#1A78B0' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                Materi
            </button>
            @if($modul->adaKuis())
            <button wire:click="$set('tab', 'kuis')"
                class="flex-1 flex items-center justify-center gap-2 py-3 text-sm font-semibold transition-all duration-200
                    {{ $tab === 'kuis'
                        ? 'border-b-2 border-orange-500 text-orange-600'
                        : 'text-stone-400 hover:text-stone-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                </svg>
                Kuis
                <span class="text-xs px-1.5 py-0.5 rounded-full font-bold
                    {{ $tab === 'kuis' ? 'bg-orange-100 text-orange-600' : 'bg-stone-100 text-stone-400' }}">
                    {{ $soals->count() }}
                </span>
            </button>
            @endif
        </div>

        {{-- Tab: Materi --}}
        @if($tab === 'materi')
        <div class="p-5 space-y-4">

            {{-- Video --}}
            @if($modul->link_video)
            <div>
                <p class="text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-2.5">Video Pembelajaran</p>
                @php
                    $videoId = '';
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n]+)/', $modul->link_video, $m)) {
                        $videoId = $m[1];
                    }
                @endphp
                @if($videoId)
                <div class="rounded-2xl overflow-hidden aspect-video border border-stone-100
                            shadow-[0_4px_16px_-4px_rgba(120,113,108,.15)]">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                        class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
                @else
                <a href="{{ $modul->link_video }}" target="_blank"
                    class="group flex items-center gap-3 p-4 bg-white border border-stone-100 rounded-2xl
                           shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_12px_-4px_rgba(120,113,108,.1)]
                           hover:shadow-[0_4px_16px_-4px_rgba(15,79,122,.2)] hover:-translate-y-0.5
                           transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                shadow-[0_2px_8px_-1px_rgba(239,68,68,.3)]
                                group-hover:scale-110 transition-all duration-200
                                bg-gradient-to-br from-red-400 to-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-stone-800 group-hover:text-blue-700 transition-colors duration-200">Buka Video Pembelajaran</p>
                        <p class="text-xs text-stone-400 mt-0.5">Klik untuk membuka di tab baru</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-blue-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                @endif
            </div>
            @endif

            {{-- File --}}
            @if($modul->file_path)
            <div>
                <p class="text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-2.5">File Materi</p>
                <a href="{{ asset('storage/'.$modul->file_path) }}" target="_blank"
                    class="group flex items-center gap-3 p-4 bg-white border border-stone-100 rounded-2xl
                           shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_4px_12px_-4px_rgba(120,113,108,.1)]
                           hover:shadow-[0_4px_16px_-4px_rgba(15,79,122,.2)] hover:-translate-y-0.5
                           transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                shadow-[0_2px_8px_-1px_rgba(15,79,122,.3)]
                                group-hover:scale-110 transition-all duration-200"
                         style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-stone-800 group-hover:text-blue-700 transition-colors duration-200">Unduh File Materi</p>
                        <p class="text-xs text-stone-400 mt-0.5 truncate">{{ basename($modul->file_path) }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-stone-300 group-hover:text-blue-400 group-hover:translate-x-0.5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
            @endif

            {{-- Konten Teks --}}
            @if($modul->konten)
            <div>
                <p class="text-[10.5px] font-bold text-stone-400 uppercase tracking-widest mb-2.5">Materi Pembelajaran</p>
                <div class="bg-stone-50 border border-stone-100 rounded-2xl p-5
                            shadow-[0_1px_0_rgba(255,255,255,.95)_inset]">
                    <div class="prose prose-sm max-w-none text-stone-700 leading-relaxed">
                        {!! nl2br(e($modul->konten)) !!}
                    </div>
                </div>
            </div>
            @endif

            {{-- CTA Selesai --}}
            @if($progress?->status !== 'completed')
            <button wire:click="selesaiBelajar"
                class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl
                       text-white text-sm font-bold overflow-hidden
                       shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                       hover:-translate-y-0.5 hover:scale-[1.01]
                       hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55)]
                       active:scale-[.97] transition-all duration-200"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                @if($modul->adaKuis())
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                </svg>
                <span class="relative">Lanjut ke Kuis</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="relative">Tandai Selesai</span>
                @endif
            </button>
            @else
            <div class="flex items-center justify-center gap-2 w-full py-3.5 rounded-2xl
                        text-green-700 text-sm font-bold bg-green-50 border border-green-200
                        shadow-[0_1px_0_rgba(255,255,255,.9)_inset]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Modul Sudah Diselesaikan
            </div>
            @endif

        </div>
        @endif

        {{-- Tab: Kuis --}}
        @if($tab === 'kuis' && $modul->adaKuis())
        <div class="p-5 space-y-4">

            @if($kuisMessage)
            <div class="p-4 rounded-2xl text-sm font-semibold flex items-center gap-2.5
                {{ str_contains($kuisMessage, 'Selamat') ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-600' }}">
                @if(str_contains($kuisMessage, 'Selamat'))
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                @endif
                {{ $kuisMessage }}
            </div>
            @endif

            @if(!$sudahKuis)
            <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-xs text-blue-700 font-medium">Nilai minimum lulus: <strong>{{ $modul->min_quiz_score }}%</strong></p>
            </div>

            @foreach($soals as $i => $soal)
            <div class="bg-white border border-stone-100 rounded-2xl p-4 space-y-3
                        shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_8px_-3px_rgba(120,113,108,.08)]">
                <div class="flex items-start gap-2.5">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold text-white
                                 shadow-[0_2px_6px_-1px_rgba(15,79,122,.3)]"
                          style="background:linear-gradient(135deg,#3B9FD1 0%,#0F5A8C 100%)">
                        {{ $i + 1 }}
                    </span>
                    <p class="text-sm font-semibold text-stone-800 leading-snug">{{ $soal->pertanyaan }}</p>
                </div>
                <div class="space-y-2 pl-8">
                    @foreach(['a' => $soal->pilihan_a, 'b' => $soal->pilihan_b, 'c' => $soal->pilihan_c, 'd' => $soal->pilihan_d] as $key => $pilihan)
                    @if($pilihan)
                    <label class="flex items-center gap-3 p-2.5 rounded-xl cursor-pointer transition-all duration-200
                        {{ isset($jawaban[$soal->id]) && $jawaban[$soal->id] === $key
                            ? 'bg-blue-50 border border-blue-200 shadow-[0_1px_0_rgba(255,255,255,.9)_inset]'
                            : 'bg-stone-50 border border-stone-100 hover:bg-blue-50/50 hover:border-blue-100' }}">
                        <input type="radio" wire:model="jawaban.{{ $soal->id }}" value="{{ $key }}"
                            class="text-blue-600"/>
                        <span class="text-sm text-stone-700">
                            <strong class="{{ isset($jawaban[$soal->id]) && $jawaban[$soal->id] === $key ? 'text-blue-600' : 'text-stone-400' }}">
                                {{ strtoupper($key) }}.
                            </strong>
                            {{ $pilihan }}
                        </span>
                    </label>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach

            <button wire:click="submitKuis"
                class="relative w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl
                       text-white text-sm font-bold overflow-hidden
                       shadow-[0_4px_16px_-3px_rgba(234,88,12,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                       hover:-translate-y-0.5 hover:shadow-[0_8px_24px_-4px_rgba(234,88,12,.55)]
                       active:scale-[.97] transition-all duration-200"
                style="background:linear-gradient(135deg,#FB923C 0%,#F97316 50%,#EA580C 100%)">
                <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
                <span class="relative">Submit Jawaban</span>
            </button>

            @else
            {{-- Hasil Kuis --}}
            <div class="text-center py-6">
                @php $lulus = $nilaiKuis >= ($modul->min_quiz_score ?? 70); @endphp
                <div class="w-24 h-24 rounded-full mx-auto mb-4 flex items-center justify-center
                            relative overflow-hidden
                            {{ $lulus ? 'shadow-[0_8px_24px_-4px_rgba(34,197,94,.4)]' : 'shadow-[0_8px_24px_-4px_rgba(239,68,68,.4)]' }}"
                     style="background:{{ $lulus ? 'linear-gradient(135deg,#4ade80,#16a34a)' : 'linear-gradient(135deg,#f87171,#dc2626)' }}">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></span>
                    <p class="text-2xl font-bold text-white relative">{{ $nilaiKuis }}%</p>
                </div>
                <p class="text-base font-bold {{ $lulus ? 'text-green-600' : 'text-red-500' }}">
                    {{ $lulus ? 'Selamat, Kamu Lulus!' : 'Belum Lulus' }}
                </p>
                <p class="text-xs text-stone-400 mt-1">Nilai minimum: {{ $modul->min_quiz_score }}%</p>

                @if($progress?->status !== 'completed')
                <button wire:click="ulangiKuis"
                    class="relative mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl
                           text-white text-sm font-bold overflow-hidden
                           shadow-[0_4px_16px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                           hover:-translate-y-0.5 hover:shadow-[0_8px_24px_-4px_rgba(15,79,122,.55)]
                           active:scale-[.97] transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span class="relative">Ulangi Kuis</span>
                </button>
                @endif
            </div>
            @endif

        </div>
        @endif

    </div>

</div>