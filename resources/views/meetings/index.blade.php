<x-app-layout>

{{-- ══ PAGE HEADER ══ --}}
<div class="flex items-start justify-between gap-4 mb-5 flex-wrap max-sm:flex-col max-sm:gap-2.5 max-sm:mb-3.5">
    <div>
        <div class="text-[22px] font-extrabold text-slate-900 tracking-[-0.02em] leading-tight max-sm:text-[16px]">Riwayat Rapat</div>
        <div class="text-[13px] text-slate-400 mt-0.5 max-sm:text-[12px]">Daftar seluruh rapat yang telah dijadwalkan</div>
    </div>

    @if(session('success'))
        <div id="flashSuccess"
             class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-[13px] font-medium">
            <svg class="w-3.5 h-3.5 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->role === 'notulis')
        <a href="{{ route('meetings.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 text-white text-[13px] font-semibold no-underline
                  shadow-[0_4px_14px_rgba(37,99,235,0.25)] transition-all duration-150
                  hover:bg-blue-700 hover:shadow-[0_6px_18px_rgba(37,99,235,0.3)]
                  max-sm:w-full max-sm:justify-center">
            <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Buat Rapat
        </a>
    @endif
</div>

{{-- ══ TOOLBAR ══ --}}
<div class="bg-white border border-slate-200 rounded-xl px-4 py-3 mb-3 flex flex-wrap items-center gap-3
            shadow-[0_1px_3px_rgba(10,22,40,0.06)]
            max-sm:flex-col max-sm:items-stretch max-sm:px-3 max-sm:py-2.5 max-sm:gap-2">

    {{-- Search --}}
    <div class="relative flex-shrink-0 min-w-[180px] max-w-[260px] max-sm:max-w-full max-sm:w-full">
        <input type="text" id="searchInput"
               class="w-full pl-9 pr-8 py-2 rounded-lg border border-slate-200 bg-slate-50 text-[13px] text-slate-900
                      outline-none transition-all duration-150 placeholder:text-slate-400
                      focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)]"
               placeholder="Cari judul rapat..." autocomplete="off"
               value="{{ request('search') }}">
        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 stroke-slate-400 fill-none pointer-events-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <button id="searchClear" type="button"
                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs hidden hover:text-slate-600">✕</button>
    </div>

    <div class="w-px h-6 bg-slate-200 max-sm:w-full max-sm:h-px"></div>

    {{-- Filter Status --}}
    <div class="flex items-center gap-1.5 flex-wrap max-sm:overflow-x-auto max-sm:flex-nowrap max-sm:pb-0.5">
        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 flex-shrink-0">Status</span>
        <button type="button" class="chip active inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-100 border-slate-200 text-slate-700 [&.active]:bg-blue-50 [&.active]:border-blue-400 [&.active]:text-blue-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="status" data-value="">Semua</button>
        <button type="button" class="chip chip-scheduled inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-50 border-slate-200 text-slate-600 [&.active]:bg-blue-50 [&.active]:border-blue-400 [&.active]:text-blue-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="status" data-value="scheduled">
            <span class="chip-dot w-1.5 h-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>Terjadwal
        </button>
        <button type="button" class="chip chip-completed inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-50 border-slate-200 text-slate-600 [&.active]:bg-green-50 [&.active]:border-green-400 [&.active]:text-green-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="status" data-value="completed">
            <span class="chip-dot w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>Selesai
        </button>
    </div>

    <div class="w-px h-6 bg-slate-200 max-sm:w-full max-sm:h-px"></div>

    {{-- Filter Jenis --}}
    <div class="flex items-center gap-1.5 flex-wrap max-sm:overflow-x-auto max-sm:flex-nowrap max-sm:pb-0.5">
        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 flex-shrink-0">Jenis</span>
        <button type="button" class="chip active inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-100 border-slate-200 text-slate-700 [&.active]:bg-blue-50 [&.active]:border-blue-400 [&.active]:text-blue-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="jenis" data-value="">Semua</button>
        <button type="button" class="chip chip-internal inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-50 border-slate-200 text-slate-600 [&.active]:bg-purple-50 [&.active]:border-purple-400 [&.active]:text-purple-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="jenis" data-value="Internal DISKOMINFO">
            <span class="chip-dot w-1.5 h-1.5 rounded-full bg-purple-500 flex-shrink-0"></span>Internal
        </button>
        <button type="button" class="chip chip-eksternal inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-medium cursor-pointer border transition-all duration-150 whitespace-nowrap
                                     bg-slate-50 border-slate-200 text-slate-600 [&.active]:bg-orange-50 [&.active]:border-orange-400 [&.active]:text-orange-700 [&.active]:font-semibold
                                     hover:border-slate-300" data-filter="jenis" data-value="Eksternal DISKOMINFO">
            <span class="chip-dot w-1.5 h-1.5 rounded-full bg-orange-500 flex-shrink-0"></span>Eksternal
        </button>
    </div>

    <div class="w-px h-6 bg-slate-200 max-sm:w-full max-sm:h-px"></div>

    {{-- Sort --}}
    <button type="button" id="sortDate"
            class="sort-btn active inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[12px] font-semibold cursor-pointer
                   border border-slate-200 bg-slate-50 text-slate-600 transition-all duration-150
                   [&.active]:bg-blue-50 [&.active]:border-blue-300 [&.active]:text-blue-700
                   hover:border-slate-300">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
        </svg>
        <span>Terbaru</span>
    </button>
