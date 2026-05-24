/**
 * pages/edit.js
 * Semua JS yang sebelumnya ada di @push('scripts') dalam edit.blade.php.
 * Dipindah ke sini agar blade bersih dari inline script.
 *
 * Dijalankan otomatis oleh app.js saat DOMContentLoaded.
 * Auto-skip jika elemen #form-edit tidak ada di halaman.
 */

export function initEdit() {
    if (!document.getElementById('form-edit')) return;

    // TinyMCE di-load via @push di blade, tunggu sampai tersedia
    if (typeof tinymce !== 'undefined') {
        initTinyMCE();
    }

    initSuratDropzone();
    initPartisipan();
    initHapusSurat();
    initHapusFoto();
    initFormSubmit();
}

/* ─── Surat Undangan Dropzone ────────────────────────────── */
function initSuratDropzone() {
    const input    = document.getElementById('surat-input');
    const dropzone = document.getElementById('surat-dropzone');
    const iconDef  = document.getElementById('surat-icon-default');
    const preview  = document.getElementById('surat-preview');
    const filename = document.getElementById('surat-filename');
    const filesize = document.getElementById('surat-filesize');
    const clearBtn = document.getElementById('surat-clear');

    if (!dropzone) return;

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
}

/* ─── Hapus Surat ────────────────────────────────────────── */
function initHapusSurat() {
    const modal    = document.getElementById('modal-hapus-surat');
    const btnBatal = document.getElementById('modal-surat-batal');
    const btnKonfirm = document.getElementById('modal-surat-konfirm');

    if (!modal) return;

    window.hapusSurat = function() {
        modal.classList.remove('hidden');
    };

    if (btnBatal) btnBatal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    if (btnKonfirm) btnKonfirm.addEventListener('click', function() {
        document.getElementById('form-hapus-surat').submit();
    });
}

/* ─── Hapus Foto ─────────────────────────────────────────── */
function initHapusFoto() {
    const modal      = document.getElementById('modal-hapus-foto');
    const modalNama  = document.getElementById('modal-foto-nama');
    const btnBatal   = document.getElementById('modal-foto-batal');
    const btnKonfirm = document.getElementById('modal-foto-konfirm');

    if (!modal) return;

    let pendingId = null;

    window.hapusFoto = function(dokId, namaFile) {
        pendingId = dokId;
        if (modalNama) modalNama.textContent = namaFile;
        modal.style.display = 'flex';
        requestAnimationFrame(() => modal.classList.add('modal-open'));
    };

    function tutup() {
        modal.classList.remove('modal-open');
        setTimeout(() => {
            modal.style.display = 'none';
            pendingId = null;
            if (btnKonfirm) {
                btnKonfirm.disabled = false;
                btnKonfirm.innerHTML = `
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg> Ya, Hapus`;
            }
        }, 200);
    }

    if (btnBatal) btnBatal.addEventListener('click', tutup);
    modal.addEventListener('click', e => { if (e.target === modal) tutup(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && pendingId) tutup(); });

    if (btnKonfirm) {
        btnKonfirm.addEventListener('click', function() {
            if (!pendingId) return;
            this.disabled  = true;
            this.innerHTML = `
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="animation:spin 1s linear infinite">
                    <polyline points="23 4 23 10 17 10"/>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                </svg> Menghapus...`;
            document.getElementById('hapus-dok-id').value = pendingId;
            document.getElementById('form-hapus-foto').submit();
        });
    }
}

/* ─── TinyMCE ─────────────────────────────────────────────── */
function initTinyMCE() {
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
}

