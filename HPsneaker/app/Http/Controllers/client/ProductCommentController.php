<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class ProductCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = session('user');

    if (!$user) {
        return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập để bình luận.');
    }

    $request->validate([
        'cmt' => 'required|string|max:1000',
    ]);

    Comment::create([
        'product_id' => $id,
        'name'       => $user['name'],
        'email'      => $user['email'],
        'cmt'        => $request->cmt,
        'status'     => true,
    ]);

    return back()->with('success', 'Bình luận đã được gửi.');
    }
}
