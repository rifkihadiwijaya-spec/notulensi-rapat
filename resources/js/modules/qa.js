/**
 * modules/qa.js
 * Q&A dinamis untuk halaman meetings/show.
 *
 * Fitur:
 *  - Kirim pertanyaan (viewer) tanpa reload → append langsung ke list
 *  - Kirim jawaban (notulis) tanpa reload → append ke reply-wrap
 *  - Kirim balasan/klarifikasi (viewer) langsung di thread pertanyaan
 *  - Toggle show/hide form balas viewer dengan tombol "Balas / Klarifikasi"
 *  - Loading state pada tombol submit
 *  - Toast notification (success / error) — pojok kanan bawah
 *  - Inline feedback ringan di bawah form
 *  - Auto-resize textarea saat mengetik
 *  - Animasi entrance untuk item baru
 *  - Counter pertanyaan di card-header ikut update
 *  - Shake animation pada field kosong
 */

export function initQA() {
    const qaSection = document.querySelector('.qa-section');
    if (!qaSection) return;

    // ── Auto-resize semua textarea Q&A ──────────────────────
    qaSection.querySelectorAll('textarea').forEach(ta => autoResize(ta));
    qaSection.addEventListener('input', e => {
        if (e.target.tagName === 'TEXTAREA') autoResize(e.target);
    });

    // ── Form pertanyaan (viewer) ─────────────────────────────
    const questionForm = qaSection.querySelector('.qa-question-form');
    if (questionForm) {
        questionForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            await submitQuestion(this);
        });
    }

    // ── Toggle "Balas / Klarifikasi" (viewer) — event delegation ─
    qaSection.addEventListener('click', function (e) {
        // Tombol toggle buka form
        if (e.target.closest('.qa-toggle-reply')) {
            const btn      = e.target.closest('.qa-toggle-reply');
            const wrap     = btn.closest('.reply-form-wrap');
            const collapse = wrap.querySelector('.qa-reply-collapse');
            const isOpen   = btn.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                collapseReplyForm(btn, collapse);
            } else {
                expandReplyForm(btn, collapse);
            }
            return;
        }

        // Tombol batal
        if (e.target.closest('.qa-cancel-reply')) {
            const wrap     = e.target.closest('.reply-form-wrap');
            const btn      = wrap.querySelector('.qa-toggle-reply');
            const collapse = wrap.querySelector('.qa-reply-collapse');
            collapseReplyForm(btn, collapse);
            return;
        }
    });

    // ── Form jawaban / balas (notulis & viewer) — event delegation ──
    qaSection.addEventListener('submit', async function (e) {
        if (!e.target.classList.contains('qa-reply-form')) return;
        e.preventDefault();
        await submitReply(e.target);
    });
}

// ─────────────────────────────────────────────────────────────
// TOGGLE HELPERS
// ─────────────────────────────────────────────────────────────
function expandReplyForm(btn, collapse) {
    collapse.classList.remove('hidden');
    btn.setAttribute('aria-expanded', 'true');
    // Rotate icon sedikit sebagai visual cue
    const icon = btn.querySelector('svg');
    if (icon) icon.style.transform = 'rotate(10deg)';
    // Fokus ke textarea
    const ta = collapse.querySelector('textarea');
    if (ta) { autoResize(ta); ta.focus(); }
}

function collapseReplyForm(btn, collapse) {
    collapse.classList.add('hidden');
    btn.setAttribute('aria-expanded', 'false');
    const icon = btn.querySelector('svg');
    if (icon) icon.style.transform = '';
    // Reset textarea
    const ta = collapse.querySelector('textarea');
    if (ta) { ta.value = ''; autoResize(ta); }
    // Clear feedback
    const fb = collapse.querySelector('.qa-form-feedback');
    if (fb) fb.innerHTML = '';
}

