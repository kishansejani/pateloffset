@extends('layouts.app')
@section('title', 'Track Order')

@section('content')
@include('partials.page-hero', ['title' => 'Track Your <span class="text-grad">Order</span>', 'sub' => 'Enter your order number and mobile number to see live status.', 'crumbs' => ['Track Order' => null]])

<section class="section" style="padding-top:60px">
    <div class="container" style="max-width:820px">
        <form class="box" data-reveal="up" style="display:grid;grid-template-columns:1fr 1fr auto;gap:12px;align-items:end">
            <div class="field"><label>Order Number</label><input class="input" name="order_number" value="{{ request('order_number') }}" placeholder="PO2611181234" required></div>
            <div class="field"><label>Mobile Number</label><input class="input" name="phone" value="{{ request('phone') }}" placeholder="10 digit mobile" required></div>
            <button class="btn"><i class="fa-solid fa-magnifying-glass"></i> Track</button>
        </form>
        @if(session('error'))<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>@endif

        @if($order)
            <div class="box" data-reveal="zoom">
                <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px">
                    <div><h3 style="font-size:22px;text-transform:none;letter-spacing:0">Order #{{ $order->order_number }}</h3><span class="muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</span></div>
                    <div><span class="pill {{ $order->payment_status === 'paid' ? 'green' : '' }}">Payment: {{ ucfirst($order->payment_status) }}</span> <span class="pill">{{ $order->statusLabel() }}</span></div>
                </div>
                @include('partials.order-timeline')
                @foreach($order->items as $i)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed var(--line)"><span>{{ $i->product_name }} <small class="muted">× {{ number_format($i->quantity) }}</small></span><b>₹{{ number_format($i->price + $i->design_charge, 2) }}</b></div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding-top:12px;font:800 20px var(--font-head);color:var(--ink)"><span>Total</span><span>₹{{ number_format($order->total, 2) }}</span></div>
            </div>
        @endif
    </div>
</section>
@push('head')<style>@media(max-width:600px){form.box{grid-template-columns:1fr!important}}</style>@endpush
@endsection
