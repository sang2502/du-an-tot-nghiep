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

        // Số sản phẩm đang bán
        $activeProducts = DB::table('products')->where('status', 1)->count();

        // Số sản phẩm hết hàng
        $outOfStockProducts = DB::table('product_variants')->where('stock', 0)->count();

        // Số đơn hàng đang xử lý
        $pendingOrders = DB::table('orders')->where('status', 'pending')->count();

        // Số đơn hàng bị huỷ
        $cancelledOrders = DB::table('orders')->where('status', 'cancelled')->count();

        // Danh sách 5 sản phẩm bán chạy nhất
        $bestSellers = DB::table('order_items')
            ->select('product_variant_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_variant_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $bestSellerNames = [];
        foreach ($bestSellers as $item) {
            $productVariant = DB::table('product_variants')->where('id', $item->product_variant_id)->first();
            if ($productVariant) {
                $product = DB::table('products')->where('id', $productVariant->product_id)->first();
                if ($product) {
                    $bestSellerNames[] = [
                        'name' => $product->name . ' (' . $item->total_sold . ')',
                        'id' => $product->id
                    ];
                }
            }
        }
        if (empty($bestSellerNames)) {
            $bestSellerNames[] = ['name' => 'Không có', 'id' => null];
        }

        // Lấy danh sách đơn hàng chứa sản phẩm hết hàng
        $outOfStockVariantIds = DB::table('product_variants')->where('stock', 0)->pluck('id')->toArray();

        $outOfStockOrders = DB::table('order_items')
            ->whereIn('product_variant_id', $outOfStockVariantIds)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.name', 'orders.email', 'orders.phone', 'orders.status', 'orders.created_at')
            ->distinct()
            ->get();

        return view('admin.stastic.stastic', compact(
            'revenue', 'Orders', 'voucherUsed','customers',
            'months', 'revenueData',
            'activeProducts', 'outOfStockProducts',
            'pendingOrders', 'cancelledOrders',
            'bestSellerNames',
            'outOfStockOrders'
        ));
        
    }
}