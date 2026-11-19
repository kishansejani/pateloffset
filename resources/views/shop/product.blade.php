@extends('layouts.app')
@section('title', $product->name)
@section('meta', $product->short_description)

@section('content')
@php
    $tiers = $product->tiers();
    $base = $tiers[0]['price'] / $tiers[0]['qty'];
    $rating = $product->rating();
    $count = $product->reviews->count();
    $waText = rawurlencode('Hi, I want to order "'.$product->name.'". Please share details. '.route('product', $product));
    $jsData = json_encode(['tiers' => $tiers, 'options' => $product->options ?? [], 'design_fee' => $product->design_fee, 'mrp' => $product->mrp_per_unit]);
    $variants = array_unique([$product->color, '#0b1120', '#ec4899', '#0891b2']);
@endphp

@include('partials.page-hero', [
    'title' => e($product->name),
    'crumbs' => ['Shop' => route('shop'), $product->category->name => route('category', $product->category), $product->name => null],
])

<section class="section" style="padding-top:60px">
    <div class="container">
        <div class="pd">
            {{-- Gallery --}}
            <div class="pd-gallery" data-reveal="left">
                <div class="pd-main">
                    <x-mockup :art="$product->art" :color="$product->color" :title="$product->name" :image="$product->image"/>
                </div>
                <div class="pd-thumbs">
                    @if($product->image)
                        <button type="button" class="active"><x-mockup :art="$product->art" :color="$product->color" :title="$product->name" :image="$product->image"/></button>
                    @endif
                    @foreach($variants as $i => $v)
                        <button type="button" class="{{ ! $product->image && $i === 0 ? 'active' : '' }}"><x-mockup :art="$product->art" :color="$v" :title="$product->name"/></button>
                    @endforeach
                </div>
            </div>

            {{-- Configurator --}}
            <div class="pd-info" data-reveal="right">
                <span class="pill"><i class="{{ $product->category->icon }}"></i>{{ $product->category->name }}</span>
                <h1 style="margin-top:14px">{{ $product->name }}</h1>
                <div class="pd-meta">
                    @if($count)<span><span class="stars" style="font-size:15px">★★★★★</span> <b style="color:var(--ink)">{{ $rating }}</b> ({{ $count }} reviews)</span>@endif
                    <span><i class="fa-regular fa-eye"></i> {{ $product->views }} views</span>
                    <span class="pill green"><i class="fa-solid fa-truck-fast"></i>Dispatch: {{ $product->dispatch_time }}</span>
                </div>

                @if($errors->any())
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $errors->first() }}</div>
                @endif

                <div class="box">
                    <h3><i class="fa-solid fa-list-check"></i>Product Highlights</h3>
                    <ul class="check-list">
                        @foreach($product->featureLines() as $f)<li><i class="fa-solid fa-circle-check"></i>{{ $f }}</li>@endforeach
                    </ul>
                </div>

                <form id="product-form" method="POST" action="{{ route('cart.add', $product) }}" enctype="multipart/form-data"
                      data-product="{{ $jsData }}">
                    @csrf
                    <div class="box">
                        <h3><i class="fa-solid fa-sliders"></i>Select Your Options</h3>
                        @foreach($product->options ?? [] as $opt)
                            <span class="opt-label">{{ $opt['name'] }}</span>
                            <div class="chips">
                                @foreach($opt['values'] as $v)
                                    <label class="chip-opt">
                                        <input type="radio" name="options[{{ $opt['name'] }}]" value="{{ $v['label'] }}" @checked(old('options.'.$opt['name'], $loop->first ? $v['label'] : null) === $v['label'])>
                                        <span>{{ $v['label'] }} @if($v['add'] > 0)<small>(+₹{{ $v['add'] }}/pc)</small>@endif</span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach

                        <span class="opt-label">Quantity &amp; Pricing</span>
                        <div class="tiers">
                            @foreach($tiers as $t)
                                @php $unit = $t['price'] / $t['qty']; $save = $loop->first ? 0 : round((1 - $unit / $base) * 100); @endphp
                                <label class="tier">
                                    <input type="radio" name="quantity" value="{{ $t['qty'] }}" @checked((int) old('quantity', $tiers[0]['qty']) === $t['qty'])>
                                    <span class="t">
                                        @if($save > 0)<span class="save">{{ $save }}% savings</span>@endif
                                        <b>{{ number_format($t['qty']) }}</b>
                                        <span class="p">₹{{ number_format($t['price']) }}</span>
                                        <small>₹{{ rtrim(rtrim(number_format($unit, 2), '0'), '.') }} / unit</small>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <span class="opt-label">Your Design</span>
                        <div class="design-opts">
                            <label><input type="radio" name="design_type" value="upload" @checked(old('design_type', 'upload') === 'upload')><span class="t"><i class="fa-solid fa-cloud-arrow-up"></i>I have a design</span></label>
                            <label><input type="radio" name="design_type" value="design_with_us" @checked(old('design_type') === 'design_with_us')><span class="t"><i class="fa-solid fa-pen-nib"></i>Design with us @if($product->design_fee)(₹{{ (int) $product->design_fee }})@else(Free)@endif</span></label>
                        </div>
                        <div id="upload-box">
                            <label class="dropzone">
                                <input type="file" name="design_file" accept=".pdf,.jpg,.jpeg,.png,.cdr,.ai,.psd,.zip,.eps">
                                <i class="fa-solid fa-file-arrow-up"></i>
                                <div><b>Click or drag your file here</b></div>
                                <small class="muted">PDF, CDR, AI, PSD, JPG, PNG, ZIP — up to 20 MB (optional, you can also send it on WhatsApp)</small>
                                <span class="fname"></span>
                            </label>
                        </div>
                    </div>

                    <div class="price-box">
                        <div>
                            <small>Total price</small>
                            <strong id="pf-total">₹{{ number_format($tiers[0]['price']) }}</strong><del id="pf-mrp"></del>
                            <div class="per" id="pf-per"></div>
                        </div>
                        <small id="pf-design" style="max-width:180px;text-align:right"></small>
                    </div>

                    <div class="pd-actions">
                        <button class="btn btn-dark" name="buy_now" value="0"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button class="btn" name="buy_now" value="1"><i class="fa-solid fa-bolt"></i> Buy Now</button>
                        <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ $waText }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                        <a href="#" class="btn btn-outline" data-modal="#inquiry-modal"><i class="fa-regular fa-envelope"></i> Inquiry</a>
                    </div>
                </form>

                <div class="trust-row">
                    <div><i class="fa-solid fa-shield-halved"></i>100% Secure Payment</div>
                    <div><i class="fa-solid fa-medal"></i>Premium Quality</div>
                    <div><i class="fa-solid fa-headset"></i>Expert Support</div>
                </div>
            </div>
        </div>

        {{-- Details tabs --}}
        <div class="detail-tabs" data-tabs>
            <div class="tabs" style="margin-bottom:24px">
                <button class="tab-btn active" data-tab="d-spec"><i class="fa-solid fa-ruler"></i>Specifications</button>
                <button class="tab-btn" data-tab="d-rev"><i class="fa-solid fa-star"></i>Reviews ({{ $count }})</button>
            </div>
            <div class="tab-pane active box" id="d-spec">
                <ul class="check-list">
                    @foreach($product->specLines() as $s)<li><i class="fa-solid fa-circle-dot" style="color:var(--primary-2)"></i>{{ $s }}</li>@endforeach
                    <li><i class="fa-solid fa-circle-dot" style="color:var(--primary-2)"></i>Dispatch time : {{ $product->dispatch_time }}</li>
                </ul>
            </div>
            <div class="tab-pane box" id="d-rev">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px" class="rev-grid">
                    <div>
                        <div class="rating-big">
                            <strong>{{ $rating ?: '—' }}</strong>
                            <div><div class="stars" style="font-size:20px">★★★★★</div><span class="muted">Based on {{ $count }} reviews</span></div>
                        </div>
                        @forelse($product->reviews as $r)
                            <div class="review">
                                <span class="avatar">{{ strtoupper(substr($r->name, 0, 1)) }}</span>
                                <div>
                                    <b style="color:var(--ink)">{{ $r->name }}</b> <span class="stars">{{ str_repeat('★', $r->rating) }}</span>
                                    <small class="muted" style="display:block">{{ $r->created_at->format('d M Y') }}</small>
                                    <p style="margin:6px 0 0">{{ $r->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="muted">No reviews yet. Be the first!</p>
                        @endforelse
                    </div>
                    <form method="POST" action="{{ route('product.review', $product) }}">
                        @csrf
                        <h3 style="font-size:20px">Write a Review</h3>
                        <div class="field" style="margin-bottom:14px">
                            <label>Your Rating</label>
                            <div class="star-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" @checked($i === 5)><label for="star{{ $i }}">★</label>
                                @endfor
                            </div>
                        </div>
                        <div class="field" style="margin-bottom:14px"><label>Name <span class="req">*</span></label><input class="input" name="name" required maxlength="80"></div>
                        <div class="field" style="margin-bottom:14px"><label>Review <span class="req">*</span></label><textarea class="input" name="comment" required maxlength="1000"></textarea></div>
                        <button class="btn">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related --}}
