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
                        @foreach ($categories as $category )
                        <li><a href="">{{$category->name}}</a></li>
                        @endforeach

                        
                    </ul>
                </div>
            </div>
            <!-- Tìm kiếm và banner -->
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                Tất cả
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="Bạn cần tìm gì?">
                            <button type="submit" class="site-btn">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/banner.jpg') }}">
                    <div class="hero__text">
                        <span>SNEAKER HOT</span>
                        <h2>Bộ sưu tập <br />2024</h2>
                        <p>Miễn phí vận chuyển toàn quốc</p>
                        <a href="#" class="primary-btn">MUA NGAY</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                @for($i = 1; $i <= 5; $i++)
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-' . $i . '.jpg') }}">
                        <h5><a href="#">Danh mục {{ $i }}</a></h5>
                    </div>
                </div>
                @endfor
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
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">Tất cả</li>
                        <li data-filter=".giay-the-thao">Giày thể thao</li>
                        <li data-filter=".giay-chay-bo">Giày chạy bộ</li>
                        <li data-filter=".phu-kien">Phụ kiện</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            {{-- Lặp sản phẩm từ DB, ví dụ: @foreach($products as $product) --}}
            @for($i = 1; $i <= 8; $i++)
            <div class="col-lg-3 col-md-4 col-sm-6 mix giay-the-thao">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset('img/featured/feature-' . $i . '.jpg') }}">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Sản phẩm {{ $i }}</a></h6>
                        <h5>{{ number_format(100000 * $i, 0, ',', '.') }} đ</h5>
                    </div>
                </div>
            </div>
            @endfor
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
                    <img src="{{ asset('img/banner/banner-1.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="{{ asset('img/banner/banner-2.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            @for($col = 1; $col <= 3; $col++)
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>
                        @if($col == 1) Sản phẩm mới
                        @elseif($col == 2) Sản phẩm nổi bật
                        @else Đánh giá cao
                        @endif
                    </h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            @for($j = 1; $j <= 3; $j++)
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="{{ asset('img/latest-product/lp-' . $j . '.jpg') }}" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Sản phẩm {{ $j }}</h6>
                                    <span>{{ number_format(100000 * $j, 0, ',', '.') }} đ</span>
                                </div>
                            </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            @endfor
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
            @for($i = 1; $i <= 3; $i++)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{ asset('img/blog/blog-' . $i . '.jpg') }}" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> {{ now()->format('d/m/Y') }}</li>
                            <li><i class="fa fa-comment-o"></i> {{ rand(1,10) }}</li>
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