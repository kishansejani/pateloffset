@php
    $site = config('site');
    $tel = 'tel:'.preg_replace('/[^0-9+]/', '', $site['phone']);
    $wa = 'https://wa.me/'.$site['whatsapp'].'?text='.rawurlencode('Hello '.$site['name'].', I want to know more about your printing services.');
    $mail = 'mailto:'.$site['email'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $site['tagline']) | {{ $site['name'] }}</title>
    <meta name="description" content="@yield('meta', 'Patel Offset — premium visiting cards, flyers, flex banners, stationery, stickers, signage & wedding cards printing with fast delivery across India.')">
    <meta name="theme-color" content="#0b1120">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='16' fill='%230b1120'/><text x='32' y='45' font-size='36' font-family='Arial' font-weight='900' text-anchor='middle' fill='%23ec4899'>P</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ filemtime(public_path('css/responsive.css')) }}">
    @stack('head')
</head>
<body>
<div id="preloader">
    <div>
        <div class="ink-drops"><span></span><span></span><span></span><span></span></div>
        <div class="preloader-text">PATEL OFFSET</div>
    </div>
</div>

<div class="toast-wrap">
    @if(session('success'))<div class="toast"><i class="fa-solid fa-circle-check"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="toast error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>@endif
</div>

<div class="topbar">
    <div class="container">
        <div class="topbar-left">
            <a href="{{ $tel }}"><i class="fa-solid fa-phone"></i>{{ $site['phone'] }}</a>
            <a href="{{ $mail }}" class="hide-sm"><i class="fa-solid fa-envelope"></i>{{ $site['email'] }}</a>
            <span class="hide-sm"><i class="fa-solid fa-clock"></i>{{ $site['hours'] }}</span>
        </div>
        <div class="topbar-right">
            <a href="{{ route('track') }}"><i class="fa-solid fa-truck-fast"></i>Track Order</a>
            <a href="{{ route('quote') }}"><i class="fa-solid fa-file-invoice"></i>Request Quote</a>
            <a href="{{ $wa }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i>WhatsApp</a>
        </div>
    </div>
</div>
<div class="cmyk-strip"></div>

<header class="header">
    <div class="container header-main">
        <button class="icon-btn menu-toggle" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-mark"></span>
            <span class="logo-text"><strong>Patel<span class="text-grad">Offset</span></strong><small>Print · Brand · Grow</small></span>
        </a>
        <form class="search" action="{{ route('shop') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search visiting cards, flyers, banners...">
            <button aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <div class="header-actions">
            <a href="{{ route('quote') }}" class="btn btn-sm btn-dark"><i class="fa-solid fa-bolt"></i> Get Quote</a>
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="icon-btn" aria-label="WhatsApp" style="color:#25d366"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="{{ route('cart') }}" class="icon-btn" aria-label="Cart"><i class="fa-solid fa-bag-shopping"></i><span class="count {{ session('cart_bumped') ? 'bump' : '' }}">{{ $cartCount }}</span></a>
        </div>
    </div>
    <nav class="nav">
        <div class="container">
            <ul>
                @foreach($navCategories as $c)
                    <li class="has-mega">
                        <a href="{{ route('category', $c) }}" class="nav-link" style="--c: {{ $c->color }}"><i class="{{ $c->icon }} cat-ico"></i>{{ $c->name }} <i class="fa-solid fa-chevron-down"></i></a>
                        <div class="mega">
                            <div class="container mega-inner">
                                <div>
                                    <div class="kicker">{{ $c->tagline }}</div>
                                    <div class="mega-links">
                                        @foreach($c->activeProducts as $p)
                                            <a href="{{ route('product', $p) }}"><i class="fa-solid fa-circle"></i>{{ $p->name }}</a>
                                        @endforeach
                                        <a href="{{ route('category', $c) }}" style="color:var(--primary);font-weight:700"><i class="fa-solid fa-arrow-right"></i>View all {{ $c->name }}</a>
                                    </div>
                                </div>
                                <div class="mega-promo">
                                    <x-mockup :art="$c->art" :color="$c->color" :title="$c->name" :image="$c->image"/>
                                    <div>
                                        <h4>{{ $c->name }}</h4>
                                        <p>{{ \Illuminate\Support\Str::limit($c->description, 80) }}</p>
                                        <a href="{{ route('category', $c) }}" class="btn btn-sm">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