// ─────────────────────────────────────────────────────────────
// SUBMIT PERTANYAAN
// ─────────────────────────────────────────────────────────────
async function submitQuestion(form) {
    const textarea  = form.querySelector('textarea[name="isi"]');
    const submitBtn = form.querySelector('[type="submit"]');
    const isi       = textarea.value.trim();

    if (!isi) {
        shakeField(textarea);
        showToast('error', 'Pertanyaan tidak boleh kosong.');
        return;
    }

    setLoading(submitBtn, true, 'Mengirim...');
    clearFeedback(form);

    try {
        const res  = await fetchPost(form.action, { isi }, getCsrf(form));
        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Gagal mengirim pertanyaan.');

        // Hapus empty-state kalau ada
        document.querySelector('.empty-qa')?.remove();

        // Append kartu pertanyaan baru ke list
        const list = document.querySelector('.qa-list');
        const card = buildQuestionCard(data.question);
        list.appendChild(card);

        // Trigger entrance animation (frame setelah mount)
        requestAnimationFrame(() => {
            requestAnimationFrame(() => card.classList.add('qa-visible'));
        });

        // Update counter badge
        updateQuestionCounter(1);

        // Reset form
        textarea.value = '';
        autoResize(textarea);

        // ✅ Toast sukses
        showToast('success', 'Pertanyaan berhasil dikirim!');

    } catch (err) {
        // ❌ Toast error
        showToast('error', err.message);
    } finally {
        setLoading(submitBtn, false, buildLabel(sendIcon(), submitBtn.dataset.label || 'Kirim Pertanyaan'));
    }
}

// ─────────────────────────────────────────────────────────────
// SUBMIT JAWABAN / BALAS
// ─────────────────────────────────────────────────────────────
async function submitReply(form) {
    const textarea  = form.querySelector('textarea[name="isi"]');
    const submitBtn = form.querySelector('[type="submit"]');
    const isi       = textarea.value.trim();
    const role      = form.dataset.replyRole || 'viewer'; // 'notulis' | 'viewer'

    if (!isi) {
        shakeField(textarea);
        showToast('error', role === 'notulis' ? 'Jawaban tidak boleh kosong.' : 'Balasan tidak boleh kosong.');
        return;
    }

    setLoading(submitBtn, true, 'Mengirim...');
    clearFeedback(form);

    try {
        const res  = await fetchPost(form.action, { isi }, getCsrf(form));
        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Gagal mengirim.');

        // Cari atau buat reply-wrap
        const questionCard = form.closest('.question-card');
        let replyWrap = questionCard.querySelector('.reply-wrap');
        if (!replyWrap) {
            replyWrap = document.createElement('div');
            replyWrap.className = 'reply-wrap mt-3 pl-9 flex flex-col gap-2';
            const replyFormWrap = questionCard.querySelector('.reply-form-wrap');
            questionCard.insertBefore(replyWrap, replyFormWrap);
        }

        // Append reply baru dengan warna sesuai role
        const replyEl = buildReplyCard(data.reply, role);
        replyWrap.appendChild(replyEl);

        // Trigger animasi
        requestAnimationFrame(() => {
            requestAnimationFrame(() => replyEl.classList.add('reply-visible'));
        });

        // Reset form
        textarea.value = '';
        autoResize(textarea);

        // Kalau viewer: tutup form collapse setelah kirim
        if (role === 'viewer') {
            const wrap     = form.closest('.reply-form-wrap');
            const toggleBtn = wrap?.querySelector('.qa-toggle-reply');
            const collapse  = wrap?.querySelector('.qa-reply-collapse');
            if (toggleBtn && collapse) collapseReplyForm(toggleBtn, collapse);
        }

        // ✅ Toast sukses
        showToast('success', role === 'notulis' ? 'Jawaban berhasil dikirim!' : 'Balasan berhasil dikirim!');

    } catch (err) {
        // ❌ Toast error
        showToast('error', err.message);
    } finally {
        const defaultLabel = role === 'notulis' ? 'Balas' : 'Kirim';
        const icon         = role === 'notulis' ? replyIcon() : sendIconSm();
        setLoading(submitBtn, false, buildLabel(icon, submitBtn.dataset.label || defaultLabel));
    }
}

// ─────────────────────────────────────────────────────────────
// TOAST NOTIFICATION
// ─────────────────────────────────────────────────────────────
/**
 * Menampilkan toast di #qa-toast-root.
 * @param {'success'|'error'|'info'} type
 * @param {string} message
 * @param {number} duration  ms sebelum auto-dismiss (default 3500)
 */
