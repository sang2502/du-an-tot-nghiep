<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Hiển thị trang checkout
    public function index()
    {
        $userId = session('user.id');
        $cart = Cart::where('user_id', $userId)->first();

        $cartItems = $cart
            ? CartItem::with(['variant.product', 'variant.size', 'variant.color'])
                ->where('cart_id', $cart->id)
                ->get()
            : collect();

        $cartTotal = $cartItems->sum(function($item) {
            return ($item->variant->price ?? 0) * $item->quantity;
        });

        return view('client.checkout.index', compact('cartItems', 'cartTotal'));
    }

    // Xử lý đặt hàng
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:1000',
            'payment' => 'required|string', // giá trị: 'COD', 'VNPAY', 'MOMO', v.v.
        ]);

        $userId = session('user.id');
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return back()->with('error', 'Giỏ hàng không tồn tại!');
        }
        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        if ($cartItems->count() === 0) {
            return back()->with('error', 'Giỏ hàng rỗng!');
        }

        DB::beginTransaction();
        try {
            // 1. Tạo đơn hàng
            $order = Order::create([
                'user_id'      => $userId,
                'customer_name'=> $data['name'],
                'customer_email'=> $data['email'],
                'customer_phone'=> $data['phone'],
                'customer_address'=> $data['address'],
                'note'         => $data['note'] ?? '',
                'status'       => 'processing', // hoặc mặc định của bạn
                'payment_method'=> $data['payment'],
                'total'        => $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity),
            ]);

            // 2. Lưu từng sản phẩm vào bảng order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'         => $order->id,
                    'product_variant_id'=> $item->product_variant_id,
                    'quantity'         => $item->quantity,
                    'price'            => $item->variant->price ?? 0,
                ]);
            }

            // 3. Xóa cart và cart items (clear giỏ hàng)
            $cartItems->each->delete();
            $cart->delete();

            DB::commit();
            return redirect()->route('shop.cart.index')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }
}
