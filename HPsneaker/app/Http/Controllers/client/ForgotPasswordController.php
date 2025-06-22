<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendNewPasswordMail;

class ForgotPasswordController extends Controller
{
    //
    public function showForm()
    {
        return view('client.account.forgot-password');
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại trong hệ thống.');
        }

        $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
        $user->password = $newPassword; 
        $user->save();

        // Gửi mail
        Mail::to($user->email)->send(new SendNewPasswordMail($user, $newPassword));


        return back()->with('success', 'Mật khẩu mới đã được gửi đến email của bạn.');
    }
}
