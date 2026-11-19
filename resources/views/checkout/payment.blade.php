@extends('layouts.app')
@section('title', 'Payment')

@section('content')
@include('partials.page-hero', ['title' => 'Complete <span class="text-grad">Payment</span>', 'sub' => 'Order #'.$order->order_number.' has been created. Pay securely to confirm it.', 'crumbs' => ['Checkout' => null, 'Payment' => null]])

<section class="section" style="padding-top:60px">
    <div class="container">
        <div class="success-card" data-reveal="zoom">
            <div style="width:90px;height:90px;border-radius:28px;margin:0 auto 20px;display:grid;place-items:center;background:var(--grad);color:#fff;font-size:38px;box-shadow:var(--shadow-lg)"><i class="fa-solid fa-shield-halved"></i></div>
            <h2>Pay <span class="text-grad">₹{{ number_format($order->total, 2) }}</span></h2>
            <p class="muted">Order <b style="color:var(--ink)">#{{ $order->order_number }}</b> · {{ $order->items->count() }} item(s) · {{ $order->name }}</p>

            @if(session('error'))<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>@endif

            @if($gatewayError)
                <div class="alert alert-error" style="text-align:left"><i class="fa-solid fa-triangle-exclamation"></i>{{ $gatewayError }}</div>
                <p class="muted">Meanwhile, you can confirm your order with us directly:</p>
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                    <a class="btn btn-whatsapp" target="_blank" rel="noopener" href="https://wa.me/{{ config('site.whatsapp') }}?text={{ rawurlencode('Hi, I placed order #'.$order->order_number.' of ₹'.number_format($order->total, 2).'. Please share payment details.') }}"><i class="fa-brands fa-whatsapp"></i> Confirm on WhatsApp</a>
                    <a class="btn btn-dark" href="tel:{{ config('site.phone') }}"><i class="fa-solid fa-phone"></i> Call Us</a>
                </div>
            @else
                <div id="pay-error" class="alert alert-error hidden" style="text-align:left"><i class="fa-solid fa-circle-exclamation"></i><span></span></div>
                <button id="pay-btn" class="btn" style="font-size:17px;padding:16px 40px;margin:10px 0"><i class="fa-solid fa-lock"></i> Pay Now with Razorpay</button>
                <p class="muted" style="font-size:13px">UPI · Credit / Debit Card · Net Banking · Wallets</p>
                @if(str_starts_with((string) config('site.razorpay.key'), 'rzp_test_'))
                    <div class="alert alert-info" style="text-align:left;font-size:13px;display:block">
                        <b>Test mode</b> — no real money is charged. Use an Indian test card:
                        <b>5267 3181 8797 5449</b> (Mastercard) or <b>4386 2894 0766 0153</b> (Visa), any future expiry, any CVV, OTP <b>1234</b> if asked. Or choose Netbanking → any bank → Success.
                    </div>
                @endif
                <form id="verify-form" method="POST" action="{{ route('payment.verify') }}" class="hidden">
                    @csrf
                    <input type="hidden" name="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature">
                </form>
            @endif
            <div class="pay-logos" style="margin-top:20px"><i class="fa-brands fa-cc-visa"></i><i class="fa-brands fa-cc-mastercard"></i><i class="fa-brands fa-google-pay"></i><i class="fa-brands fa-amazon-pay"></i></div>
        </div>
    </div>
</section>
@endsection

@if(! $gatewayError)
@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(() => {
    const options = {
        key: @json(config('site.razorpay.key')),
        amount: {{ (int) round($order->total * 100) }},
        currency: 'INR',
        name: @json(config('site.name')),
        description: @json('Order #'.$order->order_number),
        order_id: @json($order->razorpay_order_id),
        prefill: { name: @json($order->name), email: @json($order->email), contact: @json($order->phone) },
        notes: { order_number: @json($order->order_number) },
        theme: { color: '#7c3aed' },
        handler(res) {
            const f = document.getElementById('verify-form');
            f.razorpay_payment_id.value = res.razorpay_payment_id;
            f.razorpay_order_id.value = res.razorpay_order_id;
            f.razorpay_signature.value = res.razorpay_signature;
            document.getElementById('pay-btn').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Verifying payment...';
            f.submit();
        },
        modal: {
            ondismiss() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Try Payment Again';
                if (lastError) showError(lastError);
            }
        }
    };
    const btn = document.getElementById('pay-btn');
    const errBox = document.getElementById('pay-error');
    let lastError = null;
    const showError = msg => { errBox.querySelector('span').textContent = msg; errBox.classList.remove('hidden'); };

    const rzp = new Razorpay(options);
    // Razorpay shows the failure inside the popup and lets the customer retry there,
    // so we only remember the reason (shown if they close the popup).
    rzp.on('payment.failed', res => {
        lastError = (res.error && res.error.description) || 'Payment failed. Please try another payment method.';
    });

    btn.addEventListener('click', e => {
        e.preventDefault();
        errBox.classList.add('hidden');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Opening secure payment...';
        rzp.open();
    });
    @unless(session('error'))
        setTimeout(() => btn.click(), 900); // auto-open once on first visit
    @endunless
})();
</script>
@endpush
@endif
