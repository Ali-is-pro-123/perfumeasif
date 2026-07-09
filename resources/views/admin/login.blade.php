<!DOCTYPE html>
<html lang="en">
  <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login</title>
    <style>*{box-sizing:border-box}html,body{max-width:100%;overflow-x:hidden}body{min-height:100vh;margin:0;display:grid;place-items:center;background:#171313;font-family:Arial,sans-serif;padding:18px}.box{width:min(420px,100%);background:#fffaf2;padding:clamp(22px,6vw,34px);border-radius:8px;box-shadow:0 24px 70px rgba(0,0,0,.28)}h1{margin:0 0 14px;font-size:clamp(2rem,10vw,3rem);line-height:1}p{line-height:1.55;color:#6d625c}label{display:grid;gap:7px;margin-top:14px;font-weight:700;color:#5f4f45}input{width:100%;padding:13px;border:1px solid #ddd;border-radius:6px;background:#fff;color:#211b18}button{width:100%;min-height:46px;margin-top:18px;padding:12px;border:0;border-radius:6px;background:#211b18;color:white;font-weight:700}.err{color:#9f2d2d;background:#ffe8e1;padding:10px;border-radius:6px}@media(max-width:420px){body{place-items:start center;padding-top:28px}.box{padding:20px}}</style>
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
