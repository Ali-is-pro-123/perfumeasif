@extends('layouts.site')
@section('title', 'Checkout | Asif Raza Perfumes')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <section class="page-hero compact">
    <p class="eyebrow">Checkout</p>
    <h1>Complete your order.</h1>
    <p>Enter delivery details and send your perfume order request.</p>
  </section>
  <section class="checkout-layout">
    <form class="checkout-form" method="POST" action="{{ route('checkout.store') }}">
      @csrf
      <div class="form-grid">
        <label>Full name<input name="customer_name" value="{{ old('customer_name') }}" required></label>
        <label>Email<input name="email" type="email" value="{{ old('email') }}" required></label>
        <label>Phone<input name="phone" value="{{ old('phone') }}"></label>
        <label>City<input name="city" value="{{ old('city') }}"></label>
        <label class="full">Delivery address<input name="address" value="{{ old('address') }}" required></label>
        <label class="full">Order notes<textarea name="notes">{{ old('notes') }}</textarea></label>
      </div>
      @if($errors->any())
        <div class="site-flash inline">Please check the highlighted checkout fields.</div>
      @endif
      <button class="wide-button" type="submit">Place order</button>
    </form>
    <aside class="cart-summary">
      <p class="eyebrow">Your order</p>
      @foreach($items as $item)
        <div><span>{{ $item['product']->name }} x {{ $item['quantity'] }}</span><strong>${{ number_format($item['subtotal'], 0) }}</strong></div>
      @endforeach
      <div><span>Total</span><strong>${{ number_format($total, 0) }}</strong></div>
    </aside>
  </section>
</main>
@endsection
