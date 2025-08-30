<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

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
            // Lưu session admin với key gọn gàng
            session([
                'admin' => [
                    'id'   => $user->id,
                    'name' => $user->name,
                    'role' => $user->role_id, // dùng "role" để gọi cho dễ
                ]
            ]);

            if ($user->role_id == 1) {
                // Admin full quyền
                return redirect('/admin/category')->with('success', 'Đăng nhập thành công!');
            } elseif ($user->role_id == 4) {
                // Admin giao hàng
                return redirect('/admin/delivery')->with('success', 'Đăng nhập thành công!');
            } elseif ($user->role_id == 3) {
                // Tại quầy
                return redirect('/admin/pos')->with('success', 'Đăng nhập thành công!');
            } else {
                // Không có quyền
                session()->forget('admin');
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
