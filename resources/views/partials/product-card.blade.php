<article class="product-card" data-product="{{ $product->name }}">
  @if($product->badge)
    <span class="product-badge">{{ $product->badge }}</span>
  @endif
  <a class="product-media" href="{{ route('products.show', $product) }}" aria-label="View {{ $product->name }}">
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
  </a>
  <div class="product-info">
    <p>{{ $product->categoryName() }}</p>
    <h3><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
    <span>{{ $product->notes }}</span>
  </div>
  <div class="product-footer">
    <strong>${{ number_format($product->price, 0) }}</strong>
    <span>{{ $product->size }}</span>
    <a class="add-to-cart-link" href="{{ route('products.show', $product) }}" aria-label="Open {{ $product->name }} details to add to cart">
      <svg aria-hidden="true" viewBox="0 0 24 24">
        <path d="M12 5v14" />
        <path d="M5 12h14" />
      </svg>
      <span>Add to cart</span>
    </a>
  </div>
</article>
