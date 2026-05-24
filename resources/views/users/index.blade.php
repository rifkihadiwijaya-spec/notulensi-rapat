<x-app-layout>

{{-- ══ PAGE HEADER ══ --}}
<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Kelola User</h1>
        <p class="text-sm text-slate-500 mt-0.5">Daftar seluruh pengguna yang terdaftar</p>
    </div>
    <a href="{{ route('users.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
              text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200
              transition-all duration-150 w-fit">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Tambah User
    </a>
</div>

{{-- Flash Success --}}
@if(session('success'))
    <div id="flashSuccess"
         class="flex items-center gap-2.5 px-4 py-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium rounded-xl">
        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ══ TOOLBAR ══ --}}
<div class="flex flex-col gap-3 sm:flex-row sm:items-center mb-4">
    {{-- Search --}}
    <div class="relative flex-1 min-w-0">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="searchInput"
               class="w-full pl-9 pr-9 py-2.5 text-sm bg-white border border-slate-200 rounded-xl
                      placeholder:text-slate-400 text-slate-800 focus:outline-none focus:ring-2
                      focus:ring-blue-500 focus:border-transparent transition"
               placeholder="Cari nama atau username..." autocomplete="off">
        <button id="searchClear" type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600
                       text-xs hidden transition">✕</button>
    </div>

    {{-- Role Filter Chips --}}
    <div class="flex items-center gap-1.5 flex-wrap">
        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-1 hidden sm:inline">Role</span>
        <button type="button" class="chip px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all active"
                data-filter="role" data-value="">Semua</button>
        <button type="button" class="chip px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all chip-admin"
                data-filter="role" data-value="admin">Admin</button>
        <button type="button" class="chip px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all chip-notulis"
                data-filter="role" data-value="notulis">Notulis</button>
        <button type="button" class="chip px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all chip-viewer"
                data-filter="role" data-value="viewer">Viewer</button>
    </div>
</div>

{{-- Result info --}}
<div class="flex items-center justify-between mb-3 min-h-[20px]">
    <span id="resultCount" class="text-xs text-slate-500"></span>
    <button type="button" id="resetAll"
            class="hidden items-center gap-1 text-xs text-slate-500 hover:text-red-500 transition font-medium">
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
        Reset filter
    </button>
</div>

