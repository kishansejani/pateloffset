@extends('admin.layout')
@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@php
    $tiersText = old('tiers_text', collect($product->price_tiers ?? [])->map(fn ($t) => $t['qty'].' = '.$t['price'])->implode("\n"));
    $optionsText = old('options_text', collect($product->options ?? [])->map(fn ($o) => $o['name'].': '.collect($o['values'])->map(fn ($v) => $v['label'].'='.$v['add'])->implode(', '))->implode("\n"));
@endphp

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf @if($product->exists) @method('PUT') @endif
    @if($errors->any())<div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $errors->first() }}</div>@endif
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:22px" class="order-grid">
        <div class="card form-grid">
            <div class="field full"><label>Name *</label><input class="input" name="name" value="{{ old('name', $product->name) }}" required></div>
            <div class="field"><label>Category *</label><select class="input" name="category_id">@foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
            <div class="field"><label>Slug (auto if empty)</label><input class="input" name="slug" value="{{ old('slug', $product->slug) }}"></div>
            <div class="field full"><label>Short description</label><input class="input" name="short_description" value="{{ old('short_description', $product->short_description) }}"></div>
            <div class="field"><label>Highlights (one per line)</label><textarea class="input" name="description" rows="5">{{ old('description', $product->description) }}</textarea></div>
            <div class="field"><label>Specifications (one per line)</label><textarea class="input" name="specifications" rows="5">{{ old('specifications', $product->specifications) }}</textarea></div>
            <div class="field"><label>Price tiers * <small class="muted">(quantity = total price, one per line)</small></label><textarea class="input" name="tiers_text" rows="4" placeholder="500 = 1500&#10;1000 = 2500" required>{{ $tiersText }}</textarea></div>
            <div class="field"><label>Options <small class="muted">(Name: Label=extra ₹ per pc, ...)</small></label><textarea class="input" name="options_text" rows="4" placeholder="Printing Side: Single Side=0, Both Side=0.5">{{ $optionsText }}</textarea></div>
            <div class="field"><label>MRP per unit (for % OFF)</label><input class="input" type="number" step="0.01" name="mrp_per_unit" value="{{ old('mrp_per_unit', $product->mrp_per_unit) }}"></div>
            <div class="field"><label>"Design with us" fee (₹)</label><input class="input" type="number" step="0.01" name="design_fee" value="{{ old('design_fee', $product->design_fee) }}"></div>
            <div class="field"><label>Dispatch time *</label><input class="input" name="dispatch_time" value="{{ old('dispatch_time', $product->dispatch_time) }}" required></div>
        </div>
        <div>
            <div class="card">
                <h3>Image</h3>
                <div style="border-radius:14px;overflow:hidden;margin-bottom:12px"><x-mockup :art="$product->art ?? 'card'" :color="$product->color" :title="$product->name ?: 'Preview'" :image="$product->image"/></div>
                <input type="file" name="image" accept="image/*" class="input">
                @if($product->image)<label style="display:flex;gap:8px;margin-top:8px;font-size:14px"><input type="checkbox" name="remove_image" value="1"> Remove photo (use graphic)</label>@endif
                <p class="muted" style="font-size:12.5px;margin-top:8px">No photo? An auto-generated graphic is shown using the style &amp; colour below.</p>
                <div class="form-grid">
                    <div class="field"><label>Graphic style</label><select class="input" name="art">@foreach($arts as $a)<option @selected(old('art', $product->art) === $a)>{{ $a }}</option>@endforeach</select></div>
                    <div class="field"><label>Colour</label><input class="input" type="color" name="color" value="{{ old('color', $product->color) }}" style="height:46px;padding:4px"></div>
                </div>
            </div>
            <div class="card">
                <h3>Visibility</h3>
                @foreach(['is_active' => 'Active (visible on site)', 'is_new' => 'New Arrival', 'is_bestseller' => 'Bestseller', 'is_hot' => 'Hot Product', 'is_featured' => 'Featured'] as $f => $l)
                    <label style="display:flex;gap:10px;margin-bottom:10px;font-weight:600"><input type="checkbox" name="{{ $f }}" value="1" @checked(old($f, $product->$f))> {{ $l }}</label>
                @endforeach
            </div>
            <button class="btn btn-block"><i class="fa-solid fa-floppy-disk"></i> Save Product</button>
        </div>
    </div>
</form>
<style>@media(max-width:1000px){.order-grid{grid-template-columns:1fr!important}}</style>
@endsection
