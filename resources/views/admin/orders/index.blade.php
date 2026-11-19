@extends('admin.layout')
@section('title', 'Orders')
@section('crumb', 'Sales')
@section('icon', 'fa-solid fa-cart-shopping')
@section('subtitle', 'Track every print order from payment to delivery.')

@section('content')
<div class="ap-stats">
    <button type="button" class="ap-stat on" data-dt-target="orders" data-filter="" style="--c:#1e40af"><span class="lbl">All orders</span><span class="ic"><i class="fa-solid fa-receipt"></i></span><b class="val" data-count>{{ $orders->count() }}</b><span class="note">₹{{ number_format($orders->where('payment_status', 'paid')->sum('total')) }} collected</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="orders" data-filter="pay-paid" style="--c:#10b981"><span class="lbl">Paid</span><span class="ic"><i class="fa-solid fa-indian-rupee-sign"></i></span><b class="val" data-count>{{ $orders->where('payment_status', 'paid')->count() }}</b><span class="note">Payment received</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="orders" data-filter="printing" style="--c:#6366f1"><span class="lbl">Printing</span><span class="ic"><i class="fa-solid fa-print"></i></span><b class="val" data-count>{{ $orders->where('status', 'printing')->count() }}</b><span class="note">On the press now</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="orders" data-filter="pay-pending" style="--c:#f59e0b"><span class="lbl">Unpaid</span><span class="ic"><i class="fa-solid fa-clock"></i></span><b class="val" data-count>{{ $orders->where('payment_status', 'pending')->count() }}</b><span class="note">Awaiting payment</span><span class="bar"></span></button>
</div>

<div class="dt" data-dt="orders" data-title="Orders" data-unit="orders" data-empty="No orders yet">
    <div class="dt-tabs">
        <button type="button" class="dt-tab on" data-filter="">All</button>
        @foreach(\App\Models\Order::STATUSES as $k => $v)
            <button type="button" class="dt-tab" data-filter="{{ $k }}">{{ $v }}</button>
        @endforeach
        <button type="button" class="dt-tab" data-filter="pay-failed" style="color:#e11d48">Payment failed</button>
    </div>
    @include('admin.orders.table')
</div>
@endsection
