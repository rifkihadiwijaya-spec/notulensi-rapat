<x-app-layout>

{{-- Top Bar --}}
<div class="flex items-start justify-between gap-3 mb-5 flex-wrap max-sm:flex-col max-sm:gap-2.5 max-sm:mb-4">
  <div class="flex items-start gap-3">
    <a href="{{ route('meetings.index') }}"
       class="hidden max-lg:inline-flex items-center gap-1.5 px-3 py-[7px] rounded-lg border border-slate-200
              bg-white text-slate-600 text-[13px] font-medium no-underline flex-shrink-0 mt-0.5
              transition-all duration-150 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900
              max-sm:px-2.5">
      <svg class="w-4 h-4 stroke-current fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
      </svg>
      <span class="max-sm:hidden">Kembali</span>
    </a>
    <div>
      <div class="text-[22px] font-extrabold text-slate-900 tracking-[-0.02em] leading-tight max-sm:text-[16px]">{{ $meeting->judul }}</div>
      <div class="text-[13px] text-slate-400 mt-0.5 max-sm:text-[12px]">Detail Rapat</div>
    </div>
  </div>
  <a href="{{ route('meetings.pdf', $meeting->id) }}"
     class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-red-600 text-white text-[13px] font-semibold no-underline
            shadow-[0_4px_14px_rgba(220,38,38,0.25)] transition-all duration-150
            hover:bg-red-700 hover:shadow-[0_6px_18px_rgba(220,38,38,0.3)]
            max-sm:w-full max-sm:justify-center">
    <svg class="w-[15px] h-[15px] stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
      <polyline points="7 10 12 15 17 10"/>
      <line x1="12" y1="15" x2="12" y2="3"/>
    </svg>
    Download PDF
  </a>
</div>

