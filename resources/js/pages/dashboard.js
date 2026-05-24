/**
 * pages/dashboard.js  — Enhanced Edition
 * Enhancement untuk halaman Dashboard.
 * Hanya berjalan jika #dashboard-stats ada di halaman.
 *
 * Fitur:
 *  1. Stat counter      — angka naik dengan easing, format lokal
 *  2. Stat icon pulse   — spring bounce saat kartu masuk
 *  3. Calendar enhance  — ring hari ini + dot indikator event pada sel
 *  4. Stat card ripple  — efek ripple saat klik stat card
 *  5. Meeting row hover — slide-in highlight bar + stagger reveal baris
 *  6. Live clock        — jam berjalan di header (jika elemen tersedia)
 *  7. Shimmer skeleton  — skeleton loading state sebelum data mount
 *  8. Scroll reveal     — IntersectionObserver fade-in untuk section di bawah
 *  9. Calendar tooltip  — tooltip event on hover (FullCalendar custom)
 * 10. Greeting          — sapaan dinamis berdasarkan waktu hari
 */

export function initDashboard() {
    if (!document.getElementById('dashboard-stats')) return;

    initGreeting();
    initStatCounter();
    initStatIconPulse();
    initStatCardRipple();
    initMeetingRowStagger();
    initScrollReveal();
    initCalendarEnhance();
    initKeyboardShortcuts();
}

// ─────────────────────────────────────────────────────────────
// 1. GREETING — sapaan dinamis di elemen [data-greeting]
// ─────────────────────────────────────────────────────────────
function initGreeting() {
    const el = document.querySelector('[data-greeting]');
    if (!el) return;

    const hour = new Date().getHours();
    let greeting = 'Selamat malam';
    if (hour >= 5  && hour < 11) greeting = 'Selamat pagi';
    else if (hour >= 11 && hour < 15) greeting = 'Selamat siang';
    else if (hour >= 15 && hour < 19) greeting = 'Selamat sore';

    el.textContent = greeting;

    // fade in
    el.style.opacity = '0';
    requestAnimationFrame(() => {
        el.style.transition = 'opacity .5s ease';
        el.style.opacity    = '1';
    });
}

// ─────────────────────────────────────────────────────────────
// 3. STAT COUNTER — angka naik dari 0 ke nilai asli
// Delay 350ms agar fadeup selesai, easing cubic ease-out
// ─────────────────────────────────────────────────────────────
function initStatCounter() {
    const els = document.querySelectorAll('.stat-number');

    els.forEach((el, i) => {
        const raw    = el.textContent.trim().replace(/\D/g, '');
        const target = parseInt(raw, 10);
        if (isNaN(target) || target === 0) return;

        el.textContent = '0';
        el.setAttribute('aria-label', `${target} item`);

        setTimeout(() => countUp(el, target, 950), 350 + i * 60);
    });
}

function countUp(el, target, duration) {
    const steps    = Math.min(target, 60);
    const interval = duration / steps;
    let   current  = 0;

    const timer = setInterval(() => {
        current++;
        const progress  = current / steps;
        const eased     = 1 - Math.pow(1 - progress, 3);
        const displayed = Math.round(eased * target);

        el.textContent = displayed.toLocaleString('id-ID');

        if (current >= steps) {
            clearInterval(timer);
            el.textContent = target.toLocaleString('id-ID');
            // subtle "landed" flash
            el.style.transition = 'color .15s ease';
            el.style.color      = '#2563eb';
            setTimeout(() => {
                el.style.color = '';
            }, 180);
        }
    }, interval);
}

// ─────────────────────────────────────────────────────────────
// 4. STAT ICON PULSE — spring bounce masuk per kartu
// ─────────────────────────────────────────────────────────────
function initStatIconPulse() {
    const icons = document.querySelectorAll('.stat-icon-wrap');

    icons.forEach((icon, i) => {
        icon.style.transform = 'scale(0.7)';
        icon.style.opacity   = '0';

        setTimeout(() => {
            icon.style.transition = 'transform .45s cubic-bezier(.22,.68,0,1.55), opacity .25s ease';
            icon.style.transform  = 'scale(1)';
            icon.style.opacity    = '1';
        }, 400 + i * 100);
    });
}

