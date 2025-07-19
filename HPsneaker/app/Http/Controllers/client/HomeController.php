<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Product::select('products.*')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->take(8)
            ->get();

        $categories = Category::all();
        $newProducts = Product::orderBy('created_at', 'desc')->take(3)->get();
        $brands = Brand::all();

        return view('client.home.index', compact('bestSellers', 'categories', 'newProducts', 'brands'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('home.index');
        }

        $products = Product::where('name', 'like', "%$query%")->get();
        return view('client.home.search', compact('products'));
    }
}
