/* Patel Offset — interactions & animations (no dependencies) */
(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const money = n => '₹' + Number(n).toLocaleString('en-IN', { maximumFractionDigits: 2 });

    // Preloader
    window.addEventListener('load', () => setTimeout(() => $('#preloader')?.classList.add('done'), 350));
    setTimeout(() => $('#preloader')?.classList.add('done'), 1800);

    // Sticky header + back to top
    const header = $('.header'), toTop = $('.to-top');
    const onScroll = () => {
        header?.classList.toggle('scrolled', scrollY > 40);
        toTop?.classList.toggle('show', scrollY > 600);
    };
    addEventListener('scroll', onScroll, { passive: true }); onScroll();
    toTop?.addEventListener('click', () => scrollTo({ top: 0 }));

    // Mobile nav
    const nav = $('.nav'), backdrop = $('.nav-backdrop');
    $('.menu-toggle')?.addEventListener('click', () => { nav.classList.add('open'); backdrop.classList.add('open'); });
    backdrop?.addEventListener('click', () => { nav.classList.remove('open'); backdrop.classList.remove('open'); });
    $$('.nav li.has-mega > .nav-link').forEach(a => a.addEventListener('click', e => {
        if (innerWidth <= 900) { e.preventDefault(); a.parentElement.classList.toggle('open'); }
    }));

    // Reveal on scroll
    const io = new IntersectionObserver(entries => entries.forEach(en => {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
    }), { threshold: .12, rootMargin: '0px 0px -40px 0px' });
    $$('[data-reveal]').forEach(el => io.observe(el));
    // auto-stagger children of [data-stagger]
    $$('[data-stagger]').forEach(g => [...g.children].forEach((c, i) => {
        c.setAttribute('data-reveal', c.dataset.reveal || 'up'); c.style.setProperty('--d', (i % 8) * 0.08 + 's'); io.observe(c);
    }));

    // Counters
    const cio = new IntersectionObserver(entries => entries.forEach(en => {
        if (!en.isIntersecting) return;
        const el = en.target, target = +el.dataset.count, suffix = el.dataset.suffix || '';
        const start = performance.now(), dur = 1800;
        const tick = now => {
            const p = Math.min((now - start) / dur, 1), e = 1 - Math.pow(1 - p, 4);
            el.textContent = Math.floor(target * e).toLocaleString('en-IN') + suffix;
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick); cio.unobserve(el);
    }), { threshold: .5 });
    $$('[data-count]').forEach(el => cio.observe(el));

    // Hero slider
    const slider = $('.hero');
    if (slider) {
        const slides = $$('.slide', slider), dots = $$('.slider-dots button', slider);
        let i = 0, timer;
        const go = n => {
            slides[i].classList.remove('active'); dots[i]?.classList.remove('active');
            i = (n + slides.length) % slides.length;
            slides[i].classList.add('active'); dots[i]?.classList.add('active');
        };
        const auto = () => { clearInterval(timer); timer = setInterval(() => go(i + 1), 6500); };
        dots.forEach((d, n) => d.addEventListener('click', () => { go(n); auto(); }));
        $('.slider-arrow.next', slider)?.addEventListener('click', () => { go(i + 1); auto(); });
        $('.slider-arrow.prev', slider)?.addEventListener('click', () => { go(i - 1); auto(); });
        auto();
        // parallax blobs on mouse
        slider.addEventListener('mousemove', e => {
            const x = (e.clientX / innerWidth - .5) * 30, y = (e.clientY / innerHeight - .5) * 30;
            $$('.hero-visual', slider).forEach(v => v.style.transform = `translate(${x}px, ${y}px)`);
        });
    }

    // Tabs
    $$('[data-tabs]').forEach(wrap => {
        const btns = $$('.tab-btn', wrap), panes = $$('.tab-pane', wrap);
        btns.forEach(b => b.addEventListener('click', () => {
            btns.forEach(x => x.classList.toggle('active', x === b));
            panes.forEach(p => p.classList.toggle('active', p.id === b.dataset.tab));
        }));
    });

    // Carousels
    $$('[data-carousel]').forEach(c => {
        const track = $('.carousel-track', c);
        const step = () => track.firstElementChild ? track.firstElementChild.offsetWidth + 24 : 300;
        $('[data-prev]', c)?.addEventListener('click', () => track.scrollBy({ left: -step() }));
        $('[data-next]', c)?.addEventListener('click', () => track.scrollBy({ left: step() }));
    });

    // 3D tilt on product cards
    if (matchMedia('(hover:hover)').matches) {
        $$('[data-tilt]').forEach(card => {
            card.addEventListener('mousemove', e => {
                const r = card.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = `perspective(900px) rotateY(${x * 8}deg) rotateX(${-y * 8}deg) translateY(-8px)`;
            });
            card.addEventListener('mouseleave', () => card.style.transform = '');
        });
    }

    // Button ripple
    document.addEventListener('click', e => {
        const b = e.target.closest('.btn'); if (!b) return;
        const r = b.getBoundingClientRect(), s = document.createElement('span'), size = Math.max(r.width, r.height);
        s.className = 'ripple'; s.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - r.left - size / 2}px;top:${e.clientY - r.top - size / 2}px`;
        b.appendChild(s); setTimeout(() => s.remove(), 700);
    });

    // Toasts
    $$('.toast').forEach(t => setTimeout(() => { t.classList.add('hide'); setTimeout(() => t.remove(), 500); }, 4500));

    // Modals
    $$('[data-modal]').forEach(b => b.addEventListener('click', e => { e.preventDefault(); $(b.dataset.modal)?.classList.add('open'); }));
    $$('.modal').forEach(m => m.addEventListener('click', e => { if (e.target === m || e.target.closest('.modal-close')) m.classList.remove('open'); }));
    document.addEventListener('keydown', e => e.key === 'Escape' && $$('.modal.open').forEach(m => m.classList.remove('open')));

    // Dropzone filename
    $$('.dropzone').forEach(dz => {
        const input = $('input[type=file]', dz), name = $('.fname', dz);
        input.addEventListener('change', () => { name.textContent = input.files[0]?.name || ''; });
        ['dragenter', 'dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('drag'); }));
        ['dragleave', 'drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('drag'); }));
        dz.addEventListener('drop', e => { input.files = e.dataTransfer.files; input.dispatchEvent(new Event('change')); });
    });

    // Product configurator — live price
    const form = $('#product-form');
    if (form) {
        const data = JSON.parse(form.dataset.product);
        const out = { total: $('#pf-total'), per: $('#pf-per'), mrp: $('#pf-mrp'), design: $('#pf-design') };
        const upload = $('#upload-box');
        const calc = () => {
            const qty = +($('input[name=quantity]:checked', form)?.value || 0);
            const tier = data.tiers.find(t => t.qty === qty); if (!tier) return;
            let extra = 0;
            (data.options || []).forEach(o => {
                const chosen = $(`input[name="options[${o.name}]"]:checked`, form)?.value;
                const v = o.values.find(v => v.label === chosen); if (v) extra += +(v.add || 0);
            });
            const designType = $('input[name=design_type]:checked', form)?.value;
            const designFee = designType === 'design_with_us' ? data.design_fee : 0;
            const total = tier.price + extra * qty + designFee;
            out.total.textContent = money(total);
            out.per.textContent = money((tier.price + extra * qty) / qty) + ' / unit';
            out.mrp.textContent = data.mrp && data.mrp * qty > tier.price ? money(data.mrp * qty + extra * qty + designFee) : '';
            out.design.textContent = designFee ? '+ ' + money(designFee) + ' design charge' : 'Inclusive of all printing';
            upload?.classList.toggle('hidden', designType !== 'upload');
            out.total.animate([{ transform: 'scale(1.15)', color: '#facc15' }, { transform: 'scale(1)', color: '#fff' }], { duration: 400 });
        };
        form.addEventListener('change', calc); calc();
        // which button submitted (buy now vs cart)
        $$('[name=buy_now]', form).forEach(b => b.addEventListener('click', () => form.dataset.buy = b.value));
    }

    // Gallery thumbs (switch art color variants)
    $$('.pd-thumbs button').forEach(b => b.addEventListener('click', () => {
        $$('.pd-thumbs button').forEach(x => x.classList.toggle('active', x === b));
        const main = $('.pd-main'); main.innerHTML = b.innerHTML;
        main.firstElementChild.animate([{ opacity: 0, transform: 'scale(.95)' }, { opacity: 1, transform: 'none' }], { duration: 450, easing: 'ease-out' });
    }));
})();
