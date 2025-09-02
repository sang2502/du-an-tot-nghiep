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
        <div class="card" style="grid-column: span 2;">
            <h3>
                <!-- Doanh thu -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="10" stroke="#2563eb" stroke-width="2" fill="none"/></svg>
                Tổng doanh thu
            </h3>
            <form method="GET" style="margin-bottom:16px;" onsubmit="return validateDateFilter();">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <label for="start_date" style="font-weight:500;">Từ ngày:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" required style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <label for="end_date" style="font-weight:500;">Đến ngày:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" required style="padding:4px 10px;border-radius:6px;border:1px solid #e0e7ff;">
                        <button type="submit" style="padding:4px 16px;border-radius:6px;border:none;background:#2563eb;color:#fff;font-weight:500;">Lọc</button>
                        <a href="/admin/stastic" style="padding:4px 16px;border-radius:6px;border:none;background:#e0e7ff;color:#2563eb;font-weight:500;text-decoration:none;margin-left:8px;">Reset</a>
                    </div>
                </div>
            </form>
            <div style="display:flex;flex-direction:column;align-items:flex-start;gap:8px;">
                <div style="font-size:34px;font-weight:700;color:#2563eb;">
                    {{ number_format($totalRevenue) }} ₫
                </div>
                <button type="button" onclick="toggleRevenueDetail()" id="toggleRevenueBtn"
                    style="margin:8px 0 0 0;padding:4px 14px;border-radius:6px;border:1px solid #e0e7ff;background:#f3f4f6;color:#2563eb;font-weight:500;cursor:pointer;">
                    Xem chi tiết ▼
                </button>
                <div id="revenueDetail" style="display:none;transition:all 0.3s;">
                    <div style="display:flex;gap:32px;margin-top:4px;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <svg fill="#3b82f6" viewBox="0 0 24 24" style="width:18px;height:18px;"><circle cx="12" cy="12" r="10" stroke="#3b82f6" stroke-width="2" fill="none"/><path d="M8 12h8v8H8z"/></svg>
                            <span style="color:#3b82f6;font-weight:500;">Trực tuyến:</span>
                            <span style="font-weight:600;">{{ number_format($onlineRevenue) }} ₫</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <svg fill="#f59e42" viewBox="0 0 24 24" style="width:18px;height:18px;"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 16v-4M12 16v-8M16 16v-2" stroke="#f59e42" stroke-width="2"/></svg>
                            <span style="color:#f59e42;font-weight:500;">Tại quầy:</span>
                            <span style="font-weight:600;">{{ number_format($posRevenue) }} ₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h3>
                <!-- Tổng số đơn -->
                <svg fill="#2563eb" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 8h8v8H8z"/></svg>
                Tổng số đơn
            </h3>
            <div class="value">{{ number_format($Orders) }}</div>
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
            <div class="value">{{ number_format($pendingOrders) }}</div>
        </div>
        <div class="card">
            <h3>
                <!-- Đơn bị huỷ -->
                <svg fill="#dc3545" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#dc3545" stroke-width="2" fill="none"/><line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545" stroke-width="2"/><line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545" stroke-width="2"/></svg>
                Đơn bị huỷ
            </h3>
            <div class="value">{{ number_format($cancelledOrders) }}</div>
        </div>
            <!-- Số lượng hóa đơn chờ tại quầy -->
    <div class="card">
        <h3>
            <svg fill="#f59e42" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 8h8v8H8z"/></svg>
            Hóa đơn chờ tại quầy
        </h3>
        <div class="value">{{ number_format($posPendingCount) }}</div>
    </div>

    <!-- Số lượng hóa đơn đã thanh toán tại quầy -->
    <div class="card">
        <h3>
            <svg fill="#22c55e" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 8h8v8H8z"/></svg>
            Hóa đơn đã thanh toán tại quầy
        </h3>
        <div class="value">{{ number_format($posPaidCount) }}</div>
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

    <!-- Biểu đồ doanh thu trực tuyến hàng tháng -->
    <div class="card">
        <h3>
            <svg fill="#3b82f6" viewBox="0 0 24 24"><path d="M3 3v18h18"/><rect x="7" y="7" width="10" height="10"/></svg>
            Doanh thu trực tuyến hàng tháng
        </h3>
        <canvas id="monthlyChart" height="250"></canvas>
    </div>

    <!-- Biểu đồ doanh thu tại quầy theo tháng -->
    <div class="card" style="grid-column: span 5;">
        <h3>
            <svg fill="#3b82f6" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 16v-4M12 16v-8M16 16v-2"/></svg>
            Doanh thu tại quầy theo tháng
        </h3>
        <canvas id="posMonthlyChart" height="250"></canvas>
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
                            <td style="padding:8px;">
            <a href="{{ route('order.show', $order->id) }}" target="_blank"
               style="padding:4px 12px;border-radius:6px;background:#2563eb;color:#fff;font-weight:500;text-decoration:none;">
                Chi tiết
            </a>
        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:8px;">Không có đơn hàng nào chứa sản phẩm hết hàng.</td>
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

    const posCtx = document.getElementById('posMonthlyChart').getContext('2d');
    new Chart(posCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($posMonths) !!},
            datasets: [{
                label: 'Doanh thu tại quầy',
                data: {!! json_encode($posRevenueData) !!},
                backgroundColor: '#f59e42',
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

    function validateDateFilter() {
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;
        if (start && end && end <= start) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu!');
            return false;
        }
        return true;
    }

    function toggleRevenueDetail() {
        const detail = document.getElementById('revenueDetail');
        const btn = document.getElementById('toggleRevenueBtn');
        if (detail.style.display === 'none' || detail.style.display === '') {
            detail.style.display = 'block';
            btn.textContent = 'Ẩn chi tiết ▲';
        } else {
            detail.style.display = 'none';
            btn.textContent = 'Xem chi tiết ▼';
        }
    }
    </script>
@endsection