{{-- ══ TABLE CARD ══ --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/70">
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5 w-12">#</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Pengguna</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5 hidden sm:table-cell">Username</th>
                    <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Role</th>
                    <th class="text-right text-xs font-semibold text-slate-500 uppercase tracking-wider px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTbody" class="divide-y divide-slate-100">
                @forelse($users as $i => $user)
                    <tr data-role="{{ $user->role }}"
                        data-search="{{ strtolower($user->name . ' ' . ($user->username ?? '')) }}"
                        class="row-visible hover:bg-slate-50/60 transition-colors duration-100"
                        style="animation-delay: {{ $i * 0.035 }}s">

                        <td class="px-5 py-4 text-slate-400 font-medium text-xs">{{ $i + 1 }}</td>

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Avatar --}}
                                @php
                                    $avatarClasses = match($user->role) {
                                        'admin'   => 'bg-blue-100 text-blue-700',
                                        'notulis' => 'bg-orange-100 text-orange-700',
                                        default   => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <div class="w-9 h-9 rounded-xl {{ $avatarClasses }} flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 leading-tight">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Bergabung {{ $user->created_at->translatedFormat('d M Y') }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-4 hidden sm:table-cell">
                            <span class="font-mono text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">
                                {{ $user->username ?? '-' }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold rounded-lg">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Admin
                                </span>
                            @elseif($user->role === 'notulis')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-orange-50 text-orange-700 border border-orange-200 text-xs font-semibold rounded-lg">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Notulis
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-xs font-semibold rounded-lg">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Viewer
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                                          text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200
                                          rounded-lg transition-colors">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                                                   text-red-600 bg-red-50 hover:bg-red-100 border border-red-200
                                                   rounded-lg transition-colors btn-delete"
                                            data-name="{{ $user->name }}">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-600 text-sm">Belum ada user</p>
                                    <p class="text-xs mt-0.5">Tambahkan user pertama dengan klik tombol di atas</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- No Result Block --}}
    <div id="noResult" class="hidden py-16 text-center">
        <div class="flex flex-col items-center gap-3 text-slate-400">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-600 text-sm">Tidak ditemukan</p>
                <p id="noResultSub" class="text-xs mt-0.5">Coba ubah kata kunci atau filter</p>
            </div>
        </div>
    </div>
</div>

{{-- ══ DELETE MODAL ══ --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 scale-95 opacity-0 transition-all duration-200" id="modalBox">
        <div class="flex flex-col items-center text-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Hapus Pengguna</h3>
                <p class="text-sm text-slate-500 mt-1.5">
                    Apakah Anda yakin ingin menghapus <strong id="deleteTargetName" class="text-slate-800 font-semibold"></strong>?
                </p>
                <p class="text-xs text-slate-400 mt-1">Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="flex gap-3 w-full mt-1">
                <button type="button" id="modalCancel"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100
                               hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="button" id="modalConfirm"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600
                               hover:bg-red-700 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    </svg>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══ CHIP STYLES (minimal inline) ══ --}}
<style>
    .chip { background: #f8fafc; border-color: #e2e8f0; color: #64748b; }
    .chip:hover { background: #f1f5f9; }
    .chip.active { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .chip-admin.active { background: #eff6ff; border-color: #93c5fd; color: #1d4ed8; }
    .chip-notulis.active { background: #fff7ed; border-color: #fed7aa; color: #c2410c; }
    .chip-viewer.active { background: #f1f5f9; border-color: #cbd5e1; color: #475569; }
</style>

<script>
    // ── Search & Filter ──
    const searchInput  = document.getElementById('searchInput');
    const searchClear  = document.getElementById('searchClear');
    const resultCount  = document.getElementById('resultCount');
    const resetAll     = document.getElementById('resetAll');
    const noResult     = document.getElementById('noResult');
    const tbody        = document.getElementById('userTbody');
    const allChips     = document.querySelectorAll('.chip[data-filter]');

    let activeRole = '';
    let searchVal  = '';

    function updateRows() {
        const rows = tbody.querySelectorAll('tr[data-role]');
        let visible = 0;
        rows.forEach(row => {
            const roleMatch   = !activeRole || row.dataset.role === activeRole;
            const searchMatch = !searchVal  || row.dataset.search.includes(searchVal);
            const show = roleMatch && searchMatch;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        resultCount.textContent = visible + ' pengguna';
        noResult.classList.toggle('hidden', visible > 0);
        resetAll.classList.toggle('hidden', !activeRole && !searchVal);
        resetAll.classList.toggle('flex', !!(activeRole || searchVal));
    }

    searchInput.addEventListener('input', () => {
        searchVal = searchInput.value.toLowerCase().trim();
        searchClear.classList.toggle('hidden', !searchVal);
        updateRows();
    });
    searchClear.addEventListener('click', () => {
        searchInput.value = ''; searchVal = '';
        searchClear.classList.add('hidden');
        updateRows();
    });

    allChips.forEach(chip => {
        chip.addEventListener('click', () => {
            allChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeRole = chip.dataset.value;
            updateRows();
        });
    });

    resetAll.addEventListener('click', () => {
        searchInput.value = ''; searchVal = ''; activeRole = '';
        searchClear.classList.add('hidden');
        allChips.forEach(c => c.classList.remove('active'));
        document.querySelector('.chip[data-value=""]').classList.add('active');
        updateRows();
    });

    // ── Delete Modal ──
    const modal       = document.getElementById('deleteModal');
    const modalBox    = document.getElementById('modalBox');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm= document.getElementById('modalConfirm');
    let pendingForm   = null;

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('deleteTargetName').textContent = btn.dataset.name;
            pendingForm = btn.closest('form');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => {
                modalBox.classList.remove('scale-95', 'opacity-0');
                modalBox.classList.add('scale-100', 'opacity-100');
            });
        });
    });

    function closeModal() {
        modalBox.classList.remove('scale-100', 'opacity-100');
        modalBox.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 200);
    }

    modalCancel.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    modalConfirm.addEventListener('click', () => { if (pendingForm) pendingForm.submit(); });

    // ── Init ──
    updateRows();

    // Auto-hide flash
    const flash = document.getElementById('flashSuccess');
    if (flash) setTimeout(() => { flash.style.opacity = '0'; flash.style.transition = 'opacity .4s'; setTimeout(() => flash.remove(), 400); }, 4000);
</script>

</x-app-layout>