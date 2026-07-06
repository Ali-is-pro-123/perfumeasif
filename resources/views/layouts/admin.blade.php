<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin | Asif Raza Perfumes')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2" />
    <style>
      *{box-sizing:border-box}body{margin:0;background:#f4efe7;color:#211b18;font-family:Inter,Arial,sans-serif}.admin{display:grid;grid-template-columns:280px 1fr;min-height:100vh}.side{position:sticky;top:0;height:100vh;background:linear-gradient(180deg,#171313,#261c17);color:#fff;padding:26px 22px;display:flex;flex-direction:column;gap:22px}.admin-brand{display:flex;align-items:center;gap:12px;padding-bottom:18px;border-bottom:1px solid rgba(255,255,255,.12)}.admin-brand img{width:70px;height:46px;object-fit:contain}.admin-brand strong{display:block;font-size:.95rem;letter-spacing:.06em;text-transform:uppercase}.admin-brand span{color:rgba(255,255,255,.62);font-size:.78rem}.side nav{display:grid;gap:8px}.side a,.side button{display:flex;align-items:center;justify-content:space-between;gap:10px;width:100%;min-height:44px;color:rgba(255,255,255,.76);text-decoration:none;background:transparent;border:0;border-radius:8px;padding:0 12px;font:inherit;font-weight:800;cursor:pointer}.side a:hover,.side a.active,.side button:hover{color:#fff;background:rgba(255,255,255,.1)}.side-footer{margin-top:auto;padding-top:18px;border-top:1px solid rgba(255,255,255,.12)}.main{min-width:0;padding:28px clamp(18px,4vw,44px) 44px}.topbar{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:26px}.topbar p{margin:6px 0 0;color:#796d63}.topbar h1{margin:0;font-size:clamp(1.9rem,3vw,3rem);line-height:1}.topbar-actions{display:flex;gap:10px;flex-wrap:wrap}.card{background:#fffaf2;border:1px solid rgba(33,27,24,.1);border-radius:10px;padding:22px;box-shadow:0 18px 44px rgba(35,28,24,.06);margin-bottom:18px}.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.stat-card{position:relative;overflow:hidden;min-height:150px}.stat-card:after{content:"";position:absolute;right:-34px;top:-34px;width:120px;height:120px;border-radius:50%;background:rgba(190,140,60,.12)}.stat-card span{color:#a66e31;font-size:.76rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase}.stat-card strong{display:block;margin-top:18px;font-size:3rem;line-height:1}.stat-card p{margin:8px 0 0;color:#796d63}.panel-grid{display:grid;grid-template-columns:1.2fr .8fr;gap:16px;margin-top:16px}.quick-list{display:grid;gap:10px}.quick-list a,.message-row{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px;border:1px solid rgba(33,27,24,.08);border-radius:8px;background:#fff}.message-row{align-items:flex-start}.message-row p{margin:4px 0 0;color:#796d63}.message-row small,.muted{color:#8d8178}.btn,button{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:40px;background:#211b18;color:#fff;border:0;border-radius:8px;padding:0 14px;text-decoration:none;font-weight:900;cursor:pointer}.btn.light{color:#211b18;background:#fff;border:1px solid rgba(33,27,24,.12)}.danger{background:#9f2d2d}.table-wrap{overflow:auto;border:1px solid rgba(33,27,24,.1);border-radius:10px;background:#fffaf2}table{width:100%;border-collapse:collapse;min-width:720px}th,td{border-bottom:1px solid rgba(33,27,24,.08);padding:14px;text-align:left}th{color:#796d63;font-size:.78rem;letter-spacing:.08em;text-transform:uppercase}tr:last-child td{border-bottom:0}.badge{display:inline-flex;min-height:26px;align-items:center;border-radius:999px;padding:0 10px;background:#eee6dc;color:#5f4b3d;font-size:.75rem;font-weight:900}.badge.on{background:#e7d3a4;color:#3a2a15}.actions{display:flex;gap:8px;flex-wrap:wrap}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.form-grid .full{grid-column:1/-1}label{display:grid;gap:7px;color:#5f4f45;font-size:.86rem;font-weight:900}input:not([type=checkbox]),textarea{width:100%;padding:12px 13px;border:1px solid rgba(33,27,24,.14);border-radius:8px;background:#fff;color:#211b18}textarea{min-height:130px;resize:vertical}.check-row{display:flex;align-items:center;gap:10px;padding:12px;border:1px solid rgba(33,27,24,.1);border-radius:8px;background:#fff}.check-row input{width:auto}.alert{border-color:rgba(166,110,49,.25);background:#fff4df;color:#5b3f20}.message-list{display:grid;gap:14px}.message-card h3{display:flex;justify-content:space-between;gap:12px;margin:0 0 12px}.message-card p{color:#5f4f45;line-height:1.7}.empty{padding:26px;text-align:center;color:#796d63}.brand-gold{color:#d7a849}@media(max-width:980px){.admin{grid-template-columns:1fr}.side{position:static;height:auto}.side nav{grid-template-columns:repeat(2,minmax(0,1fr))}.panel-grid,.grid,.form-grid{grid-template-columns:1fr}.topbar{align-items:flex-start;flex-direction:column}table{min-width:640px}}@media(max-width:560px){.main{padding:20px 14px 34px}.side nav{grid-template-columns:1fr}.admin-brand img{width:62px}.stat-card strong{font-size:2.4rem}}
    </style>
  </head>
  <body>
    <div class="admin">
      <aside class="side">
        <div class="admin-brand">
          <img src="{{ asset('assets/logo-removebg-preview.png') }}" alt="Asif Raza Perfumes">
          <div>
            <strong>Admin Panel</strong>
            <span>Asif Raza Perfumes</span>
          </div>
        </div>
        <nav aria-label="Admin navigation">
          <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard <span>01</span></a>
          <a class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products') }}">Products <span>02</span></a>
          <a class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}" href="{{ route('admin.messages') }}">Messages <span>03</span></a>
          <a href="{{ route('home') }}">View Site <span>↗</span></a>
        </nav>
        <div class="side-footer">
          <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit">Logout</button></form>
        </div>
      </aside>
      <main class="main">
        @if(session('success'))<div class="card alert">{{ session('success') }}</div>@endif
        @yield('content')
      </main>
    </div>
  </body>
</html>
