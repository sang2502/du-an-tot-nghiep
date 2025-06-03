<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use \App\Models\Role;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function loginForm()
    {
        return view('admin.login.admin_login');
    }
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Tìm user có email và password giống nhau (plain text)
    $user = User::where('email', $request->email)
                ->where('password', $request->password)
                ->first();

    if ($user) {
        if ($user->role_id == 1) {
            session(['admin' => $user->toArray()]);
            return redirect('/admin/category')->with('success', 'Đăng nhập thành công!');
        } else {
            return back()->withErrors(['email' => 'Bạn không có quyền admin.']);
        }
    }

    return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
}

    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin')->with('success', 'Đăng xuất thành công!');
    }
}
