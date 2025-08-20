<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StasticController extends Controller
{
    public function index(Request $request)
    {
        // --- Bộ lọc ---
        $orderFilter = $request->input('order_filter', 'all');
        $revenueFilter = $request->input('revenue_filter', 'all');
        $pendingFilter = $request->input('pending_filter', 'all');
        $cancelledFilter = $request->input('cancelled_filter', 'all');
        $posPendingFilter = $request->input('pos_pending_filter', 'all');
        $posPaidFilter = $request->input('pos_paid_filter', 'all');

        // --- Tổng doanh thu ---
        $revenueQuery = DB::table('orders')->where('status', 'completed');
        if ($revenueFilter == 'week') {
            $revenueQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($revenueFilter == 'month') {
            $revenueQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($revenueFilter == 'year') {
            $revenueQuery->whereYear('created_at', now()->year);
        }
        $revenue = $revenueQuery->sum('total_amount');

        // --- Tổng số đơn ---
        $ordersQuery = DB::table('orders');
        if ($orderFilter == 'week') {
            $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($orderFilter == 'month') {
            $ordersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($orderFilter == 'year') {
            $ordersQuery->whereYear('created_at', now()->year);
        }
        $Orders = $ordersQuery->count();

        // --- Đơn đang xử lý ---
        $pendingQuery = DB::table('orders')->where('status', 'pending');
        if ($pendingFilter == 'week') {
            $pendingQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($pendingFilter == 'month') {
            $pendingQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($pendingFilter == 'year') {
            $pendingQuery->whereYear('created_at', now()->year);
        }
        $pendingOrders = $pendingQuery->count();

        // --- Đơn bị huỷ ---
        $cancelledQuery = DB::table('orders')->where('status', 'cancelled');
        if ($cancelledFilter == 'week') {
            $cancelledQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($cancelledFilter == 'month') {
            $cancelledQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($cancelledFilter == 'year') {
            $cancelledQuery->whereYear('created_at', now()->year);
        }
        $cancelledOrders = $cancelledQuery->count();

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

        // Lấy danh sách 5 sản phẩm bán chạy nhất
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

        // Số lượng hóa đơn chờ tại quầy
        $posPendingQuery = DB::table('pos_orders')->where('status', 'Đang chờ');
        if ($posPendingFilter == 'week') {
            $posPendingQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($posPendingFilter == 'month') {
            $posPendingQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($posPendingFilter == 'year') {
            $posPendingQuery->whereYear('created_at', now()->year);
        }
        $posPendingCount = $posPendingQuery->count();

        // Số lượng hóa đơn đã thanh toán tại quầy
        $posPaidQuery = DB::table('pos_orders')->where('status', 'Đã thanh toán');
        if ($posPaidFilter == 'week') {
            $posPaidQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($posPaidFilter == 'month') {
            $posPaidQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($posPaidFilter == 'year') {
            $posPaidQuery->whereYear('created_at', now()->year);
        }
        $posPaidCount = $posPaidQuery->count();

        // Biểu đồ doanh thu tại quầy theo tháng
        $monthlyPosRevenue = DB::table('pos_orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('status', 'Đã thanh toán')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $posMonths = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
        $posRevenueData = array_fill(0, 12, 0);
        foreach ($monthlyPosRevenue as $item) {
            $posRevenueData[$item->month - 1] = $item->revenue;
        }

        // Doanh thu trực tuyến
        $onlineRevenueQuery = DB::table('orders')->where('status', 'completed');
        if ($revenueFilter == 'week') {
            $onlineRevenueQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($revenueFilter == 'month') {
            $onlineRevenueQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($revenueFilter == 'year') {
            $onlineRevenueQuery->whereYear('created_at', now()->year);
        }
        $onlineRevenue = $onlineRevenueQuery->sum('total_amount');

        // Doanh thu tại quầy
        $posRevenueQuery = DB::table('pos_orders')->where('status', 'Đã thanh toán');
        if ($revenueFilter == 'week') {
            $posRevenueQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($revenueFilter == 'month') {
            $posRevenueQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($revenueFilter == 'year') {
            $posRevenueQuery->whereYear('created_at', now()->year);
        }
        $posRevenue = $posRevenueQuery->sum('total_amount');

        // Tổng doanh thu
        $totalRevenue = $onlineRevenue + $posRevenue;

        return view('admin.stastic.stastic', compact(
            'totalRevenue', 'onlineRevenue', 'posRevenue', 'revenueFilter',
            'revenue', 'Orders', 'voucherUsed','customers',
            'months', 'revenueData',
            'activeProducts', 'outOfStockProducts',
            'pendingOrders', 'cancelledOrders',
            'bestSellerNames',
            'outOfStockOrders',
            'posPendingCount', 'posPaidCount',
            'posMonths', 'posRevenueData',
            'posPendingFilter', 'posPaidFilter'
        ));
        
    }
}