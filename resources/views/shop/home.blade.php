@extends('layouts.app')
@section('title', 'Premium Offset & Digital Printing')

@section('content')
{{-- ================= HERO SLIDER ================= --}}
<section class="hero">
    <div class="hero-bg"><div class="grid"></div><div class="blob b1"></div><div class="blob b2"></div><div class="blob b3"></div></div>
    <div class="slides">
        @php
            $slides = [
                ['eyebrow' => 'Trusted by 5,000+ businesses', 'h' => 'Print that makes your <span class="hl">brand unforgettable</span>', 'p' => 'Visiting cards, flyers, banners, stationery & signage — premium quality offset and digital printing delivered fast to your doorstep.', 'a1' => ['Explore Products', route('shop')], 'a2' => ['Get Free Quote', route('quote')], 'v1' => ['card', '#5b21b6', 'Patel Offset'], 'v2' => ['flyer', '#ec4899', 'Mega Sale'], 'chip1' => ['fa-solid fa-truck-fast', '#06b6d4', 'Fast Delivery', '24-48 hrs express'], 'chip2' => ['fa-solid fa-star', '#f59e0b', '4.9 / 5 Rating', '2,000+ reviews']],
                ['eyebrow' => 'Luxury finishes available', 'h' => 'Gold foil, velvet & <span class="hl">metal visiting cards</span>', 'p' => 'Make every handshake count with thick 800 GSM boards, real foil stamping, spot UV and die-cut shapes that people keep.', 'a1' => ['Shop Visiting Cards', route('category', 'visiting-cards')], 'a2' => ['Talk to Designer', 'https://wa.me/'.config('site.whatsapp')], 'v1' => ['card', '#1c1917', 'Royal Gold'], 'v2' => ['invite', '#9f1239', 'Wedding'], 'chip1' => ['fa-solid fa-gem', '#ec4899', 'Premium Finish', 'Foil · UV · Velvet'], 'chip2' => ['fa-solid fa-pen-nib', '#7c3aed', 'Free Design Help', 'By expert team']],
                ['eyebrow' => 'Big format · Same day print', 'h' => 'Flex, standees & <span class="hl">signage that sells</span>', 'p' => 'High-resolution solvent & eco-solvent prints for shop boards, events and exhibitions. Weather resistant, colour rich, ready fast.', 'a1' => ['Shop Flex & Banners', route('category', 'flex-banners')], 'a2' => ['Request Quote', route('quote')], 'v1' => ['banner', '#ea580c', 'Grand Sale'], 'v2' => ['standee', '#7c3aed', 'Expo 2026'], 'chip1' => ['fa-solid fa-ruler-combined', '#16a34a', 'Any Size', 'Custom dimensions'], 'chip2' => ['fa-solid fa-shield-halved', '#06b6d4', 'Secure Payment', 'Razorpay protected']],
            ];
        @endphp
        @foreach($slides as $i => $s)
            <div class="slide {{ $i === 0 ? 'active' : '' }}">
                <div class="container">
                    <div>
                        <span class="eyebrow anim"><span class="dot"></span>{{ $s['eyebrow'] }}</span>
                        <h1 class="anim">{!! $s['h'] !!}</h1>
                        <p class="lead anim">{{ $s['p'] }}</p>
                        <div class="actions anim">
                            <a href="{{ $s['a1'][1] }}" class="btn">{{ $s['a1'][0] }} <i class="fa-solid fa-arrow-right"></i></a>
                            <a href="{{ $s['a2'][1] }}" class="btn btn-light">{{ $s['a2'][0] }}</a>
                        </div>
                        <div class="stats-mini anim">
                            <div><strong>15+</strong><span>Years Experience</span></div>
                            <div><strong>50K+</strong><span>Orders Delivered</span></div>
                            <div><strong>200+</strong><span>Print Products</span></div>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <div class="card3d v1"><x-mockup :art="$s['v1'][0]" :color="$s['v1'][1]" :title="$s['v1'][2]"/></div>
                        <div class="card3d v2"><x-mockup :art="$s['v2'][0]" :color="$s['v2'][1]" :title="$s['v2'][2]"/></div>
                        <div class="chip c1"><i class="{{ $s['chip1'][0] }}" style="background:{{ $s['chip1'][1] }}"></i><div><b>{{ $s['chip1'][2] }}</b>{{ $s['chip1'][3] }}</div></div>
                        <div class="chip c2"><i class="{{ $s['chip2'][0] }}" style="background:{{ $s['chip2'][1] }}"></i><div><b>{{ $s['chip2'][2] }}</b>{{ $s['chip2'][3] }}</div></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="slider-arrow prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="slider-arrow next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
    <div class="slider-dots">@foreach($slides as $i => $s)<button class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>@endforeach</div>
