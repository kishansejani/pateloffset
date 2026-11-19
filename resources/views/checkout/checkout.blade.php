@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
@include('partials.page-hero', ['title' => 'Secure <span class="text-grad">Checkout</span>', 'crumbs' => ['Cart' => route('cart'), 'Checkout' => null]])

<section class="section" style="padding-top:60px">
    <div class="container cart-layout">
        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" data-reveal="left">
            @csrf
            <div class="box">
                <h3><i class="fa-solid fa-user"></i>Contact Details</h3>
                <div class="form-grid">
                    @foreach([['name', 'Full Name', true, 'text'], ['phone', 'Mobile Number', true, 'tel'], ['email', 'Email Address', true, 'email'], ['company', 'Company / Shop Name', false, 'text'], ['gst_number', 'GST Number (optional)', false, 'text']] as [$f, $l, $req, $type])
                        <div class="field {{ $f === 'gst_number' ? 'full' : '' }}">
                            <label>{{ $l }} @if($req)<span class="req">*</span>@endif</label>
                            <input class="input" type="{{ $type }}" name="{{ $f }}" value="{{ old($f) }}" @required($req) @if($f === 'phone') maxlength="10" inputmode="numeric" placeholder="10 digit mobile" @endif>
                            @error($f)<span class="error">{{ $message }}</span>@enderror
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="box">
                <h3><i class="fa-solid fa-location-dot"></i>Delivery Address</h3>
                <div class="form-grid">
                    <div class="field full"><label>Address <span class="req">*</span></label><textarea class="input" name="address" required style="min-height:80px">{{ old('address') }}</textarea>@error('address')<span class="error">{{ $message }}</span>@enderror</div>
                    <div class="field"><label>City <span class="req">*</span></label><input class="input" name="city" value="{{ old('city') }}" required>@error('city')<span class="error">{{ $message }}</span>@enderror</div>
                    <div class="field"><label>State <span class="req">*</span></label>
                        <select class="input" name="state" required>
                            @foreach(['Gujarat', 'Maharashtra', 'Rajasthan', 'Madhya Pradesh', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Telangana', 'Uttar Pradesh', 'West Bengal', 'Punjab', 'Haryana', 'Kerala', 'Andhra Pradesh', 'Bihar', 'Goa', 'Odisha', 'Other'] as $st)
                                <option @selected(old('state', 'Gujarat') === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"><label>Pincode <span class="req">*</span></label><input class="input" name="pincode" value="{{ old('pincode') }}" maxlength="6" inputmode="numeric" required>@error('pincode')<span class="error">{{ $message }}</span>@enderror</div>
                    <div class="field full"><label>Order Notes (optional)</label><textarea class="input" name="notes" placeholder="Any special instructions for printing or delivery">{{ old('notes') }}</textarea></div>
                </div>
            </div>
            <div class="box">
                <h3><i class="fa-solid fa-box"></i>Items ({{ count($items) }})</h3>
                @foreach($items as $i)
                    <div style="display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px dashed var(--line)">
                        <span><b style="color:var(--ink)">{{ $i['name'] }}</b> <small class="muted">× {{ number_format($i['quantity']) }} @foreach($i['options'] as $v) · {{ $v }} @endforeach</small></span>
                        <b>₹{{ number_format($i['price'] + $i['design_charge'], 2) }}</b>
                    </div>
                @endforeach
            </div>
        </form>

        @component('checkout.summary', ['totals' => $totals])
            <button form="checkout-form" class="btn btn-block" style="margin-top:12px"><i class="fa-solid fa-lock"></i> Place Order &amp; Pay ₹{{ number_format($totals['total'], 2) }}</button>
            <p class="muted center" style="font-size:12.5px;margin-top:10px">By placing the order you agree to our <a href="{{ route('policy', 'terms') }}" style="color:var(--primary)">Terms</a>.</p>
        @endcomponent
    </div>
</section>
@endsection