function showToast(type, message, duration = 3500) {
    const root = document.getElementById('qa-toast-root');
    if (!root) return;

    const cfg = {
        success: {
            bg     : 'bg-green-600',
            border : 'border-green-700',
            icon   : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                      </svg>`,
        },
        error: {
            bg     : 'bg-red-600',
            border : 'border-red-700',
            icon   : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                      </svg>`,
        },
        info: {
            bg     : 'bg-blue-600',
            border : 'border-blue-700',
            icon   : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                      </svg>`,
        },
    };

    const { bg, border, icon } = cfg[type] || cfg.info;

    const toast = document.createElement('div');
    toast.className = [
        'pointer-events-auto flex items-center gap-3',
        'px-4 py-3 rounded-xl shadow-2xl border',
        'text-white text-[13px] font-semibold',
        bg, border,
        'min-w-[220px] max-w-[340px]',
        'translate-y-4 opacity-0',
        'transition-all duration-300 ease-out',
    ].join(' ');

    const progressBar = document.createElement('div');
    progressBar.className = 'absolute bottom-0 left-0 h-[3px] rounded-b-xl bg-white/30';
    progressBar.style.cssText = `width:100%; transition:width ${duration}ms linear;`;

    toast.style.position = 'relative';
    toast.style.overflow = 'hidden';

    toast.innerHTML = `
        <span class="flex-shrink-0">${icon}</span>
        <span class="flex-1 min-w-0">${escHtml(message)}</span>
        <button class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity ml-1"
                aria-label="Tutup">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
    `;
    toast.appendChild(progressBar);

    toast.querySelector('button').addEventListener('click', () => dismissToast(toast));

    root.appendChild(toast);

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
            progressBar.style.width = '0%';
        });
    });

    setTimeout(() => dismissToast(toast), duration);
}

function dismissToast(toast) {
    if (!toast.isConnected) return;
    toast.classList.add('opacity-0', 'translate-y-2', 'scale-95');
    toast.style.transition = 'all 0.25s ease-in';
    setTimeout(() => toast.remove(), 260);
}

// ─────────────────────────────────────────────────────────────
// BUILD ELEMENTS
// ─────────────────────────────────────────────────────────────

/**
 * Bangun kartu pertanyaan baru (dipakai setelah AJAX submit).
 * Viewer mendapat tombol "Balas / Klarifikasi" beserta form collapse-nya.
 */
function buildQuestionCard(q) {
    const qaSection = document.querySelector('.qa-section');
    const userRole  = qaSection?.dataset.userRole || '';
    const replyUrlTpl = qaSection?.dataset.replyUrlTemplate || '';
    const replyUrl  = replyUrlTpl.replace('__ID__', q.id);

    const card = document.createElement('div');
    card.className = [
        'question-card border border-slate-200 rounded-xl p-4 bg-white',
        'shadow-[0_1px_3px_rgba(10,22,40,0.06)]',
        'opacity-0 translate-y-3',
        'transition-all duration-400 ease-out',
    ].join(' ');
    card.dataset.id = q.id;

    const initials = getInitials(q.user_name || 'U');

    // Form balas untuk viewer (collapsible)
    const viewerReplyHtml = userRole === 'viewer' ? `
        <div class="reply-form-wrap mt-3 pl-9">
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
          <div class="qa-reply-collapse hidden mt-2">
            <form action="${escHtml(replyUrl)}" method="POST"
                  class="qa-reply-form" data-reply-role="viewer">
              <input type="hidden" name="_token" value="${escHtml(getCsrfMeta())}">
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
                    ${sendIconSm()}
                    Kirim
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
    ` : '';

    card.innerHTML = `
        <div class="flex items-center gap-2 mb-2.5">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-blue-700
                        flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0">
                ${escHtml(initials)}
            </div>
            <span class="text-[12.5px] font-semibold text-slate-700">${escHtml(q.user_name || '')}</span>
            <span class="text-[11px] text-slate-400 ml-auto whitespace-nowrap">
                ${escHtml(formatWITA(q.created_at))}
            </span>
        </div>
        <div class="text-[13.5px] text-slate-700 leading-relaxed pl-9">${escHtml(q.isi)}</div>
        ${viewerReplyHtml}
    `;
    return card;
}

/**
 * Bangun elemen reply baru.
 * @param {object} r      - data reply dari server
 * @param {string} role   - 'notulis' | 'viewer'
 */
function buildReplyCard(r, role = 'viewer') {
    const el = document.createElement('div');

    const isNotulis = role === 'notulis';
    el.className = [
        'reply-card flex items-start gap-2.5 rounded-xl p-3 border',
        isNotulis ? 'bg-green-50 border-green-100' : 'bg-blue-50 border-blue-100',
        'opacity-0 translate-y-2',
        'transition-all duration-300 ease-out',
    ].join(' ');

    const initials  = getInitials(r.user_name || 'N');
    const avatarCls = isNotulis
        ? 'bg-gradient-to-br from-emerald-500 to-cyan-600'
        : 'bg-gradient-to-br from-blue-400 to-blue-600';
    const nameCls   = isNotulis ? 'text-emerald-700' : 'text-blue-700';
    const badge     = isNotulis
        ? `<span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-emerald-100 text-emerald-600 border border-emerald-200">Notulis</span>`
        : '';

    el.innerHTML = `
        <div class="w-7 h-7 rounded-full ${avatarCls}
                    flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0">
            ${escHtml(initials)}
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-0.5">
              <span class="text-[11.5px] font-semibold ${nameCls}">${escHtml(r.user_name || '')}</span>
              ${badge}
            </div>
            <div class="text-[13px] text-slate-600 leading-relaxed">${escHtml(r.isi)}</div>
        </div>
    `;
    return el;
}

// ─────────────────────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────────────────────
function fetchPost(url, data, csrf) {
    return fetch(url, {
        method : 'POST',
        headers: {
            'Content-Type'    : 'application/json',
            'X-CSRF-TOKEN'    : csrf,
            'Accept'          : 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(data),
    });
}

function getCsrf(form) {
    return form.querySelector('[name="_token"]')?.value
        || document.querySelector('meta[name="csrf-token"]')?.content
        || '';
}

function getCsrfMeta() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

function setLoading(btn, loading, label) {
    btn.disabled  = loading;
    btn.innerHTML = loading
        ? `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
               style="animation:spin 0.8s linear infinite">
               <polyline points="23 4 23 10 17 10"/>
               <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
           </svg> Mengirim...`
        : label;
}

function buildLabel(iconHtml, text) {
    return `${iconHtml} ${escHtml(text)}`;
}

function clearFeedback(form) {
    const fb = form.querySelector('.qa-form-feedback');
    if (fb) fb.innerHTML = '';
}

function autoResize(ta) {
    ta.style.height = 'auto';
    ta.style.height = ta.scrollHeight + 'px';
}

function shakeField(el) {
    el.classList.remove('qa-shake');
    void el.offsetWidth; // reflow
    el.classList.add('qa-shake');
    el.addEventListener('animationend', () => el.classList.remove('qa-shake'), { once: true });
    el.focus();
}

function updateQuestionCounter(delta) {
    const counter = document.querySelector('.qa-counter');
    if (!counter) return;
    const current = parseInt(counter.textContent, 10) || 0;
    const next    = current + delta;
    counter.textContent = `${next} pertanyaan`;
    counter.classList.add('scale-110');
    setTimeout(() => counter.classList.remove('scale-110'), 200);
}

function getInitials(name) {
    return name
        .split(' ')
        .slice(0, 2)
        .map(w => w[0] || '')
        .join('')
        .toUpperCase();
}

function escHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/**
 * Format tanggal ke "dd MMM YYYY, HH:mm WITA" menggunakan timezone Asia/Makassar (WITA, UTC+8).
 */
function formatWITA(date) {
    const d = date ? new Date(date) : new Date();

    const WITA_OFFSET_MS = 8 * 60 * 60 * 1000;
    const local = new Date(d.getTime() + WITA_OFFSET_MS);

    const MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    const dd   = String(local.getUTCDate()).padStart(2, '0');
    const mmm  = MONTHS[local.getUTCMonth()];
    const yyyy = local.getUTCFullYear();
    const hh   = String(local.getUTCHours()).padStart(2, '0');
    const min  = String(local.getUTCMinutes()).padStart(2, '0');

    return `${dd} ${mmm} ${yyyy}, ${hh}:${min} WITA`;
}

// ─────────────────────────────────────────────────────────────
// CSS ANIMATIONS — inject sekali ke <head>
// ─────────────────────────────────────────────────────────────
(function injectQaStyles() {
    if (document.getElementById('qa-keyframes')) return;
    const style = document.createElement('style');
    style.id = 'qa-keyframes';
    style.textContent = `
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes qa-shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }
        .qa-shake {
            animation: qa-shake 0.35s ease;
        }
        /* entrance: pertanyaan baru */
        .question-card.qa-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        /* entrance: reply baru */
        .reply-card.reply-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    `;
    document.head.appendChild(style);
})();

// ─────────────────────────────────────────────────────────────
// ICONS
// ─────────────────────────────────────────────────────────────
function sendIcon() {
    return `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="22" y1="2" x2="11" y2="13"/>
        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
    </svg>`;
}

function sendIconSm() {
    return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="22" y1="2" x2="11" y2="13"/>
        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
    </svg>`;
}

function replyIcon() {
    return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="9 17 4 12 9 7"/>
        <path d="M20 18v-2a4 4 0 0 0-4-4H4"/>
    </svg>`;
}