</section>

{{-- ================= MARQUEE ================= --}}
<div class="marquee">
    <div class="marquee-track">
        @for($r = 0; $r < 2; $r++)
            @foreach(['Visiting Cards', 'Flyers & Brochures', 'Flex Banners', 'Letterheads', 'Stickers & Labels', 'Standees', 'Wedding Cards', 'Bill Books', 'ID Cards'] as $m)
                <span><i class="fa-solid fa-star-of-life"></i>{{ $m }}</span>
            @endforeach
        @endfor
    </div>
</div>

{{-- ================= CATEGORIES ================= --}}
<section class="section">
    <div class="container">
        <div class="section-head" data-reveal="up">
            <div class="kicker">What we print</div>
            <h2>Shop by <span class="text-grad">Category</span></h2>
            <p>Everything your business needs to look professional — designed, printed and delivered by one trusted partner.</p>
        </div>
        <div class="cat-grid" data-stagger>
            @foreach($categories as $c)
                <a href="{{ route('category', $c) }}" class="cat-card" style="--c: {{ $c->color }}">
                    <div class="art"><x-mockup :art="$c->art" :color="$c->color" :title="$c->name" :image="$c->image"/></div>
                    <div class="body">
                        <span class="ico"><i class="{{ $c->icon }}"></i></span>
                        <div><h3>{{ $c->name }}</h3><small>{{ $c->active_products_count }} products</small></div>
                        <span class="go"><i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= PRODUCT TABS ================= --}}
<section class="section section-soft" data-tabs>
    <div class="container">
        <div class="head-row">
            <div class="section-head left" data-reveal="left">
                <div class="kicker">Our collection</div>
                <h2>Trending <span class="text-grad">Products</span></h2>
            </div>
            <div class="tabs" data-reveal="right">
                <button class="tab-btn active" data-tab="t-new"><i class="fa-solid fa-sparkles"></i>New Arrival</button>
                <button class="tab-btn" data-tab="t-best"><i class="fa-solid fa-trophy"></i>Bestseller</button>
                <button class="tab-btn" data-tab="t-hot"><i class="fa-solid fa-fire"></i>Hot Products</button>
            </div>
        </div>
        @foreach(['t-new' => $newArrivals, 't-best' => $bestsellers, 't-hot' => $hot] as $id => $list)
            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $id }}">
                <div class="carousel" data-carousel>
                    <div class="carousel-track">
                        @foreach($list as $p) @include('partials.product-card') @endforeach
                    </div>
                    <div class="carousel-nav" style="justify-content:center">
                        <button data-prev aria-label="Previous"><i class="fa-solid fa-arrow-left"></i></button>
                        <button data-next aria-label="Next"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= HOW IT WORKS ================= --}}
<section class="section section-dark">
    <div class="container">
        <div class="section-head" data-reveal="up">
            <div class="kicker">Simple process</div>
            <h2>From idea to print in <span class="text-grad">4 easy steps</span></h2>
            <p>Order online in minutes. We take care of design checks, printing, finishing and delivery.</p>
        </div>
        <div class="steps" data-stagger>
            <div class="step"><div class="num"><i class="fa-solid fa-hand-pointer"></i></div><h4>Choose Product</h4><p>Pick a product, finish and quantity with instant transparent pricing.</p></div>
            <div class="step"><div class="num"><i class="fa-solid fa-cloud-arrow-up"></i></div><h4>Upload Design</h4><p>Upload your file or let our designers create one for you.</p></div>
            <div class="step"><div class="num"><i class="fa-solid fa-credit-card"></i></div><h4>Pay Securely</h4><p>UPI, cards, net banking & wallets via Razorpay.</p></div>
            <div class="step"><div class="num"><i class="fa-solid fa-truck-fast"></i></div><h4>Fast Delivery</h4><p>Printed with care and shipped to your doorstep, all over India.</p></div>
        </div>
        <div class="counters">
            <div class="counter"><strong data-count="15" data-suffix="+">0</strong><span>Years of Printing</span></div>
            <div class="counter"><strong data-count="50000" data-suffix="+">0</strong><span>Orders Delivered</span></div>
            <div class="counter"><strong data-count="5000" data-suffix="+">0</strong><span>Happy Businesses</span></div>
            <div class="counter"><strong data-count="99" data-suffix="%">0</strong><span>On-time Dispatch</span></div>
        </div>
    </div>
</section>

