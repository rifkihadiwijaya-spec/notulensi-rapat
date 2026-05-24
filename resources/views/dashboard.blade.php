<x-app-layout>

    {{-- FullCalendar CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        /* ── FullCalendar overrides (minimal, hanya yang tidak bisa Tailwind) ── */
        .fc .fc-button {
            background: #2563eb !important; border-color: #2563eb !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 600 !important; font-size: 12px !important; border-radius: 8px !important;
        }
        .fc .fc-button:hover { background: #1d4ed8 !important; border-color: #1d4ed8 !important; }
        .fc .fc-button-active { background: #1e40af !important; border-color: #1e40af !important; }
        .fc .fc-toolbar-title {
            font-size: 15px !important; font-weight: 800 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important; color: #0f172a !important;
        }
        .fc .fc-col-header-cell-cushion {
            font-size: 11px !important; font-weight: 700 !important;
            text-transform: uppercase !important; letter-spacing: 0.07em !important;
            color: #94a3b8 !important; text-decoration: none !important;
        }
        .fc .fc-daygrid-day-number {
            font-size: 12px !important; font-weight: 600 !important;
            color: #475569 !important; text-decoration: none !important;
        }
        .fc .fc-daygrid-day.fc-day-today { background: #eff6ff !important; }
        .fc-event {
            border-radius: 5px !important; font-size: 11px !important;
            font-weight: 600 !important; padding: 1px 5px !important;
            border: none !important; cursor: pointer;
        }
        .fc .fc-toolbar { margin-bottom: 14px !important; }
        @media (max-width: 639px) {
            .fc .fc-toolbar-title { font-size: 13px !important; }
            .fc .fc-button { padding: 3px 7px !important; font-size: 11px !important; }
            .fc .fc-col-header-cell-cushion { font-size: 10px !important; padding: 3px 1px !important; }
            .fc-event { font-size: 9px !important; padding: 1px 3px !important; }
            .fc .fc-daygrid-day-frame { min-height: 44px !important; }
        }

        /* Animasi masuk kartu */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeup-1 { animation: fadeUp 0.38s cubic-bezier(.22,.68,0,1.2) 0.05s both; }
        .animate-fadeup-2 { animation: fadeUp 0.38s cubic-bezier(.22,.68,0,1.2) 0.13s both; }
        .animate-fadeup-3 { animation: fadeUp 0.38s cubic-bezier(.22,.68,0,1.2) 0.21s both; }
        .animate-fadeup-4 { animation: fadeUp 0.38s cubic-bezier(.22,.68,0,1.2) 0.29s both; }
        .animate-fadeup-5 { animation: fadeUp 0.38s cubic-bezier(.22,.68,0,1.2) 0.37s both; }

        /* Shimmer line dekorasi */
        .shimmer-line {
            background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 50%, #93c5fd 100%);
            height: 3px; border-radius: 2px;
        }

    </style>

    {{-- ══════════════════════════════
         HEADER SECTION
    ══════════════════════════════ --}}
    <div class="animate-fadeup-1 mb-7 max-sm:mb-5">
        <div class="shimmer-line w-10 mb-3"></div>

        {{-- Greeting dinamis (diisi JS lewat data-greeting) --}}
        <p class="text-[12px] font-semibold text-blue-500 uppercase tracking-[0.12em] mb-0.5">
            <span data-greeting>Halo</span> 👋
        </p>
        <h1 class="text-2xl font-extrabold text-slate-900 leading-tight tracking-tight max-sm:text-xl">
            Dasbor Rapat
        </h1>
        <p class="text-[13px] text-slate-400 mt-1 font-medium">Pantau semua jadwal dan aktivitas rapat Anda</p>
    </div>

    {{-- ══════════════════════════════
         STAT CARDS
    ══════════════════════════════ --}}
    <div id="dashboard-stats" class="grid grid-cols-3 gap-4 mb-6 max-lg:grid-cols-2 max-sm:grid-cols-1 max-sm:gap-3 max-sm:mb-5">

        {{-- Total Rapat --}}
        <div class="animate-fadeup-1 relative bg-white border border-slate-100 rounded-2xl p-5 flex items-center gap-4
                    shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-all duration-200
                    hover:shadow-[0_6px_24px_rgba(37,99,235,0.13)] hover:-translate-y-0.5
                    max-sm:p-4 max-sm:gap-3 overflow-hidden group">
            {{-- Dekorasi sudut --}}
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-bl-[4rem] opacity-60 group-hover:opacity-90 transition-opacity duration-200 -z-0"></div>

            <div class="relative z-10 stat-icon-wrap w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                        bg-gradient-to-br from-blue-400 to-blue-700
                        shadow-[0_4px_14px_rgba(37,99,235,0.30)]">
                <svg class="w-5 h-5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-1">Total Rapat</div>
                <div class="stat-number text-[30px] font-extrabold text-slate-900 leading-none max-sm:text-2xl">{{ $totalMeetings }}</div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="animate-fadeup-2 relative bg-white border border-slate-100 rounded-2xl p-5 flex items-center gap-4
                    shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-all duration-200
                    hover:shadow-[0_6px_24px_rgba(22,163,74,0.13)] hover:-translate-y-0.5
                    max-sm:p-4 max-sm:gap-3 overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-50 to-green-100 rounded-bl-[4rem] opacity-60 group-hover:opacity-90 transition-opacity duration-200 -z-0"></div>

            <div class="relative z-10 stat-icon-wrap w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                        bg-gradient-to-br from-green-400 to-green-700
                        shadow-[0_4px_14px_rgba(22,163,74,0.28)]">
                <svg class="w-5 h-5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-1">Selesai</div>
                <div class="stat-number text-[30px] font-extrabold text-slate-900 leading-none max-sm:text-2xl">{{ $completedCount }}</div>
            </div>
        </div>

        {{-- Terjadwal --}}
        <div class="animate-fadeup-3 relative bg-white border border-slate-100 rounded-2xl p-5 flex items-center gap-4
                    shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-all duration-200
                    hover:shadow-[0_6px_24px_rgba(245,158,11,0.13)] hover:-translate-y-0.5
                    max-sm:p-4 max-sm:gap-3 max-lg:col-span-2 max-sm:col-span-1 overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-amber-100 rounded-bl-[4rem] opacity-60 group-hover:opacity-90 transition-opacity duration-200 -z-0"></div>

            <div class="relative z-10 stat-icon-wrap w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                        bg-gradient-to-br from-amber-400 to-amber-600
                        shadow-[0_4px_14px_rgba(245,158,11,0.28)]">
                <svg class="w-5 h-5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400 mb-1">Terjadwal</div>
                <div class="stat-number text-[30px] font-extrabold text-slate-900 leading-none max-sm:text-2xl">{{ $scheduledCount }}</div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════
         MAIN GRID: KALENDER + RAPAT TERAKHIR
    ══════════════════════════════ --}}
    <div class="grid grid-cols-[1fr_360px] gap-5 max-lg:grid-cols-1 max-sm:gap-4">

        {{-- ── Kalender ── --}}
        <div data-reveal data-reveal-delay="80"
             class="animate-fadeup-4 bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4
                    shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-all duration-200
                    hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">

            {{-- Header kalender --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm">
                        <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Kalender Rapat</span>
                </div>
                <div class="flex gap-3 text-[11.5px] text-slate-500 font-medium">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-blue-500 rounded-[3px] inline-block shadow-[0_0_0_2px_rgba(59,130,246,0.2)]"></span>
                        Terjadwal
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-[3px] inline-block shadow-[0_0_0_2px_rgba(34,197,94,0.2)]"></span>
                        Selesai
                    </span>
                </div>
            </div>

            <div class="p-6 max-sm:p-3">
                <div id="calendar"></div>
            </div>
        </div>

        {{-- ── 5 Rapat Terakhir ── --}}
        <div data-reveal data-reveal-delay="160"
             class="animate-fadeup-5 bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4
                    shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-all duration-200
                    hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-orange-500 flex items-center justify-center shadow-sm">
                        <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Rapat Terakhir</span>
                </div>
                <a href="{{ route('meetings.index') }}"
                   class="flex items-center gap-1 text-[11.5px] font-semibold text-orange-500 no-underline
                          bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg px-2.5 py-1
                          transition-all duration-150 group">
                    Lihat Semua
                    <svg class="w-3 h-3 stroke-current fill-none transition-transform duration-150 group-hover:translate-x-0.5" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- List --}}
            <div class="flex flex-col divide-y divide-slate-50">
                @forelse($recentMeetings as $meeting)
                    <a href="{{ route('meetings.show', $meeting->id) }}"
                       class="flex items-center gap-3.5 px-5 py-4 no-underline
                              transition-all duration-150 hover:bg-slate-50/80 group">

                        {{-- Kotak tanggal --}}
                        <div class="w-11 h-11 flex-shrink-0 rounded-xl
                                    bg-gradient-to-br from-blue-500 to-blue-700
                                    flex flex-col items-center justify-center text-white
                                    shadow-[0_2px_8px_rgba(37,99,235,0.22)]
                                    group-hover:shadow-[0_4px_14px_rgba(37,99,235,0.32)]
                                    transition-shadow duration-150">
                            <div class="text-[15px] font-extrabold leading-none">
                                {{ \Carbon\Carbon::parse($meeting->tanggal)->format('d') }}
                            </div>
                            <div class="text-[9px] font-bold uppercase tracking-[0.06em] opacity-80">
                                {{ \Carbon\Carbon::parse($meeting->tanggal)->translatedFormat('M') }}
                            </div>
                        </div>

                        {{-- Info rapat --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-[13px] font-semibold text-slate-800 truncate leading-tight
                                        group-hover:text-blue-700 transition-colors duration-150">
                                {{ $meeting->judul }}
                            </div>
                            <div class="flex items-center gap-3 mt-1 text-[11px] text-slate-400 font-medium">
                                @if($meeting->lokasi)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $meeting->lokasi }}
                                </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($meeting->waktu)->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        {{-- Badge status --}}
                        @if($meeting->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10.5px] font-bold
                                         bg-green-50 text-green-700 border border-green-200 flex-shrink-0
                                         shadow-[0_0_0_0_rgba(34,197,94,0)] hover:shadow-[0_0_0_3px_rgba(34,197,94,0.15)]
                                         transition-shadow duration-150">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10.5px] font-bold
                                         bg-blue-50 text-blue-700 border border-blue-200 flex-shrink-0
                                         shadow-[0_0_0_0_rgba(59,130,246,0)] hover:shadow-[0_0_0_3px_rgba(59,130,246,0.15)]
                                         transition-shadow duration-150">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                Terjadwal
                            </span>
                        @endif

                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 px-4 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4 border border-slate-100">
                            <svg class="w-7 h-7 stroke-slate-300 fill-none" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-[13px] font-semibold text-slate-400">Belum ada data rapat</div>
                        <div class="text-[11.5px] text-slate-300 mt-1">Rapat yang dibuat akan muncul di sini</div>
                    </div>
                @endforelse
            </div>

        </div>

    </div>

    {{-- FullCalendar JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: @json($events),
            eventClick: function(info) {
                if (info.event.url) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                }
            },
            height: 'auto',
        });
        calendar.render();
        calendarEl._calendar = calendar;
        window.addEventListener('resize', function () {
            calendar.updateSize();
        });
    });
    </script>
    @endpush

</x-app-layout>