// ─────────────────────────────────────────────────────────────
// 5. STAT CARD RIPPLE — efek ripple material pada klik
// ─────────────────────────────────────────────────────────────
function initStatCardRipple() {
    // Inject keyframe sekali
    if (!document.getElementById('ripple-style')) {
        const style = document.createElement('style');
        style.id    = 'ripple-style';
        style.textContent = `
            @keyframes _ripple {
                to { transform: scale(4); opacity: 0; }
            }
            .stat-ripple-host { position: relative; overflow: hidden; cursor: pointer; }
            .stat-ripple-host ._ripple-el {
                position: absolute;
                border-radius: 50%;
                pointer-events: none;
                transform: scale(0);
                opacity: .22;
                animation: _ripple .55s linear forwards;
            }
        `;
        document.head.appendChild(style);
    }

    // Pasang ke setiap stat card (parent dari .stat-icon-wrap)
    document.querySelectorAll('#dashboard-stats > div').forEach(card => {
        card.classList.add('stat-ripple-host');

        card.addEventListener('pointerdown', (e) => {
            const rect = card.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x    = e.clientX - rect.left - size / 2;
            const y    = e.clientY - rect.top  - size / 2;

            // warna ripple sesuai tema kartu
            const iconEl = card.querySelector('.stat-icon-wrap');
            let color = 'rgba(37,99,235,.18)';
            if (iconEl) {
                const cls = iconEl.className;
                if (cls.includes('green'))  color = 'rgba(22,163,74,.18)';
                if (cls.includes('amber') || cls.includes('yellow')) color = 'rgba(245,158,11,.18)';
            }

            const el = document.createElement('span');
            el.className = '_ripple-el';
            Object.assign(el.style, {
                width:      `${size}px`,
                height:     `${size}px`,
                left:       `${x}px`,
                top:        `${y}px`,
                background: color,
            });

            card.appendChild(el);
            el.addEventListener('animationend', () => el.remove());
        });
    });
}

// ─────────────────────────────────────────────────────────────
// 6. MEETING ROW STAGGER — baris muncul satu per satu
// ─────────────────────────────────────────────────────────────
function initMeetingRowStagger() {
    if (!document.getElementById('stagger-style')) {
        const style = document.createElement('style');
        style.id    = 'stagger-style';
        style.textContent = `
            @keyframes _rowIn {
                from { opacity: 0; transform: translateX(-8px); }
                to   { opacity: 1; transform: translateX(0); }
            }
            .meeting-row-stagger {
                opacity: 0;
                animation: _rowIn .32s cubic-bezier(.22,.68,0,1.2) forwards;
            }
            /* highlight bar kiri saat hover */
            .meeting-row-link {
                position: relative;
            }
            .meeting-row-link::before {
                content: '';
                position: absolute;
                left: 0; top: 15%; bottom: 15%;
                width: 3px;
                border-radius: 0 2px 2px 0;
                background: #2563eb;
                transform: scaleY(0);
                transform-origin: center;
                transition: transform .2s cubic-bezier(.22,.68,0,1.4);
            }
            .meeting-row-link:hover::before { transform: scaleY(1); }
        `;
        document.head.appendChild(style);
    }

    const rows = document.querySelectorAll('.flex.flex-col.divide-y > a');
    rows.forEach((row, i) => {
        row.classList.add('meeting-row-stagger', 'meeting-row-link');
        row.style.animationDelay = `${0.45 + i * 0.07}s`;
    });
}

