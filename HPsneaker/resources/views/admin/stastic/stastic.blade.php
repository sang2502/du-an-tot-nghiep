@extends('admin.layout.master')

@section('main')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card h3 {
            font-size: 18px;
            color: #888;
        }
        .card .value {
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
        }
        .stat-change {
            margin-top: 5px;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .up {
            background-color: #e6f4ea;
            color: #28a745;
        }
        .down {
            background-color: #fcebea;
            color: #dc3545;
        }
        canvas {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
    <div class="cards">
        <div class="card" style="flex:1">
            <h3>Tổng doanh thu</h3>
            <div class="value">{{ $revenue }} Đồng</div>
        </div>
        <div class="card" style="flex:1">
            <h3>Tổng số đơn</h3>
            <div class="value">{{ number_format($Orders) }} Đơn</div>
        </div>
        <div class="card" style="flex:1">
            <h3>Số voucher đã dùng</h3>
            <div class="value">{{ $voucherUsed }}</div>
        </div>
        <div class="card" style="flex:1">
            <h3>Số lượng người dùng</h3>
            <div class="value">{{ number_format($customers) }}</div>
        </div>
    </div>

    <div class="card">
        <h3>Doanh thu hàng tháng</h3>
        <canvas id="monthlyChart" height="250"></canvas>
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
                borderRadius: 6,
                barThickness: 24
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
                        stepSize: 1000000 // Tuỳ chỉnh theo mức doanh thu
                    }
                }
            }
        }
    });
</script>
@endsection