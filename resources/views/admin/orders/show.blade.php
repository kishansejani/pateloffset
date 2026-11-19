@extends('admin.layout')
@section('title', 'Order #'.$order->order_number)
@section('actions')
    <a href="https://wa.me/91{{ $order->phone }}?text={{ rawurlencode('Hello '.$order->name.', update on your Patel Offset order #'.$order->order_number.': '.$order->statusLabel()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-whatsapp"><i class="fa-brands fa-whatsapp"></i> Message Customer</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px" class="order-grid">
    <div>
        <div class="card">
            <h3>Items</h3>
            <table>
                <tr><th>Product</th><th>Options</th><th>Qty</th><th>Design</th><th>Amount</th></tr>
                @foreach($order->items as $i)
                    <tr>
                        <td><b>{{ $i->product_name }}</b></td>
                        <td>@foreach($i->options ?? [] as $k => $v)<span class="tag">{{ $k }}: {{ $v }}</span> @endforeach</td>
                        <td>{{ number_format($i->quantity) }}</td>
                        <td>
                            @if($i->design_type === 'design_with_us')<span class="tag printing">Design by us</span>@endif
                            @if($i->design_file)<a class="btn btn-sm btn-outline" href="{{ asset('storage/'.$i->design_file) }}" target="_blank" download><i class="fa-solid fa-download"></i> File</a>@elseif($i->design_type === 'upload')<span class="muted">Not uploaded</span>@endif
                        </td>
                        <td><b>₹{{ number_format($i->price + $i->design_charge, 2) }}</b></td>
                    </tr>
                @endforeach
            </table>
            <div style="max-width:320px;margin-left:auto;margin-top:16px">
                <div class="sum-row"><span>Subtotal</span><b>₹{{ number_format($order->subtotal, 2) }}</b></div>
                <div class="sum-row"><span>Design</span><b>₹{{ number_format($order->design_charges, 2) }}</b></div>
                <div class="sum-row"><span>Shipping</span><b>₹{{ number_format($order->shipping, 2) }}</b></div>
                <div class="sum-row"><span>GST</span><b>₹{{ number_format($order->gst, 2) }}</b></div>
                <div class="sum-row total"><span>Total</span><span>₹{{ number_format($order->total, 2) }}</span></div>
            </div>
        </div>
        @if($order->notes)<div class="card"><h3>Customer Notes</h3><p>{{ $order->notes }}</p></div>@endif
    </div>
    <div>
        <div class="card">
            <h3>Status</h3>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" style="display:flex;gap:10px">
                @csrf @method('PATCH')
                <select class="input" name="status">@foreach(\App\Models\Order::STATUSES as $k => $v)<option value="{{ $k }}" @selected($order->status === $k)>{{ $v }}</option>@endforeach</select>
                <button class="btn btn-sm">Update</button>
            </form>
            <p style="margin-top:14px">Payment: <span class="tag {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></p>
            @if($order->razorpay_payment_id)<p class="muted" style="font-size:13px;word-break:break-all">Razorpay Payment ID:<br><b>{{ $order->razorpay_payment_id }}</b><br>Paid at: {{ $order->paid_at?->format('d M Y, h:i A') }}</p>@endif
        </div>
        <div class="card">
            <h3>Customer</h3>
            <p style="margin:0"><b>{{ $order->name }}</b>@if($order->company)<br>{{ $order->company }}@endif</p>
            <p><a href="tel:{{ $order->phone }}"><i class="fa-solid fa-phone"></i> {{ $order->phone }}</a><br><a href="mailto:{{ $order->email }}"><i class="fa-solid fa-envelope"></i> {{ $order->email }}</a></p>
            @if($order->gst_number)<p>GST: {{ $order->gst_number }}</p>@endif
            <h3 style="margin-top:16px">Delivery Address</h3>
            <p class="muted">{{ $order->address }}<br>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
        </div>
    </div>
</div>
<style>@media(max-width:1000px){.order-grid{grid-template-columns:1fr!important}}</style>
@endsection
