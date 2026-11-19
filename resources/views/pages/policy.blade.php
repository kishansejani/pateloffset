@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.page-hero', ['title' => e($title), 'crumbs' => [$title => null]])
@php $s = config('site'); @endphp
<section class="section" style="padding-top:60px">
    <div class="container">
        <div class="prose" data-reveal="up">
            <p class="muted">Last updated: {{ now()->format('d M Y') }}</p>
            @switch($page)
                @case('privacy')
                    <p>{{ $s['name'] }} respects your privacy. This policy explains what information we collect and how we use it.</p>
                    <h3>Information we collect</h3>
                    <ul><li>Name, phone, email and delivery address when you place an order or inquiry.</li><li>Design files you upload for printing.</li><li>Payment is processed by Razorpay — we never store your card or bank details.</li></ul>
                    <h3>How we use it</h3>
                    <ul><li>To process, print and deliver your orders.</li><li>To contact you about your order via call, WhatsApp or email.</li><li>To send offers only if you subscribe (you can unsubscribe anytime).</li></ul>
                    <h3>Your designs</h3>
                    <p>Your artwork is used only for your order and is never shared or reused without permission.</p>
                    @break
                @case('terms')
                    <h3>Orders</h3>
                    <p>By placing an order you confirm that you own the rights to the content you submit for printing. We may refuse content that is illegal or infringes copyright.</p>
                    <h3>Design &amp; proofs</h3>
                    <p>Please check spelling, numbers and layout carefully. We print as approved; errors in approved designs are the customer's responsibility.</p>
                    <h3>Colours</h3>
                    <p>Slight colour variation (up to 10%) between screen and print, or between print runs, is normal in printing and is not a defect.</p>
                    <h3>Pricing</h3>
                    <p>All prices are in INR. GST is charged as applicable. Prices may change without prior notice; confirmed orders are honoured at the paid price.</p>
                    @break
                @case('shipping')
                    <h3>Dispatch time</h3>
                    <p>Each product shows its dispatch time. It starts after payment and final design approval.</p>
                    <h3>Delivery</h3>
                    <ul><li>Local delivery: 1-2 days after dispatch.</li><li>Rest of India: 3-7 days via courier.</li><li>Free shipping on orders above ₹{{ number_format($s['free_shipping_above']) }}; otherwise ₹{{ $s['shipping_charge'] }}.</li></ul>
                    <h3>Self pickup</h3>
                    <p>You can also collect orders from our shop: {{ $s['address'] }}.</p>
                    @break
                @case('returns')
                    <p>Since every product is custom printed for you, we cannot accept returns for change of mind.</p>
                    <h3>Reprint / replacement</h3>
                    <ul><li>If you receive a damaged or wrongly printed product (our mistake), we will reprint it free of cost.</li><li>Report the issue within 48 hours of delivery with photos on WhatsApp or email.</li></ul>
                    @break
                @case('cancellation')
                    <ul><li>Orders can be cancelled before printing starts for a full refund.</li><li>If design work has started, design charges are non-refundable.</li><li>Once printing starts, orders cannot be cancelled.</li><li>Refunds are processed to the original payment method within 5-7 working days.</li></ul>
                    @break
            @endswitch
            <h3>Contact</h3>
            <p>Questions? Call <a href="tel:{{ $s['phone'] }}" style="color:var(--primary)">{{ $s['phone'] }}</a>, WhatsApp us, or email <a href="mailto:{{ $s['email'] }}" style="color:var(--primary)">{{ $s['email'] }}</a>.</p>
        </div>
    </div>
</section>
@endsection
