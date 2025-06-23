@extends('client.layout.master')
@section('main')
    <section class="checkout-success spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow rounded-3 p-4">
                        <div class="text-center mb-4">
                            <h2 class="mt-3 text-success">🎉 Chúc mừng quý khách!</h2>
                            <p class="lead">Đơn hàng của bạn đã được đặt thành công.</p>
                        </div>
                        <h4 class="mb-3">Thông tin đơn hàng</h4>
                        <table class="table">
                            <tr>
                                <th>Mã đơn hàng:</th>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Tên khách hàng:</th>
                                <td>{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $order->email }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td>{{ $order->phone }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ giao hàng:</th>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <th>Phương thức thanh toán:</th>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>{{ ucfirst($order->status) }}</td>
                            </tr>
                            @if(isset($order->voucher))
                                <tr>
                                    <th>Mã giảm giá:</th>
                                    <td>{{ $order->voucher->code }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Giảm giá áp dụng:</th>
                                <td>{{ number_format($order->discount_applied, 0, ',', '.') }} đ</td>
                            </tr>
                            <tr>
                                <th>Tổng cộng:</th>
                                <td><b>{{ number_format($order->total_amount, 0, ',', '.') }} đ</b></td>
                            </tr>
                        </table>
                        <h4 class="mt-4 mb-3">Chi tiết sản phẩm</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Phân loại</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->variant->product->name ?? 'Sản phẩm' }}</td>
                                    <td>
                                        @if($item->variant->size && $item->variant->color)
                                            Size: {{ $item->variant->size->value }}, Màu: {{ $item->variant->color->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                    <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="text-center mt-4">
                            <a href="/" class="btn btn-primary">Quay về trang chủ</a>
                            <a href="/orders/history" class="btn btn-outline-success ms-2">Xem lịch sử đơn hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
