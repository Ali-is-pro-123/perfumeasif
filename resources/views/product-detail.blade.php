@extends('layouts.site')
@section('title', $product->name . ' | Aurele Parfum')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>/</span><a href="{{ route('products') }}">Products</a><span>/</span><span>{{ $product->name }}</span>
  </nav>
  <section class="product-detail" data-product="{{ $product->name }}">
    <div class="detail-gallery">
      <div class="detail-image">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
      </div>
    </div>
    <div class="detail-copy">
      <p class="eyebrow">{{ $product->categoryName() }}</p>
      <h1>{{ $product->name }}</h1>
      <p class="detail-price">${{ number_format($product->price, 0) }}</p>
      <p class="detail-description">{{ $product->description }}</p>
      <form class="detail-cart-form" method="POST" action="{{ route('cart.add', $product) }}">
        @csrf
        <label>Quantity<input name="quantity" type="number" min="1" max="20" value="1"></label>
        <button class="wide-button add-button-detail" type="submit">
          <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 5v14" /><path d="M5 12h14" /></svg>
          <span>Add to cart</span>
        </button>
      </form>
      <div class="detail-accordion">
        <details open><summary>Fragrance notes</summary><p>{{ $product->notes }}</p></details>
        <details><summary>Size</summary><p>{{ $product->size }}</p></details>
      </div>
    </div>
  </section>
</main>
@endsection
