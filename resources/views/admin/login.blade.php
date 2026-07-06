<!DOCTYPE html>
<html lang="en">
  <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login</title>
    <style>body{min-height:100vh;margin:0;display:grid;place-items:center;background:#171313;font-family:Arial,sans-serif}.box{width:min(420px,calc(100% - 32px));background:#fffaf2;padding:30px;border-radius:8px}input{width:100%;box-sizing:border-box;padding:12px;margin:8px 0 14px;border:1px solid #ddd;border-radius:6px}button{width:100%;padding:12px;border:0;border-radius:6px;background:#211b18;color:white;font-weight:700}.err{color:#9f2d2d}</style>
  </head>
  <body>
    <form class="box" method="POST" action="{{ route('admin.login.submit') }}">
      @csrf
      <h1>Admin Login</h1>
      <p>Email: admin@perfume.test<br>Password: admin12345</p>
      @error('email')<p class="err">{{ $message }}</p>@enderror
      <label>Email<input name="email" type="email" value="{{ old('email') }}" required></label>
      <label>Password<input name="password" type="password" required></label>
      <button type="submit">Login</button>
    </form>
  </body>
</html>
