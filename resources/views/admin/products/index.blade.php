@extends('layouts.admin')
@section('title', 'Products | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>Products</h1>
    <p>Update perfume details, prices, carousel status, and images.</p>
  </div>
  <a class="btn" href="{{ route('admin.products.create') }}">Add product</a>
</div>
<div class="table-wrap">
  <table>
    <thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Featured</th><th>Carousel</th><th>Actions</th></tr></thead>
    <tbody>
      @foreach($products as $product)
        <tr>
          <td><strong>{{ $product->name }}</strong><br><span class="muted">{{ $product->size }}</span></td>
          <td>{{ $product->category }}</td>
          <td>${{ number_format($product->price, 0) }}</td>
          <td><span class="badge {{ $product->is_featured ? 'on' : '' }}">{{ $product->is_featured ? 'Yes' : 'No' }}</span></td>
          <td><span class="badge {{ $product->is_carousel ? 'on' : '' }}">{{ $product->is_carousel ? 'Yes' : 'No' }}</span></td>
          <td>
            <div class="actions">
              <a class="btn light" href="{{ route('admin.products.edit', $product) }}">Edit</a>
              <form method="POST" action="{{ route('admin.products.delete', $product) }}">@csrf @method('DELETE')<button class="danger" type="submit">Delete</button></form>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
