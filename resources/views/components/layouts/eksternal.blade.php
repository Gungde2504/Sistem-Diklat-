{{-- layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal Eksternal' }} — Sistem Diklat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-stone-50 font-sans antialiased">

    <div class="min-h-screen pb-20 lg:pb-0 lg:flex ">

        {{-- ── SIDEBAR DESKTOP ── --}}
        <aside class="hidden lg:flex lg:flex-col w-64 flex-shrink-0 bg-white
              shadow-[0_1px_0_rgba(255,255,255,.95)_inset,4px_0_20px_-4px_rgba(120,113,108,.12)]"
            style="height:100vh; position:fixed; top:0; left:0; overflow:hidden; z-index:40;">

            {{-- Header biru --}}
            <div class="flex flex-col items-center text-center flex-shrink-0 px-5 py-6"
                style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%); border-radius:28px 28px 0 0">
                <img src="{{ asset('images/logo/logo.png') }}"
                    class="w-14 h-14 rounded-full object-cover mb-3
                        shadow-[0_4px_16px_rgba(0,0,0,.2)]"
                    alt="Logo" />
                <p class="text-white font-bold text-sm leading-tight tracking-tight">RSU Prima Medika</p>
                <p class="text-white/60 text-xs mt-0.5 capitalize">
                    {{ auth()->user()->detailEksternal?->jenis ?? 'Eksternal' }}
                </p>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 overflow-hidden">
                @include('eksternal.partials.sidebar-nav')
            </nav>

            {{-- Footer --}}
            <div class="px-4 py-3 border-t border-stone-100 flex-shrink-0
                    bg-gradient-to-r from-slate-50 to-blue-50/40
                    shadow-[0_-1px_0_rgba(255,255,255,.9)_inset]">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center
                            text-white text-xs font-bold
                            shadow-[0_2px_8px_-1px_rgba(15,79,122,.4),0_1px_0_rgba(255,255,255,.2)_inset]"
                        style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-stone-800 text-xs font-semibold truncate">{{ auth()->user()->nama }}</p>
                        <p class="text-stone-400 text-[10.5px] truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ── MAIN CONTENT ── --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
            {{-- Top Header --}}
            <header class="bg-white border-b border-stone-200 px-5 py-3 flex items-center justify-between
               fixed top-0 left-0 right-0 z-30 lg:left-64
               shadow-[0_1px_0_rgba(255,255,255,.95)_inset,0_2px_12px_-3px_rgba(120,113,108,.1)]">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/logo.png') }}"
                        class="w-8 h-8 rounded-full object-cover lg:hidden
                            shadow-[0_2px_8px_rgba(0,0,0,.12)]"
                        alt="Logo">
                    <div class="flex items-center gap-2.5">
                        <div class="w-0.5 h-5 rounded-full hidden lg:block flex-shrink-0"
                            style="background:linear-gradient(180deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)"></div>
                        <div>
                            <h1 class="text-sm font-bold text-stone-800 tracking-tight">{{ $title ?? 'Dashboard' }}</h1>
                            <p class="text-[11px] text-stone-400 lg:hidden">{{ auth()->user()->nama }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @livewire('notifikasi-dropdown')
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="relative flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold
                               text-white overflow-hidden
                               shadow-[0_3px_12px_-3px_rgba(220,38,38,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                               hover:-translate-y-0.5 hover:scale-[1.03]
                               hover:shadow-[0_6px_18px_-3px_rgba(220,38,38,.55),0_1px_0_rgba(255,255,255,.2)_inset]
                               active:scale-[.96] transition-all duration-200"
                            style="background:linear-gradient(135deg,#F87171 0%,#EF4444 45%,#DC2626 100%)">
                            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 relative" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            <span class="relative">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 px-4 lg:px-6  lg:pb-6 lg:pt-16 relative z-0" style="padding-top: 80px;">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- ── BOTTOM NAV MOBILE ── --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-stone-200 px-2 pb-safe
            shadow-[0_-4px_20px_-4px_rgba(120,113,108,.12),0_-1px_0_rgba(255,255,255,.9)_inset]">
        <div class="flex items-center justify-around">

            {{-- Dashboard --}}
            <a href="{{ route('eksternal.dashboard') }}"
                class="group flex flex-col items-center gap-0.5 px-3 py-2.5 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('eksternal.dashboard') ? 'text-blue-600' : 'text-stone-400 hover:text-blue-500 active:scale-95' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200
                         {{ request()->routeIs('eksternal.dashboard')
                             ? 'shadow-[0_3px_10px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                             : 'bg-stone-100 group-hover:bg-blue-50 group-hover:shadow-[0_2px_8px_-2px_rgba(15,79,122,.2)]' }}"
                    @if(request()->routeIs('eksternal.dashboard'))
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)"
                    @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 {{ request()->routeIs('eksternal.dashboard') ? 'text-white' : 'text-stone-500 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </span>
                <span class="text-[10px] font-semibold {{ request()->routeIs('eksternal.dashboard') ? 'text-blue-600' : 'text-stone-400 group-hover:text-blue-500' }}">Home</span>
            </a>

            {{-- Absensi --}}
            <a href="{{ route('eksternal.absensi') }}"
                class="group flex flex-col items-center gap-0.5 px-3 py-2.5 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('eksternal.absensi*') ? 'text-blue-600' : 'text-stone-400 hover:text-blue-500 active:scale-95' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200
                         {{ request()->routeIs('eksternal.absensi*')
                             ? 'shadow-[0_3px_10px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                             : 'bg-stone-100 group-hover:bg-blue-50 group-hover:shadow-[0_2px_8px_-2px_rgba(15,79,122,.2)]' }}"
                    @if(request()->routeIs('eksternal.absensi*'))
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)"
                    @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 {{ request()->routeIs('eksternal.absensi*') ? 'text-white' : 'text-stone-500 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </span>
                <span class="text-[10px] font-semibold {{ request()->routeIs('eksternal.absensi*') ? 'text-blue-600' : 'text-stone-400 group-hover:text-blue-500' }}">Absensi</span>
            </a>

            {{-- Jurnal — Center Button --}}
            <a href="{{ route('eksternal.jurnal') }}"
                class="group flex flex-col items-center gap-1 -mt-5 active:scale-95 transition-all duration-200">
                <div class="w-14 h-14 rounded-full flex items-center justify-center
                        shadow-[0_6px_20px_-3px_rgba(15,79,122,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                        group-hover:-translate-y-1
                        group-hover:shadow-[0_10px_28px_-4px_rgba(15,79,122,.55)]
                        transition-all duration-200"
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)">
                    <span class="absolute w-14 h-14 rounded-full border-2 border-blue-300/40
                             group-hover:scale-110 transition-all duration-300 pointer-events-none"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white relative" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600">Jurnal</span>
            </a>

            {{-- Acara --}}
            <a href="{{ route('eksternal.acara') }}"
                class="group flex flex-col items-center gap-0.5 px-3 py-2.5 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('eksternal.acara*') ? 'text-blue-600' : 'text-stone-400 hover:text-blue-500 active:scale-95' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200
                         {{ request()->routeIs('eksternal.acara*')
                             ? 'shadow-[0_3px_10px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                             : 'bg-stone-100 group-hover:bg-blue-50 group-hover:shadow-[0_2px_8px_-2px_rgba(15,79,122,.2)]' }}"
                    @if(request()->routeIs('eksternal.acara*'))
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)"
                    @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 {{ request()->routeIs('eksternal.acara*') ? 'text-white' : 'text-stone-500 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                    </svg>
                </span>
                <span class="text-[10px] font-semibold {{ request()->routeIs('eksternal.acara*') ? 'text-blue-600' : 'text-stone-400 group-hover:text-blue-500' }}">Acara</span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('eksternal.profil') }}"
                class="group flex flex-col items-center gap-0.5 px-3 py-2.5 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('eksternal.profil') ? 'text-blue-600' : 'text-stone-400 hover:text-blue-500 active:scale-95' }}">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200
                         {{ request()->routeIs('eksternal.profil')
                             ? 'shadow-[0_3px_10px_-2px_rgba(15,79,122,.35),0_1px_0_rgba(255,255,255,.2)_inset]'
                             : 'bg-stone-100 group-hover:bg-blue-50 group-hover:shadow-[0_2px_8px_-2px_rgba(15,79,122,.2)]' }}"
                    @if(request()->routeIs('eksternal.profil'))
                    style="background:linear-gradient(135deg,#3B9FD1 0%,#1A78B0 50%,#0F5A8C 100%)"
                    @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 {{ request()->routeIs('eksternal.profil') ? 'text-white' : 'text-stone-500 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </span>
                <span class="text-[10px] font-semibold {{ request()->routeIs('eksternal.profil') ? 'text-blue-600' : 'text-stone-400 group-hover:text-blue-500' }}">Profil</span>
            </a>

        </div>
    </nav>

    @livewireScripts
</body>

</html>