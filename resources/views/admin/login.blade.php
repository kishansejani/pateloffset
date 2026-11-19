<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | {{ config('site.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body style="background:var(--ink);min-height:100vh;display:grid;place-items:center;padding:20px">
<div class="hero-bg" style="position:fixed"><div class="grid"></div><div class="blob b1"></div><div class="blob b2"></div></div>
<form method="POST" class="modal-box" style="transform:none;position:relative;max-width:420px">
    @csrf
    <a href="{{ route('home') }}" class="logo" style="margin-bottom:24px"><span class="logo-mark"></span><span class="logo-text"><strong>Patel<span class="text-grad">Offset</span></strong><small>Admin Panel</small></span></a>
    <h2 style="font-size:26px">Welcome back</h2>
    <p class="muted">Sign in to manage orders and products.</p>
    @error('email')<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
    <div class="field" style="margin-bottom:14px"><label>Email</label><input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus></div>
    <div class="field" style="margin-bottom:14px"><label>Password</label><input class="input" type="password" name="password" required></div>
    <label style="display:flex;gap:8px;align-items:center;margin-bottom:18px;font-size:14px"><input type="checkbox" name="remember"> Remember me</label>
    <button class="btn btn-block">Sign In <i class="fa-solid fa-arrow-right"></i></button>
</form>
</body>
</html>
