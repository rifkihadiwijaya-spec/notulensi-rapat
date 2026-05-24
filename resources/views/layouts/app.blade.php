<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="h-full font-[\'Plus_Jakarta_Sans\',sans-serif] bg-[#f0f4f8] text-slate-900 antialiased">
        <div class="flex h-screen w-screen overflow-hidden">

            {{-- ═══════════════ SIDEBAR OVERLAY ═══════════════ --}}
            <div id="sidebarOverlay"
                 class="fixed inset-0 bg-[rgba(10,22,40,0.45)] backdrop-blur-sm z-[102]
                        opacity-0 pointer-events-none transition-opacity duration-300
                        [&.active]:opacity-100 [&.active]:pointer-events-auto"></div>

            {{-- ═══════════════ SIDEBAR ═══════════════ --}}
            <aside id="sidebar"
                   class="w-64 min-w-[256px] bg-white flex flex-col h-screen overflow-y-auto relative
                          border-r border-slate-200 shadow-[2px_0_12px_rgba(15,23,42,0.06)]
                          max-lg:fixed max-lg:top-0 max-lg:left-0 max-lg:z-[103]
                          max-lg:-translate-x-full max-lg:transition-transform max-lg:duration-[280ms] max-lg:ease-[cubic-bezier(0.4,0,0.2,1)]
                          max-lg:shadow-2xl max-lg:pointer-events-none
                          max-lg:[&.sidebar-open]:translate-x-0 max-lg:[&.sidebar-open]:pointer-events-auto">

                {{-- Close button (mobile/tablet only) --}}
                <button id="sidebarCloseBtn" aria-label="Tutup menu"
                        class="hidden max-lg:flex absolute top-3.5 right-3.5 w-7 h-7 rounded-full
                               border border-slate-200 bg-slate-50 text-slate-500 cursor-pointer
                               items-center justify-center z-10 transition-colors duration-150
                               hover:bg-red-50 hover:text-red-500 hover:border-red-200">
                    <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>

                {{-- Brand --}}
                <div class="flex items-center gap-[11px] px-4 py-[18px] pb-4 border-b border-slate-100">
                    <div class="w-[52px] h-[52px] bg-transparent rounded-[10px] flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <img src="{{ asset('images/logo-diskominfo.png') }}" alt="Logo" class="w-[52px] h-[52px] object-contain">
                    </div>
                    <div>
                        <div class="text-[13px] font-bold text-slate-900 leading-tight tracking-[-0.01em]">Sistem Notulensi</div>
                        <div class="text-[9.5px] text-slate-400 font-semibold uppercase tracking-[0.07em] mt-px">Rapat Dinas</div>
                    </div>
                </div>

                {{-- Nav --}}
                <nav class="flex-1 px-2.5 py-3.5 flex flex-col gap-0.5">
                    <div class="text-[9.5px] font-bold uppercase tracking-[0.1em] text-slate-300 px-2.5 py-2.5 pb-1">Menu Utama</div>

                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg no-underline text-slate-500 text-[13px] font-medium
                              transition-all duration-150 relative
                              hover:bg-slate-100 hover:text-slate-900
                              {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                        @if(request()->routeIs('dashboard'))
                            <span class="absolute left-0 top-[18%] bottom-[18%] w-[3px] bg-gradient-to-b from-orange-500 to-blue-400 rounded-r-[3px]"></span>
                        @endif
                        <svg class="w-4 h-4 flex-shrink-0 stroke-current fill-none opacity-75 {{ request()->routeIs('dashboard') ? '!opacity-100' : '' }}" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('meetings.index') }}"
                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg no-underline text-slate-500 text-[13px] font-medium
                              transition-all duration-150 relative
                              hover:bg-slate-100 hover:text-slate-900
                              {{ request()->routeIs('meetings.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                        @if(request()->routeIs('meetings.*'))
                            <span class="absolute left-0 top-[18%] bottom-[18%] w-[3px] bg-gradient-to-b from-orange-500 to-blue-400 rounded-r-[3px]"></span>
                        @endif
                        <svg class="w-4 h-4 flex-shrink-0 stroke-current fill-none opacity-75 {{ request()->routeIs('meetings.*') ? '!opacity-100' : '' }}" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Riwayat Rapat
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <div class="text-[9.5px] font-bold uppercase tracking-[0.1em] text-slate-300 px-2.5 py-2.5 pb-1 mt-2">Administrasi</div>
                        <a href="{{ route('users.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg no-underline text-slate-500 text-[13px] font-medium
                                  transition-all duration-150 relative
                                  hover:bg-slate-100 hover:text-slate-900
                                  {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                            @if(request()->routeIs('users.*'))
                                <span class="absolute left-0 top-[18%] bottom-[18%] w-[3px] bg-gradient-to-b from-orange-500 to-blue-400 rounded-r-[3px]"></span>
                            @endif
                            <svg class="w-4 h-4 flex-shrink-0 stroke-current fill-none opacity-75 {{ request()->routeIs('users.*') ? '!opacity-100' : '' }}" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                            Kelola User
                        </a>
                    @endif
                </nav>

                {{-- Footer --}}
                <div class="px-2.5 py-2.5 pb-3.5 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 text-[13px] font-medium
                                       bg-transparent border-none cursor-pointer w-full text-left font-[inherit]
                                       transition-all duration-150
                                       hover:bg-red-50 hover:text-red-500">
                            <svg class="w-[15px] h-[15px] stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            {{-- ═══════════════ MAIN AREA ═══════════════ --}}
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f0f4f8]
                        max-lg:w-full max-lg:h-screen max-lg:overflow-y-auto max-lg:overflow-x-hidden">

                {{-- HEADER --}}
                <header class="h-[60px] min-h-[60px] bg-white border-b border-slate-200 px-6
                               flex items-center justify-between flex-shrink-0
                               shadow-[0_1px_3px_rgba(10,22,40,0.08),0_1px_2px_rgba(10,22,40,0.06)]
                               max-lg:sticky max-lg:top-0 max-lg:z-[101] max-lg:px-4 max-lg:gap-2
                               max-sm:h-auto max-sm:min-h-[52px] max-sm:px-3 max-sm:py-2">

                    {{-- Hamburger (mobile/tablet) --}}
                    <button id="hamburgerBtn" aria-label="Buka menu"
                            class="hidden max-lg:flex items-center justify-center w-9 h-9
                                   border border-slate-200 rounded-lg bg-slate-50 cursor-pointer
                                   text-slate-600 flex-shrink-0 transition-all duration-150
                                   relative z-[101] mr-1
                                   hover:bg-slate-100 hover:border-slate-300 hover:text-slate-900">
                        <svg class="w-[18px] h-[18px] stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>

                    {{-- Brand title --}}
                    <div class="text-2xl font-extrabold text-slate-900 tracking-[-0.02em] flex items-center gap-0.5 max-sm:text-lg">
                        <span class="text-blue-500">SI</span><span class="text-orange-500">NORA</span>
                        <span class="text-slate-400 font-medium text-[12.5px] ml-2 tracking-normal max-lg:hidden max-sm:hidden">Sistem Informasi Notulensi Rapat Dinas</span>
                    </div>

                    {{-- Right side --}}
                    <div class="flex items-center gap-3">
                        {{-- Clock badge --}}
                        <div class="flex items-center gap-1.5 bg-blue-50 border border-blue-100 rounded-lg px-3 py-1.5
                                    text-xs text-blue-600 font-semibold tabular-nums max-sm:hidden">
                            <svg class="w-[13px] h-[13px] stroke-blue-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            <span id="clock"></span>
                        </div>

                        {{-- User chip --}}
                        <div class="flex items-center gap-2.5 py-1.5 pr-3 pl-1.5 rounded-full bg-slate-50 border border-slate-200
                                    transition-all duration-150 hover:border-blue-300
                                    max-sm:py-1 max-sm:pr-2 max-sm:gap-1.5">
                            <div class="w-[30px] h-[30px] rounded-full bg-gradient-to-br from-blue-500 to-orange-500
                                        flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-[12.5px] font-bold text-slate-900 leading-tight max-sm:text-[11px] max-sm:max-w-[80px] max-sm:truncate">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-[10.5px] text-orange-500 font-semibold uppercase tracking-[0.05em] max-sm:hidden">
                                    {{ ucfirst(auth()->user()->role) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- PAGE CONTENT --}}
                <main class="flex-1 overflow-y-auto overflow-x-hidden p-6 max-lg:p-5 max-sm:p-3">
                    {{ $slot }}
                </main>
            </div>

        </div>

        {{-- Clock Script --}}
        <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
                + '  ' +
                now.toLocaleTimeString('id-ID');
        }
        setInterval(updateClock, 1000);
        updateClock();
        </script>

        {{-- Sidebar drawer script --}}
        <script>
        (function () {
            var sidebar   = document.getElementById('sidebar');
            var overlay   = document.getElementById('sidebarOverlay');
            var hamburger = document.getElementById('hamburgerBtn');
            var closeBtn  = document.getElementById('sidebarCloseBtn');

            function triggerCalendarResize() {
                setTimeout(function () {
                    var calEl = document.getElementById('calendar');
                    if (calEl && calEl._calendar) {
                        calEl._calendar.updateSize();
                    }
                    window.dispatchEvent(new Event('resize'));
                }, 300);
            }

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('sidebar-open');
                if (overlay) overlay.classList.add('active');
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('sidebar-open');
                if (overlay) overlay.classList.remove('active');
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
                triggerCalendarResize();
            }

            if (hamburger) hamburger.addEventListener('click', openSidebar);
            if (closeBtn)  closeBtn.addEventListener('click', closeSidebar);
            if (overlay)   overlay.addEventListener('click', closeSidebar);

            if (sidebar) {
                sidebar.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        setTimeout(closeSidebar, 150);
                    });
                });
            }

            window.addEventListener('resize', function () {
                if (window.innerWidth > 1024) {
                    closeSidebar();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeSidebar();
            });

            document.querySelectorAll('.table-wrap').forEach(function (wrap) {
                wrap.addEventListener('scroll', function () {
                    var atEnd = wrap.scrollLeft + wrap.clientWidth >= wrap.scrollWidth - 4;
                    wrap.classList.toggle('scrolled-end', atEnd);
                });
            });
        })();
        </script>

        @stack('scripts')
    </body>
</html>