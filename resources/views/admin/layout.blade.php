@php
    $me = auth()->user();
    $initials = collect(explode(' ', $me->name ?? 'Admin'))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') ?: 'A';
    $menu = [
        'overview' => ['Overview', [
            ['dashboard', 'Dashboard', 'fa-solid fa-table-cells-large', route('admin.dashboard'), 'admin.dashboard', null],
        ]],
        'sales' => ['Sales', [
            ['orders', 'Orders', 'fa-solid fa-cart-shopping', route('admin.orders.index'), 'admin.orders.*', $adminBadges['orders'] ?: null],
            ['inquiries', 'Inquiries', 'fa-solid fa-inbox', route('admin.inquiries.index'), 'admin.inquiries.*', $adminBadges['inquiries'] ?: null],
        ]],
        'catalog' => ['Catalog', [
            ['categories', 'Categories', 'fa-solid fa-layer-group', route('admin.categories.index'), 'admin.categories.*', null],
            ['products', 'Products', 'fa-solid fa-cube', route('admin.products.index'), 'admin.products.*', null],
        ]],
        'storefront' => ['Storefront', [
            ['website', 'View Website', 'fa-solid fa-globe', route('home'), null, null],
            ['shop', 'Shop Page', 'fa-solid fa-store', route('shop'), null, null],
        ]],
    ];
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Admin · {{ config('site.name') }}</title>
    <script>try{const p=JSON.parse(localStorage.getItem('ap.prefs')||'{}');document.documentElement.dataset.theme=p.theme||'light';document.documentElement.dataset.accent=p.accent||'violet';}catch(e){}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    @stack('head')
</head>
<body class="ap" data-site="{{ config('site.name') }}">
<div class="toast-wrap">
    @if(session('success'))<div class="toast"><i class="fa-solid fa-circle-check"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="toast error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>@endif
</div>

