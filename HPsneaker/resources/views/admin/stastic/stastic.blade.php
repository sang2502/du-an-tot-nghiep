@extends('admin.layout.master')

@section('main')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            padding: 30px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }
        .card {
            background: linear-gradient(120deg, #fff 80%, #e0e7ff 100%);
            border-radius: 18px;
            padding: 28px 20px;
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.16);
        }
        .card h3 {
            font-size: 17px;
            color: #3b82f6;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card .value {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 6px;
        }
        .card svg {
            width: 22px;
            height: 22px;
            vertical-align: middle;
        }
        .card ul {
            font-size: 16px;
            margin: 0;
            padding-left: 18px;
        }
        .card ul li {
            margin-bottom: 4px;
            color: #334155;
        }
        .card .icon-bg {
            position: absolute;
            top: -18px;
            right: -18px;
            opacity: 0.08;
            font-size: 80px;
        }
        .card:last-child {
            grid-column: span 5;
        }
        @media (max-width: 1200px) {
            .cards { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 700px) {
            .cards { grid-template-columns: 1fr; }
        }
        canvas {
            background-color: #fff;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(59,130,246,0.07);
        }
    </style>
    <div class="cards">
        <div class="card">
            <h3>
                <!-- Doanh thu -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="10" stroke="#2563eb" stroke-width="2" fill="none"/></svg>
                Tổng doanh thu
            </h3>
            <form method="GET" style="margin-bottom:8px;">
                <select name="revenue_filter" onchange="this.form.submit()" style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                    <option value="all" {{ request('revenue_filter','all')=='all'?'selected':'' }}>Tất cả</option>
                    <option value="week" {{ request('revenue_filter')=='week'?'selected':'' }}>Tuần này</option>
                    <option value="month" {{ request('revenue_filter')=='month'?'selected':'' }}>Tháng này</option>
                    <option value="year" {{ request('revenue_filter')=='year'?'selected':'' }}>Năm nay</option>
                </select>
            </form>
            <div class="value">{{ number_format($revenue) }} ₫</div>
        </div>
        <div class="card">
            <h3>
                <!-- Tổng số đơn -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 8h8v8H8z"/></svg>
                Tổng số đơn
            </h3>
            <form method="GET" style="margin-bottom:8px;">
                <select name="order_filter" onchange="this.form.submit()" style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                    <option value="all" {{ request('order_filter','all')=='all'?'selected':'' }}>Tất cả</option>
                    <option value="week" {{ request('order_filter')=='week'?'selected':'' }}>Tuần này</option>
                    <option value="month" {{ request('order_filter')=='month'?'selected':'' }}>Tháng này</option>
                    <option value="year" {{ request('order_filter')=='year'?'selected':'' }}>Năm nay</option>
                </select>
            </form>
            <div class="value">{{ number_format($Orders) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Voucher đã dùng -->
                <svg fill="#22c55e" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="7.5" cy="12" r="1.5"/><circle cx="16.5" cy="12" r="1.5"/><path d="M12 7v10"/></svg>
                Voucher đã dùng
            </h3>
            <div class="value">{{ $voucherUsed }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Người dùng -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0 1 12 0v2"/></svg>
                Người dùng
            </h3>
            <div class="value">{{ number_format($customers) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Đang bán -->
                <svg fill="#3b82f6" viewBox="0 0 24 24"><path d="M5 12h14M12 5v14"/><circle cx="12" cy="12" r="10" stroke="#3b82f6" stroke-width="2" fill="none"/></svg>
                Đang bán
            </h3>
            <div class="value">{{ number_format($activeProducts) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Hết hàng -->
                <svg fill="#dc3545" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="none"/><line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545" stroke-width="2"/><line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545" stroke-width="2"/></svg>
                Hết hàng
            </h3>
            <div class="value">{{ number_format($outOfStockProducts) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Đơn đang xử lý -->
                <svg fill="#f59e42" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#f59e42" stroke-width="2" fill="none"/><path d="M12 8v4l3 3" stroke="#f59e42" stroke-width="2" fill="none"/></svg>
                Đơn đang xử lý
            </h3>
            <form method="GET" style="margin-bottom:8px;">
                <select name="pending_filter" onchange="this.form.submit()" style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                    <option value="all" {{ request('pending_filter','all')=='all'?'selected':'' }}>Tất cả</option>
                    <option value="week" {{ request('pending_filter')=='week'?'selected':'' }}>Tuần này</option>
                    <option value="month" {{ request('pending_filter')=='month'?'selected':'' }}>Tháng này</option>
                    <option value="year" {{ request('pending_filter')=='year'?'selected':'' }}>Năm nay</option>
                </select>
            </form>
            <div class="value">{{ number_format($pendingOrders) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Đơn bị huỷ -->
                <svg fill="#dc3545" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#dc3545" stroke-width="2" fill="none"/><line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545" stroke-width="2"/><line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545" stroke-width="2"/></svg>
                Đơn bị huỷ
            </h3>
            <form method="GET" style="margin-bottom:8px;">
                <select name="cancelled_filter" onchange="this.form.submit()" style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                    <option value="all" {{ request('cancelled_filter','all')=='all'?'selected':'' }}>Tất cả</option>
                    <option value="week" {{ request('cancelled_filter')=='week'?'selected':'' }}>Tuần này</option>
                    <option value="month" {{ request('cancelled_filter')=='month'?'selected':'' }}>Tháng này</option>
                    <option value="year" {{ request('cancelled_filter')=='year'?'selected':'' }}>Năm nay</option>
                </select>
            </form>
            <div class="value">{{ number_format($cancelledOrders) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Top bán chạy nhất -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 2.5-7.5L2 9h7z"/></svg>
                Top bán chạy nhất
            </h3>
            <div class="value">
                <ul>
                    @foreach($bestSellerNames as $item)
                        @if(!empty($item['id']))
                            <li>
                                <a href="{{ route('shop.product.show', ['name' => \Illuminate\Support\Str::slug($item['name']), 'id' => $item['id']]) }}" target="_blank" style="color:#2563eb;text-decoration:underline;">
                                    {{ $item['name'] }}
                            </a>
                        </li>
                        @else
                            <li>{{ $item['name'] }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <h3><svg fill="#3b82f6" viewBox="0 0 24 24"><path d="M3 3v18h18"/><rect x="7" y="7" width="10" height="10"/></svg> Doanh thu hàng tháng</h3>
        <canvas id="monthlyChart" height="250"></canvas>
    </div>

    <div class="card" style="grid-column: span 5;">
        <h3 style="color:#dc3545"><svg fill="#dc3545" viewBox="0 0 24 24" style="width:22px;height:22px;"><path d="M6 6h12v12H6z"/><path d="M9 9h6v6H9z"/></svg> Đơn hàng chứa sản phẩm hết hàng</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f3f4f6;">
                        <th style="padding:8px;">ID</th>
                        <th style="padding:8px;">Tên khách</th>
                        <th style="padding:8px;">Email</th>
                        <th style="padding:8px;">SĐT</th>
                        <th style="padding:8px;">Trạng thái</th>
                        <th style="padding:8px;">Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outOfStockOrders as $order)
                        <tr>
                            <td style="padding:8px;">{{ $order->id }}</td>
                            <td style="padding:8px;">{{ $order->name }}</td>
                            <td style="padding:8px;">{{ $order->email }}</td>
                            <td style="padding:8px;">{{ $order->phone }}</td>
                            <td style="padding:8px;">{{ $order->status }}</td>
                            <td style="padding:8px;">{{ $order->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:8px;">Không có đơn hàng nào chứa sản phẩm hết hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 8,
                barThickness: 28
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1000000
                    }
                }
            }
        }
    });
    </script>
@endsection