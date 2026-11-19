/* =========================================================
   PATEL OFFSET — Admin Console scripts
   ========================================================= */
(() => {
    'use strict';
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const store = {
        get(k, d) { try { const v = localStorage.getItem('ap.' + k); return v === null ? d : JSON.parse(v); } catch (e) { return d; } },
        set(k, v) { try { localStorage.setItem('ap.' + k, JSON.stringify(v)); } catch (e) {} },
        del(k) { try { localStorage.removeItem('ap.' + k); } catch (e) {} },
    };
    const csrf = () => $('meta[name="csrf-token"]')?.content || '';
    const esc = s => String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const root = document.documentElement;
    const shell = $('.ap-shell');

    /* ---------- Toasts ---------- */
    function toast(msg, type = 'success') {
        let wrap = $('.toast-wrap');
        if (!wrap) { wrap = document.createElement('div'); wrap.className = 'toast-wrap'; document.body.appendChild(wrap); }
        const t = document.createElement('div');
        t.className = 'toast' + (type === 'error' ? ' error' : '');
        t.innerHTML = `<i class="fa-solid ${type === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check'}"></i>${esc(msg)}`;
        wrap.appendChild(t);
        hideToast(t);
    }
    function hideToast(t) { setTimeout(() => { t.classList.add('hide'); setTimeout(() => t.remove(), 500); }, 4000); }
    $$('.toast').forEach(hideToast);
    window.apToast = toast;

    /* ---------- Preferences (theme / accent / density) ---------- */
    const prefs = Object.assign({ theme: 'light', accent: 'violet', density: 'comfortable', striped: false, collapsed: false }, store.get('prefs', {}));
    function applyPrefs() {
        root.dataset.theme = prefs.theme;
        root.dataset.accent = prefs.accent;
        shell?.classList.toggle('collapsed', !!prefs.collapsed);
        $$('.dt').forEach(d => { d.classList.toggle('compact', prefs.density === 'compact'); d.classList.toggle('striped', !!prefs.striped); });
        const ti = $('#apTheme i'); if (ti) ti.className = prefs.theme === 'dark' ? 'fa-regular fa-moon' : 'fa-regular fa-sun';
        $$('[data-pref]').forEach(b => b.classList.toggle('on', String(prefs[b.dataset.pref]) === b.dataset.val));
    }
    function setPref(k, v) { prefs[k] = v; store.set('prefs', prefs); applyPrefs(); }
    applyPrefs();
    $$('[data-pref]').forEach(b => b.addEventListener('click', () => {
        const v = b.dataset.val; setPref(b.dataset.pref, v === 'true' ? true : v === 'false' ? false : v);
    }));
    $('#apTheme')?.addEventListener('click', () => setPref('theme', prefs.theme === 'dark' ? 'light' : 'dark'));

    /* ---------- Sidebar ---------- */
    const backdrop = $('.ap-backdrop');
    const isMobile = () => matchMedia('(max-width: 991px)').matches;
    $('#apSideToggle')?.addEventListener('click', () => {
        if (isMobile()) { shell.classList.toggle('mobile-open'); backdrop.classList.toggle('open', shell.classList.contains('mobile-open')); }
        else setPref('collapsed', !prefs.collapsed);
    });
    backdrop?.addEventListener('click', () => { shell.classList.remove('mobile-open'); backdrop.classList.remove('open'); });

    // group open/closed
    const closedGroups = store.get('closedGroups', []);
    $$('.ap-group').forEach(g => {
        const items = $('.ap-group-items', g);
        const fit = () => { items.style.maxHeight = items.scrollHeight + 'px'; };
        fit();
        if (closedGroups.includes(g.dataset.group) && !$('.ap-link.active', g)) g.classList.add('closed');
        $('.ap-group-head', g).addEventListener('click', () => {
            fit(); g.classList.toggle('closed');
            const list = $$('.ap-group.closed').map(x => x.dataset.group);
            store.set('closedGroups', list);
        });
    });

    // filter menu
    $('#apMenuFilter')?.addEventListener('input', e => {
        const q = e.target.value.trim().toLowerCase();
        $$('.ap-group').forEach(g => {
            let any = false;
            $$('.ap-link', g).forEach(l => {
                const hit = !q || l.dataset.label.toLowerCase().includes(q);
                l.classList.toggle('hidden-by-filter', !hit); if (hit) any = true;
            });
            g.classList.toggle('hidden-by-filter', !any);
            if (q) g.classList.remove('closed');
        });
    });

    // custom menu order + hidden items
    function applyMenuLayout() {
        const layout = store.get('menu', null);
        $$('.ap-group').forEach(g => {
            const box = $('.ap-group-items', g);
            const conf = layout?.[g.dataset.group];
            if (conf) conf.order.forEach(id => { const el = $(`.ap-link[data-id="${id}"]`, box); if (el) box.appendChild(el); });
            $$('.ap-link', box).forEach(l => l.classList.toggle('user-hidden', !!conf?.hidden?.includes(l.dataset.id) && !l.classList.contains('active')));
            box.style.maxHeight = box.scrollHeight + 'px';
        });
    }
    applyMenuLayout();

    /* ---------- Dropdowns ---------- */
    document.addEventListener('click', e => {
        const trigger = e.target.closest('[data-dd-toggle]');
        const dd = trigger?.closest('.ap-dd');
        $$('.ap-dd.open').forEach(o => { if (o !== dd && !o.contains(e.target)) o.classList.remove('open'); });
        if (trigger && dd) { dd.classList.toggle('open'); e.stopPropagation(); }
    });

    /* ---------- Overlays (command palette, modals) ---------- */
    function openOverlay(el) { el.classList.add('open'); }
    function closeOverlay(el) { el.classList.remove('open'); }
    $$('.ap-overlay').forEach(o => o.addEventListener('mousedown', e => { if (e.target === o) closeOverlay(o); }));
    $$('[data-close]').forEach(b => b.addEventListener('click', () => closeOverlay(b.closest('.ap-overlay') || b.closest('.ap-drawer'))));

    /* ---------- Command palette ---------- */
    const cmd = $('#apCmd');
    if (cmd) {
        const input = $('input', cmd), list = $('.cmd-list', cmd);
        const items = [
            ...$$('.ap-link').map(l => ({ label: l.dataset.label, icon: $('i', l).className, href: l.href, target: l.target, group: 'Pages' })),
            ...$$('[data-cmd]').map(a => ({ label: a.dataset.cmd, icon: a.dataset.cmdIcon || 'fa-solid fa-bolt', href: a.href, group: 'Quick actions' })),
            { label: 'Toggle dark mode', icon: 'fa-regular fa-moon', run: () => $('#apTheme').click(), group: 'Quick actions' },
            { label: 'Toggle sidebar', icon: 'fa-solid fa-table-columns', run: () => $('#apSideToggle').click(), group: 'Quick actions' },
            { label: 'Customize menu', icon: 'fa-solid fa-sliders', run: () => openMenuEditor(), group: 'Quick actions' },
        ];
        let sel = 0, shown = [];
        const render = () => {
            const q = input.value.trim().toLowerCase();
            shown = items.filter(i => i.label.toLowerCase().includes(q));
            sel = Math.min(sel, Math.max(shown.length - 1, 0));
            let html = '', grp = '';
            shown.forEach((it, i) => {
                if (it.group !== grp) { grp = it.group; html += `<h6>${grp}</h6>`; }
                html += `<div class="cmd-item${i === sel ? ' sel' : ''}" data-i="${i}"><i class="${it.icon}"></i>${esc(it.label)}<small>${it.run ? 'Action' : 'Jump to'}</small></div>`;
            });
            list.innerHTML = html || '<p class="muted" style="padding:20px;text-align:center">No results</p>';
            $('.cmd-item.sel', list)?.scrollIntoView({ block: 'nearest' });
        };
        const go = i => {
            const it = shown[i]; if (!it) return;
            closeOverlay(cmd);
            if (it.run) it.run(); else if (it.target === '_blank') window.open(it.href, '_blank'); else location.href = it.href;
        };
        const open = () => { input.value = ''; sel = 0; render(); openOverlay(cmd); setTimeout(() => input.focus(), 50); };
        $('#apSearchBtn')?.addEventListener('click', open);
        input.addEventListener('input', () => { sel = 0; render(); });
        list.addEventListener('mousemove', e => { const it = e.target.closest('.cmd-item'); if (it && +it.dataset.i !== sel) { sel = +it.dataset.i; render(); } });
        list.addEventListener('click', e => { const it = e.target.closest('.cmd-item'); if (it) go(+it.dataset.i); });
        input.addEventListener('keydown', e => {
            if (e.key === 'ArrowDown') { sel = (sel + 1) % Math.max(shown.length, 1); render(); e.preventDefault(); }
            if (e.key === 'ArrowUp') { sel = (sel - 1 + shown.length) % Math.max(shown.length, 1); render(); e.preventDefault(); }
            if (e.key === 'Enter') go(sel);
        });
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); cmd.classList.contains('open') ? closeOverlay(cmd) : open(); }
            if (e.key === 'Escape') { $$('.ap-overlay.open').forEach(closeOverlay); $$('.ap-drawer.open').forEach(d => d.classList.remove('open')); $$('.ap-dd.open').forEach(d => d.classList.remove('open')); }
        });
    }

    /* ---------- Page fullscreen ---------- */
    $('#apFullscreen')?.addEventListener('click', () => {
        if (document.fullscreenElement) document.exitFullscreen(); else document.documentElement.requestFullscreen?.();
    });
    document.addEventListener('fullscreenchange', () => {
        const i = $('#apFullscreen i'); if (i) i.className = document.fullscreenElement === document.documentElement ? 'fa-solid fa-compress' : 'fa-solid fa-expand';
    });

    /* ---------- Settings drawer ---------- */
    const drawer = $('#apDrawer');
    $('#apFab')?.addEventListener('click', () => drawer.classList.add('open'));
    drawer && $$('[data-close]', drawer).forEach(b => b.addEventListener('click', () => drawer.classList.remove('open')));

    /* ---------- Sidebar menu editor (drag & drop) ---------- */
    const menuModal = $('#apMenuModal');
    function openMenuEditor() {
        if (!menuModal) return;
        const layout = store.get('menu', {});
        const box = $('.menu-sort', menuModal);
        box.innerHTML = '';
        $$('.ap-group').forEach(g => {
            box.insertAdjacentHTML('beforeend', `<div class="grp">${esc($('.ap-group-head span', g).textContent)}</div>`);
            const wrap = document.createElement('div');
            wrap.className = 'menu-sort-group'; wrap.dataset.group = g.dataset.group; wrap.style.display = 'grid'; wrap.style.gap = '6px';
            $$('.ap-link', g).forEach(l => {
                const hidden = layout[g.dataset.group]?.hidden?.includes(l.dataset.id);
                wrap.insertAdjacentHTML('beforeend', `<div class="ms" draggable="true" data-id="${l.dataset.id}"><i class="fa-solid fa-grip-vertical grip"></i><i class="${$('i', l).className} ico"></i>${esc(l.dataset.label)}<label class="sw"><input type="checkbox" ${hidden ? '' : 'checked'}><span class="tr"></span></label></div>`);
            });
            box.appendChild(wrap);
            dragSort(wrap, '.ms');
        });
        openOverlay(menuModal);
    }
    $$('[data-open-menu-editor]').forEach(b => b.addEventListener('click', e => { e.preventDefault(); drawer?.classList.remove('open'); openMenuEditor(); }));
    $('#apMenuSave')?.addEventListener('click', () => {
        const layout = {};
        $$('.menu-sort-group', menuModal).forEach(w => {
            layout[w.dataset.group] = {
                order: $$('.ms', w).map(m => m.dataset.id),
                hidden: $$('.ms', w).filter(m => !$('input', m).checked).map(m => m.dataset.id),
            };
        });
        store.set('menu', layout); applyMenuLayout(); closeOverlay(menuModal); toast('Menu layout saved');
    });
    $('#apMenuReset')?.addEventListener('click', () => { store.del('menu'); location.reload(); });

    /* generic drag-to-sort for a container */
    function dragSort(container, selector, onDrop) {
        let dragEl = null;
        container.addEventListener('dragstart', e => {
            dragEl = e.target.closest(selector); if (!dragEl) return;
            dragEl.classList.add('dragging'); e.dataTransfer.effectAllowed = 'move';
            try { e.dataTransfer.setData('text/plain', ''); } catch (err) {}
        });
        container.addEventListener('dragover', e => {
            const over = e.target.closest(selector); if (!dragEl || !over || !container.contains(over)) return;
            e.preventDefault();
            $$(selector + '.over', container).forEach(x => x.classList.remove('over'));
            if (over !== dragEl) over.classList.add('over');
        });
        container.addEventListener('drop', e => {
            const over = e.target.closest(selector); if (!dragEl || !over || over === dragEl) return;
            e.preventDefault();
            const items = $$(selector, container);
            if (items.indexOf(dragEl) < items.indexOf(over)) over.after(dragEl); else over.before(dragEl);
            onDrop?.();
        });
        container.addEventListener('dragend', () => { dragEl?.classList.remove('dragging'); $$(selector + '.over', container).forEach(x => x.classList.remove('over')); dragEl = null; });
    }

    /* ---------- Confirm dialog for destructive forms ---------- */
    const confirmModal = $('#apConfirm');
    let pendingForm = null;
    document.addEventListener('submit', e => {
        const f = e.target;
        if (!f.matches('[data-confirm]') || f.dataset.confirmed) return;
        e.preventDefault();
        if (!confirmModal) { if (confirm(f.dataset.confirm)) { f.dataset.confirmed = 1; f.submit(); } return; }
        pendingForm = f;
        $('.confirm-text', confirmModal).textContent = f.dataset.confirm;
        openOverlay(confirmModal);
    }, true);
    $('#apConfirmYes')?.addEventListener('click', () => { if (pendingForm) { pendingForm.dataset.confirmed = 1; pendingForm.submit(); } });

    /* ---------- AJAX toggle switches ---------- */
    document.addEventListener('change', async e => {
        const inp = e.target.closest('input[data-toggle-url]'); if (!inp) return;
        const on = inp.checked;
        inp.disabled = true;
        try {
            const res = await fetch(inp.dataset.toggleUrl, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ field: inp.dataset.field, value: on }),
            });
            if (!res.ok) throw new Error();
            const data = await res.json();
            const row = inp.closest('tr');
            if (row && inp.dataset.tag) {
                const tags = new Set((row.dataset.tags || '').split(' ').filter(Boolean));
                on ? tags.add(inp.dataset.tag) : tags.delete(inp.dataset.tag);
                if (inp.dataset.tagOff) on ? tags.delete(inp.dataset.tagOff) : tags.add(inp.dataset.tagOff);
                row.dataset.tags = [...tags].join(' ');
                row.closest('.dt')?.dispatchEvent(new CustomEvent('dt:refresh'));
            }
            toast(data.message || 'Saved');
        } catch (err) {
            inp.checked = !on; toast('Could not update. Please try again.', 'error');
        } finally { inp.disabled = false; }
    });

    /* ---------- Lazy script loader ---------- */
    const loaded = {};
    const loadScript = src => loaded[src] || (loaded[src] = new Promise((ok, fail) => {
        const s = document.createElement('script'); s.src = src; s.onload = ok; s.onerror = () => { delete loaded[src]; fail(); }; document.head.appendChild(s);
    }));
    const download = (blob, name) => { const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = name; document.body.appendChild(a); a.click(); setTimeout(() => { URL.revokeObjectURL(a.href); a.remove(); }, 500); };

    /* =========================================================
       DATA TABLE
       ========================================================= */
    class DataTable {
        constructor(el) {
            this.el = el;
            this.name = el.dataset.dt;
            this.title = el.dataset.title || document.title;
            this.table = $('table', el);
            this.sizes = [10, 20, 25, 50, 100];
            const st = store.get('dt.' + this.name, {});
            this.perPage = st.perPage || +el.dataset.perPage || 10;
            this.sortKey = st.sortKey ?? null; this.sortDir = st.sortDir || 'asc';
            this.page = 1; this.query = ''; this.filter = '';

            // columns
            this.headRow = $('thead tr', this.table);
            this.cols = $$('th', this.headRow).map((th, i) => ({
                key: th.dataset.col || 'c' + i, th, label: th.textContent.trim() || th.dataset.label || '',
                sortable: !th.hasAttribute('data-nosort'), exportable: !th.hasAttribute('data-noexport'), locked: th.hasAttribute('data-lock'),
            }));
            const keys = this.cols.map(c => c.key);
            this.order = (st.order && st.order.length === keys.length && st.order.every(k => keys.includes(k))) ? st.order : keys.slice();
            this.hidden = new Set((st.hidden || []).filter(k => keys.includes(k)));
            if (this.sortKey && !keys.includes(this.sortKey)) this.sortKey = null;

            // rows
            this.tbody = $('tbody', this.table);
            this.rows = $$('tr', this.tbody).filter(r => !r.classList.contains('dt-empty-src')).map((tr, idx) => {
                const cells = {};
                $$(':scope > td', tr).forEach((td, i) => { if (this.cols[i]) cells[this.cols[i].key] = td; });
                return { tr, cells, idx };
            });
            $$('.dt-empty-src', this.tbody).forEach(r => r.remove());

            this.build();
            this.renderHead();
            this.update();
            el.addEventListener('dt:refresh', () => { this.countTabs(); this.update(); });
        }

        save() { store.set('dt.' + this.name, { perPage: this.perPage, sortKey: this.sortKey, sortDir: this.sortDir, order: this.order, hidden: [...this.hidden] }); }

        build() {
            const el = this.el;
            // tabs (optional, provided in markup)
            this.tabs = $('.dt-tabs', el);
            const colsBtn = `<div class="ap-dd"><button type="button" class="dt-btn sq" data-dd-toggle title="Manage columns"><i class="fa-solid fa-table-columns"></i></button><div class="ap-menu dt-cols"><h6>Columns · drag to reorder</h6><div class="dt-col-list"></div><div class="dt-cols-foot"><span>Show / hide</span><button type="button" data-reset>Reset</button></div></div></div>`;
            if (this.tabs) {
                this.tabs.insertAdjacentHTML('beforeend', `<div class="dt-tabs-right"><span class="dt-total"></span>${colsBtn}</div>`);
                $$('.dt-tab', this.tabs).forEach(t => t.addEventListener('click', () => this.setFilter(t.dataset.filter || '')));
            }
            // toolbar
            const bar = document.createElement('div');
            bar.className = 'dt-bar';
            bar.innerHTML = `
                <select class="dt-select dt-size" aria-label="Rows per page">${this.sizes.map(s => `<option value="${s}">${s}</option>`).join('')}<option value="0">All</option></select>
                <span class="dt-lbl">per page</span>
                <button type="button" class="dt-btn" data-x="excel"><i class="fa-solid fa-file-excel"></i><span class="t">Excel</span></button>
                <button type="button" class="dt-btn" data-x="pdf"><i class="fa-solid fa-file-pdf"></i><span class="t">PDF</span></button>
                <button type="button" class="dt-btn" data-x="print"><i class="fa-solid fa-print"></i><span class="t">Print</span></button>
                <div class="ap-dd"><button type="button" class="dt-btn" data-dd-toggle><i class="fa-solid fa-ellipsis"></i><span class="t">More</span><i class="fa-solid fa-chevron-down" style="font-size:11px"></i></button>
                    <div class="ap-menu left">
                        <button type="button" class="mi" data-x="csv"><i class="fa-solid fa-file-csv"></i>Export CSV</button>
                        <button type="button" class="mi" data-x="copy"><i class="fa-regular fa-copy"></i>Copy to clipboard</button>
                        <hr>
                        <button type="button" class="mi" data-x="density"><i class="fa-solid fa-arrows-up-down"></i>Toggle compact rows</button>
                        <button type="button" class="mi" data-x="striped"><i class="fa-solid fa-grip-lines"></i>Toggle striped rows</button>
                        <button type="button" class="mi" data-x="reset"><i class="fa-solid fa-rotate-left"></i>Reset table layout</button>
                    </div></div>
                <button type="button" class="dt-btn sq" data-x="fs" title="Fullscreen"><i class="fa-solid fa-expand"></i></button>
                ${this.tabs ? '' : colsBtn}
                <span class="grow"></span>
                <div class="dt-search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" placeholder="Search records..." aria-label="Search records"></div>`;
            if (this.tabs) this.tabs.after(bar); else el.prepend(bar);
            this.bar = bar;
            const wrap = document.createElement('div'); wrap.className = 'dt-wrap';
            this.table.before(wrap); wrap.appendChild(this.table);
            const foot = document.createElement('div'); foot.className = 'dt-foot';
            foot.innerHTML = '<span class="dt-info"></span><div class="dt-pages"></div>';
            wrap.after(foot);
            this.info = $('.dt-info', foot); this.pages = $('.dt-pages', foot);

            const size = $('.dt-size', bar);
            size.value = this.sizes.includes(this.perPage) ? this.perPage : (this.perPage === 0 ? 0 : 10);
            size.addEventListener('change', () => { this.perPage = +size.value; this.page = 1; this.save(); this.update(); });
            let t;
            $('.dt-search input', bar).addEventListener('input', e => { clearTimeout(t); t = setTimeout(() => { this.query = e.target.value.trim().toLowerCase(); this.page = 1; this.update(); }, 150); });
            el.addEventListener('click', e => {
                const b = e.target.closest('[data-x]'); if (!b || !el.contains(b)) return;
                b.closest('.ap-dd')?.classList.remove('open');
                this.action(b.dataset.x);
            });
            this.pages.addEventListener('click', e => { const b = e.target.closest('button[data-p]'); if (b && !b.disabled) { this.page = +b.dataset.p; this.update(); this.el.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); } });

            // column manager
            this.colList = $('.dt-col-list', el);
            $('[data-reset]', el)?.addEventListener('click', () => this.resetLayout());
            this.colList.addEventListener('change', e => {
                const k = e.target.dataset.k; if (!k) return;
                e.target.checked ? this.hidden.delete(k) : this.hidden.add(k);
                if (this.hidden.size >= this.cols.length) { this.hidden.delete(k); e.target.checked = true; }
                this.save(); this.renderHead(); this.update();
            });
            dragSort(this.colList, '.dt-col-item', () => { this.order = $$('.dt-col-item', this.colList).map(i => i.dataset.k); this.save(); this.renderHead(); this.update(); });

            // header click sort + header drag reorder
            this.headRow.addEventListener('click', e => {
                const th = e.target.closest('th'); if (!th) return;
                const col = this.cols.find(c => c.th === th); if (!col?.sortable) return;
                if (this.sortKey === col.key) this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                else { this.sortKey = col.key; this.sortDir = 'asc'; }
                this.save(); this.renderHead(); this.update();
            });
            let dragK = null;
            this.headRow.addEventListener('dragstart', e => { const th = e.target.closest('th'); dragK = this.cols.find(c => c.th === th)?.key; th?.classList.add('dragging'); try { e.dataTransfer.setData('text/plain', ''); } catch (er) {} });
            this.headRow.addEventListener('dragover', e => { if (!dragK) return; const th = e.target.closest('th'); if (!th) return; e.preventDefault(); $$('th', this.headRow).forEach(x => x.classList.toggle('drag-over', x === th)); });
            this.headRow.addEventListener('drop', e => {
                const th = e.target.closest('th'); const to = this.cols.find(c => c.th === th)?.key;
                if (!dragK || !to || to === dragK) return; e.preventDefault();
                const o = this.order.filter(k => k !== dragK); const i = o.indexOf(to);
                o.splice(this.order.indexOf(dragK) < this.order.indexOf(to) ? i + 1 : i, 0, dragK);
                this.order = o; this.save(); this.renderHead(); this.update();
            });
            this.headRow.addEventListener('dragend', () => { dragK = null; $$('th', this.headRow).forEach(x => x.classList.remove('drag-over', 'dragging')); });

            this.countTabs();
        }

        colByKey(k) { return this.cols.find(c => c.key === k); }

        renderHead() {
            this.order.forEach(k => {
                const c = this.colByKey(k); const th = c.th;
                this.headRow.appendChild(th);
                th.style.display = this.hidden.has(k) ? 'none' : '';
                th.draggable = true;
                th.classList.toggle('sortable', c.sortable);
                th.classList.toggle('asc', this.sortKey === k && this.sortDir === 'asc');
                th.classList.toggle('desc', this.sortKey === k && this.sortDir === 'desc');
                if (!th.dataset.built) {
                    th.innerHTML = `<span class="th-in"><span>${th.innerHTML}</span>${c.sortable ? '<span class="si"><i class="fa-solid fa-caret-up up"></i><i class="fa-solid fa-caret-down down"></i></span>' : ''}</span>`;
                    th.dataset.built = 1;
                }
                if (c.sortable) th.setAttribute('aria-sort', this.sortKey === k ? (this.sortDir === 'asc' ? 'ascending' : 'descending') : 'none');
            });
            this.colList.innerHTML = this.order.map(k => {
                const c = this.colByKey(k);
                return `<div class="dt-col-item" draggable="true" data-k="${k}"><i class="fa-solid fa-grip-vertical grip"></i>${esc(c.label || 'Column')}<input type="checkbox" data-k="${k}" ${this.hidden.has(k) ? '' : 'checked'} aria-label="Show ${esc(c.label)}"></div>`;
            }).join('');
        }

        sortVal(row, key) {
            const td = row.cells[key]; if (!td) return '';
            const raw = td.dataset.sort ?? td.textContent.trim();
            const n = parseFloat(String(raw).replace(/[₹,\s]/g, ''));
            return /^[\s₹-]*[\d,.]+\s*$/.test(raw) && !isNaN(n) ? n : String(raw).toLowerCase();
        }

        matches(row) {
            if (this.filter && !(' ' + (row.tr.dataset.tags || '') + ' ').includes(' ' + this.filter + ' ')) return false;
            if (this.query && !row.tr.textContent.toLowerCase().replace(/\s+/g, ' ').includes(this.query)) return false;
            return true;
        }

        visibleRows() {
            let rows = this.rows.filter(r => this.matches(r));
            if (this.sortKey) {
                const k = this.sortKey, d = this.sortDir === 'asc' ? 1 : -1;
                rows = rows.slice().sort((a, b) => {
                    const x = this.sortVal(a, k), y = this.sortVal(b, k);
                    if (typeof x === 'number' && typeof y === 'number') return (x - y) * d;
                    return String(x).localeCompare(String(y), undefined, { numeric: true }) * d;
                });
            }
            return rows;
        }

        setFilter(f) {
            this.filter = f; this.page = 1;
            $$('.dt-tab', this.tabs || this.el).forEach(t => t.classList.toggle('on', (t.dataset.filter || '') === f));
            $$(`[data-dt-target="${this.name}"]`).forEach(c => c.classList.toggle('on', (c.dataset.filter || '') === f));
            this.update();
        }

        countTabs() {
            const count = f => this.rows.filter(r => !f || (' ' + (r.tr.dataset.tags || '') + ' ').includes(' ' + f + ' ')).length;
            $$('.dt-tab', this.el).forEach(t => { let n = $('.n', t); if (!n) { n = document.createElement('span'); n.className = 'n'; t.appendChild(n); } n.textContent = count(t.dataset.filter || ''); });
            $$(`[data-dt-target="${this.name}"] [data-count]`).forEach(v => { v.textContent = count(v.closest('[data-dt-target]').dataset.filter || ''); });
        }

        update() {
            const rows = this.visibleRows();
            const total = rows.length, per = this.perPage || total || 1;
            const pages = Math.max(1, Math.ceil(total / per));
            this.page = Math.min(this.page, pages);
            const start = (this.page - 1) * per, slice = this.perPage ? rows.slice(start, start + per) : rows;

            const frag = document.createDocumentFragment();
            slice.forEach((r, i) => {
                this.order.forEach(k => { const td = r.cells[k]; if (td) { r.tr.appendChild(td); td.style.display = this.hidden.has(k) ? 'none' : ''; } });
                r.tr.classList.remove('dt-in'); void r.tr.offsetWidth; r.tr.classList.add('dt-in'); r.tr.style.animationDelay = Math.min(i * 25, 300) + 'ms';
                frag.appendChild(r.tr);
            });
            this.tbody.innerHTML = '';
            if (!slice.length) {
                const span = this.cols.length - this.hidden.size;
                this.tbody.innerHTML = `<tr class="dt-empty"><td colspan="${span}"><i class="fa-regular fa-folder-open"></i>${this.query ? 'No matching records found' : (this.el.dataset.empty || 'No records yet')}</td></tr>`;
            } else this.tbody.appendChild(frag);

            this.info.textContent = total ? `Showing ${start + 1} to ${Math.min(start + per, total)} of ${total} entries${total !== this.rows.length ? ` (filtered from ${this.rows.length})` : ''}` : 'Showing 0 entries';
            const t = $('.dt-total', this.el); if (t) t.textContent = `${total} ${this.el.dataset.unit || 'records'}`;

            // pagination
            let html = `<button data-p="${this.page - 1}" ${this.page === 1 ? 'disabled' : ''} aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>`;
            const nums = [];
            for (let p = 1; p <= pages; p++) if (p === 1 || p === pages || Math.abs(p - this.page) <= 1) nums.push(p);
            let last = 0;
            nums.forEach(p => { if (p - last > 1) html += '<button disabled>…</button>'; html += `<button data-p="${p}" class="${p === this.page ? 'on' : ''}">${p}</button>`; last = p; });
            html += `<button data-p="${this.page + 1}" ${this.page === pages ? 'disabled' : ''} aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>`;
            this.pages.innerHTML = pages > 1 ? html : '';
        }

        resetLayout() {
            this.order = this.cols.map(c => c.key); this.hidden.clear(); this.sortKey = null; this.sortDir = 'asc';
            store.del('dt.' + this.name); this.renderHead(); this.update(); toast('Table layout reset');
        }

        /* ---- export data ---- */
        exportData() {
            const cols = this.order.map(k => this.colByKey(k)).filter(c => c.exportable && !this.hidden.has(c.key));
            const head = cols.map(c => c.label);
            const body = this.visibleRows().map(r => cols.map(c => {
                const td = r.cells[c.key]; if (!td) return '';
                return (td.dataset.export ?? td.innerText).replace(/\s+/g, ' ').trim();
            }));
            return { head, body };
        }
        fileName(ext) { const d = new Date(); return `${this.name}-${d.getFullYear()}${String(d.getMonth() + 1).padStart(2, '0')}${String(d.getDate()).padStart(2, '0')}.${ext}`; }

        async action(x) {
            const { head, body } = ['excel', 'pdf', 'print', 'csv', 'copy'].includes(x) ? this.exportData() : { head: [], body: [] };
            if (x === 'csv' || x === 'copy') {
                const sep = x === 'csv' ? ',' : '\t';
                const q = v => x === 'csv' && /[",\n]/.test(v) ? `"${v.replace(/"/g, '""')}"` : v;
                const text = [head, ...body].map(r => r.map(q).join(sep)).join('\n');
                if (x === 'csv') download(new Blob(['﻿' + text], { type: 'text/csv;charset=utf-8' }), this.fileName('csv'));
                else { await navigator.clipboard?.writeText(text); toast(`${body.length} rows copied`); }
            }
            if (x === 'excel') {
                try {
                    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js');
                    const ws = XLSX.utils.aoa_to_sheet([head, ...body]);
                    ws['!cols'] = head.map((h, i) => ({ wch: Math.min(50, Math.max(h.length, ...body.map(r => (r[i] || '').length)) + 2) }));
                    const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, this.title.slice(0, 31));
                    XLSX.writeFile(wb, this.fileName('xlsx'));
                } catch (e) { toast('Excel library failed to load — exported CSV instead', 'error'); this.action('csv'); }
            }
            if (x === 'pdf') {
                try {
                    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
                    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js');
                    const doc = new window.jspdf.jsPDF({ orientation: head.length > 5 ? 'landscape' : 'portrait', unit: 'pt' });
                    const clean = v => v.replace(/₹/g, 'Rs. ').replace(/[^\x20-\x7E]/g, '');
                    const accent = getComputedStyle(root).getPropertyValue('--ac').trim() || '#7c3aed';
                    const rgb = accent.match(/\w\w/g)?.map(h => parseInt(h, 16)) || [124, 58, 237];
                    doc.setFontSize(16); doc.text(clean(document.body.dataset.site || '') + ' - ' + this.title, 40, 40);
                    doc.setFontSize(9); doc.setTextColor(120); doc.text(`Generated ${new Date().toLocaleString()} · ${body.length} records`, 40, 56);
                    doc.autoTable({ head: [head.map(clean)], body: body.map(r => r.map(clean)), startY: 70, styles: { fontSize: 8.5, cellPadding: 5 }, headStyles: { fillColor: rgb, textColor: 255 }, alternateRowStyles: { fillColor: [246, 247, 251] }, margin: { left: 40, right: 40 } });
                    doc.save(this.fileName('pdf'));
                } catch (e) { toast('PDF library failed to load — opening print view', 'error'); this.action('print'); }
            }
            if (x === 'print') {
                const w = window.open('', '_blank');
                if (!w) { toast('Allow pop-ups to print', 'error'); return; }
                w.document.write(`<!DOCTYPE html><html><head><title>${esc(this.title)}</title><style>
                    body{font-family:'Segoe UI',system-ui,sans-serif;color:#0f172a;margin:30px}
                    h1{font-size:20px;margin:0 0 4px} p{color:#64748b;font-size:12px;margin:0 0 18px}
                    table{width:100%;border-collapse:collapse;font-size:12px} th{background:#f1f5f9;text-align:left;text-transform:uppercase;font-size:10.5px;letter-spacing:.06em}
                    th,td{border:1px solid #e2e8f0;padding:7px 9px} tr:nth-child(even) td{background:#fafbfc}
                    </style></head><body><h1>${esc((document.body.dataset.site || '') + ' — ' + this.title)}</h1><p>Printed ${new Date().toLocaleString()} · ${body.length} records</p>
                    <table><thead><tr>${head.map(h => `<th>${esc(h)}</th>`).join('')}</tr></thead><tbody>${body.map(r => `<tr>${r.map(c => `<td>${esc(c)}</td>`).join('')}</tr>`).join('')}</tbody></table>
                    <script>window.onload=()=>{window.print();setTimeout(()=>window.close(),300)}<\/script></body></html>`);
                w.document.close();
            }
            if (x === 'fs') {
                const i = $('[data-x="fs"] i', this.el);
                if (document.fullscreenElement === this.el) document.exitFullscreen();
                else if (this.el.requestFullscreen) this.el.requestFullscreen().catch(() => this.el.classList.toggle('dt-fs-fallback'));
                else this.el.classList.toggle('dt-fs-fallback');
                document.addEventListener('fullscreenchange', () => { i.className = document.fullscreenElement === this.el ? 'fa-solid fa-compress' : 'fa-solid fa-expand'; }, { once: true });
            }
            if (x === 'density') setPref('density', prefs.density === 'compact' ? 'comfortable' : 'compact');
            if (x === 'striped') setPref('striped', !prefs.striped);
            if (x === 'reset') this.resetLayout();
        }
    }

    const tables = {};
    $$('.dt[data-dt]').forEach(el => { tables[el.dataset.dt] = new DataTable(el); });
    applyPrefs();
    // stat cards that filter a table
    $$('[data-dt-target]').forEach(c => c.addEventListener('click', () => tables[c.dataset.dtTarget]?.setFilter(c.dataset.filter || '')));
    window.apTables = tables;
})();
