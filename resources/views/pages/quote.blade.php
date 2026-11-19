@extends('layouts.app')
@section('title', 'Request a Quote')

@section('content')
@include('partials.page-hero', ['title' => 'Request a <span class="text-grad">Free Quote</span>', 'sub' => 'Bulk orders, custom sizes or special finishes — tell us what you need and get the best price within 30 minutes.', 'crumbs' => ['Request Quote' => null]])

<section class="section" style="padding-top:60px">
    <div class="container feature-wrap" style="align-items:start">
        <div class="box" data-reveal="left" style="margin:0">
            @if($errors->any())<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $errors->first() }}</div>@endif
            <form method="POST" action="{{ route('inquiry') }}" enctype="multipart/form-data" class="form-grid">
                @csrf
                <input type="hidden" name="type" value="quote">
                <div class="field"><label>Full Name <span class="req">*</span></label><input class="input" name="name" value="{{ old('name') }}" required></div>
                <div class="field"><label>Mobile <span class="req">*</span></label><input class="input" name="phone" value="{{ old('phone') }}" required inputmode="tel"></div>
                <div class="field full"><label>Email</label><input class="input" type="email" name="email" value="{{ old('email') }}"></div>
                <div class="field"><label>Product</label>
                    <select class="input" name="product">
                        <option value="">Select product / Other</option>
                        @foreach($products as $p)<option @selected(old('product', $selected) === $p)>{{ $p }}</option>@endforeach
                    </select>
                </div>
                <div class="field"><label>Quantity</label><input class="input" name="quantity" value="{{ old('quantity') }}" placeholder="e.g. 1000 pcs"></div>
                <div class="field full"><label>Requirement Details</label><textarea class="input" name="message" placeholder="Size, paper, finish, deadline...">{{ old('message') }}</textarea></div>
                <div class="field full">
                    <label class="dropzone">
                        <input type="file" name="attachment">
                        <i class="fa-solid fa-paperclip"></i>
                        <div><b>Attach reference / design (optional)</b></div>
                        <small class="muted">PDF, CDR, AI, PSD, JPG, PNG, ZIP — max 20 MB</small>
                        <span class="fname"></span>
                    </label>
                </div>
                <div class="full"><button class="btn btn-block"><i class="fa-solid fa-paper-plane"></i> Get My Quote</button></div>
            </form>
        </div>
        <div data-reveal="right">
            <div class="kicker">Why request a quote?</div>
            <h2 style="font-size:36px">Custom jobs, <span class="text-grad">best prices</span></h2>
            <div class="feature-list" style="grid-template-columns:1fr">
                <div class="feature" style="--c:#7c3aed"><i class="fa-solid fa-boxes-stacked"></i><h4>Bulk Discounts</h4><p>Special rates for large quantities and repeat orders.</p></div>
                <div class="feature" style="--c:#ec4899"><i class="fa-solid fa-ruler-combined"></i><h4>Any Size, Any Paper</h4><p>Custom dimensions, papers, foils, die-cuts and finishing.</p></div>
                <div class="feature" style="--c:#06b6d4"><i class="fa-solid fa-stopwatch"></i><h4>Reply in 30 Minutes</h4><p>Our team responds quickly by call or WhatsApp.</p></div>
            </div>
            <div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap">
                <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                <a href="tel:{{ config('site.phone') }}" class="btn btn-dark"><i class="fa-solid fa-phone"></i> {{ config('site.phone') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
