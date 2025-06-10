@extends('client.layout.master')
@section('main')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Giỏ hàng</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ url('/') }}">Trang chủ</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ví dụ dữ liệu động, thay bằng @foreach($cartItems as $item) --}}
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="{{ asset('img/cart/cart-1.jpg') }}" alt="">
                                    <h5>Giày Sneaker Nam Trắng</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    1.200.000 đ
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    1.200.000 đ
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="{{ asset('img/cart/cart-2.jpg') }}" alt="">
                                    <h5>Giày Sneaker Nữ Hồng</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    950.000 đ
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="2">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    1.900.000 đ
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close"></span>
                                </td>
                            </tr>
                            {{-- Kết thúc ví dụ --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ url('/shop') }}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        Cập nhật giỏ hàng</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Mã giảm giá</h5>
                        <form action="#">
                            <input type="text" placeholder="Nhập mã giảm giá">
                            <button type="submit" class="site-btn">Áp dụng</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Tổng giỏ hàng</h5>
                    <ul>
                        <li>Tạm tính <span>3.100.000 đ</span></li>
                        <li>Tổng cộng <span>3.100.000 đ</span></li>
                    </ul>
                    <a href="{{ url('/checkout') }}" class="primary-btn">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->
@endsection