@extends('layouts.site')
@section('title', 'Products | Aurele Parfum')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <section class="page-hero compact">
    <p class="eyebrow">Shop fragrance</p>
    <h1>Products</h1>
    <p>Explore extrait perfumes, discovery sets, and refill-minded bottles for every atmosphere.</p>
  </section>
  <section class="shop-layout">
    <aside class="shop-sidebar" aria-label="Product categories">
      <strong>Categories</strong>
      <a class="{{ $activeCategory ? '' : 'active' }}" href="{{ route('products') }}">All fragrance</a>
      @foreach($categories as $category)
        <a class="{{ $activeCategory === $category->slug ? 'active' : '' }}" href="{{ route('products', ['category' => $category->slug]) }}">{{ $category->name }}</a>
      @endforeach
    </aside>
    <div>
      <div class="shop-toolbar"><span>{{ $products->count() }} products - Ships in 2 business days</span></div>
      <div class="product-grid product-grid-wide">
        @foreach($products as $product)
          @include('partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </div>
  </section>
</main>
@endsection
