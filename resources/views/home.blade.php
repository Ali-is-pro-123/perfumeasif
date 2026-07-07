@extends('layouts.site')

@section('title', 'Aurele Perfume | Fine Fragrance House')

@section('content')
<main>
  <section class="home-hero">
    <div class="home-hero-media" aria-hidden="true"></div>
    <div class="home-hero-overlay"></div>
    <div class="home-hero-content">
      <p class="eyebrow">Small-batch fine fragrance</p>
      <h1>Aurele Perfume</h1>
      <p>Modern extrait perfumes built around luminous florals, mineral amber, and textured woods.</p>
      <div class="hero-actions">
        <a class="primary-action" href="{{ route('products') }}">
          <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M5 12h14" /><path d="m13 6 6 6-6 6" /></svg>
          Shop products
        </a>
        <a class="secondary-action" href="{{ route('about') }}">Our standard</a>
      </div>
    </div>
  </section>

  <section class="feature-strip">
    <article><span>01</span><strong>Extrait strength</strong><p>Long-wearing formulas designed for a polished, skin-close trail.</p></article>
    <article><span>02</span><strong>Gift-ready packaging</strong><p>Weighted glass, minimal cartons, and a fragrance card in every order.</p></article>
    <article><span>03</span><strong>Try before opening</strong><p>Use the included sample first, then keep or exchange the sealed bottle.</p></article>
  </section>

  <section class="collection-highlight">
    <div class="highlight-image" aria-hidden="true"></div>
    <div class="highlight-copy">
      <p class="eyebrow">New season edit</p>
      <h2>Fragrance built like a wardrobe.</h2>
      <p>Start with a clean everyday scent, add a warm evening extrait, then keep a discovery set ready for travel and gifting.</p>
      <div class="highlight-actions">
        <a class="dark-action" href="{{ route('products') }}">Shop the edit</a>
        <a class="text-link" href="{{ route('products') }}">View bestseller</a>
      </div>
    </div>
  </section>

  <section class="section-shell">
    <div class="section-heading">
      <div><p class="eyebrow">Featured fragrances</p><h2>Signature scents</h2></div>
      <a class="text-link" href="{{ route('products') }}">View all products</a>
    </div>
    <div class="product-grid">
      @foreach($featuredProducts as $product)
        @include('partials.product-card', ['product' => $product])
      @endforeach
    </div>
  </section>

  <section class="editorial-band">
    <div><p class="eyebrow">Fragrance house</p><h2>Quiet luxury, composed for daily ritual.</h2></div>
    <p>Aurele creates refined perfumes that feel personal, elegant, and wearable. Every scent is macerated in small batches and finished in refill-minded glass.</p>
  </section>

  <section class="scent-slider-section" aria-label="Featured fragrance slider">
    <div class="slider-copy">
      <p class="eyebrow">Fragrance carousel</p>
      <h2>Signature perfumes in motion.</h2>
      <p>Explore bestsellers, new arrivals, and evening extrait perfumes in a smooth auto-moving carousel.</p>
    </div>
    <div class="scent-slider" data-scent-slider tabindex="0">
      @foreach($carouselProducts as $product)
        <article class="slider-card {{ $loop->iteration === 2 ? 'slider-card-green' : '' }} {{ $loop->iteration === 3 ? 'slider-card-dark' : '' }} {{ $loop->iteration === 4 ? 'slider-card-citrus' : '' }} {{ $loop->iteration === 5 ? 'slider-card-linen' : '' }} {{ $loop->iteration === 6 ? 'slider-card-set' : '' }}" style="--card-image: url('{{ asset($product->image) }}')">
          <span class="slider-badge">{{ $product->badge }}</span>
          <h3>{{ $product->name }}</h3>
          <p>{{ $product->description }}</p>
          <div class="slider-card-footer">
            <strong>${{ number_format($product->price, 0) }}</strong>
            <a href="{{ route('products.show', $product) }}">View</a>
          </div>
        </article>
      @endforeach
    </div>
  </section>
</main>
@endsection
