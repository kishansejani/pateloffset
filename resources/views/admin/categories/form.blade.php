@extends('admin.layout')
@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="card form-grid" style="max-width:800px">
    @csrf @if($category->exists) @method('PUT') @endif
    @if($errors->any())<div class="alert alert-error full"><i class="fa-solid fa-circle-exclamation"></i>{{ $errors->first() }}</div>@endif
    <div class="field"><label>Name *</label><input class="input" name="name" value="{{ old('name', $category->name) }}" required></div>
    <div class="field"><label>Slug (auto if empty)</label><input class="input" name="slug" value="{{ old('slug', $category->slug) }}"></div>
    <div class="field"><label>Icon (Font Awesome class) *</label><input class="input" name="icon" value="{{ old('icon', $category->icon) }}" required></div>
    <div class="field"><label>Sort order</label><input class="input" type="number" name="sort" value="{{ old('sort', $category->sort) }}"></div>
    <div class="field"><label>Graphic style</label><select class="input" name="art">@foreach($arts as $a)<option @selected(old('art', $category->art) === $a)>{{ $a }}</option>@endforeach</select></div>
    <div class="field"><label>Colour</label><input class="input" type="color" name="color" value="{{ old('color', $category->color) }}" style="height:46px;padding:4px"></div>
    <div class="field full"><label>Tagline</label><input class="input" name="tagline" value="{{ old('tagline', $category->tagline) }}"></div>
    <div class="field full"><label>Description</label><textarea class="input" name="description">{{ old('description', $category->description) }}</textarea></div>
    <div class="field full"><label>Photo (optional — replaces the graphic)</label><input type="file" name="image" accept="image/*" class="input"></div>
    <label class="full" style="display:flex;gap:10px;font-weight:600"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))> Active</label>
    <div class="full"><button class="btn"><i class="fa-solid fa-floppy-disk"></i> Save Category</button></div>
</form>
@endsection
