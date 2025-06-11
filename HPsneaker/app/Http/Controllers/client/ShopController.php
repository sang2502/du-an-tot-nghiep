<?php 
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Color;
use App\Models\Size;
use App\Models\Voucher;
use App\Models\ProductVariant;
class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->get();
        $categories = Category::all();
        return view('client.shop.index', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('shop.index');
        }
        
        $products = Product::where('name', 'like', "%$query%")->get();
        return view('client.shop.search', compact('products'));
    }

// ShopController.php
public function show($name, $id)
{
    $product = Product::findOrFail($id);
    $variant = ProductVariant::where('product_id', $product->id)->get();
    // Lấy các sản phẩm cùng danh mục, loại trừ sản phẩm hiện tại
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->limit(8)
        ->get();

    // Lấy gallery nếu có
    $gallery = ProductImage::where('product_id', $product->id)->get();
    $product->gallery = $gallery;

    return view('client.shop.product-detail', compact('product', 'relatedProducts', 'variant'));
}
}