@extends('client.layout.master')
@section('main')
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Bạn có mã giảm giá? <a href="#">Nhập mã tại đây</a></h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Thông tin giao hàng</h4>
                <form action="{{ route('checkout.submit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Họ tên<span>*</span></p>
                                        <input type="text" name="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ giao hàng<span>*</span></p>
                                <input type="text" name="address" value="{{ old('address') }}" required placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">
                            </div>
                            <div class="checkout__input">
                                <p>Số điện thoại<span>*</span></p>
                                <input type="text" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú đơn hàng</p>
                                <input type="text" name="note" value="{{ old('note') }}" placeholder="Ghi chú cho đơn hàng (nếu có)">
                            </div>
                            <div class="checkout__input">
                                <p>Phương thức thanh toán<span>*</span></p>
                                <select name="payment" required class="form-control">
                                    <option value="COD">Thanh toán khi nhận hàng</option>
                                    <option value="VNPAY">VNPAY</option>
                                    <option value="MOMO">MOMO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">
                                    Sản phẩm <span>Tổng</span>
                                </div>
                                <ul>
                                    @forelse($cartItems as $item)
                                        <li>
                                            {{ $item->variant->product->name ?? 'Sản phẩm' }}
                                            (x{{ $item->quantity }})
                                            <span>
                                            {{ number_format(($item->variant->price ?? 0) * $item->quantity, 0, ',', '.') }} đ
                                        </span>
                                        </li>
                                    @empty
                                        <li>Giỏ hàng trống</li>
                                    @endforelse
                                </ul>
                                <div class="checkout__order__subtotal">
                                    Tạm tính <span>{{ number_format($cartTotal, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="checkout__order__total">
                                    Tổng cộng <span>{{ number_format($cartTotal, 0, ',', '.') }} đ</span>
                                </div>
                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
