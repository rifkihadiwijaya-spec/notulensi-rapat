<x-app-layout>

{{-- Top Bar --}}
<div class="flex items-start justify-between gap-4 mb-5 flex-wrap max-sm:flex-col max-sm:gap-2.5 max-sm:mb-4">
  <div>
    <div class="text-[22px] font-extrabold text-slate-900 tracking-[-0.02em] leading-tight max-sm:text-[17px]">Buat Rapat Baru</div>
    <div class="text-[13px] text-slate-400 mt-0.5 max-sm:text-[12px]">Isi detail rapat yang akan dijadwalkan</div>
  </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="flex items-start gap-3 px-4 py-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-[13px] mb-4">
  <svg class="w-4 h-4 stroke-current fill-none flex-shrink-0 mt-px" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
  </svg>
  <div>
    <strong class="font-bold">Terdapat kesalahan pada form:</strong>
    <ul class="mt-1 ml-4 list-disc">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif

{{-- Form Card --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-[0_1px_4px_rgba(10,22,40,0.07)] transition-shadow duration-200 hover:shadow-[0_4px_16px_rgba(10,22,40,0.10)]">
  <div class="px-[22px] py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50 gap-3 max-sm:px-3.5">
    <span class="flex items-center gap-2 text-[13px] font-bold text-slate-800">
      <svg class="w-4 h-4 stroke-blue-500 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      Detail Rapat
    </span>
  </div>

  <form action="{{ route('meetings.store') }}" method="POST" enctype="multipart/form-data" id="form-create">
    @csrf
    <div class="p-[22px_24px] max-sm:p-4">
      <div class="grid grid-cols-2 gap-[18px] items-start max-sm:grid-cols-1 max-sm:gap-3.5">

        {{-- Judul --}}
        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block max-sm:text-[10.5px]">
            Judul Rapat <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-[11px] top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
            </span>
            <input type="text" name="judul"
                   class="w-full min-w-0 pl-9 pr-3 py-[9px] border rounded-lg text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150 text-ellipsis overflow-hidden whitespace-nowrap
                          {{ $errors->has('judul') ? 'border-red-300 bg-red-50 shadow-[0_0_0_3px_rgba(239,68,68,0.06)]' : 'border-slate-200' }}
                          focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:py-2.5 max-sm:min-h-[44px]"
                   placeholder="Contoh: Rapat Koordinasi Bulanan Dinas"
                   value="{{ old('judul') }}" required>
          </div>
          @error('judul') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Tanggal --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Tanggal <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-[11px] top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            </span>
            <input type="date" name="tanggal"
                   class="w-full min-w-0 pl-9 pr-3 py-[9px] border rounded-lg text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150
                          {{ $errors->has('tanggal') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}
                          focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:py-2.5 max-sm:min-h-[44px]"
                   value="{{ old('tanggal') }}" required>
          </div>
          @error('tanggal') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Waktu --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Waktu <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-[11px] top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
              </svg>
            </span>
            <input type="time" name="waktu"
                   class="w-full min-w-0 pl-9 pr-3 py-[9px] border rounded-lg text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150
                          {{ $errors->has('waktu') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}
                          focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:py-2.5 max-sm:min-h-[44px]"
                   value="{{ old('waktu') }}" required>
          </div>
          @error('waktu') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Lokasi --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Lokasi <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-[11px] top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none flex items-center z-[1]">
              <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
            </span>
            <input type="text" name="lokasi"
                   class="w-full min-w-0 pl-9 pr-3 py-[9px] border rounded-lg text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150 text-ellipsis overflow-hidden whitespace-nowrap
                          {{ $errors->has('lokasi') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}
                          focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:py-2.5 max-sm:min-h-[44px]"
                   placeholder="Contoh: Ruang Rapat Lantai 3"
                   value="{{ old('lokasi') }}" required>
          </div>
          @error('lokasi') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Jenis Rapat --}}
        <div class="flex flex-col gap-1.5 min-w-0">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Jenis Rapat <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <select name="jenis"
                  class="w-full min-w-0 appearance-none px-3 py-[9px] border rounded-lg text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150 cursor-pointer whitespace-nowrap overflow-hidden text-ellipsis pr-9
                         bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%2264748b%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]
                         {{ $errors->has('jenis') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}
                         focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:py-2.5 max-sm:min-h-[44px]"
                  required>
            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih jenis rapat...</option>
            <option value="Internal DISKOMINFO"  {{ old('jenis') === 'Internal DISKOMINFO'  ? 'selected' : '' }}>Internal DISKOMINFO</option>
            <option value="Eksternal DISKOMINFO" {{ old('jenis') === 'Eksternal DISKOMINFO' ? 'selected' : '' }}>Eksternal DISKOMINFO</option>
          </select>
          @error('jenis') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Section: Konten Rapat --}}
        <div class="col-span-2 max-sm:col-span-1 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-400 pt-2.5 border-t border-slate-100 mt-1">
          Konten Rapat
          <span class="flex-1 h-px bg-slate-100"></span>
        </div>

        {{-- Topik --}}
        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Topik / Agenda <span class="text-orange-500 ml-0.5">*</span>
          </label>
          <textarea name="topik"
                    class="w-full min-w-0 box-border border rounded-lg p-[9px_12px] text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none resize-y min-h-[96px] leading-[1.65] transition-all duration-150
                           {{ $errors->has('topik') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}
                           focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] max-sm:text-[14px] max-sm:min-h-[100px] max-sm:p-2.5"
                    placeholder="Uraikan topik atau agenda yang akan dibahas dalam rapat..."
                    required>{{ old('topik') }}</textarea>
          @error('topik') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
        </div>

        {{-- Section: Partisipan --}}
        <div class="col-span-2 max-sm:col-span-1 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-400 pt-2.5 border-t border-slate-100 mt-1">
          Daftar Partisipan
          <span class="flex-1 h-px bg-slate-100"></span>
        </div>

        {{-- Partisipan Dinamis --}}
        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <input type="hidden" name="partisipan" id="partisipan-json">

          <div class="rounded-xl border border-slate-200 overflow-hidden overflow-x-auto -webkit-overflow-scrolling-touch">
            <table class="w-full border-collapse text-[13px] min-w-[820px]" id="partisipan-table">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-9">#</th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                      Nama
                    </div>
                  </th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-[175px]">
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 stroke-slate-400 fill-none flex-shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
                      Peran
                    </div>
                  </th>
                  <th class="px-3 py-2.5 text-left text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400 w-[175px]">
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
                  <th class="px-3 py-2.5 w-11"></th>
                </tr>
              </thead>
              <tbody id="partisipan-tbody"></tbody>
            </table>

            <div class="flex items-center justify-between px-4 py-3 border-t border-slate-100 bg-slate-50">
              <button type="button" id="btn-add-row"
                      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-[12.5px] font-semibold cursor-pointer
                             bg-blue-50 text-blue-700 border border-blue-200 transition-all duration-150 font-[inherit]
                             hover:bg-blue-600 hover:text-white hover:border-blue-600">
                <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Peserta
              </button>
              <span class="text-[12px] text-slate-400" id="partisipan-count">0 peserta</span>
            </div>
          </div>

          @error('partisipan') <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span> @enderror
          <span class="text-[11px] text-slate-400 mt-0.5 leading-[1.5]">Isi nama, jabatan, dan bidang/unit kerja setiap peserta. Baris kosong akan diabaikan.</span>
        </div>

        {{-- Section: Surat Undangan --}}
        <div class="col-span-2 max-sm:col-span-1 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-400 pt-2.5 border-t border-slate-100 mt-1">
          Surat Undangan
          <span class="flex-1 h-px bg-slate-100"></span>
        </div>

        <div class="flex flex-col gap-1.5 min-w-0 col-span-2 max-sm:col-span-1">
          <label class="text-[11px] font-bold uppercase tracking-[0.06em] text-slate-600 block">
            Upload Surat Undangan
            <span class="text-slate-400 font-normal normal-case tracking-normal ml-1">(PDF, maks. 5 MB — opsional)</span>
          </label>
          <label id="surat-dropzone"
                 class="relative flex flex-col items-center justify-center gap-2 border-2 border-dashed rounded-xl px-5 py-7 cursor-pointer transition-all duration-200
                        {{ $errors->has('surat_undangan') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-slate-50 hover:border-blue-400 hover:bg-blue-50/40' }}">
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
                      class="mt-1 inline-flex items-center gap-1 text-[11.5px] font-semibold text-red-500 hover:text-red-700 bg-transparent border-none cursor-pointer font-[inherit]">
                <svg class="w-3 h-3 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                Hapus pilihan
              </button>
            </div>
          </label>
          @error('surat_undangan')
            <span class="text-[11.5px] text-red-600 mt-0.5">{{ $message }}</span>
          @enderror
        </div>

      </div>
    </div>

    {{-- Footer --}}
    <div class="flex items-center justify-end gap-2.5 px-6 py-4 border-t border-slate-100 bg-slate-50
                max-sm:flex-col-reverse max-sm:gap-2 max-sm:px-3.5">
      <a href="{{ route('meetings.index') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-[13px] font-semibold no-underline
                bg-white border border-slate-200 text-slate-600 transition-all duration-150
                hover:bg-slate-50 hover:border-slate-300
                max-sm:w-full max-sm:justify-center max-sm:py-[11px] max-sm:text-[13.5px]">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Batal
      </a>
      <button type="submit"
              class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-[13px] font-semibold cursor-pointer font-[inherit]
                     bg-blue-600 text-white border-none shadow-[0_4px_14px_rgba(37,99,235,0.25)] transition-all duration-150
                     hover:bg-blue-700 hover:shadow-[0_6px_18px_rgba(37,99,235,0.3)]
                     max-sm:w-full max-sm:justify-center max-sm:py-[11px] max-sm:text-[13.5px]">
        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
          <polyline points="17 21 17 13 7 13 7 21"/>
          <polyline points="7 3 7 8 15 8"/>
        </svg>
        Simpan Rapat
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
// ── Surat Undangan Dropzone ───────────────────────────────────
(function() {
  const input    = document.getElementById('surat-input');
  const dropzone = document.getElementById('surat-dropzone');
  const iconDef  = document.getElementById('surat-icon-default');
  const preview  = document.getElementById('surat-preview');
  const filename = document.getElementById('surat-filename');
  const filesize = document.getElementById('surat-filesize');
  const clearBtn = document.getElementById('surat-clear');

  function fmt(b) { return b < 1048576 ? (b/1024).toFixed(1)+' KB' : (b/1048576).toFixed(1)+' MB'; }

  function showPreview(file) {
    filename.textContent = file.name;
    filesize.textContent = fmt(file.size);
    iconDef.classList.add('hidden'); iconDef.classList.remove('flex');
    preview.classList.remove('hidden'); preview.classList.add('flex');
    dropzone.classList.add('border-green-300','bg-green-50/40');
    dropzone.classList.remove('border-slate-200','bg-slate-50','hover:border-blue-400','hover:bg-blue-50/40');
  }

  function clearPreview() {
    input.value = '';
    preview.classList.add('hidden'); preview.classList.remove('flex');
    iconDef.classList.remove('hidden'); iconDef.classList.add('flex');
    dropzone.classList.remove('border-green-300','bg-green-50/40');
    dropzone.classList.add('border-slate-200','bg-slate-50','hover:border-blue-400','hover:bg-blue-50/40');
  }

  input.addEventListener('change', function() {
    if (this.files[0]) showPreview(this.files[0]);
  });
  clearBtn.addEventListener('click', function(e) {
    e.preventDefault(); e.stopPropagation(); clearPreview();
  });
  ['dragenter','dragover'].forEach(e => dropzone.addEventListener(e, ev => {
    ev.preventDefault(); dropzone.classList.add('border-blue-400','bg-blue-50/40');
  }));
  ['dragleave','dragend'].forEach(e => dropzone.addEventListener(e, () =>
    dropzone.classList.remove('border-blue-400','bg-blue-50/40')
  ));
  dropzone.addEventListener('drop', function(e) {
    e.preventDefault(); dropzone.classList.remove('border-blue-400','bg-blue-50/40');
    const file = e.dataTransfer.files[0];
    if (file && file.type === 'application/pdf') {
      const dt = new DataTransfer(); dt.items.add(file);
      input.files = dt.files; showPreview(file);
    }
  });
})();

// ── Partisipan ────────────────────────────────────────────────
const ROLES = ['Pimpinan Rapat','Sekretaris / Notulis','Narasumber','Peserta','Undangan'];
const tbody   = document.getElementById('partisipan-tbody');
const jsonIn  = document.getElementById('partisipan-json');
const countEl = document.getElementById('partisipan-count');

const INPUT_CLS = 'w-full min-w-0 border border-slate-200 rounded-lg px-3 py-[8px] text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150 focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)]';
const SELECT_CLS = 'w-full min-w-0 appearance-none border border-slate-200 rounded-lg px-3 py-[8px] pr-8 text-[13px] bg-slate-50 text-slate-900 font-[inherit] outline-none transition-all duration-150 cursor-pointer focus:border-blue-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(59,130,246,0.12)] bg-[url(\'data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%2264748b%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%2F%3E%3C%2Fsvg%3E\')] bg-no-repeat bg-[right_8px_center]';

let initialRows = [];
try {
  const old = @json(old('partisipan'));
  if (old) initialRows = JSON.parse(old);
} catch(e) {}

if (!initialRows.length) {
  initialRows = [
    { nama: '', peran: 'Pimpinan Rapat', jabatan: '', bidang: '' },
    { nama: '', peran: 'Sekretaris / Notulis', jabatan: '', bidang: '' },
    { nama: '', peran: 'Peserta', jabatan: '', bidang: '' },
  ];
}

function buildRoleOptions(selected) {
  const isOther = selected && !ROLES.includes(selected);
  return ROLES.map(r =>
    `<option value="${r}" ${r === selected ? 'selected' : ''}>${r}</option>`
  ).join('') +
  `<option value="Lainnya" ${isOther ? 'selected' : ''}>Lainnya…</option>`;
}

function addRow(data = { nama: '', peran: 'Peserta', jabatan: '', bidang: '' }) {
  const tr = document.createElement('tr');
  tr.className = 'partisipan-row border-b border-slate-100 last:border-b-0 transition-all duration-150 hover:bg-slate-50/50';

  const isOther = data.peran && !ROLES.includes(data.peran);

  tr.innerHTML = `
    <td class="px-3 py-2.5 text-slate-400 font-medium text-[12px] td-num align-top pt-[13px]"></td>
    <td class="px-3 py-2 align-top">
      <input type="text" class="p-nama ${INPUT_CLS}" placeholder="Nama peserta…" value="${escHtml(data.nama || '')}">
    </td>
    <td class="px-3 py-2 align-top">
      <div class="flex flex-col gap-1">
        <select class="p-peran ${SELECT_CLS}">
          ${buildRoleOptions(isOther ? 'Lainnya' : (data.peran || 'Peserta'))}
        </select>
        <input type="text" class="p-peran-custom ${INPUT_CLS}"
          placeholder="Tulis peran…"
          value="${isOther ? escHtml(data.peran) : ''}"
          style="display:${isOther ? 'block' : 'none'};">
      </div>
    </td>
    <td class="px-3 py-2 align-top">
      <input type="text" class="p-jabatan ${INPUT_CLS}" placeholder="cth: Fungsional Muda" value="${escHtml(data.jabatan || '')}">
    </td>
    <td class="px-3 py-2 align-top">
      <input type="text" class="p-bidang ${INPUT_CLS}" placeholder="cth: Statistik / DISKOMINFO" value="${escHtml(data.bidang || '')}">
    </td>
    <td class="px-3 py-2 align-top pt-[10px]">
      <button type="button" class="partisipan-del-btn w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 border border-transparent transition-all duration-150 hover:bg-red-50 hover:text-red-500 hover:border-red-200 cursor-pointer bg-transparent font-[inherit]" title="Hapus baris">
        <svg class="w-[13px] h-[13px] stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </td>`;

  tr.querySelector('.p-peran').addEventListener('change', function() {
    const custom = tr.querySelector('.p-peran-custom');
    if (this.value === 'Lainnya') {
      custom.style.display = 'block'; custom.focus();
    } else {
      custom.style.display = 'none'; custom.value = '';
    }
    syncJson();
  });

  tr.querySelector('.partisipan-del-btn').addEventListener('click', function() {
    if (tbody.querySelectorAll('.partisipan-row').length <= 1) return;
    tr.style.opacity = '0';
    tr.style.transform = 'translateX(12px)';
    tr.style.transition = 'opacity .18s ease, transform .18s ease';
    setTimeout(() => { tr.remove(); syncJson(); renumber(); }, 180);
  });

  tr.querySelectorAll('input, select').forEach(el => el.addEventListener('input', syncJson));
  tbody.appendChild(tr);
  renumber();
  syncJson();
}

function renumber() {
  tbody.querySelectorAll('.partisipan-row').forEach((tr, i) => {
    tr.querySelector('.td-num').textContent = i + 1;
  });
}

function syncJson() {
  const rows = [];
  tbody.querySelectorAll('.partisipan-row').forEach(tr => {
    const nama    = tr.querySelector('.p-nama').value.trim();
    const sel     = tr.querySelector('.p-peran').value;
    const peran   = sel === 'Lainnya' ? tr.querySelector('.p-peran-custom').value.trim() : sel;
    const jabatan = tr.querySelector('.p-jabatan').value.trim();
    const bidang  = tr.querySelector('.p-bidang').value.trim();
    if (nama || peran || jabatan || bidang) rows.push({ nama, peran, jabatan, bidang });
  });
  jsonIn.value = JSON.stringify(rows);
  const total = rows.filter(r => r.nama).length;
  countEl.textContent = total + ' peserta';
}

function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

initialRows.forEach(r => addRow(r));
document.getElementById('btn-add-row').addEventListener('click', () => addRow());
document.getElementById('form-create').addEventListener('submit', syncJson);
</script>
@endpush

</x-app-layout>