</div>

{{-- ══ RESULT INFO ══ --}}
<div class="flex items-center gap-3 mb-3 px-1">
    <span class="text-[13px] text-slate-500 result-count" id="resultCount"
          data-total="{{ $totalAll }}"
          data-showing="{{ $meetings->total() }}"></span>
    <button type="button" id="resetAll"
            class="reset-all inline-flex items-center gap-1 text-[11.5px] text-blue-400 hover:text-slate-600 transition-colors duration-150 cursor-pointer border-none bg-transparent"
            style="display:none">
        <svg class="w-2.5 h-2.5 stroke-current fill-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Reset filter
    </button>
</div>

{{-- ══ TABLE ══ --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4
            shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200
            hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
    <div class="overflow-x-auto -webkit-overflow-scrolling-touch table-wrap">
        <table class="w-full border-collapse text-[13px]">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400 w-10">#</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Judul Rapat</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Tanggal &amp; Waktu</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400 max-lg:hidden">Dibuat Oleh</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400 max-lg:hidden">Pertanyaan</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Status</th>
                    <th class="px-4 py-3 text-left text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody id="meetingTbody">
                @forelse($meetings as $i => $meeting)
                    <tr data-status="{{ $meeting->status }}"
                        data-jenis="{{ $meeting->jenis }}"
                        data-judul="{{ strtolower($meeting->judul) }}"
                        data-tanggal="{{ $meeting->tanggal }}"
                        class="row-visible border-b border-slate-100 transition-all duration-150 hover:bg-slate-50/60 last:border-b-0"
                        style="animation-delay: {{ $i * 0.035 }}s">

                        <td class="px-4 py-3.5 text-slate-400 font-medium text-[12px]">{{ $meetings->firstItem() + $i }}</td>

                        <td class="px-4 py-3.5 max-w-[280px]">
                            <div class="font-semibold text-slate-800 text-[13px] leading-tight judul-searchable">{{ $meeting->judul }}</div>
                            @if($meeting->lokasi)
                                <div class="flex items-center gap-1 mt-1 text-[11.5px] text-slate-400">
                                    <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $meeting->lokasi }}
                                </div>
                            @endif
                            @if($meeting->jenis)
                                <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[10.5px] font-semibold
                                             {{ $meeting->jenis === 'Internal DISKOMINFO'
                                                ? 'bg-purple-50 text-purple-700 border border-purple-200'
                                                : 'bg-orange-50 text-orange-700 border border-orange-200' }}">
                                    {{ $meeting->jenis === 'Internal DISKOMINFO' ? 'Internal' : 'Eksternal' }}
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3.5">
                            <div class="text-[13px] font-semibold text-slate-800">{{ \Carbon\Carbon::parse($meeting->tanggal)->translatedFormat('d M Y') }}</div>
                            <div class="text-[11.5px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($meeting->waktu)->format('H:i') }} WIB</div>
                        </td>

                        <td class="px-4 py-3.5 max-lg:hidden">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-orange-500
                                            flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0">
                                    {{ $meeting->creator_initials }}
                                </div>
                                <span class="text-[12.5px] text-slate-700 font-medium">{{ $meeting->display_creator_name }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3.5 max-lg:hidden">
                            <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-lg
                                         bg-slate-100 text-slate-600 text-[12px] font-bold border border-slate-200">
                                {{ $meeting->questions_count }}
                            </span>
                        </td>

                        <td class="px-4 py-3.5">
                            @if($meeting->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                             bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                             bg-blue-50 text-blue-700 border border-blue-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Terjadwal
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('meetings.show', $meeting->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[12px] font-semibold no-underline
                                          bg-blue-50 text-blue-700 border border-blue-200 transition-all duration-150
                                          hover:bg-blue-600 hover:text-white hover:border-blue-600">
                                    <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                                @can('update', $meeting)
                                    <a href="{{ route('meetings.edit', $meeting->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[12px] font-semibold no-underline
                                              bg-orange-50 text-orange-700 border border-orange-200 transition-all duration-150
                                              hover:bg-orange-500 hover:text-white hover:border-orange-500">
                                        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="flex flex-col items-center justify-center py-14 px-4 text-center">
                                <svg class="w-12 h-12 stroke-slate-300 fill-none mb-3" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div class="text-[14px] font-semibold text-slate-500 mb-1">Tidak ada data rapat</div>
                                <div class="text-[12.5px] text-slate-400">Belum ada rapat yang dibuat</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- No result block --}}
    <div id="noResult" class="hidden flex-col items-center justify-center py-14 px-4 text-center">
        <svg class="w-10 h-10 stroke-slate-300 fill-none mb-3" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <div class="text-[14px] font-semibold text-slate-500 mb-1">Tidak ditemukan</div>
        <div class="text-[12.5px] text-slate-400" id="noResultSub">Coba ubah kata kunci atau filter</div>
    </div>

    @if($meetings->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $meetings->links() }}</div>
    @endif
</div>

</x-app-layout>