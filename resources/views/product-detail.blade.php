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
      <p class="eyebrow">{{ $product->category }}</p>
      <h1>{{ $product->name }}</h1>
      <p class="detail-price">${{ number_format($product->price, 0) }}</p>
      <p class="detail-description">{{ $product->description }}</p>
      <a class="wide-button add-button-detail" href="{{ route('contact') }}">
        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M5 12h14" /><path d="m13 6 6 6-6 6" /></svg>
        <span>Request information</span>
      </a>
      <div class="detail-accordion">
        <details open><summary>Fragrance notes</summary><p>{{ $product->notes }}</p></details>
        <details><summary>Size</summary><p>{{ $product->size }}</p></details>
      </div>
    </div>
  </section>
</main>
@endsection
