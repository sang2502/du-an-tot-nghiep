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

        // Tìm kiếm theo user_id (nếu có nhập keyword)
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('user_id', 'like', '%' . $request->keyword . '%');
        }
        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        // Sắp xếp mới nhất trước và phân trang 10 đơn mỗi trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

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
        // Lấy đơn hàng + danh sách sản phẩm trong đơn
        $order = Order::with('orderItems')->findOrFail($id);
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
    public function update(Request $request, order $contact)
    {
        //
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

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        if($order->status == 'cancelled') {
            $order->cancel_reason = $request->input('cancel_reason'); // lưu lý do hủy
        }
        $order->save();
        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}

