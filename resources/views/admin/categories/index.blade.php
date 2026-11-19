@extends('admin.layout')
@section('title', 'Categories')
@section('actions')<a href="{{ route('admin.categories.create') }}" class="btn btn-sm"><i class="fa-solid fa-plus"></i> Add Category</a>@endsection

@section('content')
<div class="card">
    <table>
        <tr><th>Sort</th><th></th><th>Name</th><th>Tagline</th><th>Products</th><th>Active</th><th></th></tr>
        @foreach($categories as $c)
            <tr>
                <td>{{ $c->sort }}</td>
                <td><span style="width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:{{ $c->color }};color:#fff"><i class="{{ $c->icon }}"></i></span></td>
                <td><b>{{ $c->name }}</b></td>
                <td class="muted">{{ $c->tagline }}</td>
                <td>{{ $c->products_count }}</td>
                <td><span class="tag {{ $c->is_active ? 'paid' : 'failed' }}">{{ $c->is_active ? 'Yes' : 'No' }}</span></td>
                <td style="white-space:nowrap">
                    <a class="act" href="{{ route('admin.categories.edit', $c) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" style="display:inline" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="act del"><i class="fa-regular fa-trash-can"></i></button></form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
