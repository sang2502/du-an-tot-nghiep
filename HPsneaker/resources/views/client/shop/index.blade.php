@extends('client.layout.master')
@section('main')

    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shop Giày Sneaker</h2>
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
                                @foreach($categories as $category)
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
                            <div class="sidebar__item__color sidebar__item__color--white">
                                <label for="white">
                                    Trắng
                                    <input type="radio" id="white">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--black">
                                <label for="black">
                                    Đen
                                    <input type="radio" id="black">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--red">
                                <label for="red">
                                    Đỏ
                                    <input type="radio" id="red">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--blue">
                                <label for="blue">
                                    Xanh
                                    <input type="radio" id="blue">
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <h4>Kích cỡ phổ biến</h4>
                            <div class="sidebar__item__size">
                                <label for="size-40">
                                    40
                                    <input type="radio" id="size-40">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="size-41">
                                    41
                                    <input type="radio" id="size-41">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="size-42">
                                    42
                                    <input type="radio" id="size-42">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="size-43">
                                    43
                                    <input type="radio" id="size-43">
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Giày mới nhất</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">
                                        @foreach($products->sortByDesc('created_at')->take(3) as $product)
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
                        </div>
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
                                        <div class="product__item__pic set-bg" data-setbg="{{ $product->thumbnail }}">
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
                    {{-- {!! $products->links() !!} --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection