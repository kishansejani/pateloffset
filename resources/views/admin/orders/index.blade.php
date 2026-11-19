@extends('admin.layout')
@section('title', 'Orders')

@section('content')
<div class="card">
    <form class="filters">
        <input class="input" name="q" value="{{ request('q') }}" placeholder="Order #, name or phone">
        <select class="input" name="status"><option value="">All status</option>@foreach(\App\Models\Order::STATUSES as $k => $v)<option value="{{ $k }}" @selected(request('status') === $k)>{{ $v }}</option>@endforeach</select>
        <select class="input" name="payment"><option value="">All payments</option>@foreach(['pending', 'paid', 'failed'] as $p)<option value="{{ $p }}" @selected(request('payment') === $p)>{{ ucfirst($p) }}</option>@endforeach</select>
        <button class="btn btn-sm">Filter</button>
    </form>
    @include('admin.orders.table')
    {{ $orders->links('partials.pagination') }}
</div>
@endsection
