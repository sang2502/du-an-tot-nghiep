@extends('client.layout.master')

@section('main')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><b>Ngày đặt:</b> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p>
                        <b>Trạng thái:</b>
                        @switch($order->status)
                            @case('processing')
                                <span class="badge bg-warning text-dark">Đang xử lý</span>
                                @break
                            @case('completed')
                                <span class="badge bg-success">Hoàn thành</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                                @break
                            @case('paid')
                                <span class="badge bg-info text-dark">Đã thanh toán</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endswitch
                    </p>
                </div>
                <div class="col-md-6">
                    <p><b>Tổng tiền:</b> <span class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span></p>
                </div>
            </div>
            <hr>
            <h5 class="mb-3">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Màu & Size</th>
                            <th>Số lượng</th>
                            <th>Giá()</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->variant->product->name ?? '' }}</td>
                            <td>
                                @if($item->variant)
                                    <span class="badge bg-secondary">Màu: {{ $item->variant->color->name ?? '' }}</span>
                                    <span class="badge bg-secondary">Size: {{ $item->variant->size->value ?? '' }}</span>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
