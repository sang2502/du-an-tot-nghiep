<?php
namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Voucher;
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
    public function applyVoucher(Request $request)
{
    $voucher = Voucher::where('code', $request->voucher_code)
        ->where(function($q) {
            $q->whereNull('valid_to')->orWhere('valid_to', '>=', now());
        })
        ->first();

    if (!$voucher) {
        return response()->json([
            'success' => false,
            'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
        ]);
    }

    session(['voucher' => $voucher]);

    // Lấy lại cartItems giống như hàm index()
    $cartItems = CartItem::with(['variant.product', 'variant.size', 'variant.color'])
        ->whereHas('cart', function ($q) {
            $q->where('user_id', session('user.id'));
        })
        ->get();

    $subtotal = $cartItems->sum(function($i) {
        return ($i->variant->price ?? 0) * $i->quantity;
    });

    $discount = 0;
    if ($voucher->discount_type == 'percent') {
        $discount = round($subtotal * $voucher->discount_value / 100);
        if ($voucher->max_discount && $discount > $voucher->max_discount) {
            $discount = $voucher->max_discount;
        }
    } else {
        $discount = $voucher->discount_value;
    }
    if ($discount > $subtotal) $discount = $subtotal;
    $total = $subtotal - $discount;

    return response()->json([
        'success' => true,
        'message' => 'Áp dụng mã giảm giá thành công!',
        'voucher' => $voucher,
        'discount' => number_format($discount, 0, ',', '.'),
        'total' => number_format($total, 0, ',', '.'),
        'subtotal' => number_format($subtotal, 0, ',', '.'),
        'voucher_code' => $voucher->code,
    ]);
}
public function removeVoucher()
{
    session()->forget('voucher');
    $cartItems = CartItem::with(['variant.product', 'variant.size', 'variant.color'])
        ->whereHas('cart', function ($q) {
            $q->where('user_id', session('user.id'));
        })
        ->get();
    $subtotal = $cartItems->sum(function($i) {
        return ($i->variant->price ?? 0) * $i->quantity;
    });
    $total = $subtotal;
    return response()->json([
        'success' => true,
        'message' => 'Đã hủy mã giảm giá.',
        'subtotal' => number_format($subtotal, 0, ',', '.'),
        'total' => number_format($total, 0, ',', '.'),
    ]);
}
}
