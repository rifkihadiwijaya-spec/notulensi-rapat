<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login – Sistem Notulensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-['Plus_Jakarta_Sans',sans-serif]">

    {{-- Background decorations --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-blue-100/60 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-[420px] h-[420px] rounded-full bg-slate-200/50 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full bg-blue-50/40 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-sm">

        {{-- Brand --}}
        <div class="flex items-center justify-center gap-3 mb-8">
            <div class="w-11 h-11 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center overflow-hidden flex-shrink-0">
                <img src="{{ asset('images/logo-diskominfo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            </div>
            <div>
                <div class="text-[15px] font-extrabold text-slate-900 tracking-tight leading-tight">Sistem Notulensi</div>
                <div class="text-[11.5px] font-medium text-slate-400 leading-tight">Rapat Dinas</div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Card top accent --}}
            <div class="h-1 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-600"></div>

            <div class="px-7 pt-7 pb-8">

                {{-- Heading --}}
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Selamat Datang</h1>
                    <p class="text-sm text-slate-500 mt-1">Masuk untuk melanjutkan ke sistem</p>
                </div>

                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="flex items-start gap-2.5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl mb-5">
                        <svg class="w-4 h-4 stroke-current fill-none flex-shrink-0 mt-px" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Username --}}
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5" for="username">
                            Username
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input id="username" type="text" name="username"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border rounded-xl bg-white text-slate-800 font-[inherit]
                                       placeholder:text-slate-300 outline-none transition-all duration-150
                                       {{ $errors->has('username') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 hover:border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent' }}"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                required autofocus autocomplete="username">
                        </div>
                        @error('username')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5" for="password">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password"
                                class="w-full pl-9 pr-10 py-2.5 text-sm border rounded-xl bg-white text-slate-800 font-[inherit]
                                       placeholder:text-slate-300 outline-none transition-all duration-150
                                       [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden
                                       {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 hover:border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent' }}"
                                placeholder="Masukkan password"
                                required autocomplete="current-password">
                            <button type="button" id="toggle-pw-btn"
                                onclick="togglePassword()"
                                title="Tampilkan password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-150 p-0.5 rounded-lg">
                                <svg id="eye-icon" class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2.5 mb-6">
                        <input type="checkbox" id="remember_me" name="remember"
                            class="w-4 h-4 rounded border-slate-300 text-blue-600 accent-blue-600 cursor-pointer">
                        <label for="remember_me" class="text-sm text-slate-600 cursor-pointer select-none font-medium">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl transition-colors duration-150
                               shadow-sm shadow-blue-200 cursor-pointer font-[inherit]">
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Masuk
                    </button>

                </form>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-slate-400 mt-6 font-medium">
            &copy; {{ date('Y') }} Sistem Informasi Notulensi Rapat Dinas
        </p>

    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        const btn   = document.getElementById('toggle-pw-btn');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.innerHTML = isHidden
            ? `<svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                   <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                   <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                   <line x1="1" y1="1" x2="23" y2="23"/>
               </svg>`
            : `<svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                   <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                   <circle cx="12" cy="12" r="3"/>
               </svg>`;
    }
    </script>

</body>
</html>