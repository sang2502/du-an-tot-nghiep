<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\PosOrderItem;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PosOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posOrder = PosOrder::where('status', 'Đang chờ')
            ->get();

        return view('admin.pos.list', compact('posOrder'));
    }
    public function edit(Request $request)
    {
        //
        $vouchers = Voucher::all();
        $productVariant = ProductVariant::all();
        $posOrderItem = PosOrderItem::where('pos_order_id', $request->id)->get();
        $posOrder = PosOrder::findOrFail($request->id);
        $query = Product::query();

        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }
        $products = $query->get();
        return view('admin.pos.update', compact('productVariant', 'posOrderItem', 'posOrder', 'vouchers'));
    }
    public function store(Request $request)
    {
        //
        $order = new PosOrder();
        $order->id;
        $order->staff_id = 3;
        $order->customer_id = 1;
        $order->total_amount = 0;
        $order->note = 'Hoá đơn tạm';
        $order->payment_method = 'null';
        $order->created_at = now();
        $order->status = 'Đang chờ';
        $order->updated_at = now();
        $order->save();
        return redirect()->route('pos.index');
    }
    public function addItem(Request $request, $id)
    {
        $posOrderId = $request->input('pos_order_id');
        $productVariantId = $request->input('product_variant_id'); // hoặc từ URL nếu đang dùng route

        $existingItem = PosOrderItem::where('pos_order_id', $posOrderId)
            ->where('product_variant_id', $productVariantId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            PosOrderItem::create([
                'pos_order_id' => $posOrderId,
                'product_variant_id' => $productVariantId,
                'quantity' => 1,
                'price' => ProductVariant::find($productVariantId)->price,
            ]);
        }
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $order = PosOrder::findOrFail($id);
        $order->total_amount = $request->total_amount;
        $order->discount_applied = $request->discount_applied;
        $order->payment_method = $request->payment_method;
        $order->updated_at = now();

        if ($order->payment_method == 'Tiền mặt') {
            $order->status = 'Đã thanh toán';
            $order->save();
            return redirect()->route('pos.bill', $order->id);
        } elseif ($order->payment_method == 'VNPAY') {
            $order->status = 'Chờ thanh toán'; // trạng thái tạm thời
            $order->save();

            // Tạo URL thanh toán VNPAY
            $vnp_TmnCode = "2LKOA8F9";
            $vnp_HashSecret = "E1S54MZI38X50YDEDIK6LDCSEFHHX49L";
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('vnpay.return'); // route xử lý callback

            $vnp_TxnRef = $order->id;
            $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->id;
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->total_amount * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            ksort($inputData);
            $query = "";
            $hashdata = "";
            $i = 0;
            foreach ($inputData as $key => $value) {
                $hashdata .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
                $i++;
            }

            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

            return redirect()->away($vnp_Url);
        } else {
            return redirect()->route('pos.bill', $order->id)->with('error', 'Vui lòng chọn phương thức thanh toán hợp lệ!');
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');

        $order = PosOrder::find($vnp_TxnRef);

        if ($vnp_ResponseCode == '00') {
            $order->status = 'Đã thanh toán';
        } else {
            $order->status = 'Thanh toán thất bại';
        }

        $order->save();

        return redirect()->route('pos.bill', $order->id)->with('message', 'Kết quả thanh toán: ' . $order->status);
    }


    public function bill(Request $request, $id)
    {
        $order = PosOrder::with('items.productVariant.product')->findOrFail($id);
        $items = PosOrderItem::where('pos_order_id', $id)->get();
        return view('admin.pos.bill', compact('order', 'items'));
    }

    public function deleteItem($id)
    {
        $item = PosOrderItem::findOrFail($id);
        $item->delete();
        return redirect()->back();
    }
    public function history(Request $request)
    {
        $posOrder = PosOrder::where('status', 'Đã thanh toán')->get();

        $order = null;
        $items = collect();

        if ($request->filled('id')) {
            $order = PosOrder::with('items.productVariant.product')->find($request->id);

            if (!$order) {
                return back()->with('error', 'Không tìm thấy đơn hàng.');
            }

            $items = PosOrderItem::where('pos_order_id', $order->id)->get();
        }

        return view('admin.pos.history', compact('posOrder', 'order', 'items'));
    }
}
