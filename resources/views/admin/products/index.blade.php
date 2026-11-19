@extends('admin.layout')
@section('title', 'Products')
@section('crumb', 'Catalog')
@section('icon', 'fa-solid fa-cube')
@section('subtitle', 'Manage printing products, quantity pricing, badges and visibility.')
@section('actions')
    <a href="{{ route('admin.categories.index') }}" class="ap-btn"><i class="fa-solid fa-layer-group"></i>Categories</a>
    <a href="{{ route('admin.products.create') }}" class="ap-btn dark"><i class="fa-solid fa-plus"></i>Add product</a>
@endsection

@section('content')
<div class="ap-stats">
    <button type="button" class="ap-stat on" data-dt-target="products" data-filter="" style="--c:#1e40af"><span class="lbl">All products</span><span class="ic"><i class="fa-solid fa-cube"></i></span><b class="val" data-count>{{ $products->count() }}</b><span class="note">In the catalog</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="products" data-filter="active" style="--c:#10b981"><span class="lbl">Active</span><span class="ic"><i class="fa-solid fa-circle-check"></i></span><b class="val" data-count>{{ $products->where('is_active', true)->count() }}</b><span class="note">Visible on the storefront</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="products" data-filter="featured" style="--c:#f59e0b"><span class="lbl">Featured</span><span class="ic"><i class="fa-solid fa-star"></i></span><b class="val" data-count>{{ $products->where('is_featured', true)->count() }}</b><span class="note">Highlighted on home page</span><span class="bar"></span></button>
    <button type="button" class="ap-stat" data-dt-target="products" data-filter="inactive" style="--c:#f43f5e"><span class="lbl">Inactive</span><span class="ic"><i class="fa-solid fa-circle-pause"></i></span><b class="val" data-count>{{ $products->where('is_active', false)->count() }}</b><span class="note">Hidden from customers</span><span class="bar"></span></button>
</div>

<div class="dt" data-dt="products" data-title="Products" data-unit="products" data-empty="No products yet">
    <div class="dt-tabs">
        <button type="button" class="dt-tab on" data-filter="">All</button>
        <button type="button" class="dt-tab" data-filter="active">Active</button>
        <button type="button" class="dt-tab" data-filter="inactive">Inactive</button>
        <button type="button" class="dt-tab" data-filter="featured"><i class="fa-solid fa-star" style="font-size:12px"></i>Featured</button>
        <button type="button" class="dt-tab" data-filter="bestseller">Bestseller</button>
        <button type="button" class="dt-tab" data-filter="hot">Hot</button>
        <button type="button" class="dt-tab" data-filter="new">New</button>
        <select class="dt-select" aria-label="Filter by category" onchange="apTables.products.setFilter(this.value)">
            <option value="">All categories</option>
            @foreach($categories as $c)<option value="cat-{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <table>
        <thead><tr>
            <th data-col="sr">Sr. No</th>
            <th data-col="product">Product</th>
            <th data-col="category">Category</th>
            <th data-col="price">Starting price</th>
            <th data-col="dispatch">Dispatch</th>
            <th data-col="views">Views</th>
            <th data-col="featured">Featured</th>
            <th data-col="status">Status</th>
            <th data-col="badges">Badges</th>
            <th data-col="actions" data-nosort data-noexport>Actions</th>
        </tr></thead>
        <tbody>
        @foreach($products as $p)
            @php $tags = collect(['is_featured' => 'featured', 'is_bestseller' => 'bestseller', 'is_hot' => 'hot', 'is_new' => 'new'])->filter(fn ($t, $f) => $p->$f)->implode(' '); @endphp
            <tr data-tags="{{ $p->is_active ? 'active' : 'inactive' }} {{ $tags }} cat-{{ $p->category_id }}">
                <td data-sort="{{ $loop->iteration }}"><span class="srno">{{ $loop->iteration }}</span></td>
                <td data-sort="{{ $p->name }}" data-export="{{ $p->name }}">
                    <div class="ent">
                        <span class="thumb"><x-mockup :art="$p->art" :color="$p->color" :title="$p->name" :image="$p->image"/></span>
                        <div><b>{{ $p->name }}</b><small>{{ Str::limit($p->short_description, 48) ?: '—' }}</small><code>/product/{{ $p->slug }}</code></div>
                    </div>
                </td>
                <td>{{ $p->category->name }}</td>
                <td class="nowrap" data-sort="{{ $p->startingPrice() }}" data-export="₹{{ number_format($p->startingPrice()) }} / {{ $p->startingQty() }} pcs"><b style="color:var(--ap-text)">₹{{ number_format($p->startingPrice()) }}</b> <small class="muted">/ {{ number_format($p->startingQty()) }} pcs</small></td>
                <td class="nowrap">{{ $p->dispatch_time }}</td>
                <td data-sort="{{ $p->views }}">{{ number_format($p->views) }}</td>
                <td data-sort="{{ $p->is_featured ? 1 : 0 }}" data-export="{{ $p->is_featured ? 'Yes' : 'No' }}">
                    <label class="sw"><input type="checkbox" data-toggle-url="{{ route('admin.products.toggle', $p) }}" data-field="is_featured" data-tag="featured" @checked($p->is_featured)><span class="tr" style="--on:#f59e0b"></span></label>
                </td>
                <td data-sort="{{ $p->is_active ? 1 : 0 }}" data-export="{{ $p->is_active ? 'Active' : 'Inactive' }}">
                    <label class="sw"><input type="checkbox" data-toggle-url="{{ route('admin.products.toggle', $p) }}" data-field="is_active" data-tag="active" data-tag-off="inactive" @checked($p->is_active)><span class="tr"></span><span class="st-on">Active</span><span class="st-off">Inactive</span></label>
                </td>
                <td data-export="{{ collect(['is_new' => 'New', 'is_bestseller' => 'Bestseller', 'is_hot' => 'Hot'])->filter(fn ($l, $f) => $p->$f)->implode(', ') }}">
                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                        @if($p->is_new)<span class="pill blue">New</span>@endif
                        @if($p->is_bestseller)<span class="pill green">Bestseller</span>@endif
                        @if($p->is_hot)<span class="pill red"><i class="fa-solid fa-fire"></i>Hot</span>@endif
                        @unless($p->is_new || $p->is_bestseller || $p->is_hot)<span class="muted">—</span>@endunless
                    </div>
                </td>
                <td>
                    <div class="acts">
                        <a class="act view" href="{{ route('product', $p) }}" target="_blank" title="View on website"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        <a class="act edit" href="{{ route('admin.products.edit', $p) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.products.destroy', $p) }}" data-confirm="Delete product “{{ $p->name }}”? This cannot be undone.">@csrf @method('DELETE')<button class="act del" title="Delete"><i class="fa-regular fa-trash-can"></i></button></form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
