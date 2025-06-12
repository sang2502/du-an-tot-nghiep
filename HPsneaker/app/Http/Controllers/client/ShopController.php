<?php
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\CartItem;


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

    public function addToCart(Request $request, $id)
    {
        if (!session()->has('user')) {
            return redirect()->route('user.login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
        }

        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        $variantId = $request->input('product_variant_id', null);

        // 1. Lấy hoặc tạo cart cho user
        $cart = Cart::firstOrCreate([
            'user_id' => session('user.id'),
        ]);

        // 2. Kiểm tra sản phẩm (và biến thể) đã có trong cart chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // Nếu đã có thì tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có thì tạo mới
            CartItem::create([
                'user_id' => session('user.id'),
                'cart_id' => $cart->id,
                'product_variant_id' => $variantId ?? null,
                'quantity' => $quantity,
            ]);
        }
        return redirect()->route('shop.cart.index');
    }
}