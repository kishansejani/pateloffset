@extends('layouts.app')
@section('title', $category->name ?? (request('q') ? 'Search: '.request('q') : 'All Products'))

@section('content')
@include('partials.page-hero', [
    'title' => $category ? e($category->name) : (request('q') ? 'Results for “'.e(request('q')).'”' : 'All <span class="text-grad">Products</span>'),
    'sub' => $category->description ?? 'Browse our complete range of premium printing products with instant pricing.',
    'crumbs' => $category ? ['Shop' => route('shop'), $category->name => null] : ['Shop' => null],
])

<section class="section" style="padding-top:60px">
    <div class="container shop-layout">
        <aside class="sidebar" data-reveal="left">
            <h4>Categories</h4>
            <ul>
                <li><a href="{{ route('shop') }}" class="{{ ! $category ? 'active' : '' }}"><i class="fa-solid fa-border-all"></i>All Products</a></li>
                @foreach($categories as $c)
                    <li><a href="{{ route('category', $c) }}" class="{{ $category?->id === $c->id ? 'active' : '' }}" style="--c:{{ $c->color }}"><i class="{{ $c->icon }}"></i>{{ $c->name }}<span>{{ $c->active_products_count }}</span></a></li>
                @endforeach
            </ul>
            <h4 style="margin-top:20px">Collections</h4>
            <ul>
                @foreach(['new' => ['fa-solid fa-wand-magic-sparkles', 'New Arrival'], 'bestseller' => ['fa-solid fa-trophy', 'Bestseller'], 'hot' => ['fa-solid fa-fire', 'Hot Products'], 'featured' => ['fa-solid fa-star', 'Featured']] as $k => [$ic, $l])
                    <li><a href="{{ request()->fullUrlWithQuery(['filter' => request('filter') === $k ? null : $k, 'page' => null]) }}" class="{{ request('filter') === $k ? 'active' : '' }}" style="--c:var(--magenta)"><i class="{{ $ic }}"></i>{{ $l }}</a></li>
                @endforeach
            </ul>
            <div class="cta" style="padding:24px;grid-template-columns:1fr;border-radius:20px;margin-top:20px">
                <div style="position:relative;z-index:2"><h4 style="color:#fff;margin-bottom:6px">Need help choosing?</h4><p style="font-size:13.5px;margin-bottom:12px">Our experts reply within minutes.</p>
                <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="btn btn-sm btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> Chat Now</a></div>
            </div>
        </aside>

        <div>
            <div class="toolbar" data-reveal="up">
                <span class="muted">Showing <b style="color:var(--ink)">{{ $products->total() }}</b> products</span>
                <form>
                    @foreach(request()->except(['sort', 'page']) as $k => $v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                    <select name="sort" class="select" onchange="this.form.submit()">
                        <option value="">Sort: Recommended</option>
                        <option value="popular" @selected(request('sort') === 'popular')>Most Popular</option>
                        <option value="latest" @selected(request('sort') === 'latest')>Latest</option>
                        <option value="name" @selected(request('sort') === 'name')>Name A–Z</option>
                    </select>
                </form>
            </div>
            @if($products->count())
                <div class="product-grid" data-stagger>
                    @foreach($products as $p) @include('partials.product-card') @endforeach
                </div>
                {{ $products->links('partials.pagination') }}
            @else
                <div class="empty">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3>No products found</h3>
                    <p class="muted">Try a different search, or ask us — we print almost anything!</p>
                    <a href="{{ route('quote') }}" class="btn">Request Custom Quote</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
