<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\PosOrderItem;
use App\Models\ProductVariant;
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
        $posOrder = PosOrder::all();
        return view('admin.pos.list', compact('posOrder'));
    }
    public function edit(Request $request )
    {
        //
        $productVariant = ProductVariant::all();
        $posOrderItem = PosOrderItem::where('pos_order_id', $request->id)->get();
        $query = Product::query();

        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        $products = $query->get();
        return view('admin.pos.update', compact('productVariant', 'posOrderItem'));
    }
    public function store(Request $request)
    {
        //
        $order = new PosOrder();
        $order->id;
        $order->staff_id = 1;
        $order->customer_id = 1;
        $order->total_amount = 0;
        $order->note = 'Hoá đơn tạm';
        $order->payment_method = 'Tiền mặt';
        $order->created_at = now();
        $order->status = 'Đang chờ';
        $order->save();
        $orderItems = OrderItem::where('order_id', 0)->get();
        foreach ($orderItems as $item) {
            $item->order_id = $order->id;
            $item->save();
        }
        return redirect()->route('pos.index');
    }
    public function addItem(Request $request, $id)
    {
        PosOrderItem::create([
            'pos_order_id' =>$request->id,
            'product_variant_id' => $id,
            'quantity' => 1,
            'price' => ProductVariant::find($id)->price,
    ]);
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
}
