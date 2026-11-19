@extends('admin.layout')
@section('title', 'Categories')
@section('crumb', 'Catalog')
@section('icon', 'fa-solid fa-layer-group')
@section('subtitle', 'Organise the printing catalog into categories shown in the website menu.')
@section('actions')
    <a href="{{ route('admin.products.index') }}" class="ap-btn"><i class="fa-solid fa-cube"></i>Products</a>
    <a href="{{ route('admin.categories.create') }}" class="ap-btn dark"><i class="fa-solid fa-plus"></i>Add category</a>
@endsection

@section('content')
<div class="ap-stats">
    <button type="button" class="ap-stat on" data-dt-target="categories" data-filter="" style="--c:#1e40af"><span class="lbl">All categories</span><span class="ic"><i class="fa-solid fa-layer-group"></i></span><b class="val" data-count>{{ $categories->count() }}</b><span class="note">Total catalog</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="categories" data-filter="active" style="--c:#10b981"><span class="lbl">Active</span><span class="ic"><i class="fa-solid fa-circle-check"></i></span><b class="val" data-count>{{ $categories->where('is_active', true)->count() }}</b><span class="note">Visible on the storefront</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="categories" data-filter="inactive" style="--c:#f43f5e"><span class="lbl">Inactive</span><span class="ic"><i class="fa-solid fa-circle-pause"></i></span><b class="val" data-count>{{ $categories->where('is_active', false)->count() }}</b><span class="note">Hidden from customers</span><span class="bar"></span></button>
    <a href="{{ route('admin.products.index') }}" class="ap-stat" style="--c:#f59e0b"><span class="lbl">Products</span><span class="ic"><i class="fa-solid fa-cube"></i></span><b class="val">{{ $categories->sum('products_count') }}</b><span class="note">Across all categories</span><span class="bar"></span></a>
</div>

<div class="dt" data-dt="categories" data-title="Categories" data-unit="categories" data-empty="No categories yet">
    <div class="dt-tabs">
        <button type="button" class="dt-tab on" data-filter="">All</button>
        <button type="button" class="dt-tab" data-filter="active">Active</button>
        <button type="button" class="dt-tab" data-filter="inactive">Inactive</button>
        <button type="button" class="dt-tab" data-filter="has-products"><i class="fa-solid fa-star" style="font-size:12px"></i>With products</button>
    </div>
    <table>
        <thead><tr>
            <th data-col="sr">Sr. No</th>
            <th data-col="category">Category</th>
            <th data-col="products">Products</th>
            <th data-col="sort">Menu order</th>
            <th data-col="status">Status</th>
            <th data-col="slug">Slug</th>
            <th data-col="updated">Updated</th>
            <th data-col="actions" data-nosort data-noexport>Actions</th>
        </tr></thead>
        <tbody>
        @foreach($categories as $c)
            <tr data-tags="{{ $c->is_active ? 'active' : 'inactive' }} {{ $c->products_count ? 'has-products' : '' }}">
                <td data-sort="{{ $loop->iteration }}"><span class="srno">{{ $loop->iteration }}</span></td>
                <td data-sort="{{ $c->name }}" data-export="{{ $c->name }}">
                    <div class="ent">
                        <span class="thumb" style="background:{{ $c->color }}">
                            @if($c->image)<img src="{{ asset('storage/'.$c->image) }}" alt="">@else<i class="{{ $c->icon }}"></i>@endif
                        </span>
                        <div><b>{{ $c->name }}</b><small>{{ $c->tagline ?: '—' }}</small><code>/category/{{ $c->slug }}</code></div>
                    </div>
                </td>
                <td data-sort="{{ $c->products_count }}" data-export="{{ $c->products_count }}"><span class="pill violet"><i class="fa-solid fa-cube"></i>{{ $c->products_count }} {{ Str::plural('product', $c->products_count) }}</span></td>
                <td data-sort="{{ $c->sort }}">{{ $c->sort }}</td>
                <td data-sort="{{ $c->is_active ? 1 : 0 }}" data-export="{{ $c->is_active ? 'Active' : 'Inactive' }}">
                    <label class="sw"><input type="checkbox" data-toggle-url="{{ route('admin.categories.toggle', $c) }}" data-field="is_active" data-tag="active" data-tag-off="inactive" @checked($c->is_active)><span class="tr"></span><span class="st-on">Active</span><span class="st-off">Inactive</span></label>
                </td>
                <td>{{ $c->slug }}</td>
                <td class="nowrap" data-sort="{{ $c->updated_at?->timestamp }}">{{ $c->updated_at?->format('d M Y') }}</td>
                <td>
                    <div class="acts">
                        <a class="act view" href="{{ route('category', $c) }}" target="_blank" title="View on website"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        <a class="act edit" href="{{ route('admin.categories.edit', $c) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" data-confirm="Delete category “{{ $c->name }}”? This cannot be undone.">@csrf @method('DELETE')<button class="act del" title="Delete"><i class="fa-regular fa-trash-can"></i></button></form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
