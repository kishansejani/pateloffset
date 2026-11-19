@php
    $flow = ['confirmed' => 'fa-solid fa-check', 'designing' => 'fa-solid fa-pen-nib', 'printing' => 'fa-solid fa-print', 'shipped' => 'fa-solid fa-truck', 'delivered' => 'fa-solid fa-house-circle-check'];
    $keys = array_keys($flow);
    $pos = array_search($order->status, $keys, true);
@endphp
@if($order->status === 'cancelled')
    <div class="alert alert-error"><i class="fa-solid fa-ban"></i>This order has been cancelled.</div>
@else
    <div class="timeline">
        @foreach($flow as $k => $ic)
            <div class="tl {{ $pos !== false && array_search($k, $keys) <= $pos ? 'done' : '' }}"><i class="{{ $ic }}"></i>{{ \App\Models\Order::STATUSES[$k] }}</div>
        @endforeach
    </div>
@endif