{{-- Info Rapat --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50 gap-3 max-sm:flex-wrap max-sm:gap-1.5 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-blue-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      Informasi Rapat
    </span>
    @if($meeting->status === 'completed')
      <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-green-50 text-green-700 border border-green-200">
        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Selesai
      </span>
    @else
      <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Terjadwal
      </span>
    @endif
  </div>
  <div class="p-[22px_24px] max-sm:p-4">
    <div class="grid grid-cols-2 gap-5 max-sm:grid-cols-1 max-sm:gap-4">

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Tanggal</span>
        <span class="text-[13.5px] font-semibold text-slate-800">
          {{ \Carbon\Carbon::parse($meeting->tanggal)->translatedFormat('d F Y') }}
        </span>
      </div>

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Waktu</span>
        <span class="text-[13.5px] font-semibold text-slate-800">
          {{ \Carbon\Carbon::parse($meeting->waktu)->format('H:i') }} WIB
        </span>
      </div>

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Lokasi</span>
        <span class="text-[13.5px] font-semibold text-slate-800">{{ $meeting->lokasi }}</span>
      </div>

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Jenis Rapat</span>
        <span class="text-[13.5px] font-semibold text-slate-800">{{ $meeting->jenis }}</span>
      </div>

      <div class="flex flex-col gap-1 col-span-2 max-sm:col-span-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Topik</span>
        <span class="text-[13.5px] font-semibold text-slate-800">{{ $meeting->topik }}</span>
      </div>

      {{-- ── Partisipan Terstruktur ── --}}
      <div class="flex flex-col gap-2 col-span-2 max-sm:col-span-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Partisipan</span>

        @php
          $rawPartisipan = $meeting->partisipan;
          $rows = [];
          if ($rawPartisipan) {
            $decoded = json_decode($rawPartisipan, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
              $rows = array_values(array_filter($decoded, fn($r) =>
                !empty($r['nama']) || !empty($r['peran']) || !empty($r['jabatan']) || !empty($r['bidang'])
              ));
            }
          }
          $roleColors = [
            'Pimpinan Rapat'       => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'dot' => 'bg-blue-500'],
            'Sekretaris / Notulis' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'dot' => 'bg-violet-500'],
            'Narasumber'           => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'dot' => 'bg-orange-500'],
            'Peserta'              => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-200',  'dot' => 'bg-green-500'],
            'Undangan'             => ['bg' => 'bg-slate-50',  'text' => 'text-slate-600',  'border' => 'border-slate-200',  'dot' => 'bg-slate-400'],
          ];
          $defaultRole = ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'];
        @endphp

        @if(count($rows))
          <div class="rounded-xl border border-slate-200 overflow-hidden overflow-x-auto">
            <table class="w-full border-collapse text-[13px] min-w-[600px]">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-9">#</th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                      Nama
                    </div>
                  </th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-[155px]">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
                      Peran
                    </div>
                  </th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-[165px]">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                      Jabatan
                    </div>
                  </th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-[200px]">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                      Bidang / Unit Kerja
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($rows as $i => $row)
                  @php
                    $peran = $row['peran'] ?? '';
                    $rc = $roleColors[$peran] ?? $defaultRole;
                  @endphp
                  <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition-colors duration-100">
                    <td class="px-3 py-3 text-[12px] text-slate-400 font-medium">{{ $i + 1 }}</td>
                    <td class="px-3 py-3">
                      <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-extrabold text-white flex-shrink-0 uppercase {{ $rc['dot'] }}">
                          {{ mb_strtoupper(mb_substr(trim($row['nama'] ?? '?'), 0, 1)) }}
                        </span>
                        <span class="text-[13px] font-semibold text-slate-800">{{ $row['nama'] ?? '—' }}</span>
                      </div>
                    </td>
                    <td class="px-3 py-3">
                      @if($peran)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11.5px] font-semibold border {{ $rc['bg'] }} {{ $rc['text'] }} {{ $rc['border'] }}">
                          <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $rc['dot'] }}"></span>
                          {{ $peran }}
                        </span>
                      @else
                        <span class="text-slate-300 text-[12px]">—</span>
                      @endif
                    </td>
                    <td class="px-3 py-3 text-[12.5px] text-slate-600">
                      {{ $row['jabatan'] ?? '—' ?: '—' }}
                    </td>
                    <td class="px-3 py-3 text-[12.5px] text-slate-600">
                      {{ $row['bidang'] ?? '—' ?: '—' }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @elseif($rawPartisipan && !is_array(json_decode($rawPartisipan, true)))
          <span class="text-[13.5px] font-semibold text-slate-800 whitespace-pre-line">{{ $rawPartisipan }}</span>
        @else
          <span class="text-[13.5px] text-slate-400">—</span>
        @endif
      </div>

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Dibuat oleh</span>
        <span class="text-[13.5px] font-semibold text-slate-800">{{ $meeting->display_creator_name }}</span>
      </div>

      <div class="flex flex-col gap-1">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400">Notulis</span>
        <span class="text-[13.5px] font-semibold text-slate-800">{{ $meeting->display_notulen_name }}</span>
      </div>
    </div>
  </div>
</div>

{{-- Surat Undangan --}}
@if($meeting->surat_undangan)
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center bg-slate-50 gap-3 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-red-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
      </svg>
      Surat Undangan Rapat
    </span>
  </div>
  <div class="p-[22px_24px] max-sm:p-4">
    <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50">
      <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 stroke-red-500 fill-none" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
        </svg>
      </div>
      <div class="flex-1 min-w-0">
        <div class="text-[13px] font-semibold text-slate-800 truncate">{{ $meeting->surat_undangan_nama }}</div>
        <div class="text-[11.5px] text-slate-400 mt-0.5">Dokumen PDF</div>
      </div>
      <a href="{{ asset('storage/' . $meeting->surat_undangan) }}" target="_blank"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-red-600 text-white text-[12.5px] font-semibold no-underline
                shadow-[0_3px_10px_rgba(220,38,38,0.25)] transition-all duration-150
                hover:bg-red-700 hover:shadow-[0_5px_14px_rgba(220,38,38,0.3)] flex-shrink-0">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Download Surat
      </a>
    </div>
  </div>
</div>
@endif

{{-- Notulensi --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50 gap-3 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-blue-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
      Notulensi Rapat
    </span>
  </div>
  <div class="p-[22px_24px] max-sm:p-4">
    @if($meeting->notulensi)
      <div class="prose max-w-none text-[13.5px] leading-relaxed text-slate-700">{!! $meeting->notulensi !!}</div>
    @else
      <p class="text-[13px] text-slate-400 text-center py-6">Notulensi belum tersedia.</p>
    @endif
  </div>
</div>

{{-- Dokumentasi Foto --}}
@if($meeting->dokumentasi->count())
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50 gap-3 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-blue-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
        <polyline points="21 15 16 10 5 21"/>
      </svg>
      Dokumentasi Foto
    </span>
    <span class="text-[12px] text-slate-400">{{ $meeting->dokumentasi->count() }} foto</span>
  </div>
  <div class="p-[22px_24px] max-sm:p-4">
    <div class="flex flex-wrap gap-3">
      @foreach($meeting->dokumentasi as $foto)
      <a href="{{ asset('storage/' . $foto->path_file) }}" target="_blank" title="{{ $foto->nama_file }}"
         class="block rounded-lg overflow-hidden border border-slate-200 transition-opacity duration-200 hover:opacity-80">
        <img src="{{ asset('storage/' . $foto->path_file) }}"
             alt="{{ $foto->nama_file }}"
             class="w-[150px] h-[110px] object-cover">
      </a>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════
     Pertanyaan & Klarifikasi — QA Section
     qa.js meng-attach event listener ke .qa-section
     ═══════════════════════════════════════════════ --}}
<div class="qa-section bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]"
     data-user-role="{{ auth()->user()->role }}"
     data-reply-url-template="{{ route('questions.reply', ['question' => '__ID__']) }}">

  {{-- Card Header --}}
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50 gap-3 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-blue-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      Pertanyaan &amp; Klarifikasi
    </span>
    {{-- .qa-counter diupdate oleh JS setiap pertanyaan baru masuk --}}
    <span class="qa-counter text-[12px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full border border-slate-200 tabular-nums transition-all duration-300">
      {{ $meeting->questions->count() }} pertanyaan
    </span>
  </div>

  <div class="p-[22px_24px] max-sm:p-4">

    {{-- ── Form Pertanyaan (viewer) ── --}}
    @if(auth()->user()->role === 'viewer')
    <form
      action="{{ route('questions.store', $meeting->id) }}"
      method="POST"
      class="qa-question-form mb-6 bg-blue-50 border border-blue-100 rounded-xl p-4"
    >
      @csrf
      <label class="block text-[11px] font-bold uppercase tracking-[0.07em] text-blue-600 mb-2.5">
        Tulis Pertanyaan atau Klarifikasi
      </label>
      <textarea
        name="isi"
        placeholder="Tulis pertanyaan atau klarifikasi Anda di sini..."
        required
        rows="3"
        class="w-full p-3 rounded-xl border border-blue-200 bg-white text-[13px] text-slate-900
               font-[inherit] outline-none resize-none transition-all duration-150 placeholder:text-slate-400
               focus:border-blue-400 focus:shadow-[0_0_0_3px_rgba(59,130,246,0.15)]"
      ></textarea>
      <div class="flex items-center justify-between mt-3 gap-3 flex-wrap">
        {{-- Area inline feedback (JS akan isi ini) --}}
        <div class="qa-form-feedback flex-1 min-w-0 text-[12px]"></div>
        <button
          type="submit"
          data-label="Kirim Pertanyaan"
          class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 text-white text-[13px] font-semibold
                 border-none cursor-pointer font-[inherit]
                 shadow-[0_4px_14px_rgba(37,99,235,0.30)]
                 transition-all duration-150
                 hover:bg-blue-700 hover:shadow-[0_6px_18px_rgba(37,99,235,0.38)]
                 active:scale-[0.97]
                 disabled:opacity-60 disabled:cursor-not-allowed disabled:shadow-none"
        >
          <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"/>
            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
          Kirim Pertanyaan
        </button>
      </div>
    </form>
    @endif

    {{-- ── Daftar Pertanyaan ── --}}
    <div class="qa-list flex flex-col gap-3">

      @forelse($meeting->questions as $question)
      <div class="question-card border border-slate-200 rounded-xl p-4 bg-white
                  shadow-[0_1px_3px_rgba(10,22,40,0.06)]"
           data-id="{{ $question->id }}">

        {{-- Meta baris --}}
        <div class="flex items-center gap-2 mb-2.5">
          <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-blue-700
                      flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0">
            {{ $question->user_initials }}
          </div>
          <span class="text-[12.5px] font-semibold text-slate-700">{{ $question->display_user_name }}</span>
          <span class="text-[11px] text-slate-400 ml-auto whitespace-nowrap">
            {{ \Carbon\Carbon::parse($question->created_at)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
          </span>
        </div>

        {{-- Isi pertanyaan --}}
        <div class="text-[13.5px] text-slate-700 leading-relaxed pl-9">{{ $question->isi }}</div>

        {{-- Replies yang sudah ada --}}
        @if($question->replies->count())
        <div class="reply-wrap mt-3 pl-9 flex flex-col gap-2">
          @foreach($question->replies as $reply)
          @php $isNotulis = optional($reply->user)->role === 'notulis'; @endphp
          <div class="reply-card flex items-start gap-2.5 rounded-xl p-3 border
                      {{ $isNotulis
                          ? 'bg-green-50 border-green-100'
                          : 'bg-blue-50 border-blue-100' }}">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0
                        {{ $isNotulis
                            ? 'bg-gradient-to-br from-emerald-500 to-cyan-600'
                            : 'bg-gradient-to-br from-blue-400 to-blue-600' }}">
              {{ $reply->user_initials }}
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-0.5">
                <span class="text-[11.5px] font-semibold
                             {{ $isNotulis ? 'text-emerald-700' : 'text-blue-700' }}">
                  {{ $reply->display_user_name }}
                </span>
                @if($isNotulis)
                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-emerald-100 text-emerald-600 border border-emerald-200">
                  Notulis
                </span>
                @endif
              </div>
              <div class="text-[13px] text-slate-600 leading-relaxed">{{ $reply->isi }}</div>
            </div>
          </div>
          @endforeach
        </div>
        @endif

        {{-- ── Area Form Balasan ── --}}
        {{-- Notulis: form jawaban resmi (hijau) --}}
        @if(auth()->user()->role === 'notulis' && auth()->id() === $meeting->created_by)
        <div class="reply-form-wrap mt-3 pl-9">
          <div class="text-[11px] font-bold uppercase tracking-[0.07em] text-slate-400 mb-2">Tulis Jawaban</div>
          <form action="{{ route('questions.reply', $question->id) }}" method="POST"
                class="qa-reply-form" data-reply-role="notulis">
            @csrf
            <textarea
              name="isi"
              placeholder="Tulis jawaban..."
              required
              rows="2"
              class="w-full p-2.5 rounded-xl border border-slate-200 bg-slate-50 text-[13px] text-slate-900
                     font-[inherit] outline-none resize-none transition-all duration-150 placeholder:text-slate-400
                     focus:border-emerald-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(16,185,129,0.12)]"
            ></textarea>
            <div class="flex items-center justify-between mt-2 gap-3">
              <div class="qa-form-feedback flex-1 text-[12px]"></div>
              <button
                type="submit"
                data-label="Balas"
                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 text-white text-[12px] font-semibold
                       border-none cursor-pointer font-[inherit] transition-all duration-150
                       hover:bg-emerald-700 active:scale-[0.97]
                       disabled:opacity-60 disabled:cursor-not-allowed"
              >
                <svg class="w-[13px] h-[13px] stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 17 4 12 9 7"/>
                  <path d="M20 18v-2a4 4 0 0 0-4-4H4"/>
                </svg>
                Balas
              </button>
            </div>
          </form>
        </div>
        @endif

        {{-- Viewer: form follow-up / klarifikasi lanjutan (biru) --}}
        @if(auth()->user()->role === 'viewer')
        <div class="reply-form-wrap mt-3 pl-9">
          {{-- Toggle button --}}
          <button type="button"
                  class="qa-toggle-reply inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-blue-500
                         hover:text-blue-700 transition-colors duration-150"
                  aria-expanded="false">
            <svg class="w-3.5 h-3.5 stroke-current fill-none transition-transform duration-200" viewBox="0 0 24 24"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Balas / Klarifikasi
          </button>
          {{-- Collapsible form --}}
          <div class="qa-reply-collapse hidden mt-2">
            <form action="{{ route('questions.reply', $question->id) }}" method="POST"
                  class="qa-reply-form" data-reply-role="viewer">
              @csrf
              <textarea
                name="isi"
                placeholder="Tulis balasan atau klarifikasi tambahan..."
                required
                rows="2"
                class="w-full p-2.5 rounded-xl border border-blue-200 bg-blue-50 text-[13px] text-slate-900
                       font-[inherit] outline-none resize-none transition-all duration-150 placeholder:text-slate-400
                       focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)]"
              ></textarea>
              <div class="flex items-center justify-between mt-2 gap-3">
                <div class="qa-form-feedback flex-1 text-[12px]"></div>
                <div class="flex items-center gap-2">
                  <button type="button"
                          class="qa-cancel-reply text-[12px] text-slate-400 hover:text-slate-600 font-medium transition-colors duration-150">
                    Batal
                  </button>
                  <button
                    type="submit"
                    data-label="Kirim"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-[12px] font-semibold
                           border-none cursor-pointer font-[inherit] transition-all duration-150
                           hover:bg-blue-700 active:scale-[0.97]
                           disabled:opacity-60 disabled:cursor-not-allowed"
                  >
                    <svg class="w-[13px] h-[13px] stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="22" y1="2" x2="11" y2="13"/>
                      <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Kirim
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        @endif

      </div>
      @empty
      <div class="empty-qa flex flex-col items-center justify-center py-12 text-center">
        <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
          <svg class="w-7 h-7 stroke-slate-300 fill-none" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
          </svg>
        </div>
        <div class="text-[13.5px] font-semibold text-slate-500">Belum ada pertanyaan</div>
        <div class="text-[12px] text-slate-400 mt-0.5">Jadilah yang pertama bertanya!</div>
      </div>
      @endforelse

    </div>
  </div>
</div>

{{-- ── Toast Container (dikelola sepenuhnya oleh qa.js) ── --}}
<div id="qa-toast-root"
     class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-2.5 items-end pointer-events-none
            max-sm:bottom-4 max-sm:right-3 max-sm:left-3 max-sm:items-stretch">
</div>

</x-app-layout>