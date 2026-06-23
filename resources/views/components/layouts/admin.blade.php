<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Sistem Diklat</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans antialiased overflow-x-hidden">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @php
        $user = auth()->user();
        $fullName = $user->nama ?? $user->name ?? 'User';
        $parts = explode(' ', trim($fullName));
        $initials = strtoupper(substr($parts[0], 0, 1))
        . strtoupper(substr($parts[1] ?? '', 0, 1));
        $roleName = str_replace('_', ' ', $user->role ?? '');
        @endphp

        <aside class="w-64 bg-white flex-shrink-0 flex flex-col h-screen sticky top-0"
            style="box-shadow: 2px 0 8px rgba(0,0,0,0.06);">

            {{-- Logo --}}
            <div class="flex flex-col items-center px-4 pt-5 pb-4 flex-shrink-0"
                style="background: linear-gradient(160deg, #FF8C00 0%, #E85000 60%, #C73D00 100%); border-radius: 20px 20px 0 0;">

                <div class="mb-2.5 overflow-hidden"
                    style="width:58px; height:58px; border-radius:50%; background:white;
                    display:flex; align-items:center; justify-content:center;
                    box-shadow: 0 2px 14px rgba(0,0,0,0.2);">
                    <img src="{{ asset('images/logo/logo.png') }}"
                        class="w-12 h-12 rounded-full object-cover"
                        alt="Logo">
                </div>

                <p class="text-white font-bold text-sm leading-tight text-center">RSU Prima Medika</p>
                <p class="text-white/70 text-xs text-center mt-0.5">Sistem Informasi Diklat &amp; Seminar</p>
            </div>

            {{-- Nav — bisa scroll --}}
           <nav class="flex-1 px-3 py-3 min-h-0 space-y-0.5 overflow-y-auto
            [&::-webkit-scrollbar]:w-1.5
            [&::-webkit-scrollbar-track]:bg-transparent
            [&::-webkit-scrollbar-thumb]:bg-stone-200
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb:hover]:bg-stone-300">
                {{ $sidebar ?? '' }}
            </nav>

            {{-- User Info — selalu di bawah, tidak ikut scroll --}}
            <div class="flex items-center gap-2.5 px-4 py-3 flex-shrink-0 border-t border-gray-100 bg-white">

                <div class="flex-shrink-0 flex items-center justify-center rounded-full text-white text-xs font-bold"
                    style="width:32px; height:32px; background: linear-gradient(135deg, #FF8C00, #C73D00);">
                    {{ $initials }}
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 text-xs font-semibold truncate leading-tight">{{ $fullName }}</p>
                    <p class="text-gray-400 text-[11px] capitalize leading-tight">{{ $roleName }}</p>
                </div>


            </div>

        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            {{-- Topbar --}}
            <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between flex-shrink-0"
                style="box-shadow: 0 1px 6px rgba(0,0,0,0.04);">

                {{-- Kiri: Breadcrumb / Title --}}
                <div class="flex items-center gap-2.5">
                    <div class="w-1 h-5 rounded-full flex-shrink-0"
                        style="background: linear-gradient(to bottom, #FF8C00, #C73D00);"></div>
                    <h1 class="text-[15px] font-semibold text-gray-800 leading-tight">
                        {{ $title ?? 'Dashboard' }}
                    </h1>
                </div>

                {{-- Kanan: Notifikasi + Logout --}}
                <div class="flex items-center gap-2.5">

                    {{-- Notifikasi --}}
                    @livewire('notifikasi-dropdown')

                    {{-- Divider --}}
                    <div class="w-px h-5 bg-gray-200"></div>

                    {{-- Logout Button --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            x-data="{ hovered: false }"
                            @mouseenter="hovered = true"
                            @mouseleave="hovered = false"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white text-xs font-semibold transition-all duration-150"
                            style="background: linear-gradient(135deg, #ef4444, #b91c1c);"
                            :style="hovered ? 'background: linear-gradient(135deg, #dc2626, #991b1b); box-shadow: 0 2px 8px rgba(185,28,28,0.35);' : 'background: linear-gradient(135deg, #ef4444, #b91c1c); box-shadow: none;'">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-3.5 h-3.5 transition-transform duration-150"
                                :class="hovered ? 'translate-x-0.5' : ''"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Logout
                        </button>
                    </form>

                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 min-w-0">
                {{ $slot }}
            </main>

        </div>

        {{-- ── GLOBAL DELETE MODAL ── --}}
        <div
            x-data
            x-show="$store.deleteModal.open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display:none;">

            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="$store.deleteModal.close()">
            </div>

            <div class="relative bg-white rounded-3xl shadow-[0_20px_60px_-10px_rgba(0,0,0,.25)] w-full max-w-sm overflow-hidden"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                @click.stop>

                <div class="h-1.5 w-full bg-gradient-to-r from-red-400 via-red-500 to-red-600"></div>

                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center
                            bg-red-50 border border-red-200
                            shadow-[0_4px_14px_-3px_rgba(239,68,68,.25)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h3 class="text-lg font-bold text-stone-800 mb-1.5"
                            x-text="$store.deleteModal.title"></h3>
                        <p class="text-sm text-stone-500 leading-relaxed"
                            x-text="$store.deleteModal.message"></p>
                        <p class="text-xs text-red-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>

                    <div class="flex gap-3">
                        <button @click="$store.deleteModal.close()"
                            class="flex-1 py-2.5 rounded-2xl text-sm font-semibold text-stone-600
                           border border-stone-200 bg-stone-50
                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-stone-100 hover:-translate-y-0.5
                           transition-all duration-200">
                            Batal
                        </button>
                        <button @click="$store.deleteModal.confirm()"
                            class="relative flex-1 py-2.5 rounded-2xl text-sm font-bold text-white overflow-hidden
                           shadow-[0_4px_14px_-3px_rgba(239,68,68,.5),0_1px_0_rgba(255,255,255,.2)_inset]
                           hover:-translate-y-0.5 hover:shadow-[0_8px_20px_-4px_rgba(239,68,68,.55)]
                           active:scale-[.97] transition-all duration-200"
                            style="background:linear-gradient(135deg,#F87171 0%,#EF4444 45%,#DC2626 100%)">
                            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                            <span class="relative">Ya, Hapus</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alpine Store --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('deleteModal', {
                    open: false,
                    title: '',
                    message: '',
                    onConfirm: null,

                    show(title, message, onConfirm) {
                        this.title = title;
                        this.message = message;
                        this.onConfirm = onConfirm;
                        this.open = true;
                    },

                    confirm() {
                        if (this.onConfirm) this.onConfirm();
                        this.close();
                    },

                    close() {
                        this.open = false;
                        this.onConfirm = null;
                    }
                });
            });
        </script>
         {{-- ── GLOBAL DELETE MODAL ── --}}
        <div
            x-data
            x-show="$store.deleteModal.open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display:none;">

            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="$store.deleteModal.close()">
            </div>

            <div class="relative bg-white rounded-3xl shadow-[0_20px_60px_-10px_rgba(0,0,0,.25)] w-full max-w-sm overflow-hidden"
                x-transition:enter="transition duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                @click.stop>

                {{-- Top bar dinamis --}}
                <div class="h-1.5 w-full"
                    :style="$store.deleteModal.type === 'approve'
                        ? 'background:linear-gradient(90deg,#4ade80,#22c55e,#16a34a)'
                        : ($store.deleteModal.type === 'reject'
                            ? 'background:linear-gradient(90deg,#f87171,#ef4444,#dc2626)'
                            : ($store.deleteModal.type === 'confirm'
                                ? 'background:linear-gradient(90deg,#60a5fa,#3b82f6,#2563eb)'
                                : 'background:linear-gradient(90deg,#F87171,#EF4444,#DC2626)'))">
                </div>

                <div class="p-6">
                    {{-- Icon dinamis --}}
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                            :class="$store.deleteModal.type === 'approve'
                                ? 'bg-green-50 border border-green-200 shadow-[0_4px_14px_-3px_rgba(34,197,94,.25)]'
                                : ($store.deleteModal.type === 'reject'
                                    ? 'bg-red-50 border border-red-200 shadow-[0_4px_14px_-3px_rgba(239,68,68,.25)]'
                                    : ($store.deleteModal.type === 'confirm'
                                        ? 'bg-blue-50 border border-blue-200 shadow-[0_4px_14px_-3px_rgba(59,130,246,.25)]'
                                        : 'bg-red-50 border border-red-200 shadow-[0_4px_14px_-3px_rgba(239,68,68,.25)]'))">

                            {{-- Icon hapus --}}
                            <svg x-show="$store.deleteModal.type === 'delete' || $store.deleteModal.type === ''"
                                xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            {{-- Icon approve --}}
                            <svg x-show="$store.deleteModal.type === 'approve'"
                                xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{-- Icon reject --}}
                            <svg x-show="$store.deleteModal.type === 'reject'"
                                xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            {{-- Icon confirm --}}
                            <svg x-show="$store.deleteModal.type === 'confirm'"
                                xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h3 class="text-lg font-bold text-stone-800 mb-1.5"
                            x-text="$store.deleteModal.title"></h3>
                        <p class="text-sm text-stone-500 leading-relaxed"
                            x-text="$store.deleteModal.message"></p>
                        <p class="text-xs mt-2"
                            :class="$store.deleteModal.type === 'approve' ? 'text-green-500' : 'text-red-500'"
                            x-text="$store.deleteModal.type === 'approve'
                                ? 'Peserta akan dapat mengakses sistem.'
                                : 'Tindakan ini tidak dapat dibatalkan.'">
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button @click="$store.deleteModal.close()"
                            class="flex-1 py-2.5 rounded-2xl text-sm font-semibold text-stone-600
                           border border-stone-200 bg-stone-50
                           shadow-[0_1px_0_rgba(255,255,255,.9)_inset]
                           hover:bg-stone-100 hover:-translate-y-0.5
                           transition-all duration-200">
                            Batal
                        </button>
                        <button @click="$store.deleteModal.confirm()"
                            class="relative flex-1 py-2.5 rounded-2xl text-sm font-bold text-white overflow-hidden
                           hover:-translate-y-0.5 active:scale-[.97] transition-all duration-200"
                            :style="$store.deleteModal.type === 'approve'
                                ? 'background:linear-gradient(135deg,#4ade80 0%,#22c55e 45%,#16a34a 100%);box-shadow:0 4px 14px -3px rgba(34,197,94,.5)'
                                : ($store.deleteModal.type === 'confirm'
                                    ? 'background:linear-gradient(135deg,#60a5fa 0%,#3b82f6 45%,#2563eb 100%);box-shadow:0 4px 14px -3px rgba(59,130,246,.5)'
                                    : 'background:linear-gradient(135deg,#F87171 0%,#EF4444 45%,#DC2626 100%);box-shadow:0 4px 14px -3px rgba(239,68,68,.5)')">
                            <span class="absolute inset-0 bg-gradient-to-br from-white/15 to-transparent pointer-events-none"></span>
                            <span class="relative"
                                x-text="$store.deleteModal.type === 'approve'
                                    ? 'Ya, Setujui'
                                    : ($store.deleteModal.type === 'reject'
                                        ? 'Ya, Tolak'
                                        : ($store.deleteModal.type === 'confirm'
                                            ? 'Ya, Lanjutkan'
                                            : 'Ya, Hapus'))">
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

       {{-- Alpine Store --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('deleteModal', {
                    open: false,
                    title: '',
                    message: '',
                    type: 'delete',
                    onConfirm: null,
                    show(title, message, onConfirm, type = 'delete') {
                        this.title = title;
                        this.message = message;
                        this.onConfirm = onConfirm;
                        this.type = type;
                        this.open = true;
                    },
                    confirm() {
                        if (this.onConfirm) this.onConfirm();
                        this.close();
                    },
                    close() {
                        this.open = false;
                        this.onConfirm = null;
                        this.type = 'delete';
                    }
                });
            });
        </script>
        @livewireScripts
</body>

</html>