<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (app()->environment('production')) {
            return Response::make(<<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login</title>
    <style>body{min-height:100vh;margin:0;display:grid;place-items:center;background:#171313;font-family:Arial,sans-serif}.box{width:min(420px,calc(100% - 32px));background:#fffaf2;padding:30px;border-radius:8px}input{width:100%;box-sizing:border-box;padding:12px;margin:8px 0 14px;border:1px solid #ddd;border-radius:6px}a,button{display:block;text-align:center;width:100%;box-sizing:border-box;padding:12px;border:0;border-radius:6px;background:#211b18;color:white;font-weight:700;text-decoration:none}.hint{color:#6d625c;line-height:1.6}</style>
  </head>
  <body>
    <div class="box">
      <h1>Admin Login</h1>
      <p class="hint">Vercel demo mode is enabled for client testing.</p>
      <p>Email: admin@perfume.test<br>Password: admin12345</p>
      <a href="/admin">Open Admin Dashboard</a>
    </div>
  </body>
</html>
HTML);
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
