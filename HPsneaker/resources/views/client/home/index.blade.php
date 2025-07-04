@extends('client.layout.master')
@section('main')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <!-- Danh mục bên trái -->
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Tất cả danh mục</span>
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="">{{ $category->name }}</a></li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <!-- Tìm kiếm và banner -->
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('product.search') }}" method="GET">
                                <input type="text" placeholder="Tìm kiếm sản phẩm" name="keyword">
                                <button type="submit" class="site-btn">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>8888.888</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                </div>
            </div>
    </section>
    <!-- Hero Section End -->
    {{-- Banner --}}
    <div class="row">
        <div class="col-lg-12">
            <img class="banner1" src="{{ asset('img/banner/banner4.jpeg') }}" alt="">
        </div>
    </div>
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="section-title">
            <h2>Thương hiệu</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($brands as $i => $brand)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="{{ asset($brand->logo) }}"
                                style="width: 140px;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                    {{-- <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">Tất cả</li>
                            <li data-filter=".giay-the-thao">Giày thể thao</li>
                            <li data-filter=".giay-chay-bo">Giày chạy bộ</li>
                            <li data-filter=".phu-kien">Phụ kiện</li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="row featured__filter">
                {{-- Product --}}
                @foreach ($products as $i => $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix giay-the-thao">
                        <div class="featured__item">
                            <a
                                href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">
                                <div class="featured__item__pic set-bg">
                                    <img src="{{ $product->thumbnail }}" alt="">
                                </div>
                            </a>
                            <div class="featured__item__text">
                                <h6><a
                                        href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}}}">
                                        {{ $product->name }}</a></h6>
                                <h5>{{ number_format($product->price, 0, ',', '.') }} đ</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- @endforeach --}}
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('img/banner/banner2.jpeg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('img/banner/banner3.jpeg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container" style="font-weight: 500;">
            <div class="row">
                {{-- Cột 1: Mới nhất --}}
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Mới nhất</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                @foreach ($newProducts as $product)
                                    <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}}}"
                                        class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ $product->thumbnail }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6 style="font-weight: 500;">{{ $product->name }}</h6>
                                            <span
                                                style="font-weight: 300;">{{ number_format($product->price, 0, ',', '.') }}
                                                đ</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Cột 2: Nổi bật --}}
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Nổi bật</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">

                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ $product->thumbnail }}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6 style="font-weight: 500;">{{ $product->name }}</h6>
                                        <span style="font-weight: 300;">{{ number_format($product->price, 0, ',', '.') }}
                                            đ</span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- Cột 3: Đánh giá cao --}}
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Đánh giá cao</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">

                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ $product->thumbnail }}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6 style="font-weight: 500;">{{ $product->name }}</h6>
                                        <span style="font-weight: 300;">{{ number_format($product->price, 0, ',', '.') }}
                                            đ</span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Tin tức mới</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="{{ asset('img/blog/blog-' . $i . '.jpg') }}" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> {{ now()->format('d/m/Y') }}</li>
                                    <li><i class="fa fa-comment-o"></i> {{ rand(1, 10) }}</li>
                                </ul>
                                <h5><a href="#">Tiêu đề tin tức {{ $i }}</a></h5>
                                <p>Mô tả ngắn tin tức {{ $i }}...</p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
