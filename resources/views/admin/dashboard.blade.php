@extends('admin.layout')
@section('title', 'Dashboard')
@section('crumb', 'Overview')
@section('icon', 'fa-solid fa-table-cells-large')
@section('subtitle', 'Your print shop at a glance — orders, revenue and enquiries.')
@section('actions')
    <a href="{{ route('admin.orders.index') }}" class="ap-btn"><i class="fa-solid fa-cart-shopping"></i>All orders</a>
    <a href="{{ route('admin.products.create') }}" class="ap-btn dark"><i class="fa-solid fa-plus"></i>Add product</a>
@endsection

@php
    $maxOrders = max(1, $chart->max('orders'));
    $hour = now()->hour;
    $greet = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $totalMix = max(1, $statusMix->sum());
    $mixColors = ['pending' => '#f59e0b', 'confirmed' => '#10b981', 'designing' => '#8b5cf6', 'printing' => '#6366f1', 'shipped' => '#06b6d4', 'delivered' => '#22c55e', 'cancelled' => '#f43f5e'];
@endphp

@section('content')
<div class="ap-welcome">
    <div style="position:relative;z-index:1;display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap">
        <div>
            <h2>{{ $greet }}, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2>
            <p>{{ $stats['pending'] }} paid {{ Str::plural('order', $stats['pending']) }} in production and {{ $stats['inquiries'] }} unread {{ Str::plural('inquiry', $stats['inquiries']) }} waiting for you.</p>
        </div>
        <a href="{{ route('admin.inquiries.index') }}" class="ap-btn" style="background:#fff;color:#0b1120;border:0"><i class="fa-solid fa-inbox"></i>Open inbox</a>
    </div>
</div>

<div class="ap-stats">
    <div class="ap-stat" style="--c:#10b981"><span class="lbl">Revenue</span><span class="ic"><i class="fa-solid fa-indian-rupee-sign"></i></span><b class="val">₹{{ number_format($stats['revenue']) }}</b><span class="note">From paid orders</span><span class="bar"></span></div>
    <a href="{{ route('admin.orders.index') }}" class="ap-stat" style="--c:#1e40af"><span class="lbl">Orders</span><span class="ic"><i class="fa-solid fa-receipt"></i></span><b class="val">{{ $stats['orders'] }}</b><span class="note">{{ $stats['paid'] }} paid</span><span class="bar"></span></a>
    <a href="{{ route('admin.orders.index') }}" class="ap-stat" style="--c:#6366f1"><span class="lbl">In production</span><span class="ic"><i class="fa-solid fa-print"></i></span><b class="val">{{ $stats['pending'] }}</b><span class="note">Paid &amp; not delivered</span><span class="bar"></span></a>
    <a href="{{ route('admin.inquiries.index') }}" class="ap-stat" style="--c:#ec4899"><span class="lbl">New inquiries</span><span class="ic"><i class="fa-solid fa-inbox"></i></span><b class="val">{{ $stats['inquiries'] }}</b><span class="note">Unread messages</span><span class="bar"></span></a>
</div>

<div class="ap-grid-2">
    <div class="ap-card">
        <div class="ap-card-head"><h3><i class="fa-solid fa-chart-column" style="color:var(--ac)"></i> Orders — last 14 days</h3><span class="pill violet">{{ $chart->sum('orders') }} orders · ₹{{ number_format($chart->sum('revenue')) }}</span></div>
        <div class="ap-card-pad">
            <div class="ap-chart">
                @foreach($chart as $i => $d)
                    <div class="col"><div class="b" data-v="{{ $d['label'] }}: {{ $d['orders'] }} orders · ₹{{ number_format($d['revenue']) }}" style="height:{{ max(2, $d['orders'] / $maxOrders * 100) }}%;animation-delay:{{ $i * 50 }}ms;{{ $d['orders'] ? '' : 'opacity:.25' }}"></div><span>{{ $d['short'] }}</span></div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="ap-card">
        <div class="ap-card-head"><h3><i class="fa-solid fa-chart-pie" style="color:var(--ac)"></i> Order status</h3></div>
        <div class="ap-card-pad">
            @forelse(\App\Models\Order::STATUSES as $k => $label)
                @php $n = $statusMix[$k] ?? 0; @endphp
                <div style="margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;font-size:14px;font-weight:600;margin-bottom:6px"><span>{{ $label }}</span><span class="muted">{{ $n }}</span></div>
                    <div style="height:8px;border-radius:8px;background:var(--ap-surface-2);overflow:hidden"><div style="height:100%;width:{{ $n / $totalMix * 100 }}%;background:{{ $mixColors[$k] }};border-radius:8px;transition:width 1s"></div></div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

<div class="dt" data-dt="dash-orders" data-title="Latest orders" data-unit="latest orders" data-empty="No orders yet">
    <div class="dt-tabs">
        <h3 style="margin:0 10px 0 4px;font-size:18px">Latest orders</h3>
        <button type="button" class="dt-tab on" data-filter="">All</button>
        <button type="button" class="dt-tab" data-filter="pay-paid">Paid</button>
        <button type="button" class="dt-tab" data-filter="pay-pending">Unpaid</button>
    </div>
    @include('admin.orders.table')
</div>

<div class="ap-grid-2">
    <div class="ap-card">
        <div class="ap-card-head"><h3><i class="fa-solid fa-inbox" style="color:#ec4899"></i> Latest inquiries</h3><a href="{{ route('admin.inquiries.index') }}" class="ap-btn sm">View all</a></div>
        <div class="ap-card-pad" style="padding-top:6px;padding-bottom:6px">
            @forelse($inquiries as $i)
                <div class="ap-list-item">
                    <span class="ic" style="{{ $i->is_read ? '' : 'background:rgba(236,72,153,.12);color:#ec4899' }}"><i class="fa-solid {{ $i->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i></span>
                    <div style="min-width:0"><b>{{ $i->name }} <span class="pill" style="padding:2px 8px;font-size:11px">{{ ucfirst($i->type) }}</span></b><small>{{ $i->product ?: Str::limit($i->message, 50) }}</small></div>
                    <div class="r"><a href="tel:{{ $i->phone }}" class="act neutral" title="Call {{ $i->phone }}"><i class="fa-solid fa-phone"></i></a><br><small>{{ $i->created_at->diffForHumans(null, true) }}</small></div>
                </div>
            @empty
                <p class="muted" style="padding:20px 0;margin:0">No inquiries yet.</p>
            @endforelse
        </div>
    </div>
    <div class="ap-card">
        <div class="ap-card-head"><h3><i class="fa-solid fa-fire" style="color:#f97316"></i> Most viewed products</h3></div>
        <div class="ap-card-pad" style="padding-top:6px;padding-bottom:6px">
            @foreach($topProducts as $p)
                <div class="ap-list-item">
                    <span class="ic" style="overflow:hidden;padding:0"><x-mockup :art="$p->art" :color="$p->color" :title="$p->name" :image="$p->image"/></span>
                    <div style="min-width:0"><b>{{ $p->name }}</b><small>₹{{ number_format($p->startingPrice()) }} / {{ $p->startingQty() }} pcs</small></div>
                    <div class="r"><b>{{ number_format($p->views) }}</b><small>views</small></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
