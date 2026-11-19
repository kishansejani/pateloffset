@extends('layouts.app')
@section('title', 'About Us')

@section('content')
@include('partials.page-hero', ['title' => 'About <span class="text-grad">Patel Offset</span>', 'sub' => 'Over 15 years of printing excellence — from a small offset press to a complete branding & printing studio.', 'crumbs' => ['About' => null]])

<section class="section">
    <div class="container feature-wrap">
        <div class="feature-visual" data-reveal="left">
            <div class="big"><x-mockup art="brochure" color="#5b21b6" title="Patel Offset"/></div>
            <div class="float-card f1"><i class="fa-solid fa-users"></i><div><b>5,000+ Clients</b><small>Across India</small></div></div>
            <div class="float-card f2"><i class="fa-solid fa-print"></i><div><b>Modern Machines</b><small>Offset + Digital</small></div></div>
        </div>
        <div data-reveal="right">
            <div class="kicker">Our story</div>
            <h2 style="font-size:clamp(30px,4vw,42px)">We print your <span class="text-grad">brand's first impression</span></h2>
            <p class="muted">Patel Offset started with one goal: deliver print quality that big brands get, at prices every small business can afford. Today we serve shops, startups, schools, hospitals, political campaigns and corporates with a full range of printing products.</p>
            <p class="muted">Our in-house design team, multi-colour offset press, digital presses and large-format machines let us handle everything from 100 visiting cards to 1,00,000 flyers — with the same care.</p>
            <ul class="check-list" style="margin:20px 0 28px">
                <li><i class="fa-solid fa-circle-check"></i>Multi-colour offset &amp; high-speed digital printing</li>
                <li><i class="fa-solid fa-circle-check"></i>In-house finishing: lamination, foil, UV, die-cut, binding</li>
                <li><i class="fa-solid fa-circle-check"></i>Pan-India delivery with secure packaging</li>
            </ul>
            <a href="{{ route('contact') }}" class="btn">Contact Us <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="section section-dark">
    <div class="container">
        <div class="counters" style="margin-top:0;padding-top:0;border:0">
            <div class="counter"><strong data-count="15" data-suffix="+">0</strong><span>Years Experience</span></div>
            <div class="counter"><strong data-count="50000" data-suffix="+">0</strong><span>Orders Delivered</span></div>
            <div class="counter"><strong data-count="200" data-suffix="+">0</strong><span>Print Products</span></div>
            <div class="counter"><strong data-count="25" data-suffix="+">0</strong><span>Team Members</span></div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head" data-reveal="up"><div class="kicker">Our values</div><h2>What drives <span class="text-grad">us</span></h2></div>
        <div class="feature-list" style="grid-template-columns:repeat(4,1fr)" data-stagger>
            <div class="feature" style="--c:#7c3aed"><i class="fa-solid fa-gem"></i><h4>Quality First</h4><p>Every sheet is checked before it leaves our press.</p></div>
            <div class="feature" style="--c:#ec4899"><i class="fa-solid fa-handshake"></i><h4>Honest Pricing</h4><p>Clear rates, no hidden costs, ever.</p></div>
            <div class="feature" style="--c:#06b6d4"><i class="fa-solid fa-clock"></i><h4>On-Time</h4><p>Deadlines are promises we keep.</p></div>
            <div class="feature" style="--c:#f59e0b"><i class="fa-solid fa-heart"></i><h4>Customer Love</h4><p>Support on call &amp; WhatsApp, always.</p></div>
        </div>
    </div>
</section>
@push('head')<style>@media(max-width:900px){.feature-list[style*="repeat(4"]{grid-template-columns:1fr 1fr!important}}</style>@endpush
@endsection
