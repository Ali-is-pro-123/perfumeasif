@extends('layouts.site')
@section('title', 'Order received | Asif Raza Perfumes')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <section class="page-hero compact">
    <p class="eyebrow">Order received</p>
    <h1>Thank you.</h1>
    <p>Your order {{ $order->order_number }} has been received. Our team will contact you for confirmation.</p>
    <div class="hero-actions">
      <a class="dark-action" href="{{ route('products') }}">Continue shopping</a>
      <a class="light-action" href="{{ route('home') }}">Back home</a>
    </div>
  </section>
</main>
@endsection