<div class="ap-shell">
    {{-- ================= SIDEBAR ================= --}}
    <aside class="ap-side" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="ap-brand">
            <span class="mark">P</span>
            <div><b>Patel Offset</b><small>Admin Console</small></div>
        </a>
        <div class="ap-filter"><i class="fa-solid fa-magnifying-glass"></i><input id="apMenuFilter" type="search" placeholder="Filter menu..." aria-label="Filter menu"></div>
        <nav class="ap-nav">
            @foreach($menu as $gk => [$glabel, $links])
                <div class="ap-group" data-group="{{ $gk }}">
                    <button type="button" class="ap-group-head"><span>{{ $glabel }}</span><i class="fa-solid fa-chevron-down"></i></button>
                    <div class="ap-group-items">
                        @foreach($links as [$id, $label, $icon, $url, $pattern, $badge])
                            <a href="{{ $url }}" class="ap-link {{ $pattern && request()->routeIs($pattern) ? 'active' : '' }}" data-id="{{ $id }}" data-label="{{ $label }}" @if(! $pattern) target="_blank" rel="noopener" @endif>
                                <i class="{{ $icon }}"></i><span>{{ $label }}</span>
                                @if($badge)<em class="ap-badge {{ $id === 'inquiries' ? 'pink' : '' }}">{{ $badge }}</em>@endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="ap-group" data-group="system">
                <button type="button" class="ap-group-head"><span>System</span><i class="fa-solid fa-chevron-down"></i></button>
                <div class="ap-group-items">
                    <a href="#" class="ap-link" data-id="customize" data-label="Customize menu" data-open-menu-editor><i class="fa-solid fa-sliders"></i><span>Customize menu</span></a>
                </div>
            </div>
        </nav>
        <div class="ap-side-foot">
            <div class="ap-user">
                <span class="ap-avatar">{{ strtoupper($initials) }}</span>
                <div class="who"><b>{{ $me->name }}</b><small>Super Admin</small></div>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button title="Logout" aria-label="Logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></button></form>
            </div>
        </div>
    </aside>
    <div class="ap-backdrop"></div>

    {{-- ================= MAIN ================= --}}
    <div class="ap-main">
        <header class="ap-top">
            <button type="button" class="ap-icon-btn" id="apSideToggle" aria-label="Toggle sidebar"><i class="fa-solid fa-table-columns"></i></button>
            <nav class="ap-crumbs" aria-label="Breadcrumb">
                <a href="{{ route('admin.dashboard') }}" class="home" aria-label="Dashboard"><i class="fa-solid fa-house"></i></a>
                @hasSection('crumb')<i class="fa-solid fa-chevron-right sep"></i><span class="mid">@yield('crumb')</span>@endif
                <i class="fa-solid fa-chevron-right sep"></i><span class="cur">@yield('title', 'Dashboard')</span>
            </nav>
            <div class="ap-top-right">
                <button type="button" class="ap-search" id="apSearchBtn" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i><span>Search or jump to...</span><kbd>Ctrl K</kbd></button>
                <button type="button" class="ap-icon-btn" id="apTheme" title="Toggle theme" aria-label="Toggle dark mode"><i class="fa-regular fa-sun"></i></button>
                <button type="button" class="ap-icon-btn" id="apFullscreen" title="Fullscreen" aria-label="Fullscreen"><i class="fa-solid fa-expand"></i></button>
                <div class="ap-dd">
                    @php $noteCount = $adminNotes['newOrders']->count() + $adminNotes['newInquiries']->count(); @endphp
                    <button type="button" class="ap-icon-btn" data-dd-toggle aria-label="Notifications"><i class="fa-regular fa-bell"></i>@if($noteCount)<span class="dot"></span>@endif</button>
                    <div class="ap-menu ap-notes">
                        <h6>Notifications</h6>
                        @foreach($adminNotes['newOrders'] as $o)
                            <a href="{{ route('admin.orders.show', $o) }}" class="ap-note"><span class="ic"><i class="fa-solid fa-cart-shopping"></i></span><span>New paid order #{{ $o->order_number }}<small>{{ $o->name }} · ₹{{ number_format($o->total) }} · {{ $o->created_at->diffForHumans() }}</small></span></a>
                        @endforeach
                        @foreach($adminNotes['newInquiries'] as $i)
                            <a href="{{ route('admin.inquiries.index') }}" class="ap-note"><span class="ic" style="background:rgba(236,72,153,.12);color:#ec4899"><i class="fa-solid fa-inbox"></i></span><span>{{ ucfirst($i->type) }} from {{ $i->name }}<small>{{ $i->product ?: 'General' }} · {{ $i->created_at->diffForHumans() }}</small></span></a>
                        @endforeach
                        @unless($noteCount)<p class="muted" style="padding:14px 12px;margin:0;font-size:14px"><i class="fa-regular fa-bell-slash"></i> You're all caught up.</p>@endunless
                    </div>
                </div>
                <div class="ap-dd">
                    <button type="button" class="ap-me" data-dd-toggle>
                        <span class="ap-avatar">{{ strtoupper($initials) }}</span>
                        <span class="who"><b>{{ $me->name }}</b><small>Super Admin</small></span>
                        <i class="fa-solid fa-chevron-down" style="font-size:11px;color:var(--ap-muted)"></i>
                    </button>
                    <div class="ap-menu">
                        <h6>{{ $me->email }}</h6>
                        <a href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe"></i>View website</a>
                        <a href="#" data-open-menu-editor><i class="fa-solid fa-sliders"></i>Customize menu</a>
                        <hr>
                        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="mi" style="color:#e11d48"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</button></form>
                    </div>
                </div>
            </div>
        </header>

        <main class="ap-content">
            <div class="ap-head">
                <span class="ap-head-ic"><i class="@yield('icon', 'fa-solid fa-table-cells-large')"></i></span>
                <div>
                    <h1>@yield('title', 'Dashboard')</h1>
                    @hasSection('subtitle')<p>@yield('subtitle')</p>@endif
                </div>
                @hasSection('actions')<div class="ap-head-actions">@yield('actions')</div>@endif
            </div>
            @yield('content')
        </main>
    </div>
</div>

{{-- quick actions for the command palette --}}
<div hidden>
    <a href="{{ route('admin.products.create') }}" data-cmd="Add new product" data-cmd-icon="fa-solid fa-plus"></a>
    <a href="{{ route('admin.categories.create') }}" data-cmd="Add new category" data-cmd-icon="fa-solid fa-folder-plus"></a>
</div>

