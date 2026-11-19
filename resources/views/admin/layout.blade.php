<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Admin · {{ config('site.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <style>
        body { background: #f1f5f9; }
        .adm { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }
        .adm-side { background: var(--ink); color: #94a3b8; padding: 24px 16px; position: sticky; top: 0; height: 100vh; }
        .adm-side .logo-text strong { color: #fff; }
        .adm-side nav { margin-top: 30px; display: grid; gap: 4px; }
        .adm-side nav a, .adm-side nav button { display: flex; gap: 12px; align-items: center; padding: 11px 14px; border-radius: 12px; font-weight: 600; font-size: 14px; color: #cbd5e1; background: none; border: 0; cursor: pointer; width: 100%; text-align: left; }
        .adm-side nav a:hover, .adm-side nav a.active { background: rgba(255,255,255,.08); color: #fff; }
        .adm-side nav a.active i { color: var(--magenta); }
        .adm-side nav i { width: 18px; }
        .adm-main { padding: 30px; min-width: 0; }
        .adm-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px; gap: 16px; flex-wrap: wrap; }
        .adm-top h1 { font-size: 28px; margin: 0; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 18px; margin-bottom: 26px; }
        .stat { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid var(--line); display: flex; gap: 16px; align-items: center; }
        .stat i { width: 50px; height: 50px; border-radius: 14px; display: grid; place-items: center; color: #fff; font-size: 20px; background: var(--c); }
        .stat b { display: block; font: 800 24px var(--font-head); color: var(--ink); }
        .stat span { font-size: 13px; color: var(--muted); }
        .card { background: #fff; border-radius: 18px; border: 1px solid var(--line); padding: 22px; margin-bottom: 22px; overflow-x: auto; }
        .card h3 { font-size: 18px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); padding: 10px 12px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; white-space: nowrap; }
        tr:hover td { background: #fafafa; }
        .tag { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; background: #f1f5f9; color: var(--ink-2); }
        .tag.paid, .tag.delivered, .tag.confirmed { background: #dcfce7; color: #166534; }
        .tag.failed, .tag.cancelled { background: #ffe4e6; color: #9f1239; }
        .tag.pending { background: #fef9c3; color: #854d0e; }
        .tag.printing, .tag.designing, .tag.shipped { background: #e0e7ff; color: #3730a3; }
        .filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; }
        .filters .input { width: auto; }
        .act { display: inline-grid; place-items: center; width: 34px; height: 34px; border-radius: 10px; background: #f1f5f9; border: 0; cursor: pointer; color: var(--ink); }
        .act:hover { background: var(--primary-soft); color: var(--primary); }
        .act.del:hover { background: #ffe4e6; color: var(--red); }
        @media (max-width: 900px) { .adm { grid-template-columns: 1fr; } .adm-side { position: static; height: auto; } .adm-main { padding: 18px; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ filemtime(public_path('css/responsive.css')) }}">
</head>
<body>
<div class="toast-wrap">
    @if(session('success'))<div class="toast"><i class="fa-solid fa-circle-check"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="toast error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>@endif
</div>
<div class="adm">
    <aside class="adm-side">
        <a href="{{ route('admin.dashboard') }}" class="logo"><span class="logo-mark"></span><span class="logo-text"><strong>Patel<span class="text-grad">Offset</span></strong><small>Admin Panel</small></span></a>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge-high"></i>Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fa-solid fa-receipt"></i>Orders</a>
            <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}"><i class="fa-solid fa-inbox"></i>Inquiries</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fa-solid fa-box"></i>Products</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i>Categories</a>
            <a href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe"></i>View Website</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button><i class="fa-solid fa-right-from-bracket"></i>Logout</button></form>
        </nav>
    </aside>
    <main class="adm-main">
        <div class="adm-top"><h1>@yield('title')</h1>@yield('actions')</div>
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
