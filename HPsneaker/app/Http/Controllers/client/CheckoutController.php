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
            'payment' => 'required|string', // ví dụ: 'COD', 'VNPAY', 'MOMO'
        ]);

        $userId = session('user.id');
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return back()->with('error', 'Giỏ hàng không tồn tại!');
        }
        $cartItems = CartItem::with(['variant'])->where('cart_id', $cart->id)->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng rỗng!');
        }

        DB::beginTransaction();
        try {
            // Tính tổng tiền
            $cartTotal = $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity);

            // Tạo đơn hàng (khớp với migration mới)
            $order = Order::create([
                'user_id'        => $userId,
                'total_amount'   => $cartTotal,
                'voucher_id'     => null, // nếu có voucher thì xử lý logic ở đây
                'discount_applied'=> 0, // nếu có thì xử lý logic ở đây
                'status'         => 'processing',
                'payment_method' => $data['payment'],
                'shipping_address'=> $data['address'],
                // Nếu bạn có customer_name, email, phone... thì bổ sung vào migration/model!
            ]);

            // Lưu từng item vào order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->price ?? 0,
                ]);
            }

            // Xoá giỏ hàng và các item
            $cartItems->each->delete();
            $cart->delete();

            DB::commit();

            // Chuyển sang trang success (hóa đơn), truyền orderId
            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    // Trang hiển thị hóa đơn thành công cho khách
    public function success($orderId)
    {
        $order = Order::with(['orderItems.variant.product'])->findOrFail($orderId);

        return view('client.checkout.success', compact('order'));
    }
}
