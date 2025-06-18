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
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="shoping__product">Sản phẩm</th>
                                    <th>Phân loại</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr>
                                        <td class="shoping__cart__item d-flex align-items-center">
                                            <img src="{{ asset($item->variant->product->thumbnail ?? 'img/no-image.png') }}"
                                                alt=""
                                                style="width:70px; height:70px; object-fit:cover; border-radius:8px; margin-right:12px;">
                                            <div>
                                                <h6 class="mb-1">{{ $item->variant->product->name ?? 'Sản phẩm' }}</h6>
                                                <small class="text-muted">Mã SP: {{ $item->variant->sku ?? '-' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                Size: {{ $item->variant->size->value ?? '-' }},
                                                Màu: {{ $item->variant->color->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{ number_format($item->variant->price ?? 0, 0, ',', '.') }} đ
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity d-inline-flex align-items-center">
                                                <form action="" method="POST" class="d-flex">
                                                    @csrf
                                                    <div class="pro-qty d-flex align-items-center">
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                            min="1" style="width:50px;text-align:center;">
                                                    </div>

                                                </form>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            {{ number_format(($item->variant->price ?? 0) * $item->quantity, 0, ',', '.') }} đ
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="GET"
                                                onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0"><span
                                                        class="icon_close"></span></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Giỏ hàng của bạn đang trống.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(count($cartItems))
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="shoping__cart__btns">
                            <a href="{{ url('/shop') }}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
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
                                <li>Tạm tính
                                    <span>{{ number_format($cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity), 0, ',', '.') }}
                                        đ</span>
                                </li>
                                <li>Tổng cộng
                                    <span>{{ number_format($cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity), 0, ',', '.') }}
                                        đ</span>
                                </li>
                            </ul>
                            <a href="{{ route('checkout.index') }}" class="primary-btn">Thanh toán</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
