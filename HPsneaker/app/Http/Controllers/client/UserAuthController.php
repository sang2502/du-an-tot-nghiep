<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.account.login');
    }

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $user->password === $request->password) {
        session(['user' => $user->toArray()]);
        return view('client.home.index')->with('success', 'Đăng nhập thành công!');
    }

    return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
}

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('user.login')->with('success', 'Đăng xuất thành công!');
    }
}
