@extends('layouts.site')
@section('title', 'Contact | Aurele Parfum')
@section('body_class', 'inner-page')
@section('header_class', 'is-scrolled')
@section('content')
<main class="page-main">
  <section class="page-hero compact">
    <p class="eyebrow">Customer care</p>
    <h1>Contact</h1>
    <p>Ask about orders, fragrance matching, gifting, wholesale, or refill availability.</p>
  </section>
  <section class="contact-layout">
    <div class="contact-panel">
      <p class="eyebrow">Support</p>
      <h2>We usually reply within one business day.</h2>
      <div class="contact-list">
        <p><strong>Email</strong><span>care@aureleparfum.com</span></p>
        <p><strong>Studio</strong><span>24 Rue Saint-Honore, Paris</span></p>
      </div>
    </div>
    <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
      @csrf
      @if(session('success'))<p class="form-status">{{ session('success') }}</p>@endif
      <label>Name<input name="name" type="text" placeholder="Your name" required /></label>
      <label>Email<input name="email" type="email" placeholder="you@example.com" required /></label>
      <label>Address<input name="address" type="text" placeholder="Street, city, country" required /></label>
      <label>Message<textarea name="message" rows="6" placeholder="How can we help?" required></textarea></label>
      <button class="wide-button" type="submit">Send message</button>
    </form>
  </section>
</main>
@endsection
