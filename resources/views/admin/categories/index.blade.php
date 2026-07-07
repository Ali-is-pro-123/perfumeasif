@extends('layouts.admin')
@section('title', 'Categories | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>Categories</h1>
    <p>Create and manage dynamic product categories.</p>
  </div>
  <a class="btn" href="{{ route('admin.categories.create') }}">Add category</a>
</div>
<div class="table-wrap">
  <table>
    <thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @foreach($categories as $category)
        <tr>
          <td><strong>{{ $category->name }}</strong><br><span class="muted">{{ $category->description }}</span></td>
          <td>{{ $category->slug }}</td>
          <td>{{ $category->products_count }}</td>
          <td><span class="badge {{ $category->is_active ? 'on' : '' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span></td>
          <td>
            <div class="actions">
              <a class="btn light" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
              <form method="POST" action="{{ route('admin.categories.delete', $category) }}">@csrf @method('DELETE')<button class="danger" type="submit">Delete</button></form>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
