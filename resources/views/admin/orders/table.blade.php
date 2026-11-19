<table>
    <tr><th>Order #</th><th>Date</th><th>Customer</th><th>Phone</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr>
    @forelse($orders as $o)
        <tr>
            <td><b>{{ $o->order_number }}</b></td>
            <td>{{ $o->created_at->format('d M Y') }}</td>
            <td>{{ $o->name }}</td>
            <td><a href="tel:{{ $o->phone }}">{{ $o->phone }}</a></td>
            <td><b>₹{{ number_format($o->total, 2) }}</b></td>
            <td><span class="tag {{ $o->payment_status }}">{{ ucfirst($o->payment_status) }}</span></td>
            <td><span class="tag {{ $o->status }}">{{ $o->statusLabel() }}</span></td>
            <td><a class="act" href="{{ route('admin.orders.show', $o) }}" aria-label="View"><i class="fa-regular fa-eye"></i></a></td>
        </tr>
    @empty
        <tr><td colspan="8" class="muted">No orders yet.</td></tr>
    @endforelse
</table>
