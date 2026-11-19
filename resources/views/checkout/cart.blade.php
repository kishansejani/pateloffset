@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
@include('partials.page-hero', ['title' => 'Shopping <span class="text-grad">Cart</span>', 'crumbs' => ['Cart' => null]])

<section class="section" style="padding-top:60px">
    <div class="container">
        @if(count($items))
            <div class="cart-layout">
                <div data-stagger>
                    @foreach($items as $key => $i)
                        <div class="cart-item">
                            <a href="{{ route('product', $i['slug']) }}" class="img"><x-mockup :art="$i['art']" :color="$i['color']" :title="$i['name']" :image="$i['image']"/></a>
                            <div>
                                <small class="muted" style="font-weight:700;text-transform:uppercase;font-size:11.5px;letter-spacing:.08em">{{ $i['category'] }}</small>
                                <h4><a href="{{ route('product', $i['slug']) }}">{{ $i['name'] }}</a></h4>
                                <div class="opts">
                                    <span><i class="fa-solid fa-layer-group"></i> Qty: {{ number_format($i['quantity']) }}</span>
                                    @foreach($i['options'] as $k => $v)<span>{{ $k }}: {{ $v }}</span>@endforeach
                                    <span>{{ $i['design_type'] === 'design_with_us' ? 'Design by Patel Offset' : ($i['design_file'] ? 'Design uploaded ✓' : 'Design: send later') }}</span>
                                </div>
                            </div>
                            <div class="amt">
                                <div>
                                    <strong>₹{{ number_format($i['price'], 2) }}</strong>
                                    @if($i['design_charge'])<small class="muted">+ ₹{{ number_format($i['design_charge']) }} design</small>@endif
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $key) }}">@csrf @method('DELETE')<button class="remove-btn" aria-label="Remove"><i class="fa-regular fa-trash-can"></i></button></form>
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('shop') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Continue Shopping</a>
                </div>
                @include('checkout.summary', ['button' => true])
            </div>
        @else
            <div class="empty" data-reveal="zoom">
                <i class="fa-solid fa-bag-shopping"></i>
                <h3>Your cart is empty</h3>
                <p class="muted">Looks like you haven't added anything yet.</p>
                <a href="{{ route('shop') }}" class="btn">Start Shopping <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif
    </div>
</section>
@endsection
