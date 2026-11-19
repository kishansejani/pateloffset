@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
@php $s = config('site'); @endphp
@include('partials.page-hero', ['title' => 'Let\'s <span class="text-grad">Talk Print</span>', 'sub' => 'Call, WhatsApp, email or visit us — we usually respond within minutes during business hours.', 'crumbs' => ['Contact' => null]])

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="contact-cards" data-stagger>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $s['phone']) }}" class="contact-card" style="--c:var(--primary-2)"><i class="fa-solid fa-phone-volume"></i><h4>Call Us</h4><p>{{ $s['phone'] }}</p></a>
            <a href="https://wa.me/{{ $s['whatsapp'] }}?text={{ rawurlencode('Hello Patel Offset!') }}" target="_blank" rel="noopener" class="contact-card" style="--c:#25d366"><i class="fa-brands fa-whatsapp"></i><h4>WhatsApp</h4><p>Chat instantly</p></a>
            <a href="mailto:{{ $s['email'] }}" class="contact-card" style="--c:var(--orange)"><i class="fa-solid fa-envelope-open-text"></i><h4>Email Us</h4><p>{{ $s['email'] }}</p></a>
            <div class="contact-card" style="--c:var(--magenta)"><i class="fa-solid fa-location-dot"></i><h4>Visit Us</h4><p>{{ $s['address'] }}</p></div>
        </div>

        <div class="feature-wrap" style="margin-top:70px;align-items:stretch">
            <div class="box" data-reveal="left" style="margin:0">
                <div class="kicker">Send a message</div>
                <h2 style="font-size:32px">We'd love to hear from you</h2>
                @if($errors->any())<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $errors->first() }}</div>@endif
                <form method="POST" action="{{ route('inquiry') }}" class="form-grid">
                    @csrf
                    <input type="hidden" name="type" value="contact">
                    <div class="field"><label>Name <span class="req">*</span></label><input class="input" name="name" value="{{ old('name') }}" required></div>
                    <div class="field"><label>Mobile <span class="req">*</span></label><input class="input" name="phone" value="{{ old('phone') }}" required inputmode="tel"></div>
                    <div class="field full"><label>Email</label><input class="input" type="email" name="email" value="{{ old('email') }}"></div>
                    <div class="field full"><label>Message <span class="req">*</span></label><textarea class="input" name="message" required>{{ old('message') }}</textarea></div>
                    <div class="full"><button class="btn"><i class="fa-solid fa-paper-plane"></i> Send Message</button></div>
                </form>
                <p class="muted" style="margin-top:20px"><i class="fa-regular fa-clock"></i> {{ $s['hours'] }}</p>
            </div>
            <div class="map" data-reveal="right"><iframe src="{{ $s['map'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe></div>
        </div>
    </div>
</section>
@endsection
