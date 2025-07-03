@extends('client.layout.master')
@section('main')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/br2.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Cửa hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <span>Cửa hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <!-- Sidebar Danh mục -->
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Danh mục giày</h4>
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a href="#">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Khoảng giá</h4>
                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="100000" data-max="5000000">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minamount" placeholder="Từ">
                                        <input type="text" id="maxamount" placeholder="Đến">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item sidebar__item__color--option">
                            <h4>Màu sắc</h4>
                            <div class="sidebar__item__color">
                                @foreach ($colors as $color)
                                    <label for="color-{{ $color->id }}"
                                        style="background-color: {{ $color->hex_code }};
                  width: 30px; height: 30px; display: inline-block;
                  border-radius: 4px; margin-right: 5px;
                  cursor: pointer; position: relative;">
                                        <input type="radio" id="color-{{ $color->id }}"
                                            style="opacity: 0; position: absolute; inset: 0; margin: 0;">
                                    </label>
                                @endforeach


                            </div>
                        </div>
                        <div class="sidebar__item">
                            <h4>Kích cỡ phổ biến</h4>
                            @foreach ($sizes as $size)
                                <div class="sidebar__item__size">
                                    <label for="size-{{ $size->id }}">
                                        {{ $size->value }}
                                        <input type="checkbox" id="size-{{ $size->id }}">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Giày mới nhất</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">
                                        @foreach ($products->sortByDesc('created_at')->take(3) as $product)
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="{{ $product->thumbnail }}" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>{{ $product->name }}</h6>
                                                    <span>{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- End Sidebar -->

                <!-- Danh sách sản phẩm -->
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="filter__sort">
                                    <span>Sắp xếp</span>
                                    <select>
                                        <option value="0">Mặc định</option>
                                        <option value="1">Giá tăng dần</option>
                                        <option value="2">Giá giảm dần</option>
                                        <option value="3">Mới nhất</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 text-right">
                                <div class="filter__found">
                                    <h6><span>{{ $products->count() }}</span> sản phẩm</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="product__item">
                                    <a
                                        href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">
                                        <div class="product__item__pic set-bg">
                                            <img src="{{ $product->thumbnail }}" alt="">
                                        </div>
                                    </a>

                                    <div class="product__item__text">
                                        <h6><a
                                                href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">{{ $product->name }}</a>
                                        </h6>
                                        <h5>{{ number_format($product->price, 0, ',', '.') }} đ</h5>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>Không có sản phẩm nào.</p>
                            </div>
                        @endforelse
                    </div>
                    {{-- Phân trang nếu có --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
