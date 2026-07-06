<article class="product-card" data-product="{{ $product->name }}">
  @if($product->badge)
    <span class="product-badge">{{ $product->badge }}</span>
  @endif
  <a class="product-media" href="{{ route('products.show', $product) }}" aria-label="View {{ $product->name }}">
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
  </a>
  <div class="product-info">
    <p>{{ $product->category }}</p>
    <h3><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
    <span>{{ $product->notes }}</span>
  </div>
  <div class="product-footer">
    <strong>${{ number_format($product->price, 0) }}</strong>
    <span>{{ $product->size }}</span>
    <a class="add-button" href="{{ route('products.show', $product) }}" aria-label="View {{ $product->name }}">
      <svg aria-hidden="true" viewBox="0 0 24 24">
        <path d="M5 12h14" />
        <path d="m13 6 6 6-6 6" />
      </svg>
    </a>
  </div>
</article>
