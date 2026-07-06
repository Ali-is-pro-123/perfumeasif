@extends('layouts.admin')
@section('title', 'Product Form | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>{{ $product->exists ? 'Edit Product' : 'Add Product' }}</h1>
    <p>{{ $product->exists ? 'Update product information and placement.' : 'Create a new perfume entry for the website.' }}</p>
  </div>
  <a class="btn light" href="{{ route('admin.products') }}">Back products</a>
</div>
<form class="card" method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
  @csrf
  @if($product->exists) @method('PUT') @endif
  <div class="form-grid">
    <label>Name<input name="name" value="{{ old('name', $product->name) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $product->slug) }}"></label>
    <label>Category<input name="category" value="{{ old('category', $product->category) }}"></label>
    <label>Badge<input name="badge" value="{{ old('badge', $product->badge) }}"></label>
    <label class="full">Notes<input name="notes" value="{{ old('notes', $product->notes) }}"></label>
    <label class="full">Description<textarea name="description">{{ old('description', $product->description) }}</textarea></label>
    <label class="full">Image Path<input name="image" value="{{ old('image', $product->image ?: 'assets/brand-01.jpeg') }}" placeholder="assets/brand-01.jpeg"></label>
    <label>Price<input name="price" type="number" step="0.01" value="{{ old('price', $product->price ?: 0) }}" required></label>
    <label>Size<input name="size" value="{{ old('size', $product->size ?: '50 ml') }}" required></label>
    <label>Sort Order<input name="sort_order" type="number" value="{{ old('sort_order', $product->sort_order ?: 0) }}" required></label>
    <div class="check-row"><input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}><label for="is_featured">Featured product</label></div>
    <div class="check-row"><input id="is_carousel" name="is_carousel" type="checkbox" value="1" {{ old('is_carousel', $product->is_carousel) ? 'checked' : '' }}><label for="is_carousel">Show in carousel</label></div>
  </div>
  <button type="submit">Save Product</button>
</form>
@endsection
