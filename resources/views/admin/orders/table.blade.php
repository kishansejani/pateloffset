{{-- Orders data table. Expects $orders, $dtName --}}
@php
    $statusIcons = ['pending' => 'fa-hourglass-half', 'confirmed' => 'fa-circle-check', 'designing' => 'fa-pen-ruler', 'printing' => 'fa-print', 'shipped' => 'fa-truck-fast', 'delivered' => 'fa-box-open', 'cancelled' => 'fa-ban'];
    $wa = fn ($p) => strlen(preg_replace('/\D/', '', $p)) === 10 ? '91'.preg_replace('/\D/', '', $p) : preg_replace('/\D/', '', $p);
@endphp
<table>
    <thead><tr>
        <th data-col="sr">Sr. No</th>
        <th data-col="order">Order #</th>
        <th data-col="date">Date</th>
        <th data-col="customer">Customer</th>
        <th data-col="phone">Phone</th>
        <th data-col="city">City</th>
        <th data-col="items">Items</th>
        <th data-col="total">Total</th>
        <th data-col="payment">Payment</th>
        <th data-col="status">Status</th>
        <th data-col="actions" data-nosort data-noexport>Actions</th>
    </tr></thead>
    <tbody>
    @foreach($orders as $o)
        <tr data-tags="{{ $o->status }} pay-{{ $o->payment_status }}">
            <td data-sort="{{ $loop->iteration }}"><span class="srno">{{ $loop->iteration }}</span></td>
            <td data-sort="{{ $o->order_number }}"><a href="{{ route('admin.orders.show', $o) }}" style="font-weight:800;color:var(--ap-text)">#{{ $o->order_number }}</a></td>
            <td class="nowrap" data-sort="{{ $o->created_at->timestamp }}" data-export="{{ $o->created_at->format('d M Y, h:i A') }}">{{ $o->created_at->format('d M Y') }}<br><small class="muted">{{ $o->created_at->format('h:i A') }}</small></td>
            <td data-sort="{{ $o->name }}" data-export="{{ $o->name }}">
                <div class="ent" style="min-width:180px">
                    <span class="thumb" style="width:40px;height:40px;border-radius:12px;font:800 14px var(--font-head);background:hsl({{ crc32($o->name) % 360 }} 65% 50%)">{{ strtoupper(mb_substr($o->name, 0, 1)) }}</span>
                    <div><b>{{ $o->name }}</b><small>{{ $o->email }}</small></div>
                </div>
            </td>
            <td class="nowrap"><a href="tel:{{ $o->phone }}">{{ $o->phone }}</a></td>
            <td>{{ $o->city }}</td>
            <td data-sort="{{ $o->items_count ?? $o->items()->count() }}">{{ $o->items_count ?? $o->items()->count() }}</td>
            <td class="nowrap" data-sort="{{ $o->total }}" data-export="₹{{ number_format($o->total, 2) }}"><b style="color:var(--ap-text)">₹{{ number_format($o->total, 2) }}</b></td>
            <td data-sort="{{ $o->payment_status }}" data-export="{{ ucfirst($o->payment_status) }}"><span class="tag {{ $o->payment_status }}"><i class="fa-solid {{ $o->payment_status === 'paid' ? 'fa-check' : ($o->payment_status === 'failed' ? 'fa-xmark' : 'fa-clock') }}"></i>{{ ucfirst($o->payment_status) }}</span></td>
            <td data-sort="{{ array_search($o->status, array_keys(\App\Models\Order::STATUSES)) }}" data-export="{{ $o->statusLabel() }}"><span class="tag {{ $o->status }}"><i class="fa-solid {{ $statusIcons[$o->status] ?? 'fa-circle' }}"></i>{{ $o->statusLabel() }}</span></td>
            <td>
                <div class="acts">
                    <a class="act view" href="{{ route('admin.orders.show', $o) }}" title="View order"><i class="fa-regular fa-eye"></i></a>
                    <a class="act wa" href="https://wa.me/{{ $wa($o->phone) }}?text={{ rawurlencode('Hello '.$o->name.', regarding your '.config('site.name').' order #'.$o->order_number) }}" target="_blank" rel="noopener" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a class="act neutral" href="tel:{{ $o->phone }}" title="Call"><i class="fa-solid fa-phone"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
