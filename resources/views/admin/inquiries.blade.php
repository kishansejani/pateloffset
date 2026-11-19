@extends('admin.layout')
@section('title', 'Inquiries')

@section('content')
<div class="card">
    <table>
        <tr><th>Date</th><th>Type</th><th>Name</th><th>Contact</th><th>Product / Qty</th><th>Message</th><th>File</th><th></th></tr>
        @forelse($inquiries as $i)
            <tr style="{{ $i->is_read ? 'opacity:.6' : '' }}">
                <td style="white-space:nowrap">{{ $i->created_at->format('d M, h:i A') }}</td>
                <td><span class="tag {{ $i->is_read ? '' : 'pending' }}">{{ ucfirst($i->type) }}</span></td>
                <td><b>{{ $i->name }}</b></td>
                <td style="white-space:nowrap"><a href="tel:{{ $i->phone }}">{{ $i->phone }}</a> <a href="https://wa.me/{{ preg_replace('/\D/', '', strlen(preg_replace('/\D/', '', $i->phone)) === 10 ? '91'.$i->phone : $i->phone) }}" target="_blank" rel="noopener" style="color:#25d366"><i class="fa-brands fa-whatsapp"></i></a>@if($i->email)<br><small>{{ $i->email }}</small>@endif</td>
                <td>{{ $i->product ?: '—' }}@if($i->quantity)<br><small class="muted">{{ $i->quantity }}</small>@endif</td>
                <td style="max-width:300px;white-space:normal;min-width:200px">{{ $i->message }}</td>
                <td>@if($i->attachment)<a class="act" href="{{ asset('storage/'.$i->attachment) }}" target="_blank" download><i class="fa-solid fa-paperclip"></i></a>@endif</td>
                <td style="white-space:nowrap">
                    <form method="POST" action="{{ route('admin.inquiries.toggle', $i) }}" style="display:inline">@csrf @method('PATCH')<button class="act" title="Mark read/unread"><i class="fa-solid {{ $i->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i></button></form>
                    <form method="POST" action="{{ route('admin.inquiries.destroy', $i) }}" style="display:inline" onsubmit="return confirm('Delete this inquiry?')">@csrf @method('DELETE')<button class="act del"><i class="fa-regular fa-trash-can"></i></button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="muted">No inquiries yet.</td></tr>
        @endforelse
    </table>
    {{ $inquiries->links('partials.pagination') }}
</div>
@endsection