/* ─── Partisipan dinamis ──────────────────────────────────── */
function initPartisipan() {
    const ROLES = ['Pimpinan Rapat','Sekretaris / Notulis','Narasumber','Peserta','Undangan'];

    const tbody   = document.getElementById('partisipan-tbody');
    const jsonIn  = document.getElementById('partisipan-json');
    const countEl = document.getElementById('partisipan-count');

    if (!tbody || !jsonIn) return;

    /* Baca & normalisasi data dari hidden field yang sudah di-set Blade.
     * Menangani dua format sekaligus:
     *   - Format lama : { nama, peran }
     *   - Format baru : { nama, peran, jabatan, bidang }
     * Sekaligus deduplikasi jika ada nama yang muncul ganda akibat migrasi. */
    let initialRows = [];
    try {
        const raw = jsonIn.value.trim();
        if (raw) {
            const parsed = JSON.parse(raw);
            if (Array.isArray(parsed)) {
                // Buat map: key = nama lowercase → ambil versi paling lengkap
                const map = new Map();
                parsed.forEach(r => {
                    const key = (r.nama || '').trim().toLowerCase();
                    const existing = map.get(key);
                    const hasDetail = !!(r.jabatan || r.bidang);
                    const existingHasDetail = existing && !!(existing.jabatan || existing.bidang);
                    if (!existing || (hasDetail && !existingHasDetail)) {
                        map.set(key, {
                            nama    : r.nama    || '',
                            peran   : r.peran   || '',
                            jabatan : r.jabatan || '',
                            bidang  : r.bidang  || '',
                        });
                    }
                });
                // Pertahankan urutan kemunculan pertama, deduplikasi
                const seen = new Set();
                initialRows = parsed
                    .filter(r => {
                        const key = (r.nama || '').trim().toLowerCase();
                        if (seen.has(key)) return false;
                        seen.add(key);
                        return true;
                    })
                    .map(r => map.get((r.nama || '').trim().toLowerCase()));
            }
        }
    } catch(e) {
        console.warn('Partisipan parse error:', e);
    }

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

        const INPUT_CLS = 'w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-[13px] text-slate-800 font-[inherit] placeholder:text-slate-300 outline-none transition-all duration-150 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 hover:border-slate-300';
        const SELECT_CLS = `w-full px-3 py-2 pr-8 rounded-xl border border-slate-200 bg-white text-[13px] text-slate-700 font-[inherit] outline-none cursor-pointer transition-all duration-150 appearance-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 hover:border-slate-300 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%2294a3b8%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_10px_center]`;

        row.innerHTML = `
            <div class="td-num w-7 flex-shrink-0 text-[12px] font-bold text-slate-300 select-none pt-2.5 text-center"></div>

            <div class="flex-1 min-w-0">
                <input type="text" class="p-nama ${INPUT_CLS}"
                       placeholder="Nama peserta…" value="${escHtml(data.nama)}">
            </div>

            <div class="w-44 flex-shrink-0 flex flex-col gap-1">
                <select class="p-peran ${SELECT_CLS}">
                    ${buildRoleOptions(isOther ? 'Lainnya' : (data.peran || 'Peserta'))}
                </select>
                <input type="text" class="p-peran-custom ${INPUT_CLS} ${isOther ? '' : 'hidden'}"
                       placeholder="Tulis peran…" value="${isOther ? escHtml(data.peran) : ''}">
            </div>

            <div class="w-40 flex-shrink-0">
                <input type="text" class="p-jabatan ${INPUT_CLS}"
                       placeholder="cth: Fungsional Muda" value="${escHtml(data.jabatan)}">
            </div>

            <div class="w-48 flex-shrink-0">
                <input type="text" class="p-bidang ${INPUT_CLS}"
                       placeholder="cth: Statistik / DISKOMINFO" value="${escHtml(data.bidang)}">
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
}

/* ─── Submit handler ─────────────────────────────────────── */
function initFormSubmit() {
    const form = document.getElementById('form-edit');
    if (!form) return;

    form.addEventListener('submit', function() {
        if (typeof tinymce !== 'undefined') tinymce.triggerSave();

        // syncJson sudah dipanggil live via event input,
        // tapi panggil sekali lagi saat submit untuk jaga-jaga
        const tbody  = document.getElementById('partisipan-tbody');
        const jsonIn = document.getElementById('partisipan-json');
        if (!tbody || !jsonIn) return;

        const ROLES = ['Pimpinan Rapat','Sekretaris / Notulis','Narasumber','Peserta','Undangan'];
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
    });
}