<div class="nav-backdrop"></div>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="logo" style="margin-bottom:18px">
                    <span class="logo-mark"></span>
                    <span class="logo-text"><strong>Patel<span class="text-grad">Offset</span></strong><small>Print · Brand · Grow</small></span>
                </a>
                <p>Premium offset &amp; digital printing partner for businesses, shops and events. Sharp colours, perfect finishing and on-time delivery — every single order.</p>
                <div class="socials">
                    <a href="{{ $site['social']['facebook'] }}" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ $site['social']['instagram'] }}" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ $site['social']['youtube'] }}" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="{{ $site['social']['linkedin'] }}" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="{{ $wa }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('about') }}"><i class="fa-solid fa-chevron-right"></i>About Us</a></li>
                    <li><a href="{{ route('shop') }}"><i class="fa-solid fa-chevron-right"></i>All Products</a></li>
                    <li><a href="{{ route('track') }}"><i class="fa-solid fa-chevron-right"></i>My Order</a></li>
                    <li><a href="{{ route('quote') }}"><i class="fa-solid fa-chevron-right"></i>Request Quote</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fa-solid fa-chevron-right"></i>Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="{{ route('policy', 'returns') }}"><i class="fa-solid fa-chevron-right"></i>Returns &amp; Exchanges</a></li>
                    <li><a href="{{ route('policy', 'privacy') }}"><i class="fa-solid fa-chevron-right"></i>Privacy Policy</a></li>
                    <li><a href="{{ route('policy', 'shipping') }}"><i class="fa-solid fa-chevron-right"></i>Shipping &amp; Delivery</a></li>
                    <li><a href="{{ route('policy', 'terms') }}"><i class="fa-solid fa-chevron-right"></i>Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('policy', 'cancellation') }}"><i class="fa-solid fa-chevron-right"></i>Cancellation Policy</a></li>
                </ul>
            </div>
            <div>
                <h4>Get In Touch</h4>
                <ul class="footer-contact">
                    <li><i class="fa-solid fa-location-dot"></i><span>{{ $site['address'] }}</span></li>
                    <li><i class="fa-solid fa-phone"></i><a href="{{ $tel }}">{{ $site['phone'] }}</a></li>
                    <li><i class="fa-brands fa-whatsapp"></i><a href="{{ $wa }}" target="_blank" rel="noopener">Chat on WhatsApp</a></li>
                    <li><i class="fa-solid fa-envelope"></i><a href="{{ $mail }}">{{ $site['email'] }}</a></li>
                </ul>
                <form class="newsletter" method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Your email for offers" required>
                    <button>Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ $site['name'] }}. All rights reserved.</span>
            <span class="pay"><i class="fa-brands fa-cc-visa"></i><i class="fa-brands fa-cc-mastercard"></i><i class="fa-brands fa-google-pay"></i><i class="fa-solid fa-building-columns"></i></span>
        </div>
    </div>
</footer>

<div class="float-actions">
    <button class="to-top" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
    <a href="{{ $mail }}" class="fab mail" aria-label="Email us"><i class="fa-solid fa-envelope"></i><span class="tip">Email us</span></a>
    <a href="{{ $tel }}" class="fab call" aria-label="Call us"><i class="fa-solid fa-phone"></i><span class="tip">Call {{ $site['phone'] }}</span></a>
    <a href="{{ $wa }}" target="_blank" rel="noopener" class="fab wa" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i><span class="tip">Chat on WhatsApp</span></a>
</div>

<script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
@stack('scripts')
</body>
</html>
