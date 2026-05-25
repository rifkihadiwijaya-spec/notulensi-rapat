<x-app-layout>

{{-- Top Bar --}}
<div class="flex items-start justify-between gap-4 mb-6 flex-wrap max-sm:flex-col max-sm:gap-2.5 max-sm:mb-4">
  <div>
    <div class="flex items-center gap-2 mb-1">
      <div class="w-1 h-6 rounded-full bg-gradient-to-b from-blue-400 to-blue-700"></div>
      <div class="text-[22px] font-extrabold text-slate-900 tracking-[-0.02em] leading-tight max-sm:text-[18px]">Buat Rapat Baru</div>
    </div>
    <div class="text-[13px] text-slate-400 ml-3 font-medium max-sm:text-[12px]">Isi detail rapat yang akan dijadwalkan</div>
  </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="flex items-start gap-3 px-4 py-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-[13px] mb-4 shadow-sm">
  <div class="w-6 h-6 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0 mt-px">
    <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
  </div>
  <div>
    <strong class="font-bold block mb-1">Terdapat kesalahan pada form:</strong>
    <ul class="mt-1 ml-4 list-disc space-y-0.5">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif

<form action="{{ route('meetings.store') }}" method="POST" enctype="multipart/form-data" id="form-create">
@csrf

  {{-- ══════════════════════ CARD 1: Info Rapat ══════════════════════ --}}
  <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4 shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">

    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3 max-sm:px-4">
      <div class="flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm flex-shrink-0">
          <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
        </div>
        <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Informasi Rapat</span>
      </div>
    </div>

    <div class="p-6 max-sm:p-4">
      <div class="grid grid-cols-2 gap-5 items-start max-sm:grid-cols-1 max-sm:gap-4">

        {{-- Judul --}}
        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Judul Rapat <span class="text-orange-500 ml-0.5">*</span></label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
            </span>
            <input type="text" name="judul"
              class="w-full min-w-0 pl-9 pr-3 py-2.5 border-2 rounded-xl text-[13px] bg-slate-50 text-slate-900 font-[inherit] transition-all duration-150
                     {{ $errors->has('judul') ? 'border-red-300 bg-red-50 shadow-[0_0_0_4px_rgba(239,68,68,0.07)]' : 'border-slate-200 hover:border-slate-300' }}
                     focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:py-3"
              placeholder="Contoh: Rapat Koordinasi Bulanan Dinas"
              value="{{ old('judul') }}" required>
          </div>
          @error('judul') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Tanggal --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Tanggal <span class="text-orange-500 ml-0.5">*</span></label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            </span>
            <input type="date" name="tanggal"
              class="w-full min-w-0 pl-9 pr-3 py-2.5 border-2 rounded-xl text-[13px] bg-slate-50 text-slate-900 font-[inherit] transition-all duration-150
                     {{ $errors->has('tanggal') ? 'border-red-300 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}
                     focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:py-3 max-sm:min-h-[44px]"
              value="{{ old('tanggal') }}" required>
          </div>
          @error('tanggal') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Waktu --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Waktu <span class="text-orange-500 ml-0.5">*</span></label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
              </svg>
            </span>
            <input type="time" name="waktu"
              class="w-full min-w-0 pl-9 pr-3 py-2.5 border-2 rounded-xl text-[13px] bg-slate-50 text-slate-900 font-[inherit] transition-all duration-150
                     {{ $errors->has('waktu') ? 'border-red-300 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}
                     focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:py-3 max-sm:min-h-[44px]"
              value="{{ old('waktu') }}" required>
          </div>
          @error('waktu') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Lokasi --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Lokasi <span class="text-orange-500 ml-0.5">*</span></label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
              </svg>
            </span>
            <input type="text" name="lokasi"
              class="w-full min-w-0 pl-9 pr-3 py-2.5 border-2 rounded-xl text-[13px] bg-slate-50 text-slate-900 font-[inherit] transition-all duration-150
                     {{ $errors->has('lokasi') ? 'border-red-300 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}
                     focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:py-3 max-sm:min-h-[44px]"
              placeholder="Contoh: Ruang Rapat Lantai 3"
              value="{{ old('lokasi') }}" required>
          </div>
          @error('lokasi') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Jenis --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Jenis Rapat <span class="text-orange-500 ml-0.5">*</span></label>
          <select name="jenis"
                  class="w-full min-w-0 appearance-none px-3 py-2.5 border-2 rounded-xl text-[13px] bg-slate-50 text-slate-900 font-[inherit] transition-all duration-150 cursor-pointer pr-9
                         bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%2264748b%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]
                         {{ $errors->has('jenis') ? 'border-red-300 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}
                         focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:py-3 max-sm:min-h-[44px]"
                  required>
            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih jenis rapat...</option>
            <option value="Internal DISKOMINFO"  {{ old('jenis') === 'Internal DISKOMINFO'  ? 'selected' : '' }}>Internal DISKOMINFO</option>
            <option value="Eksternal DISKOMINFO" {{ old('jenis') === 'Eksternal DISKOMINFO' ? 'selected' : '' }}>Eksternal DISKOMINFO</option>
          </select>
          @error('jenis') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Divider: Konten --}}
        <div class="col-span-2 max-sm:col-span-1 flex items-center gap-3 pt-3 mt-1">
          <div class="w-1 h-4 rounded-full bg-gradient-to-b from-blue-400 to-blue-600"></div>
          <span class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-blue-500">Konten Rapat</span>
          <div class="flex-1 h-px bg-gradient-to-r from-blue-100 to-transparent"></div>
        </div>

        {{-- Topik --}}
        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <label class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-500 block">Topik / Agenda</label>
          <textarea name="topik"
                    class="w-full min-w-0 box-border border-2 rounded-xl p-3 text-[13px] bg-slate-50 text-slate-900 font-[inherit] resize-y min-h-[96px] leading-[1.65] transition-all duration-150
                           {{ $errors->has('topik') ? 'border-red-300 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}
                           focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.10)] max-sm:text-[14px] max-sm:min-h-[100px]"
                    placeholder="Uraikan topik atau agenda yang akan dibahas...">{{ old('topik') }}</textarea>
          @error('topik') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
        </div>

        {{-- Divider: Partisipan --}}
        <div class="col-span-2 max-sm:col-span-1 flex items-center gap-3 pt-3 mt-1">
          <div class="w-1 h-4 rounded-full bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
          <span class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-indigo-500">Daftar Partisipan</span>
          <div class="flex-1 h-px bg-gradient-to-r from-indigo-100 to-transparent"></div>
        </div>

        {{-- Partisipan Dinamis --}}
        <div class="flex flex-col gap-2 min-w-0 col-span-2 max-sm:col-span-1">
          <input type="hidden" name="partisipan" id="partisipan-json"
                 value="{{ old('partisipan') }}">

          <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white shadow-sm overflow-x-auto">
            <div class="flex items-center gap-3 px-4 py-2.5 bg-slate-50 border-b border-slate-200 min-w-[860px]">
              <div class="w-7 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 flex-shrink-0">#</div>
              <div class="flex-1 min-w-0 flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">
                <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Nama
              </div>
              <div class="w-44 flex-shrink-0 flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">
                <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
                Peran
              </div>
              <div class="w-40 flex-shrink-0 flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">
                <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                Jabatan
              </div>
              <div class="w-48 flex-shrink-0 flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">
                <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Bidang / Unit Kerja
              </div>
              <div class="w-8 flex-shrink-0"></div>
            </div>
            <div id="partisipan-tbody" class="divide-y divide-slate-100 min-w-[860px]"></div>
            <div class="flex items-center justify-between px-4 py-3 bg-slate-50 border-t border-slate-200 min-w-[860px]">
              <button type="button" id="btn-add-row"
                      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[12px] font-bold cursor-pointer
                             bg-indigo-50 text-indigo-700 border border-indigo-200 transition-all duration-150 font-[inherit]
                             hover:bg-indigo-600 hover:text-white hover:border-indigo-600">
                <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Peserta
              </button>
              <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                  <svg class="w-3 h-3 stroke-indigo-500 fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                  </svg>
                </div>
                <span class="text-[12px] font-semibold text-slate-500" id="partisipan-count">0 peserta</span>
              </div>
            </div>
          </div>

          @error('partisipan') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
          <span class="text-[11px] text-slate-400 leading-relaxed">Isi nama dan peran/jabatan setiap peserta. Baris kosong akan diabaikan.</span>
        </div>

      </div>
    </div>
  </div>

  {{-- ══════════════════════ CARD 2: Notulensi ══════════════════════ --}}
  <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4 shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3 max-sm:px-4">
      <div class="flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-lg bg-violet-600 flex items-center justify-center shadow-sm flex-shrink-0">
          <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
        </div>
        <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Notulensi Rapat</span>
      </div>
      <span class="text-[11px] text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg font-medium">Editor teks kaya (TinyMCE) — opsional</span>
    </div>
    <div class="p-6 max-sm:p-4">
      @php
        $notulensiDefault = <<<'HTML'
<h2><strong>Latar Belakang</strong></h2>
<p>Uraikan latar belakang dan tujuan diselenggarakannya rapat ini.</p>

<h2><strong>Peserta Rapat</strong></h2>
<p>Daftar peserta yang hadir dalam rapat ini.</p>

<h2><strong>Isi Rapat</strong></h2>
<h3>1. Pembahasan Agenda Pertama</h3>
<p>Uraikan hasil pembahasan agenda pertama secara singkat dan jelas.</p>
<h3>2. Pembahasan Agenda Kedua</h3>
<p>Uraikan hasil pembahasan agenda kedua secara singkat dan jelas.</p>

<h2><strong>Kesimpulan</strong></h2>
<p>Tuliskan kesimpulan dan tindak lanjut yang disepakati dalam rapat.</p>
HTML;
        $notulensiValue = old('notulensi') ?: $notulensiDefault;
      @endphp
      <textarea name="notulensi" id="notulensi-editor"
                class="w-full border-2 rounded-xl {{ $errors->has('notulensi') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}">{!! $notulensiValue !!}</textarea>
      @error('notulensi') <span class="text-[11.5px] text-red-500 mt-1.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
    </div>
  </div>

  {{-- ══════════════════════ CARD 3: Dokumentasi Foto ══════════════════════ --}}
  <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4 shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3 max-sm:px-4">
      <div class="flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-lg bg-teal-600 flex items-center justify-center shadow-sm flex-shrink-0">
          <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21 15 16 10 5 21"/>
          </svg>
        </div>
        <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Dokumentasi Foto</span>
      </div>
      <span class="text-[11px] text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg font-medium">Maks. 3MB per foto (JPG, PNG, WEBP) — opsional</span>
    </div>
    <div class="p-6 max-sm:p-4">
      <div class="relative">
        <input type="file" name="dokumentasi[]" multiple accept="image/*"
               class="w-full border-2 border-dashed border-slate-200 rounded-xl px-4 py-3 text-[13px] bg-slate-50 text-slate-600 font-[inherit] transition-all duration-150 cursor-pointer
                      hover:border-blue-300 hover:bg-blue-50/40 focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_4px_rgba(59,130,246,0.08)]">
      </div>
      <span class="text-[11px] text-slate-400 mt-1.5 block">Pilih lebih dari satu file untuk upload sekaligus.</span>
      @error('dokumentasi.*') <span class="text-[11.5px] text-red-500 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
    </div>
  </div>

  {{-- ══════════════════════ CARD 4: Surat Undangan ══════════════════════ --}}
  <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4 shadow-[0_2px_12px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_6px_24px_rgba(10,22,40,0.09)]">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white gap-3 max-sm:px-4">
      <div class="flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-lg bg-red-600 flex items-center justify-center shadow-sm flex-shrink-0">
          <svg class="w-3.5 h-3.5 stroke-white fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
          </svg>
        </div>
        <span class="text-[13.5px] font-bold text-slate-800 tracking-tight">Surat Undangan Rapat</span>
      </div>
      <span class="text-[11px] text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg font-medium">Maks. 5MB (PDF) — opsional</span>
    </div>
    <div class="p-6 max-sm:p-4">
      <label id="surat-dropzone"
             class="relative flex flex-col items-center justify-center gap-2 border-2 border-dashed rounded-xl px-5 py-7 cursor-pointer transition-all duration-200
                    {{ $errors->has('surat_undangan') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-slate-50 hover:border-red-300 hover:bg-red-50/30' }}">
        <input type="file" name="surat_undangan" id="surat-input" accept=".pdf" class="sr-only">
        <div id="surat-icon-default" class="flex flex-col items-center gap-2">
          <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center">
            <svg class="w-5 h-5 stroke-red-400 fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/>
            </svg>
          </div>
          <div class="text-[13px] font-semibold text-slate-600">Klik atau seret file PDF ke sini</div>
          <div class="text-[11.5px] text-slate-400">Hanya file .pdf, maksimal 5 MB</div>
        </div>
        <div id="surat-preview" class="hidden flex-col items-center gap-2">
          <div class="w-10 h-10 rounded-xl bg-green-50 border border-green-200 flex items-center justify-center">
            <svg class="w-5 h-5 stroke-green-500 fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>
          <div id="surat-filename" class="text-[13px] font-semibold text-slate-700 max-w-xs truncate text-center"></div>
          <div id="surat-filesize" class="text-[11.5px] text-slate-400"></div>
          <button type="button" id="surat-clear"
                  class="mt-1 inline-flex items-center gap-1 text-[11.5px] font-semibold text-red-500 hover:text-red-700 transition-colors duration-150 bg-transparent border-none cursor-pointer font-[inherit]">
            <svg class="w-3 h-3 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Hapus pilihan
          </button>
        </div>
      </label>
      @error('surat_undangan')
        <span class="text-[11.5px] text-red-500 mt-2 flex items-center gap-1">
          <svg class="w-3 h-3 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          {{ $message }}
        </span>
      @enderror
    </div>
  </div>

  {{-- ══════════════════════ FOOTER ══════════════════════ --}}
  <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-4 shadow-[0_2px_12px_rgba(10,22,40,0.07)]">
    <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gradient-to-r from-slate-50 to-white rounded-2xl max-sm:flex-col-reverse max-sm:gap-2 max-sm:px-4">
      <a href="{{ route('meetings.index') }}"
         class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[13px] font-semibold no-underline
                bg-white border-2 border-slate-200 text-slate-600 transition-all duration-150
                hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm
                max-sm:w-full max-sm:justify-center max-sm:py-3">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Batal
      </a>
      <button type="submit"
              class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-[13px] font-bold cursor-pointer font-[inherit]
                     bg-gradient-to-br from-blue-500 to-blue-700 text-white border-none
                     shadow-[0_4px_14px_rgba(37,99,235,0.30)] transition-all duration-150
                     hover:from-blue-600 hover:to-blue-800 hover:shadow-[0_6px_20px_rgba(37,99,235,0.38)] hover:-translate-y-px
                     max-sm:w-full max-sm:justify-center max-sm:py-3">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
          <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
        </svg>
        Simpan Rapat
      </button>
    </div>
  </div>

</form>

@push('scripts')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
// ── TinyMCE ───────────────────────────────────────────────────
tinymce.init({
  selector: '#notulensi-editor',
  license_key: 'gpl',
  promotion: false,
  branding: false,
  height: 420,
  menubar: 'file edit view insert format tools table',
  plugins: 'lists link table',
  toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | table',
  block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3',
  valid_elements: 'p,h1,h2,h3,strong/b,em/i,u,ul,ol,li,table,thead,tbody,tr,th,td,a[href|target=_blank]',
  forced_root_block: 'p',
  skin: 'oxide',
  content_css: 'default',
  setup: function(editor) {
    editor.on('init', function() {
      editor.getContainer().style.borderRadius = '7px';
      editor.getContainer().style.border = '1px solid #e2e8f0';
      editor.getContainer().style.overflow = 'hidden';
    });
    editor.on('focus', function() {
      editor.getContainer().style.borderColor = '#3b82f6';
      editor.getContainer().style.boxShadow = '0 0 0 3px rgba(59,130,246,.08)';
    });
    editor.on('blur', function() {
      editor.getContainer().style.borderColor = '#e2e8f0';
      editor.getContainer().style.boxShadow = 'none';
    });
  }
});

// ── Surat Undangan Dropzone ───────────────────────────────────
(function() {
  const input    = document.getElementById('surat-input');
  const dropzone = document.getElementById('surat-dropzone');
  const iconDef  = document.getElementById('surat-icon-default');
  const preview  = document.getElementById('surat-preview');
  const filename = document.getElementById('surat-filename');
  const filesize = document.getElementById('surat-filesize');
  const clearBtn = document.getElementById('surat-clear');

  function formatBytes(bytes) {
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  function showPreview(file) {
    filename.textContent = file.name;
    filesize.textContent = formatBytes(file.size);
    iconDef.classList.add('hidden'); iconDef.classList.remove('flex');
    preview.classList.remove('hidden'); preview.classList.add('flex');
    dropzone.classList.add('border-green-300', 'bg-green-50/40');
    dropzone.classList.remove('border-slate-200', 'bg-slate-50', 'hover:border-red-300', 'hover:bg-red-50/30');
  }

  function clearPreview() {
    input.value = '';
    preview.classList.add('hidden'); preview.classList.remove('flex');
    iconDef.classList.remove('hidden'); iconDef.classList.add('flex');
    dropzone.classList.remove('border-green-300', 'bg-green-50/40');
    dropzone.classList.add('border-slate-200', 'bg-slate-50', 'hover:border-red-300', 'hover:bg-red-50/30');
  }

  if (input) input.addEventListener('change', function() {
    if (this.files && this.files[0]) showPreview(this.files[0]);
  });
  if (clearBtn) clearBtn.addEventListener('click', function(e) {
    e.preventDefault(); e.stopPropagation(); clearPreview();
  });
  ['dragenter','dragover'].forEach(evt => dropzone.addEventListener(evt, e => {
    e.preventDefault();
    dropzone.classList.add('border-blue-400','bg-blue-50/40');
  }));
  ['dragleave','dragend'].forEach(evt => dropzone.addEventListener(evt, () =>
    dropzone.classList.remove('border-blue-400','bg-blue-50/40')
  ));
  dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.classList.remove('border-blue-400','bg-blue-50/40');
    const file = e.dataTransfer.files[0];
    if (file && file.type === 'application/pdf') {
      const dt = new DataTransfer(); dt.items.add(file);
      input.files = dt.files; showPreview(file);
    }
  });
})();

// ── Partisipan ────────────────────────────────────────────────
(function() {
  const ROLES   = ['Pimpinan Rapat','Sekretaris / Notulis','Narasumber','Peserta','Undangan'];
  const tbody   = document.getElementById('partisipan-tbody');
  const jsonIn  = document.getElementById('partisipan-json');
  const countEl = document.getElementById('partisipan-count');

  if (!tbody || !jsonIn) return;

  const INPUT_CLS  = 'w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-[13px] text-slate-800 font-[inherit] placeholder:text-slate-300 outline-none transition-all duration-150 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 hover:border-slate-300';
  const SELECT_CLS = "w-full px-3 py-2 pr-8 rounded-xl border border-slate-200 bg-white text-[13px] text-slate-700 font-[inherit] outline-none cursor-pointer transition-all duration-150 appearance-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 hover:border-slate-300 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%2294a3b8%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_10px_center]";

  let initialRows = [];
  try {
    const old = @json(old('partisipan'));
    if (old) initialRows = JSON.parse(old);
  } catch(e) {}

  if (!initialRows.length) {
    initialRows = [
      { nama: '', peran: 'Pimpinan Rapat',       jabatan: '', bidang: '' },
      { nama: '', peran: 'Sekretaris / Notulis', jabatan: '', bidang: '' },
      { nama: '', peran: 'Peserta',               jabatan: '', bidang: '' },
    ];
  }

  function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function buildRoleOptions(selected) {
    const isOther = selected && !ROLES.includes(selected);
    return ROLES.map(r =>
      `<option value="${r}" ${r === selected ? 'selected' : ''}>${r}</option>`
    ).join('') + `<option value="Lainnya" ${isOther ? 'selected' : ''}>Lainnya…</option>`;
  }

  function syncJson() {
    const rows = [];
    tbody.querySelectorAll('.partisipan-row').forEach(el => {
      const nama    = el.querySelector('.p-nama').value.trim();
      const sel     = el.querySelector('.p-peran').value;
      const peran   = sel === 'Lainnya' ? el.querySelector('.p-peran-custom').value.trim() : sel;
      const jabatan = el.querySelector('.p-jabatan').value.trim();
      const bidang  = el.querySelector('.p-bidang').value.trim();
      if (nama || peran || jabatan || bidang) rows.push({ nama, peran, jabatan, bidang });
    });
    jsonIn.value = JSON.stringify(rows);
    if (countEl) countEl.textContent = rows.filter(r => r.nama).length + ' peserta';
  }

  function renumber() {
    tbody.querySelectorAll('.partisipan-row').forEach((el, i) => {
      el.querySelector('.td-num').textContent = i + 1;
    });
  }

  function addRow(data) {
    data = Object.assign({ nama: '', peran: 'Peserta', jabatan: '', bidang: '' }, data || {});
    const isOther = data.peran && !ROLES.includes(data.peran);

    const row = document.createElement('div');
    row.className = 'partisipan-row flex items-start gap-3 px-4 py-2.5 group/row hover:bg-slate-50/70 transition-colors duration-100';

    row.innerHTML = `
      <div class="td-num w-7 flex-shrink-0 text-[12px] font-bold text-slate-300 select-none pt-2.5 text-center"></div>
      <div class="flex-1 min-w-0">
        <input type="text" class="p-nama ${INPUT_CLS}" placeholder="Nama peserta…" value="${escHtml(data.nama)}">
      </div>
      <div class="w-44 flex-shrink-0 flex flex-col gap-1">
        <select class="p-peran ${SELECT_CLS}">
          ${buildRoleOptions(isOther ? 'Lainnya' : (data.peran || 'Peserta'))}
        </select>
        <input type="text" class="p-peran-custom ${INPUT_CLS} ${isOther ? '' : 'hidden'}"
               placeholder="Tulis peran…" value="${isOther ? escHtml(data.peran) : ''}">
      </div>
      <div class="w-40 flex-shrink-0">
        <input type="text" class="p-jabatan ${INPUT_CLS}" placeholder="cth: Fungsional Muda" value="${escHtml(data.jabatan)}">
      </div>
      <div class="w-48 flex-shrink-0">
        <input type="text" class="p-bidang ${INPUT_CLS}" placeholder="cth: Statistik / DISKOMINFO" value="${escHtml(data.bidang)}">
      </div>
      <div class="w-8 flex-shrink-0 flex items-center justify-center pt-1.5">
        <button type="button" class="partisipan-del-btn w-7 h-7 rounded-lg flex items-center justify-center
                text-slate-300 border border-transparent transition-all duration-150
                hover:bg-red-50 hover:text-red-500 hover:border-red-200
                opacity-0 group-hover/row:opacity-100" title="Hapus baris">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>`;

    row.querySelector('.p-peran').addEventListener('change', function() {
      const custom = row.querySelector('.p-peran-custom');
      if (this.value === 'Lainnya') { custom.classList.remove('hidden'); custom.focus(); }
      else { custom.classList.add('hidden'); custom.value = ''; }
      syncJson();
    });

    row.querySelector('.partisipan-del-btn').addEventListener('click', function() {
      if (tbody.querySelectorAll('.partisipan-row').length <= 1) return;
      row.style.opacity = '0';
      row.style.transform = 'translateX(10px)';
      row.style.transition = 'opacity .15s, transform .15s';
      setTimeout(() => { row.remove(); syncJson(); renumber(); }, 150);
    });

    row.querySelectorAll('input, select').forEach(el => el.addEventListener('input', syncJson));
    tbody.appendChild(row);
    renumber();
    syncJson();
  }

  initialRows.forEach(r => addRow(r));

  const btnAdd = document.getElementById('btn-add-row');
  if (btnAdd) btnAdd.addEventListener('click', () => addRow());

  document.getElementById('form-create').addEventListener('submit', function() {
    if (typeof tinymce !== 'undefined') tinymce.triggerSave();
    syncJson();
  });
})();
</script>
@endpush

</x-app-layout>