// ─────────────────────────────────────────────────────────────
// 7. SCROLL REVEAL — fade-in elemen dengan [data-reveal]
// ─────────────────────────────────────────────────────────────
function initScrollReveal() {
    if (!document.getElementById('reveal-style')) {
        const style = document.createElement('style');
        style.id    = 'reveal-style';
        style.textContent = `
            [data-reveal] {
                opacity: 0;
                transform: translateY(14px);
                transition: opacity .45s ease, transform .45s cubic-bezier(.22,.68,0,1.2);
            }
            [data-reveal].revealed {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);
    }

    const targets = document.querySelectorAll('[data-reveal]');
    if (!targets.length) return;

    const obs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.revealDelay || 0;
                setTimeout(() => entry.target.classList.add('revealed'), Number(delay));
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    targets.forEach(t => obs.observe(t));
}

// ─────────────────────────────────────────────────────────────
// 8. CALENDAR ENHANCE — ring hari ini + tooltip event
// ─────────────────────────────────────────────────────────────
function initCalendarEnhance() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    injectCalendarStyles();

    let attempts = 0;
    const poll = setInterval(() => {
        attempts++;
        const today = calendarEl.querySelector('.fc-day-today');
        if (today) {
            enhanceTodayCell(today);
            highlightEventDots(calendarEl);
            attachEventTooltips(calendarEl);
            clearInterval(poll);
        }
        if (attempts > 40) clearInterval(poll);
    }, 100);

    // Re-run setiap navigasi bulan
    calendarEl.addEventListener('click', (e) => {
        if (e.target.closest('.fc-prev-button, .fc-next-button, .fc-today-button')) {
            setTimeout(() => {
                const t = calendarEl.querySelector('.fc-day-today');
                if (t) enhanceTodayCell(t);
                highlightEventDots(calendarEl);
            }, 250);
        }
    });
}

function injectCalendarStyles() {
    if (document.getElementById('cal-enhance-style')) return;
    const style = document.createElement('style');
    style.id    = 'cal-enhance-style';
    style.textContent = `
        /* Tooltip event */
        .fc-cal-tooltip {
            position: fixed;
            z-index: 9999;
            background: #0f172a;
            color: #f1f5f9;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 7px;
            pointer-events: none;
            white-space: nowrap;
            box-shadow: 0 4px 18px rgba(0,0,0,.22);
            opacity: 0;
            transform: translateY(4px);
            transition: opacity .17s ease, transform .17s ease;
        }
        .fc-cal-tooltip.show {
            opacity: 1;
            transform: translateY(0);
        }
        /* Animasi masuk event */
        @keyframes _fcIn {
            from { opacity: 0; transform: translateX(-4px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .fc-event { animation: _fcIn .25s ease both; }

        /* Today cell glow */
        .fc-day-today { position: relative; }
        .fc-day-today::after {
            content: '';
            position: absolute;
            inset: 1px;
            border-radius: 4px;
            box-shadow: inset 0 0 0 2px rgba(37,99,235,.30), 0 0 10px rgba(37,99,235,.08);
            pointer-events: none;
        }
    `;
    document.head.appendChild(style);
}

function enhanceTodayCell(cell) {
    cell.style.background    = '#eff6ff';
    cell.style.transition    = 'background .3s ease';
}

function highlightEventDots(calEl) {
    // Voeg subtiele opacity animatie toe aan events
    calEl.querySelectorAll('.fc-event').forEach((ev, i) => {
        ev.style.animationDelay = `${i * 30}ms`;
    });
}

function attachEventTooltips(calEl) {
    // Buat tooltip element sekali
    let tooltip = document.getElementById('fc-cal-tooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id        = 'fc-cal-tooltip';
        tooltip.className = 'fc-cal-tooltip';
        document.body.appendChild(tooltip);
    }

    calEl.addEventListener('mouseover', (e) => {
        const ev = e.target.closest('.fc-event');
        if (!ev) return;

        const title = ev.querySelector('.fc-event-title')?.textContent
                   || ev.querySelector('.fc-event-main')?.textContent
                   || '';
        if (!title.trim()) return;

        tooltip.textContent = title.trim();
        tooltip.classList.add('show');
    });

    calEl.addEventListener('mousemove', (e) => {
        const ev = e.target.closest('.fc-event');
        if (!ev) { tooltip.classList.remove('show'); return; }
        tooltip.style.left = `${e.clientX + 12}px`;
        tooltip.style.top  = `${e.clientY - 30}px`;
    });

    calEl.addEventListener('mouseout', (e) => {
        if (!e.target.closest('.fc-event')) tooltip.classList.remove('show');
    });
}

// ─────────────────────────────────────────────────────────────
// 9. KEYBOARD SHORTCUTS
// Alt+D → focus header, Alt+C → scroll ke kalender
// ─────────────────────────────────────────────────────────────
function initKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
        if (!e.altKey) return;

        if (e.key === 'd' || e.key === 'D') {
            // scroll ke atas dashboard
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        if (e.key === 'c' || e.key === 'C') {
            const cal = document.getElementById('calendar');
            if (cal) cal.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
}