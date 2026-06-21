<x-guest-layout>
    <div class="h-screen bg-gradient-to-br from-orange-50 via-white to-orange-100 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full max-w-md">

            {{-- Main Card --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_40px_rgba(0,0,0,0.12)] overflow-hidden">

                {{-- Header Gradient --}}
                <div class="bg-gradient-to-r from-orange-400 to-orange-600 px-8 pt-6 pb-7 relative">
                    <div class="absolute bottom-0 left-0 right-0 h-4 bg-gradient-to-t from-black/10 to-transparent"></div>

                    {{-- Logo --}}
                    <div class="flex justify-center mb-3">
                        <div class="bg-white/20 shadow-[0_0_30px_rgba(255,255,255,0.5)] rounded-full p-1.5 backdrop-blur-sm border border-white/30">
                            <img
                                src="{{ asset('images/logo/logo.png') }}"
                                alt="RSU Prima Medika"
                                class="w-12 h-12 rounded-full object-cover" />
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="text-center">
                        <h1 class="text-xl font-bold text-white tracking-wide">RSU Prima Medika</h1>
                        <p class="text-xs text-white/80 mt-0.5">Sistem Informasi Diklat & Seminar</p>
                    </div>
                </div>

                {{-- Form Area --}}
                <div class="px-8 py-5">

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-3" :status="session('status')" />

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        id="loginForm"
                        onsubmit="handleSubmit(event)">
                        @csrf

                        {{-- NIK / Email --}}
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                NIK / Email
                            </label>
                            <div class="flex items-stretch bg-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.06)] focus-within:border-orange-400 focus-within:shadow-[0_0_0_3px_rgba(251,146,60,0.15)] transition-all duration-200">
                                <div class="bg-gradient-to-b from-orange-400 to-orange-600 px-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    type="text"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Masukkan NIK atau Email"
                                    class="flex-1 bg-transparent px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                Password
                            </label>
                            <div class="flex items-stretch bg-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.06)] focus-within:border-orange-400 focus-within:shadow-[0_0_0_3px_rgba(251,146,60,0.15)] transition-all duration-200">
                                <div class="bg-gradient-to-b from-orange-400 to-orange-600 px-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Masukkan password"
                                    class="flex-1 bg-transparent px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none"
                                    style="color-scheme: light;" />
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="px-3 text-gray-300 hover:text-orange-500 transition flex items-center">
                                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg id="eye-slash" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        {{-- Remember Me & Forgot Password --}}
                        <div class="flex items-center justify-between mb-3">
                            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-400"
                                    name="remember">
                                <span class="text-xs text-gray-500">Ingat saya</span>
                            </label>
                        </div>

                        {{-- Info Login --}}
                        <div class="mb-4 p-2.5 bg-orange-50 border border-orange-100 rounded-xl text-xs text-orange-700">
                            👤 <strong>Pegawai Internal:</strong> gunakan NIK &nbsp;|&nbsp;
                            🎓 <strong>Peserta Eksternal:</strong> gunakan Email
                        </div>

                        {{-- Button Login --}}
                        <button
                            id="loginBtn"
                            type="submit"
                            class="w-full bg-gradient-to-r from-orange-400 to-orange-600
                               hover:from-orange-500 hover:to-orange-700
                               shadow-[0_4px_15px_rgba(251,146,60,0.4)]
                               hover:shadow-[0_6px_20px_rgba(251,146,60,0.5)]
                               text-white font-semibold text-sm
                               py-2.5 rounded-xl transition-all duration-200
                               active:scale-95 flex items-center justify-center gap-2">
                            {{-- Spinner (hidden by default) --}}
                            <svg id="spinner" class="hidden w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
                            </svg>
                            <span id="btnText">Login</span>
                        </button>

                        {{-- Footer --}}
                        <p class="text-center text-xs text-gray-400 mt-4">
                            © {{ date('Y') }} RSU Prima Medika. All rights reserved.
                        </p>

                    </form>
                </div>

            </div>

        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay"
        class="hidden fixed inset-0 bg-white/70 backdrop-blur-sm z-50 flex flex-col items-center justify-center gap-3">
        <div class="bg-gradient-to-r from-orange-400 to-orange-600 rounded-2xl p-4 shadow-[0_0_30px_rgba(251,146,60,0.4)]">
            <svg class="w-8 h-8 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 12H4z"></path>
            </svg>
        </div>
        <p class="text-sm font-semibold text-orange-600">Sedang masuk ke sistem...</p>
        <p class="text-xs text-gray-400">Mohon tunggu sebentar</p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeSlash = document.getElementById('eye-slash');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeSlash.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeSlash.classList.add('hidden');
            }
        }

        function handleSubmit(e) {
            // Tampilkan spinner di button
            document.getElementById('spinner').classList.remove('hidden');
            document.getElementById('btnText').textContent = 'Memproses...';
            document.getElementById('loginBtn').disabled = true;

            // Tampilkan overlay loading
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }
    </script>

</x-guest-layout>