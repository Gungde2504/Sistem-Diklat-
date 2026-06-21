@php
$menu = [
['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'home', 'section' => 'UTAMA'],
['label' => 'Manajemen Acara', 'route' => 'admin.acara.index', 'icon' => 'calendar', 'section' => null],
['label' => 'Peserta Eksternal', 'route' => 'admin.peserta.index', 'icon' => 'users', 'section' => 'PESERTA'],
['label' => 'Diklat Mandiri', 'route' => 'admin.diklat-mandiri.index', 'icon' => 'document', 'section' => null],
['label' => 'E-Learning', 'route' => 'admin.elearning.index', 'icon' => 'book', 'section' => null],
['label' => 'Rekap Jam', 'route' => 'admin.rekap-jam.index', 'icon' => 'clock', 'section' => 'ANALITIK'],
['label' => 'Laporan', 'route' => 'admin.laporan.index', 'icon' => 'chart', 'section' => null],
];
@endphp

@foreach($menu as $item)
@php
$isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*');
@endphp

{{-- Section Label --}}
@if($item['section'])
<p class="text-[10px] font-semibold text-gray-300 uppercase tracking-widest px-2 pt-3 pb-1">
    {{ $item['section'] }}
</p>
@endif

{{-- Nav Item --}}
<a href="{{ route($item['route']) }}"
    x-data="{ hovered: false }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm relative border mb-0.5 transition-all duration-150
              {{ $isActive
                  ? 'border-orange-200/60 bg-gradient-to-r from-orange-50 to-orange-100/60'
                  : 'border-transparent' }}"
    :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? 'bg-gradient-to-r from-orange-50 to-orange-100/60 !border-orange-200/60' : ''">

    {{-- Garis aktif kiri --}}
    @if($isActive)
    <span class="absolute left-0 top-[22%] bottom-[22%] w-[3px] rounded-r-full"
        style="background: linear-gradient(to bottom, #FF8C00, #C73D00);"></span>
    @endif

    {{-- Icon Card --}}
    <div class="w-[30px] h-[30px] rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-150
                    {{ $isActive
                        ? 'shadow-[0_2px_8px_rgba(200,61,0,0.3)]'
                        : 'bg-gray-100' }}"
        style="{{ $isActive ? 'background: linear-gradient(135deg, #FF8C00, #C73D00);' : '' }}"
        :style="hovered && !{{ $isActive ? 'true' : 'false' }}
                     ? 'background: linear-gradient(135deg, #FF8C00, #C73D00); box-shadow: 0 2px 8px rgba(200,61,0,0.3);'
                     : {{ $isActive ? '\'background: linear-gradient(135deg, #FF8C00, #C73D00);\'' : '\'background: #f2f2f2;\'' }}">

        {{-- HOME --}}
        @if($item['icon'] === 'home')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>

        {{-- CALENDAR --}}
        @elseif($item['icon'] === 'calendar')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>

        {{-- QR --}}
        @elseif($item['icon'] === 'qr')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
        </svg>

        {{-- USERS --}}
        @elseif($item['icon'] === 'users')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>

        {{-- DOCUMENT --}}
        @elseif($item['icon'] === 'document')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>

        {{-- BOOK --}}
        @elseif($item['icon'] === 'book')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        </svg>

        {{-- CLOCK --}}
        @elseif($item['icon'] === 'clock')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        {{-- CHART --}}
        @elseif($item['icon'] === 'chart')
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $isActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
        </svg>
        @endif

    </div>

    {{-- Label --}}
    <span class="flex-1 truncate text-[13px] transition-all duration-150
                     {{ $isActive ? 'text-orange-700 font-bold' : 'text-gray-500' }}"
        :class="hovered && !{{ $isActive ? 'true' : 'false' }} ? '!text-orange-700 !font-semibold' : ''">
        {{ $item['label'] }}
    </span>

    {{-- Badge Diklat Mandiri --}}
    @if($item['route'] === 'admin.diklat-mandiri.index')
    @php $pending = \App\Models\DiklatMandiri::where('status', 'pending')->count(); @endphp
    @if($pending > 0)
    <span class="flex-shrink-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-tight">
        {{ $pending }}
    </span>
    @endif
    @endif

</a>
@endforeach

{{-- Konfigurasi Sistem (Super Admin only) --}}
@if(auth()->user()->role === 'super_admin')
@php $cfgActive = request()->routeIs('admin.konfigurasi.*'); @endphp
<p class="text-[10px] font-semibold text-gray-300 uppercase tracking-widest px-2 pt-3 pb-1">SISTEM</p>
<a href="{{ route('admin.konfigurasi.index') }}"
    x-data="{ hovered: false }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm relative border mb-0.5 transition-all duration-150
              {{ $cfgActive
                  ? 'border-orange-200/60 bg-gradient-to-r from-orange-50 to-orange-100/60'
                  : 'border-transparent' }}"
    :class="hovered && !{{ $cfgActive ? 'true' : 'false' }} ? 'bg-gradient-to-r from-orange-50 to-orange-100/60 !border-orange-200/60' : ''">

    @if($cfgActive)
    <span class="absolute left-0 top-[22%] bottom-[22%] w-[3px] rounded-r-full"
        style="background: linear-gradient(to bottom, #FF8C00, #C73D00);"></span>
    @endif

    <div class="w-[30px] h-[30px] rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-150
                    {{ $cfgActive ? 'shadow-[0_2px_8px_rgba(200,61,0,0.3)]' : 'bg-gray-100' }}"
        style="{{ $cfgActive ? 'background: linear-gradient(135deg, #FF8C00, #C73D00);' : '' }}"
        :style="hovered && !{{ $cfgActive ? 'true' : 'false' }}
                     ? 'background: linear-gradient(135deg, #FF8C00, #C73D00); box-shadow: 0 2px 8px rgba(200,61,0,0.3);'
                     : {{ $cfgActive ? '\'background: linear-gradient(135deg, #FF8C00, #C73D00);\'' : '\'background: #f2f2f2;\'' }}">
        <svg class="w-[15px] h-[15px] transition-all duration-150 {{ $cfgActive ? 'stroke-white' : 'stroke-gray-400' }}"
            :class="hovered && !{{ $cfgActive ? 'true' : 'false' }} ? '!stroke-white' : ''"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </div>

    <span class="flex-1 truncate text-[13px] transition-all duration-150
                     {{ $cfgActive ? 'text-orange-700 font-bold' : 'text-gray-500' }}"
        :class="hovered && !{{ $cfgActive ? 'true' : 'false' }} ? '!text-orange-700 !font-semibold' : ''">
        Konfigurasi Sistem
    </span>
</a>
@endif