@extends('layouts.admin')
@section('title', 'Category Form | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h1>
    <p>Use categories to organize the products page and product forms.</p>
  </div>
  <a class="btn light" href="{{ route('admin.categories') }}">Back categories</a>
</div>
<form class="card" method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
  @csrf
  @if($category->exists) @method('PUT') @endif
  <div class="form-grid">
    <label>Name<input name="name" value="{{ old('name', $category->name) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug', $category->slug) }}"></label>
    <label>Sort Order<input name="sort_order" type="number" value="{{ old('sort_order', $category->sort_order ?: 0) }}" required></label>
    <div class="check-row"><input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}><label for="is_active">Active category</label></div>
    <label class="full">Description<textarea name="description">{{ old('description', $category->description) }}</textarea></label>
  </div>
  <button type="submit">Save Category</button>
</form>
@endsection
