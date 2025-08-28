<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Tìm theo: name, email, phone, shipping_address
        if ($request->filled('keyword')) {
            $kw = trim($request->keyword);
            $kwLike = '%'.$kw.'%';
            $kwDigits = preg_replace('/\D+/', '', $kw); // để match SĐT có dấu/khoảng trắng

            $query->where(function ($q) use ($kwLike, $kwDigits) {
                $q->where('name', 'like', $kwLike)
                    ->orWhere('email', 'like', $kwLike)
                    ->orWhere('phone', 'like', $kwLike)
                    ->orWhere('shipping_address', 'like', $kwLike);

                // Match thêm biến thể SĐT (loại bỏ khoảng trắng, dấu chấm, gạch)
                if ($kwDigits !== '') {
                    $q->orWhereRaw(
                        "REPLACE(REPLACE(REPLACE(phone,' ',''),'-',''),'.','') LIKE ?",
                        ['%'.$kwDigits.'%']
                    );
                }
            });
        }

        // Lọc trạng thái (nếu có)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Hiển thị theo ID tăng dần (1,2,3…)
        $orders = $query->orderBy('id', 'asc')->paginate(20);

        return view('admin.order.index', compact('orders'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Eager-load đầy đủ để render category/product/variant
        $order = Order::with([
            'orderItems.variant.product.category',
            'user:id,name',          // nếu cần show tên user
            'voucher:id,code',       // nếu cần
        ])->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate: bắt buộc lý do nếu chọn hủy
        $request->validate([
            'status' => 'required|in:processing,delivering,completed,cancelled,paid',
            'cancel_reason' => 'required_if:status,cancelled|nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->cancel_reason = $request->input('cancel_reason'); // null cho trạng thái khác
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        // Xóa các order_items liên quan trước
        $order->orderItems()->delete();

        // Sau đó mới xóa đơn hàng
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Đã xoá đơn hàng thành công.');
    }

}

