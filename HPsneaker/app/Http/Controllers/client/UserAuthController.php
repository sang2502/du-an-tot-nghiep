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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            session(['user' => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            ]]);
            return redirect()->route('home.index');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('home.index');
    }
    public function showProfile()
    {
        $user = session('user');
        return view('client.account.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $userArr = session('user');
        $user = User::find($userArr['id']);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password; // Nên dùng bcrypt nếu có hash
        }

        $user->update($data);

        session(['user' => $user->toArray()]);
        return view('client.account.profile', compact('user'))->with('success', 'Cập nhật thông tin thành công!');
    }
    public function editProfile()
    {
        $user = session('user');
        return view('client.account.edit', compact('user'));
    }
    public function showRegisterForm()
{
    return view('client.account.register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->role_id = 3;
    $user->save();

    // Đăng nhập luôn cho user mới
    session(['user' => [
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
    ]]);

    return redirect()->route('home.index')->with('success', 'Đăng ký thành công!');
}
    
}