{{-- ================= FEATURED ================= --}}
<section class="section">
    <div class="container">
        <div class="head-row">
            <div class="section-head left" data-reveal="left">
                <div class="kicker">Hand-picked</div>
                <h2>Featured <span class="text-grad">Products</span></h2>
            </div>
            <a href="{{ route('shop', ['filter' => 'featured']) }}" class="btn btn-outline" data-reveal="right">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="product-grid" data-stagger>
            @foreach($featured as $p) @include('partials.product-card') @endforeach
        </div>
    </div>
</section>

{{-- ================= WHY US ================= --}}
<section class="section section-soft">
    <div class="container feature-wrap">
        <div class="feature-visual" data-reveal="left">
            <div class="big"><x-mockup art="letterhead" color="#5b21b6" title="Patel Offset"/></div>
            <div class="float-card f1"><i class="fa-solid fa-award"></i><div><b>ISO Grade Quality</b><small>Heidelberg offset press</small></div></div>
            <div class="float-card f2"><i class="fa-solid fa-leaf"></i><div><b>Eco Inks</b><small>Safe &amp; vibrant</small></div></div>
        </div>
        <div data-reveal="right">
            <div class="kicker">Why choose us</div>
            <h2 style="font-size:clamp(30px,4vw,44px)">Printing excellence you can <span class="text-grad">see and feel</span></h2>
            <p class="muted">For over 15 years we have helped shops, startups, schools and corporates look their best on paper. Modern machines, skilled craftsmen and honest pricing.</p>
            <div class="feature-list">
                <div class="feature" style="--c:#7c3aed"><i class="fa-solid fa-palette"></i><h4>True Colour Match</h4><p>Calibrated CMYK workflow for colours exactly as designed.</p></div>
                <div class="feature" style="--c:#ec4899"><i class="fa-solid fa-pen-ruler"></i><h4>Free Design Check</h4><p>Every file is checked for bleed, resolution and spelling.</p></div>
                <div class="feature" style="--c:#06b6d4"><i class="fa-solid fa-bolt"></i><h4>Express Printing</h4><p>Urgent orders printed and dispatched within 24 hours.</p></div>
                <div class="feature" style="--c:#f59e0b"><i class="fa-solid fa-indian-rupee-sign"></i><h4>Best Price</h4><p>Bulk discounts and transparent pricing — no hidden charges.</p></div>
            </div>
        </div>
    </div>
</section>

{{-- ================= TESTIMONIALS ================= --}}
<section class="section">
    <div class="container">
        <div class="section-head" data-reveal="up">
            <div class="kicker">Testimonials</div>
            <h2>Loved by <span class="text-grad">our customers</span></h2>
        </div>
        <div class="testi-grid" data-stagger>
            @foreach($reviews as $r)
                <div class="testi">
                    <div class="stars" style="font-size:16px;margin-bottom:12px">★★★★★</div>
                    <p>{{ $r->comment }}</p>
                    <div class="who"><span class="avatar">{{ strtoupper(substr($r->name, 0, 1)) }}</span><div><b>{{ $r->name }}</b><small>Ordered {{ $r->product->name ?? '' }}</small></div></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= BRANDS ================= --}}
<section class="section-sm" style="border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:#fff">
    <div class="container">
        <p class="center muted" style="font-weight:700;letter-spacing:.15em;text-transform:uppercase;font-size:13px;margin-bottom:24px">Join the league of brands that trust us</p>
        <div class="brands">
            <div class="marquee-track">
                @for($r = 0; $r < 2; $r++)
                    @foreach([['fa-solid fa-mountain-sun', 'Shivam Group'], ['fa-solid fa-leaf', 'GreenKart'], ['fa-solid fa-gem', 'Royal Jewels'], ['fa-solid fa-utensils', 'Spice Route'], ['fa-solid fa-dumbbell', 'FitZone'], ['fa-solid fa-graduation-cap', 'Bright School'], ['fa-solid fa-car', 'AutoHub'], ['fa-solid fa-mug-hot', 'Chai Point']] as [$ic, $b])
                        <span class="brand"><i class="{{ $ic }}"></i>{{ $b }}</span>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="section">
    <div class="container">
        <div class="cta" data-reveal="zoom">
            <div style="position:relative;z-index:2">
                <h2>Have a bulk or custom printing requirement?</h2>
                <p>Share your requirement and get the best quote within 30 minutes. Call, WhatsApp or email — we are always here to help.</p>
            </div>
            <div class="actions">
                <a href="{{ route('quote') }}" class="btn btn-light"><i class="fa-solid fa-file-invoice"></i> Get Quote</a>
                <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                <a href="tel:{{ config('site.phone') }}" class="btn btn-dark"><i class="fa-solid fa-phone"></i> Call Now</a>
            </div>
        </div>
    </div>
</section>
@endsection
