@php
    $badge = $p->badge();
    $badgeClass = match (true) { str_contains((string) $badge, 'OFF') => '', $badge === 'New' => 'new', $badge === 'Bestseller' => 'bestseller', default => 'hot' };
    $rating = $p->reviews_avg_rating ?? null;
    $waText = rawurlencode('Hi, I am interested in "'.$p->name.'". Please share details.');
@endphp
<article class="product-card" data-tilt>
    <a href="{{ route('product', $p) }}" class="thumb">
        @if($badge)<span class="badge {{ $badgeClass }}">{{ $badge }}</span>@endif
        <x-mockup :art="$p->art" :color="$p->color" :title="$p->name" :image="$p->image"/>
    </a>
    <div class="quick">
        <a href="{{ route('product', $p) }}" aria-label="View"><i class="fa-regular fa-eye"></i></a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ $waText }}" target="_blank" rel="noopener" class="wa" aria-label="Ask on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
    </div>
    <div class="info">
        <span class="cat">{{ $p->category->name ?? '' }}</span>
        <h3><a href="{{ route('product', $p) }}">{{ $p->name }}</a></h3>
        <div class="meta-row">
            @if($rating)<span class="stars">★★★★★</span><span>{{ number_format($rating, 1) }} ({{ $p->reviews_count }})</span>@endif
            <span><i class="fa-regular fa-eye"></i> {{ $p->views }}</span>
        </div>
        <div class="price-row">
            <div class="price">
                <small>{{ $p->startingQty() }} pcs starting at</small>
                <strong>₹{{ number_format($p->startingPrice()) }}</strong>@if($p->startingMrp())<del>₹{{ number_format($p->startingMrp()) }}</del>@endif
            </div>
            <a href="{{ route('product', $p) }}" class="buy" aria-label="Buy now"><i class="fa-solid fa-bag-shopping"></i></a>
        </div>
    </div>
</article>
