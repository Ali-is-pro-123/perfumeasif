<?php

if (($_ENV['VERCEL'] ?? getenv('VERCEL')) || ($_ENV['APP_ENV'] ?? getenv('APP_ENV')) === false) {
    $defaults = [
        'APP_NAME' => 'Asif Raza Perfumes',
        'APP_ENV' => 'production',
        'APP_KEY' => 'base64:u6b+n+/T7RkLd0oXz1Czw+YAl6S1xJS1WMFbZl7XiBQ=',
        'APP_DEBUG' => 'false',
        'APP_URL' => 'https://perfumeasif.vercel.app',
        'ASSET_URL' => 'https://perfumeasif.vercel.app',
        'DB_CONNECTION' => 'sqlite',
        'DB_DATABASE' => __DIR__.'/../database/database.sqlite',
        'SESSION_DRIVER' => 'cookie',
        'CACHE_STORE' => 'array',
        'LOG_CHANNEL' => 'stderr',
        'QUEUE_CONNECTION' => 'sync',
        'VIEW_COMPILED_PATH' => '/tmp/laravel-views',
        'APP_SERVICES_CACHE' => '/tmp/laravel-cache/services.php',
        'APP_PACKAGES_CACHE' => '/tmp/laravel-cache/packages.php',
        'APP_CONFIG_CACHE' => '/tmp/laravel-cache/config.php',
        'APP_ROUTES_CACHE' => '/tmp/laravel-cache/routes.php',
        'APP_EVENTS_CACHE' => '/tmp/laravel-cache/events.php',
    ];

    foreach ($defaults as $key => $value) {
        if (($_ENV[$key] ?? getenv($key)) === false) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv($key.'='.$value);
        }
    }
}

foreach (['/tmp/laravel-views', '/tmp/laravel-cache', '/tmp/laravel-sessions', '/tmp/laravel-storage/framework/cache/data'] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$adminEmail = $_ENV['ADMIN_EMAIL'] ?? getenv('ADMIN_EMAIL') ?: 'admin@perfume.test';
$adminPassword = $_ENV['ADMIN_PASSWORD'] ?? getenv('ADMIN_PASSWORD') ?: 'admin12345';
$adminSecret = $_ENV['APP_KEY'] ?? getenv('APP_KEY') ?: 'asif-raza-perfumes';
$adminCookie = 'asif_admin_auth';
$adminCookieValue = hash_hmac('sha256', $adminEmail, $adminSecret);
$isAdminAuthed = hash_equals($adminCookieValue, $_COOKIE[$adminCookie] ?? '');

if ($path === '/admin/login') {
    $loginError = '';

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if (hash_equals($adminEmail, $email) && hash_equals($adminPassword, $password)) {
            setcookie($adminCookie, $adminCookieValue, [
                'expires' => time() + 60 * 60 * 8,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            header('Location: /admin', true, 303);
            return;
        }

        $loginError = '<p class="error">Email ya password ghalat hai.</p>';
    }

    header('Content-Type: text/html; charset=UTF-8');
    echo str_replace(['{{ERROR}}', '{{EMAIL}}'], [$loginError, htmlspecialchars($adminEmail, ENT_QUOTES, 'UTF-8')], <<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login</title>
    <style>body{min-height:100vh;margin:0;display:grid;place-items:center;background:#171313;font-family:Arial,sans-serif}.box{width:min(430px,calc(100% - 32px));background:#fffaf2;padding:30px;border-radius:8px;color:#211b18;box-shadow:0 24px 70px rgba(0,0,0,.25)}label{display:block;font-weight:700;margin:14px 0 6px}input{width:100%;box-sizing:border-box;padding:13px;border:1px solid #ddd;border-radius:6px;background:#fff;color:#211b18;font-size:1rem}button{display:block;text-align:center;width:100%;box-sizing:border-box;margin-top:18px;padding:13px;border:0;border-radius:6px;background:#211b18;color:white;font-weight:700;cursor:pointer}.hint{color:#6d625c;line-height:1.6}.logo{display:block;max-width:170px;margin:0 auto 18px}.error{background:#ffe8e1;color:#8d2315;padding:11px 12px;border-radius:6px;font-weight:700}</style>
  </head>
  <body>
    <div class="box">
      <img class="logo" src="/assets/logo-removebg-preview.png" alt="Asif Raza Perfumes">
      <h1>Admin Login</h1>
      <p class="hint">Admin dashboard open karne ke liye email aur password zaroori hai.</p>
      {{ERROR}}
      <form method="POST" action="/admin/login">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{EMAIL}}" required autocomplete="username">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
        <button type="submit">Login to Dashboard</button>
      </form>
    </div>
  </body>
</html>
HTML);
    return;
}

if ($path === '/admin/logout') {
    setcookie($adminCookie, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    header('Location: /admin/login', true, 303);
    return;
}

if ($path === '/admin' || $path === '/admin/') {
    if (! $isAdminAuthed) {
        header('Location: /admin/login', true, 303);
        return;
    }

    header('Content-Type: text/html; charset=UTF-8');
    echo <<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Dashboard</title>
    <style>*{box-sizing:border-box}body{margin:0;background:#f4efe7;color:#211b18;font-family:Inter,Arial,sans-serif}.admin{display:grid;grid-template-columns:280px 1fr;min-height:100vh}.side{background:#171313;color:#fff;padding:26px 22px}.side img{width:150px;display:block;margin-bottom:22px}.side a{display:block;color:#fff;text-decoration:none;padding:12px;border-radius:8px;margin:6px 0;background:rgba(255,255,255,.08)}.main{padding:34px}.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}.card{background:#fffaf2;border:1px solid rgba(33,27,24,.1);border-radius:10px;padding:22px;box-shadow:0 18px 44px rgba(35,28,24,.06)}.card span{color:#a66e31;font-weight:900;text-transform:uppercase;font-size:.78rem}.card strong{display:block;font-size:3rem;margin-top:12px}.notice{margin-top:18px;color:#6d625c}.actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}.btn{background:#211b18;color:#fff;text-decoration:none;padding:12px 16px;border-radius:8px;font-weight:900}@media(max-width:900px){.admin{grid-template-columns:1fr}.grid{grid-template-columns:1fr}}</style>
  </head>
  <body>
    <div class="admin">
      <aside class="side">
        <img src="/assets/logo-removebg-preview.png" alt="Asif Raza Perfumes">
        <a href="/admin">Dashboard</a>
        <a href="/products">Products</a>
        <a href="/contact">Messages</a>
        <a href="/">View Site</a>
        <a href="/admin/logout">Logout</a>
      </aside>
      <main class="main">
        <h1>Admin Dashboard</h1>
        <p class="notice">Vercel demo mode: storefront is live. Database writes need Laravel hosting/cPanel/VPS.</p>
        <div class="grid">
          <div class="card"><span>Products</span><strong>6</strong><p>Total perfumes in catalog</p></div>
          <div class="card"><span>Categories</span><strong>4</strong><p>Dynamic shop categories</p></div>
          <div class="card"><span>Messages</span><strong>0</strong><p>Customer inquiries received</p></div>
          <div class="card"><span>Status</span><strong>Live</strong><p>Vercel demo ready</p></div>
        </div>
        <div class="actions">
          <a class="btn" href="/products">View Products</a>
          <a class="btn" href="/contact">View Contact Form</a>
          <a class="btn" href="/">Open Website</a>
        </div>
      </main>
    </div>
  </body>
</html>
HTML;
    return;
}

require __DIR__.'/../public/index.php';
