@extends('layouts.app')
@section('title', 'Order Confirmed')

@section('content')
<section class="section">
    <div class="container">
        <div class="success-card">
            <svg class="check-anim" viewBox="0 0 120 120"><circle cx="60" cy="60" r="54" fill="none" stroke="#16a34a" stroke-width="6"/><path d="M36 62 l16 16 l32 -34" fill="none" stroke="#16a34a" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div class="kicker">Payment Successful</div>
            <h2>Thank you, {{ $order->name }}!</h2>
            <p class="muted">Your order <b style="color:var(--ink)">#{{ $order->order_number }}</b> is confirmed. We've received ₹{{ number_format($order->total, 2) }}. Our team will contact you on {{ $order->phone }} for design confirmation.</p>
            @include('partials.order-timeline')
            <div class="box" style="text-align:left">
                @foreach($order->items as $i)
                    <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px dashed var(--line)">
                        <span><b style="color:var(--ink)">{{ $i->product_name }}</b> <small class="muted">× {{ number_format($i->quantity) }} @foreach($i->options ?? [] as $v) · {{ $v }} @endforeach</small></span>
                        <b>₹{{ number_format($i->price + $i->design_charge, 2) }}</b>
                    </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding-top:12px;font:800 20px var(--font-head);color:var(--ink)"><span>Total Paid</span><span>₹{{ number_format($order->total, 2) }}</span></div>
                @if($order->razorpay_payment_id)<small class="muted">Payment ID: {{ $order->razorpay_payment_id }}</small>@endif
            </div>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('shop') }}" class="btn">Continue Shopping</a>
                <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ rawurlencode('Hi, my order number is #'.$order->order_number.'. Sending my design files.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> Send Design on WhatsApp</a>
            </div>
        </div>
    </div>
</section>
@endsection
