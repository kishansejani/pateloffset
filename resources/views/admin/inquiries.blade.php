@extends('admin.layout')
@section('title', 'Inquiries')
@section('crumb', 'Sales')
@section('icon', 'fa-solid fa-inbox')
@section('subtitle', 'Quote requests, bulk enquiries and contact messages from the website.')

@php $wa = fn ($p) => strlen(preg_replace('/\D/', '', $p)) === 10 ? '91'.preg_replace('/\D/', '', $p) : preg_replace('/\D/', '', $p); @endphp

@section('content')
<div class="ap-stats">
    <button type="button" class="ap-stat on" data-dt-target="inquiries" data-filter="" style="--c:#1e40af"><span class="lbl">All inquiries</span><span class="ic"><i class="fa-solid fa-inbox"></i></span><b class="val" data-count>{{ $inquiries->count() }}</b><span class="note">Received so far</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="inquiries" data-filter="unread" style="--c:#ec4899"><span class="lbl">Unread</span><span class="ic"><i class="fa-solid fa-envelope"></i></span><b class="val" data-count>{{ $inquiries->where('is_read', false)->count() }}</b><span class="note">Need a reply</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="inquiries" data-filter="quote" style="--c:#f59e0b"><span class="lbl">Quotes</span><span class="ic"><i class="fa-solid fa-file-invoice"></i></span><b class="val" data-count>{{ $inquiries->where('type', 'quote')->count() }}</b><span class="note">Price requests</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="inquiries" data-filter="read" style="--c:#10b981"><span class="lbl">Read</span><span class="ic"><i class="fa-solid fa-envelope-open"></i></span><b class="val" data-count>{{ $inquiries->where('is_read', true)->count() }}</b><span class="note">Already handled</span><span class="bar"></span></button>
</div>

<div class="dt" data-dt="inquiries" data-title="Inquiries" data-unit="inquiries" data-empty="No inquiries yet">
    <div class="dt-tabs">
        <button type="button" class="dt-tab on" data-filter="">All</button>
        <button type="button" class="dt-tab" data-filter="unread">Unread</button>
        <button type="button" class="dt-tab" data-filter="read">Read</button>
        @foreach($inquiries->pluck('type')->unique()->sort() as $t)
            <button type="button" class="dt-tab" data-filter="{{ $t }}">{{ ucfirst($t) }}</button>
        @endforeach
    </div>
    <table>
        <thead><tr>
            <th data-col="sr">Sr. No</th>
            <th data-col="date">Date</th>
            <th data-col="type">Type</th>
            <th data-col="name">Name</th>
            <th data-col="phone">Phone</th>
            <th data-col="email">Email</th>
            <th data-col="product">Product / Qty</th>
            <th data-col="message">Message</th>
            <th data-col="read">Read</th>
            <th data-col="actions" data-nosort data-noexport>Actions</th>
        </tr></thead>
        <tbody>
        @foreach($inquiries as $i)
            <tr data-tags="{{ $i->is_read ? 'read' : 'unread' }} {{ $i->type }}">
                <td data-sort="{{ $loop->iteration }}"><span class="srno">{{ $loop->iteration }}</span></td>
                <td class="nowrap" data-sort="{{ $i->created_at->timestamp }}" data-export="{{ $i->created_at->format('d M Y, h:i A') }}">{{ $i->created_at->format('d M Y') }}<br><small class="muted">{{ $i->created_at->format('h:i A') }}</small></td>
                <td><span class="pill {{ $i->type === 'quote' ? 'amber' : ($i->type === 'bulk' ? 'blue' : 'violet') }}">{{ ucfirst($i->type) }}</span></td>
                <td data-sort="{{ $i->name }}"><b style="color:var(--ap-text)">{{ $i->name }}</b></td>
                <td class="nowrap"><a href="tel:{{ $i->phone }}">{{ $i->phone }}</a></td>
                <td>@if($i->email)<a href="mailto:{{ $i->email }}">{{ $i->email }}</a>@else<span class="muted">—</span>@endif</td>
                <td data-export="{{ trim(($i->product ?: '').' '.($i->quantity ?: '')) }}">{{ $i->product ?: '—' }}@if($i->quantity)<br><small class="muted">{{ $i->quantity }}</small>@endif</td>
                <td data-export="{{ $i->message }}" style="min-width:240px;max-width:340px;white-space:normal">{{ Str::limit($i->message, 120) }}</td>
                <td data-sort="{{ $i->is_read ? 1 : 0 }}" data-export="{{ $i->is_read ? 'Yes' : 'No' }}">
                    <label class="sw"><input type="checkbox" data-toggle-url="{{ route('admin.inquiries.toggle', $i) }}" data-field="is_read" data-tag="read" data-tag-off="unread" @checked($i->is_read)><span class="tr"></span></label>
                </td>
                <td>
                    <div class="acts">
                        <a class="act wa" href="https://wa.me/{{ $wa($i->phone) }}?text={{ rawurlencode('Hello '.$i->name.', thank you for contacting '.config('site.name').'.') }}" target="_blank" rel="noopener" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a class="act neutral" href="tel:{{ $i->phone }}" title="Call"><i class="fa-solid fa-phone"></i></a>
                        @if($i->attachment)<a class="act view" href="{{ asset('storage/'.$i->attachment) }}" target="_blank" download title="Download attachment"><i class="fa-solid fa-paperclip"></i></a>@endif
                        <form method="POST" action="{{ route('admin.inquiries.destroy', $i) }}" data-confirm="Delete the inquiry from {{ $i->name }}?">@csrf @method('DELETE')<button class="act del" title="Delete"><i class="fa-regular fa-trash-can"></i></button></form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
