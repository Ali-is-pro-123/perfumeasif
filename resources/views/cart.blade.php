@extends('layouts.site')
@section('title', 'Cart | Asif Raza Perfumes')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <section class="page-hero compact">
    <p class="eyebrow">Shopping cart</p>
    <h1>Your cart</h1>
    <p>Review selected perfumes before sending your order request.</p>
  </section>
  <section class="cart-layout">
    <div class="cart-panel">
      @forelse($items as $item)
        <article class="cart-item">
          <img src="{{ asset($item['product']->image) }}" alt="{{ $item['product']->name }}">
          <div>
            <h3>{{ $item['product']->name }}</h3>
            <p>{{ $item['product']->size }} · ${{ number_format($item['product']->price, 0) }}</p>
          </div>
          <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="cart-qty">
            @csrf
            @method('PATCH')
            <input name="quantity" type="number" min="0" max="20" value="{{ $item['quantity'] }}">
            <button type="submit">Update</button>
          </form>
          <strong>${{ number_format($item['subtotal'], 0) }}</strong>
          <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
            @csrf
            @method('DELETE')
            <button class="cart-remove" type="submit">Remove</button>
          </form>
        </article>
      @empty
        <div class="cart-empty">
          <h2>Your cart is empty.</h2>
          <a class="dark-action" href="{{ route('products') }}">Shop products</a>
        </div>
      @endforelse
    </div>
    <aside class="cart-summary">
      <p class="eyebrow">Order summary</p>
      <div><span>Subtotal</span><strong>${{ number_format($total, 0) }}</strong></div>
      <div><span>Shipping</span><strong>Calculated later</strong></div>
      <a class="wide-button" href="{{ route('contact') }}">Request checkout</a>
    </aside>
  </section>
</main>
@endsection
