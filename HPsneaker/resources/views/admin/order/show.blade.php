@extends('admin.layout.master')
@section('main')
    <div class="container" style="max-width: 900px;">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card shadow-lg" style="border-radius: 16px;">
                    <div class="card-header text-center" style="background: #4663b2; color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                        <h4 class="mb-0 py-2">Chi tiết đơn hàng #{{ $order->id }}</h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <table class="table table-borderless mb-4">
                            <tr>
                                <td><b>User ID:</b></td>
                                <td>{{ $order->user_id }}</td>
                            </tr>
                            <tr>
                                <td><b>Tổng tiền:</b></td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            </tr>
                            <tr>
                                <td><b>Voucher:</b></td>
                                <td>{{ $order->voucher_id ?? 'Không áp dụng' }}</td>
                            </tr>
                            <tr>
                                <td><b>Giảm giá:</b></td>
                                <td>{{ number_format($order->discount_applied, 0, ',', '.') }}₫</td>
                            </tr>
                            <tr>
                                <td><b>Trạng thái:</b></td>
                                <td>
                                        @if($order->status == 'completed')
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">Hoàn tất</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Đang xử lý</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger rounded-pill px-3 py-2">Đã hủy</span>
                                        @else
                                            <span class="badge bg-info rounded-pill px-3 py-2">{{ $item->status }}</span>
                                        @endif
                                    </td>
                            </tr>
                            <tr>
                                <td><b>Thanh toán:</b></td>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                            </tr>
                            <tr>
                                <td><b>Địa chỉ giao:</b></td>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <td><b>Ngày tạo:</b></td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                            </tr>
                        </table>

                        <h5 class="mb-3"><b>Danh sách sản phẩm</b></h5>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle" style="background: #f7faff;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID biến thể</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($order->orderItems as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->product_variant_id }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                        <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">Không có sản phẩm nào trong đơn này</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-white" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <a href="{{ route('order.index') }}" class="btn btn-outline-secondary px-4 me-2">Quay lại</a>
                        {{-- Nếu cần, thêm nút chỉnh sửa hoặc các nút khác ở đây --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
