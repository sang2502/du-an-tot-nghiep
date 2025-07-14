<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StasticController extends Controller
{
    public function index()
    {
        // Tổng doanh thu từ đơn hàng hoàn tất
        $revenue = DB::table('orders')
            ->where('status', 'completed')
            ->sum('total_amount');

        // Tổng số đơn
        $Orders = DB::table('orders')
            ->count();

        // Số voucher đã dùng
        $voucherUsed = DB::table('orders')
            ->whereNotNull('voucher_id')
            ->count();
        // Số lượng người dùng
        $customers = DB::table('users')
            ->where(['role_id' => 3])
            ->count();

        // Doanh thu từng tháng trong năm hiện tại
        $monthlyRevenue = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $months = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
        $revenueData = array_fill(0, 12, 0);
        foreach ($monthlyRevenue as $item) {
            $revenueData[$item->month - 1] = $item->revenue;
        }

        return view('admin.stastic.stastic', compact(
            'revenue', 'Orders', 'voucherUsed','customers',
            'months', 'revenueData'
        ));
        
    }
}