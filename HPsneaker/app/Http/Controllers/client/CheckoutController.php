<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    // Trang checkout
    public function index()
    {
        $userId = session('user.id');
        if (!$userId) {
            return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng!');
        }
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart
            ? CartItem::with(['variant.product', 'variant.size', 'variant.color'])
                ->where('cart_id', $cart->id)->get()
            : collect();
        $cartTotal = $cartItems->sum(fn($item) => ($item->variant->price ?? 0) * $item->quantity);

        return view('client.checkout.index', compact('cartItems', 'cartTotal'));
    }

    // Đặt hàng COD hoặc MOMO
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:1000',
            'payment' => 'required|string',
        ]);
        $userId = session('user.id');
        if (!$userId) return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng!');

        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) return back()->with('error', 'Giỏ hàng không tồn tại!');
        $cartItems = CartItem::with(['variant'])->where('cart_id', $cart->id)->get();
        if ($cartItems->isEmpty()) return back()->with('error', 'Giỏ hàng rỗng!');

        DB::beginTransaction();
        try {
            $cartTotal = $cartItems->sum(fn ($i) => ($i->variant->price ?? 0) * $i->quantity);

            $order = Order::create([
                'user_id'          => $userId,
                'name'             => $data['name'],
                'email'            => $data['email'],
                'phone'            => $data['phone'],
                'total_amount'     => $cartTotal,
                'voucher_id'       => null,
                'discount_applied' => 0,
                'status'           => 'processing',
                'payment_method'   => $data['payment'],
                'shipping_address' => $data['address'],
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->price ?? 0,
                ]);
            }
            $cartItems->each->delete();
            $cart->delete();

            DB::commit();
            return redirect()->route('checkout.success', ['orderId' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    // Thanh toán VNPAY (tạo đơn hàng + build URL redirect)
    public function vnpay(Request $request)
    {
        $userId = session('user.id');
        if (!$userId) return response()->json(['redirect' => route('user.login')]);
        $data = $request->all();

        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with(['variant'])->where('cart_id', $cart->id)->get() : collect();
        $cartTotal = $cartItems->sum(fn ($i) => ($i->variant->price ?? 0) * $i->quantity);
        if ($cartItems->isEmpty()) return response()->json(['redirect' => route('shop.cart.index')]);

        // Tạo đơn hàng trạng thái pending
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'          => $userId,
                'name'             => $data['name'] ?? '',
                'email'            => $data['email'] ?? '',
                'phone'            => $data['phone'] ?? '',
                'total_amount'     => $cartTotal,
                'voucher_id'       => null,
                'discount_applied' => 0,
                'status'           => 'pending',
                'payment_method'   => 'VNPAY',
                'shipping_address' => $data['address'] ?? '',
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->price ?? 0,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Lỗi tạo đơn hàng: ' . $e->getMessage()]);
        }

        // Build VNPAY data (KHÔNG truyền vnp_IpnUrl vào inputData)
        $vnp_TmnCode    = env('VNPAY_TMN_CODE', 'YIR2W0WO');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET', 'A01P7Y76ANEN4524PEUIVDIBHTSA04BI');
        $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_ReturnUrl  = env('APP_URL') . "/checkout/vnpay-return";
        $orderId        = $order->id;
        $orderDesc      = "Thanh toan don hang {$orderId}"; // Không dấu hai chấm và ký tự lạ
        $orderType      = "billpayment";
        $amount         = (int)$cartTotal * 100;
        $locale         = "vn";
        $ipAddr         = $request->ip();
        $expire         = date('YmdHis', strtotime('+15 minutes'));

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $ipAddr,
            "vnp_Locale"     => $locale,
            "vnp_OrderInfo"  => $orderDesc,
            "vnp_OrderType"  => $orderType,
            "vnp_ReturnUrl"  => $vnp_ReturnUrl,
            "vnp_TxnRef"     => $orderId,
            "vnp_ExpireDate" => $expire
        ];

        // Sắp xếp và urlencode value cho hashData
        ksort($inputData);
        $hashdataArr = [];
        foreach ($inputData as $key => $value) {
            $hashdataArr[] = $key . "=" . urlencode($value); // PHẢI ENCODE value
        }
        $hashdata = implode('&', $hashdataArr);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Build query đúng chuẩn RFC3986 (encode chuẩn cho VNPAY)
        $query   = http_build_query($inputData, '', '&', PHP_QUERY_RFC3986);
        $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        Log::info('VNPAY HASH SECRET', [$vnp_HashSecret]);
        Log::info('VNPAY INPUT', $inputData);
        Log::info('VNPAY HASH STRING', [$hashdata]);
        Log::info('VNPAY SECURE HASH', [$vnpSecureHash]);
        Log::info('VNPAY URL', [$vnp_Url]);
        return response()->json(['redirect' => $vnp_Url]);
    }

    // Trang hóa đơn sau khi thanh toán thành công hoặc thất bại
    public function success($orderId)
    {
        $order = Order::with(['orderItems.variant.product'])->findOrFail($orderId);
        return view('client.checkout.success', compact('order'));
    }

    // Xử lý callback ReturnUrl từ VNPAY
    public function vnpayReturn(Request $request)
    {
        $input = $request->all();
        $vnp_HashSecret = env('VNPAY_HASH_SECRET', 'A01P7Y76ANEN4524PEUIVDIBHTSA04BI');
        $vnp_SecureHash = $input['vnp_SecureHash'] ?? '';
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);
        ksort($input);
        $hashdata = [];
        foreach ($input as $key => $value) {
            $hashdata[] = $key . "=" . urlencode($value);
        }
        $hashString = implode('&', $hashdata);
        $secureHash = hash_hmac('sha512', $hashString, $vnp_HashSecret);

        $orderId = $input['vnp_TxnRef'] ?? null;
        $order   = Order::find($orderId);

        if ($secureHash == $vnp_SecureHash && $order) {
            if (($input['vnp_ResponseCode'] ?? '') == '00') {
                $order->status = 'paid';
                $order->save();
                // XÓA CART_ITEM trước rồi mới xóa CART
                $cart = Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->id)->delete();
                    $cart->delete();
                }
            } else {
                $order->status = 'failed';
                $order->save();
            }
            return redirect()->route('checkout.success', ['orderId' => $order->id]);
        } else {
            abort(403, "Chữ ký không hợp lệ");
        }
    }


}
