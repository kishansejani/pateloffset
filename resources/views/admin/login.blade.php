<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | {{ config('site.name') }}</title>
    <script>try{const p=JSON.parse(localStorage.getItem('ap.prefs')||'{}');document.documentElement.dataset.theme=p.theme||'light';document.documentElement.dataset.accent=p.accent||'violet';}catch(e){}</script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="ap">
<div class="ap-login">
    <div class="ap-login-art">
        <span class="orb" style="width:340px;height:340px;background:#7c3aed;top:-80px;right:-60px"></span>
        <span class="orb" style="width:260px;height:260px;background:#ec4899;bottom:-60px;left:10%;animation-delay:-3s"></span>
        <a href="{{ route('home') }}" class="ap-brand" style="padding:0;position:relative"><span class="mark">P</span><div><b>Patel Offset</b><small>Admin Console</small></div></a>
        <div style="position:relative">
            <h2>Run your print shop from one beautiful console.</h2>
            <p>Orders, payments, quotes, products and categories — all in one place, on desktop or mobile.</p>
            <div style="display:flex;gap:26px;margin-top:28px;flex-wrap:wrap">
                <span><i class="fa-solid fa-chart-line"></i>&nbsp; Live dashboard</span>
                <span><i class="fa-solid fa-table"></i>&nbsp; Smart tables</span>
                <span><i class="fa-solid fa-file-export"></i>&nbsp; Excel / PDF</span>
            </div>
        </div>
        <small style="position:relative;opacity:.6">© {{ date('Y') }} {{ config('site.name') }}</small>
    </div>
    <div class="ap-login-form">
        <form method="POST" class="ap-card ap-card-pad" style="padding:36px">
            @csrf
            <span class="ap-head-ic" style="margin-bottom:22px"><i class="fa-solid fa-lock" style="color:var(--ac)"></i></span>
            <h1>Welcome back</h1>
            <p class="muted" style="margin-bottom:24px">Sign in to manage orders and products.</p>
            @error('email')<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            <div class="field" style="margin-bottom:16px"><label for="email">Email</label><input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
            <div class="field" style="margin-bottom:16px;position:relative"><label for="password">Password</label><input id="password" class="input" type="password" name="password" required autocomplete="current-password" style="padding-right:48px">
                <button type="button" onclick="const i=document.getElementById('password');i.type=i.type==='password'?'text':'password';this.firstElementChild.className=i.type==='password'?'fa-regular fa-eye':'fa-regular fa-eye-slash'" style="position:absolute;right:8px;bottom:6px;border:0;background:none;color:var(--ap-muted);cursor:pointer;padding:8px" aria-label="Show password"><i class="fa-regular fa-eye"></i></button></div>
            <label class="sw" style="margin-bottom:22px"><input type="checkbox" name="remember"><span class="tr"></span>Remember me</label>
            <button class="ap-btn dark" style="width:100%;justify-content:center;height:52px">Sign in <i class="fa-solid fa-arrow-right"></i></button>
            <a href="{{ route('home') }}" class="muted" style="display:block;text-align:center;margin-top:18px;font-size:14px"><i class="fa-solid fa-arrow-left"></i> Back to website</a>
        </form>
    </div>
</div>
</body>
</html>
