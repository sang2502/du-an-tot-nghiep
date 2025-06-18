<?php
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Cart;
class ShopCartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with(['variant.product', 'variant.size', 'variant.color'])
            ->whereHas('cart', function ($q) {
                $q->where('user_id', session('user.id'));
            })
            ->get();
        return view('client.shop.product-cart', compact('cartItems'));
    }

    public function removeCart($id)
    {
        if (!session()->has('user')) {
            return redirect()->route('user.login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
        }

        $cart = Cart::where('user_id', session('user.id'))->first();
        if (!$cart) {
            return redirect()->route('shop.index')->with('error', 'Giỏ hàng không tồn tại.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('shop.cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
}
