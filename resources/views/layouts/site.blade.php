<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Aurele Parfum')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('site.css') }}?v=5" />
  </head>
  <body class="@yield('body_class')">
    <div class="announcement-bar">
      <span>Complimentary shipping over $90</span>
      <span>Discovery set included with every full bottle</span>
    </div>

    <header class="site-header @yield('header_class')">
      <a class="brand" href="{{ route('home') }}" aria-label="Aurele home">
        <img class="brand-logo" src="{{ asset('assets/logo-removebg-preview.png') }}" alt="Asif Raza Perfumes">
      </a>
      <button class="site-menu-toggle" type="button" data-site-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="Open menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <nav class="nav-links" id="primary-navigation" data-site-menu aria-label="Primary navigation">
        <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        <a class="{{ request()->routeIs('products*') ? 'active' : '' }}" href="{{ route('products') }}">Products</a>
        <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
        <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        <a class="{{ request()->routeIs('cart') ? 'active' : '' }}" href="{{ route('cart') }}">Cart ({{ array_sum(session('cart', [])) }})</a>
      </nav>
      <a class="admin-secret-trigger" href="{{ route('admin.login') }}" aria-label="Secure access" title="Secure access">
        <svg aria-hidden="true" viewBox="0 0 24 24">
          <path d="M7 10V8a5 5 0 0 1 10 0v2" />
          <path d="M6.5 10h11A1.5 1.5 0 0 1 19 11.5v7A1.5 1.5 0 0 1 17.5 20h-11A1.5 1.5 0 0 1 5 18.5v-7A1.5 1.5 0 0 1 6.5 10Z" />
        </svg>
      </a>
    </header>

    @if(session('success'))
      <div class="site-flash">{{ session('success') }}</div>
    @endif

    @yield('content')

    <footer class="site-footer">
      <div class="footer-main">
        <div class="footer-brand">
          <a class="footer-logo" href="{{ route('home') }}">
            <img class="footer-logo-image" src="{{ asset('assets/logo-removebg-preview.png') }}" alt="Asif Raza Perfumes">
          </a>
          <p>Fine fragrance house creating modern extrait perfumes with luminous florals, polished amber, and textured woods.</p>
          <div class="footer-social" aria-label="Social links">
            <a href="{{ route('contact') }}">IG</a>
            <a href="{{ route('contact') }}">TK</a>
            <a href="{{ route('contact') }}">PT</a>
          </div>
        </div>
        <nav class="footer-column" aria-label="Shop links">
          <strong>Shop</strong>
          <a href="{{ route('products') }}">All products</a>
          <a href="{{ route('products') }}">Bestseller</a>
          <a href="{{ route('products') }}">Discovery set</a>
          <a href="{{ route('contact') }}">Gift cards</a>
        </nav>
        <nav class="footer-column" aria-label="Company links">
          <strong>Company</strong>
          <a href="{{ route('about') }}">About Aurele</a>
          <a href="{{ route('contact') }}">Contact</a>
          <a href="{{ route('contact') }}">Wholesale</a>
          <a href="{{ route('contact') }}">Stockists</a>
        </nav>
        <div class="footer-column">
          <strong>Customer care</strong>
          <span>care@aureleparfum.com</span>
          <span>Monday to Friday</span>
          <span>10:00 - 18:00</span>
          <span>Ships in 2 business days</span>
        </div>
      </div>
      <div class="footer-bottom">
        <span>2026 Aurele Parfum. All rights reserved.</span>
        <nav aria-label="Legal links">
          <a href="{{ route('contact') }}">Privacy</a>
          <a href="{{ route('contact') }}">Terms</a>
          <a href="{{ route('contact') }}">Shipping</a>
        </nav>
      </div>
    </footer>
    <script src="{{ asset('site.js') }}?v=4"></script>
  </body>
</html>
