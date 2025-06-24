<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ProductReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        Review::updateOrCreate(
        ['product_id' => $id, 'user_id' => $user['id']],
        [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]
    );

        return back()->with('success', 'Đánh giá của bạn đã được lưu.');
    }
}
