<aside class="summary" data-reveal="right">
    <h3>Order Summary</h3>
    <div class="sum-row"><span>Subtotal</span><b>₹{{ number_format($totals['subtotal'], 2) }}</b></div>
    @if($totals['design'])<div class="sum-row"><span>Design charges</span><b>₹{{ number_format($totals['design'], 2) }}</b></div>@endif
    <div class="sum-row"><span>Shipping</span><b>{!! $totals['shipping'] ? '₹'.number_format($totals['shipping'], 2) : '<span style="color:var(--green)">FREE</span>' !!}</b></div>
    <div class="sum-row"><span>GST ({{ config('site.gst_percent') }}%)</span><b>₹{{ number_format($totals['gst'], 2) }}</b></div>
    <div class="sum-row total"><span>Total</span><span class="text-grad">₹{{ number_format($totals['total'], 2) }}</span></div>
    @if($totals['shipping'])
        <div class="alert alert-info" style="font-size:13px;margin:10px 0"><i class="fa-solid fa-truck"></i>Add ₹{{ number_format(config('site.free_shipping_above') - $totals['subtotal'] - $totals['design']) }} more for FREE shipping</div>
    @endif
    @if(! empty($button))
        <a href="{{ route('checkout') }}" class="btn btn-block" style="margin-top:12px">Proceed to Checkout <i class="fa-solid fa-arrow-right"></i></a>
    @else
        {{ $slot ?? '' }}
    @endif
    <div class="secure-note"><i class="fa-solid fa-lock" style="color:var(--green)"></i>Secured by Razorpay · 256-bit SSL</div>
    <div class="pay-logos"><i class="fa-brands fa-cc-visa"></i><i class="fa-brands fa-cc-mastercard"></i><i class="fa-brands fa-google-pay"></i><i class="fa-brands fa-amazon-pay"></i><i class="fa-solid fa-building-columns"></i></div>
</aside>
