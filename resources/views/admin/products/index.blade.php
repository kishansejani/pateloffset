@extends('admin.layout')
@section('title', 'Products')
@section('actions')<a href="{{ route('admin.products.create') }}" class="btn btn-sm"><i class="fa-solid fa-plus"></i> Add Product</a>@endsection

@section('content')
<div class="card">
    <form class="filters">
        <input class="input" name="q" value="{{ request('q') }}" placeholder="Search products">
        <select class="input" name="category"><option value="">All categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>@endforeach</select>
        <button class="btn btn-sm">Filter</button>
    </form>
    <table>
        <tr><th></th><th>Name</th><th>Category</th><th>Starting price</th><th>Tags</th><th>Views</th><th>Active</th><th></th></tr>
        @foreach($products as $p)
            <tr>
                <td style="width:80px"><div style="width:70px;border-radius:10px;overflow:hidden"><x-mockup :art="$p->art" :color="$p->color" :title="$p->name" :image="$p->image"/></div></td>
                <td><b>{{ $p->name }}</b></td>
                <td>{{ $p->category->name }}</td>
                <td>₹{{ number_format($p->startingPrice()) }} <small class="muted">/ {{ $p->startingQty() }}</small></td>
                <td>@foreach(['is_new' => 'New', 'is_bestseller' => 'Best', 'is_hot' => 'Hot', 'is_featured' => 'Featured'] as $f => $l)@if($p->$f)<span class="tag">{{ $l }}</span> @endif @endforeach</td>
                <td>{{ $p->views }}</td>
                <td><span class="tag {{ $p->is_active ? 'paid' : 'failed' }}">{{ $p->is_active ? 'Yes' : 'No' }}</span></td>
                <td style="white-space:nowrap">
                    <a class="act" href="{{ route('product', $p) }}" target="_blank"><i class="fa-regular fa-eye"></i></a>
                    <a class="act" href="{{ route('admin.products.edit', $p) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="act del"><i class="fa-regular fa-trash-can"></i></button></form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $products->links('partials.pagination') }}
</div>
@endsection