{{-- Command palette --}}
<div class="ap-overlay" id="apCmd" role="dialog" aria-label="Search">
    <div class="ap-modal">
        <div class="cmd-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search pages and actions..." aria-label="Search pages and actions"><kbd>ESC</kbd></div>
        <div class="cmd-list"></div>
        <div class="cmd-foot"><span><kbd>↑</kbd> <kbd>↓</kbd> navigate</span><span><kbd>Enter</kbd> open</span><span><kbd>Ctrl K</kbd> toggle</span></div>
    </div>
</div>

{{-- Menu customizer --}}
<div class="ap-overlay" id="apMenuModal" role="dialog" aria-label="Customize menu">
    <div class="ap-modal" style="max-width:480px">
        <div class="ap-modal-head"><h3><i class="fa-solid fa-sliders" style="color:var(--ac)"></i> Customize menu</h3><button type="button" class="ap-icon-btn" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
        <div class="ap-modal-body"><p class="muted" style="font-size:14px;margin-top:0">Drag items to reorder them within a section. Switch off items you don't use.</p><div class="menu-sort"></div></div>
        <div class="ap-modal-foot"><button type="button" class="ap-btn sm" id="apMenuReset"><i class="fa-solid fa-rotate-left"></i>Reset</button><button type="button" class="ap-btn sm dark" id="apMenuSave"><i class="fa-solid fa-check"></i>Save layout</button></div>
    </div>
</div>

{{-- Confirm dialog --}}
<div class="ap-overlay" id="apConfirm" role="alertdialog" aria-label="Confirm">
    <div class="ap-modal" style="max-width:420px;text-align:center;padding:30px 26px">
        <div style="width:70px;height:70px;border-radius:50%;margin:0 auto 16px;display:grid;place-items:center;background:#fff1f2;color:#e11d48;font-size:28px"><i class="fa-regular fa-trash-can"></i></div>
        <h3 style="margin-bottom:6px">Are you sure?</h3>
        <p class="muted confirm-text" style="margin-bottom:22px"></p>
        <div style="display:flex;gap:10px;justify-content:center"><button type="button" class="ap-btn sm" data-close>Cancel</button><button type="button" class="ap-btn sm dark" id="apConfirmYes" style="background:#e11d48;color:#fff">Yes, delete</button></div>
    </div>
</div>

{{-- Settings drawer --}}
<button type="button" class="ap-fab" id="apFab" aria-label="Appearance settings"><i class="fa-solid fa-gear"></i></button>
<aside class="ap-drawer" id="apDrawer" aria-label="Appearance settings">
    <div class="ap-modal-head"><h3>Appearance</h3><button type="button" class="ap-icon-btn" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="ap-drawer-body">
        <h6>Theme</h6>
        <div class="seg"><button type="button" data-pref="theme" data-val="light"><i class="fa-regular fa-sun"></i>Light</button><button type="button" data-pref="theme" data-val="dark"><i class="fa-regular fa-moon"></i>Dark</button></div>
        <h6>Accent colour</h6>
        <div class="swatches">
            @foreach(['violet' => '#7c3aed', 'blue' => '#2563eb', 'emerald' => '#059669', 'rose' => '#e11d48', 'amber' => '#d97706'] as $k => $c)
                <button type="button" data-pref="accent" data-val="{{ $k }}" style="background:{{ $c }};--c:{{ $c }}" aria-label="{{ ucfirst($k) }}"></button>
            @endforeach
        </div>
        <h6>Sidebar</h6>
        <div class="seg"><button type="button" data-pref="collapsed" data-val="false"><i class="fa-solid fa-bars-staggered"></i>Expanded</button><button type="button" data-pref="collapsed" data-val="true"><i class="fa-solid fa-ellipsis-vertical"></i>Mini</button></div>
        <h6>Table rows</h6>
        <div class="seg"><button type="button" data-pref="density" data-val="comfortable"><i class="fa-solid fa-bars"></i>Comfortable</button><button type="button" data-pref="density" data-val="compact"><i class="fa-solid fa-align-justify"></i>Compact</button></div>
        <h6>Stripes</h6>
        <div class="seg"><button type="button" data-pref="striped" data-val="false">Plain</button><button type="button" data-pref="striped" data-val="true">Striped</button></div>
        <h6>Menu</h6>
        <button type="button" class="ap-btn sm" style="width:100%;justify-content:center" data-open-menu-editor><i class="fa-solid fa-grip-vertical"></i>Reorder &amp; hide menu items</button>
    </div>
</aside>

<script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}"></script>
@stack('scripts')
</body>
</html>
