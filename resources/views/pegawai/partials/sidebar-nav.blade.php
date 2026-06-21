{{-- sidebar-nav.blade.php (PEGAWAI) --}}
@php
$groups = [
    'MENU' => [
        ['label' => 'Dashboard',      'route' => 'pegawai.dashboard',      'icon' => 'home'],
        ['label' => 'Daftar Acara',   'route' => 'pegawai.acara',          'icon' => 'calendar'],
    ],
    'PELATIHAN' => [
        ['label' => 'Jam Pelatihan',  'route' => 'pegawai.rekap-jam',      'icon' => 'clock'],
        ['label' => 'Diklat Mandiri', 'route' => 'pegawai.diklat-mandiri', 'icon' => 'document'],
        ['label' => 'E-Learning',     'route' => 'pegawai.elearning',      'icon' => 'book'],
    ],
    'AKUN' => [
        ['label' => 'Sertifikat',     'route' => 'pegawai.sertifikat',     'icon' => 'badge'],
    ],
];

$icons = [
    'home'     => 'm2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
    'calendar' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5',
    'clock'    => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
    'document' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
    'book'     => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25',
    'badge'    => 'M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z',
];
@endphp

@foreach($groups as $groupLabel => $items)
<div class="mb-4">
    <p class="text-[9.5px] font-bold tracking-[.12em] text-stone-400 uppercase px-3 mb-1.5">
        {{ $groupLabel }}
    </p>
    <div class="space-y-0.5">
        @foreach($items as $item)
        @php $active = request()->routeIs($item['route'].'*'); @endphp
        <a href="{{ route($item['route']) }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm border
                  transition-all duration-200 relative overflow-hidden
                  {{ $active
                      ? 'bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200
                         shadow-[0_2px_8px_-2px_rgba(30,134,193,.2),0_1px_0_rgba(255,255,255,.9)_inset]
                         translate-x-0'
                      : 'border-transparent hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100
                         hover:border-blue-200
                         hover:shadow-[0_2px_8px_-2px_rgba(30,134,193,.2),0_1px_0_rgba(255,255,255,.9)_inset]
                         hover:translate-x-1' }}">

            {{-- Bar kiri --}}
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full
                         transition-all duration-200
                         {{ $active
                             ? 'opacity-100 scale-y-100'
                             : 'opacity-0 scale-y-0 group-hover:opacity-100 group-hover:scale-y-100' }}"
                  style="background:linear-gradient(180deg,#2E86C1,#0F4F7A)">
            </span>

            {{-- Icon wrap — biru semua --}}
            <span class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0
                         transition-all duration-200
                         shadow-[0_2px_6px_-1px_rgba(15,79,122,.3)]
                         {{ $active
                             ? 'scale-105 shadow-[0_4px_12px_-2px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]'
                             : 'group-hover:scale-105 group-hover:-rotate-3
                                group-hover:shadow-[0_4px_12px_-2px_rgba(15,79,122,.4)]' }}"
                  style="background:linear-gradient(135deg,#2E86C1 0%,#1A6FA3 50%,#0F4F7A 100%)">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4 text-white"
                     fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                </svg>
            </span>

            {{-- Label --}}
            <span class="flex-1 transition-all duration-200
                         {{ $active
                             ? 'text-blue-700 font-semibold'
                             : 'text-stone-600 font-medium group-hover:text-blue-700 group-hover:font-semibold' }}">
                {{ $item['label'] }}
            </span>

        </a>
        @endforeach
    </div>
</div>
@endforeach