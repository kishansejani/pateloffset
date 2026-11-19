@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat" style="--c:#16a34a"><i class="fa-solid fa-indian-rupee-sign"></i><div><b>₹{{ number_format($stats['revenue']) }}</b><span>Revenue (paid)</span></div></div>
    <div class="stat" style="--c:#7c3aed"><i class="fa-solid fa-receipt"></i><div><b>{{ $stats['orders'] }}</b><span>Total orders</span></div></div>
    <div class="stat" style="--c:#06b6d4"><i class="fa-solid fa-circle-check"></i><div><b>{{ $stats['paid'] }}</b><span>Paid orders</span></div></div>
    <div class="stat" style="--c:#f97316"><i class="fa-solid fa-print"></i><div><b>{{ $stats['pending'] }}</b><span>In production</span></div></div>
    <div class="stat" style="--c:#ec4899"><i class="fa-solid fa-inbox"></i><div><b>{{ $stats['inquiries'] }}</b><span>New inquiries</span></div></div>
    <div class="stat" style="--c:#0b1120"><i class="fa-solid fa-box"></i><div><b>{{ $stats['products'] }}</b><span>Products</span></div></div>
</div>
<div class="card">
    <h3>Latest Orders</h3>
    @include('admin.orders.table', ['orders' => $orders])
</div>
<div class="card">
    <h3>Latest Inquiries</h3>
    <table>
        <tr><th>Date</th><th>Type</th><th>Name</th><th>Phone</th><th>Product</th></tr>
        @forelse($inquiries as $i)
            <tr><td>{{ $i->created_at->format('d M, h:i A') }}</td><td><span class="tag">{{ ucfirst($i->type) }}</span></td><td>{{ $i->name }}</td><td><a href="tel:{{ $i->phone }}">{{ $i->phone }}</a></td><td>{{ $i->product ?: '—' }}</td></tr>
        @empty
            <tr><td colspan="5" class="muted">No inquiries yet.</td></tr>
        @endforelse
    </table>
</div>
@endsection