<section class="section section-soft">
    <div class="container">
        <div class="head-row">
            <div class="section-head left" data-reveal="left"><div class="kicker">You may also like</div><h2>Related <span class="text-grad">Products</span></h2></div>
        </div>
        <div class="carousel" data-carousel>
            <div class="carousel-track">
                @foreach($related as $p) @include('partials.product-card') @endforeach
            </div>
            <div class="carousel-nav" style="justify-content:center">
                <button data-prev aria-label="Previous"><i class="fa-solid fa-arrow-left"></i></button>
                <button data-next aria-label="Next"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>

{{-- Inquiry modal --}}
<div class="modal" id="inquiry-modal">
    <div class="modal-box">
        <button class="modal-close" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        <div class="kicker">Product Inquiry</div>
        <h3 style="font-size:24px">{{ $product->name }}</h3>
        <p class="muted">Send us your requirement and we'll get back within 30 minutes.</p>
        <form method="POST" action="{{ route('inquiry') }}" class="form-grid">
            @csrf
            <input type="hidden" name="type" value="product">
            <input type="hidden" name="product" value="{{ $product->name }}">
            <div class="field"><label>Name <span class="req">*</span></label><input class="input" name="name" required></div>
            <div class="field"><label>Mobile <span class="req">*</span></label><input class="input" name="phone" required inputmode="tel"></div>
            <div class="field"><label>Email</label><input class="input" type="email" name="email"></div>
            <div class="field"><label>Quantity</label><input class="input" name="quantity"></div>
            <div class="field full"><label>Message</label><textarea class="input" name="message"></textarea></div>
            <div class="full"><button class="btn btn-block"><i class="fa-solid fa-paper-plane"></i> Send Inquiry</button></div>
        </form>
    </div>
</div>
@push('head')<style>@media(max-width:900px){.rev-grid{grid-template-columns:1fr!important}}</style>@endpush
@endsection
