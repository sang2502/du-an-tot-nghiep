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

    // Render lại HTML tổng tiền
    $cart_summary_html = view('client.shop.cart-summary', [
        'subtotal' => $subtotal,
        'voucher' => $voucher,
        'discount' => $discount,
        'total' => $total
    ])->render();

    return response()->json([
        'success' => true,
        'message' => 'Áp dụng mã giảm giá thành công!',
        'cart_summary_html' => $cart_summary_html,
    ]);
}
public function updateQuantity(Request $request)
{
    $item = CartItem::find($request->id);
    if ($item) {
        $item->quantity = max(1, (int)$request->quantity);
        $item->save();
        // Tính lại tổng
        $cartItems = CartItem::whereHas('cart', function ($q) {
            $q->where('user_id', session('user.id'));
        })->get();
        $subtotal = $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity);
        $voucher = session('voucher');
        $discount = 0;
        if ($voucher) {
            if ($voucher->discount_type == 'percent') {
                $discount = round($subtotal * $voucher->discount_value / 100);
                if ($voucher->max_discount && $discount > $voucher->max_discount) {
                    $discount = $voucher->max_discount;
                }
            } else {
                $discount = $voucher->discount_value;
            }
            if ($discount > $subtotal) $discount = $subtotal;
        }
        $total = $subtotal - $discount;
        // Render lại HTML tổng tiền
        $cart_summary_html = view('client.shop.cart-summary', compact('subtotal', 'voucher', 'discount', 'total'))->render();
        return response()->json([
            'success' => true,
            'item_total' => number_format(($item->variant->price ?? 0) * $item->quantity, 0, ',', '.'),
            'cart_summary_html' => $cart_summary_html,
        ]);
    }
    return response()->json(['success' => false]);
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
    $voucher = null;
    $discount = 0;
    $total = $subtotal;

    $cart_summary_html = view('client.shop.cart-summary', [
        'subtotal' => $subtotal,
        'voucher' => $voucher,
        'discount' => $discount,
        'total' => $total
    ])->render();

    return response()->json([
        'success' => true,
        'message' => 'Đã hủy mã giảm giá.',
        'cart_summary_html' => $cart_summary_html,
    ]);
}
}
