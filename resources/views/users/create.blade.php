<x-app-layout>

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah User Baru</h1>
            <p class="text-sm text-slate-500 mt-0.5">Isi data pengguna yang akan didaftarkan</p>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="flex gap-3 px-4 py-3.5 mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
            <svg class="w-4 h-4 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <p class="font-bold mb-1">Terdapat kesalahan pada form:</p>
                <ul class="list-disc list-inside space-y-0.5 text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- ── Card: Data Pengguna ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Card Header --}}
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-700">Data Pengguna</span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Nama Lengkap (full width) --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <input type="text" name="name"
                               class="w-full pl-9 pr-4 py-2.5 text-sm border rounded-xl transition
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                               placeholder="Contoh: Budi Santoso"
                               value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-semibold text-sm">@</span>
                        <input type="text" name="username"
                               class="w-full pl-8 pr-4 py-2.5 text-sm border rounded-xl transition
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                               placeholder="budi.santoso"
                               value="{{ old('username') }}" required>
                    </div>
                    @error('username')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role"
                            class="w-full px-3 py-2.5 text-sm border rounded-xl transition bg-white appearance-none
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   {{ $errors->has('role') ? 'border-red-400 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}"
                            required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role...</option>
                        <option value="viewer"  {{ old('role') === 'viewer'  ? 'selected' : '' }}>Viewer</option>
                        <option value="notulis" {{ old('role') === 'notulis' ? 'selected' : '' }}>Notulis</option>
                        <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── Card: Keamanan Akun ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                <div class="w-7 h-7 rounded-lg bg-orange-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-700">Keamanan Akun</span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                        </span>
                        <input type="password" name="password"
                               class="w-full pl-9 pr-4 py-2.5 text-sm border rounded-xl transition
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                               placeholder="Minimal 8 karakter" required>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                        </span>
                        <input type="password" name="password_confirmation"
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 bg-white hover:border-slate-300 rounded-xl transition
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Ulangi password" required>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Footer Actions ── --}}
        <div class="flex items-center justify-end gap-3 pt-1">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-600
                      bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white
                           bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl transition-colors
                           shadow-sm shadow-blue-200">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan User
            </button>
        </div>

    </form>

</x-app-layout>