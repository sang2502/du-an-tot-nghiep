<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::where('status', 1);

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('client.blog.index', compact('blogs', ));
    }
}
