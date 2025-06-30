@extends('client.layout.master')
@section('main')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $product->name ?? 'Chi tiết sản phẩm' }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <a href="{{ url('/shop') }}">Cửa hàng</a>
                            <span>{{ $product->name ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <!-- Ảnh sản phẩm -->
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item mb-3">
                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded shadow" style="width:100%;max-height:400px;object-fit:cover;">
                        </div>
                        @if (isset($product->gallery) && count($product->gallery))
                            <div class="product__details__pic">
                                @foreach ($product->gallery as $img)
                                    <img src="{{ asset($img->url) }}" alt="" class="img-thumbnail"
                                        style="width:80px;height:80px;object-fit:cover;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Thông tin sản phẩm -->
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3 class="mb-2">{{ $product->name ?? 'Tên sản phẩm' }}</h3>
                        <div class="product__details__rating mb-2">
                            @php
                                $stars = round($averageRating ?? ($product->rating ?? 0));
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $stars)
                                    <i class="fa fa-star text-warning"></i>
                                @else
                                    <i class="fa fa-star-o text-warning"></i>
                                @endif
                            @endfor
                            <span class="ml-2 text-muted">({{ $reviews->count() ?? 0 }} đánh giá)</span>
                            {{-- rating --}}
                            @if (session('user'))
                                <form method="POST" action="{{ route('shop.submitReview', $product->id) }}"
                                    id="starRatingForm">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <label for="rating">Đánh giá sản phẩm:
                                            <span>({{ $reviews->count() }})</span></label>

                                        <div id="interactiveRating" style="font-size: 24px;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star-o star" data-value="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput"
                                        value="{{ $existingRating ?? '' }}">
                                </form>
                            @else
                                <p>Vui lòng <a href="{{ route('user.login') }}">đăng nhập</a> để đánh giá.</p>
                            @endif
                            <div class="product__details__price mb-3 h4 text-danger">
                                {{ number_format($product->price ?? 0, 0, ',', '.') }} đ
                            </div>

                            @if ($product->variants && $product->variants->count())
                                <div class="product__details__option mb-3">
                                    <span>Chọn size:</span>
                                    <div class="d-flex flex-wrap mt-2">
                                        @foreach ($product->variants as $variant)
                                            <label class="optionimage btn btn-outline-white me-2 mb-2"
                                                rel="{{ $variant->id }}">
                                                <span class="option-value">{{ $variant->size->value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif {{-- Kết thúc IF chọn size --}}

                            <div class="product__details__quantity mb-3">
                                <div class="quantity d-inline-flex align-items-center">
                                    <span class="mr-2">Số lượng:</span>
                                </div>
                            </div>
                            <form action="{{ route('shop.product.addToCart', ['id' => $product->id]) }}" method="POST"
                                class="d-inline" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_variant_id" id="product_variant_id" value="">
                                <div class="pro-qty">
                                    <input type="number" name="quantity" value="1" min="1"
                                        style="width:50px;text-align:center;">
                                </div>
                                <button type="submit" class="primary-btn mr-2" id="addToCartBtn" disabled>Thêm vào giỏ
                                    hàng</button>
                            </form>
                            <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                            <ul class="mt-3 list-unstyled">
                                <li><b>Tình trạng:</b>
                                    <span>{{ $product->in_stock ?? true ? 'Còn hàng' : 'Hết hàng' }}</span>
                                </li>
                                <li><b>Vận chuyển:</b> <span>Giao nhanh 1-2 ngày. <samp>Miễn phí vận chuyển</samp></span>
                                </li>
                                <li><b>Trọng lượng:</b> <span>{{ $product->weight ?? '1 kg' }}</span></li>
                                <li><b>Chia sẻ:</b>
                                    <div class="share mt-1">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-pinterest"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab mô tả, thông tin, đánh giá -->
                        <div class="col-lg-12 mt-5">
                            <div class="product__details__tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                            aria-selected="true">Mô tả</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                            aria-selected="false">Thông
                                            tin</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                            aria-selected="false"> Bình luận <span>({{ $comments->count() }})</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 border border-top-0 rounded-bottom bg-light">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Mô tả sản phẩm</h6>
                                            <p>{{ $product->description ?? 'Mô tả sản phẩm sẽ hiển thị ở đây.' }}</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Thông tin chi tiết</h6>
                                            <p>Thương hiệu: {{ $product->brand ?? 'Sneaker Shop' }}</p>
                                            <p>Chất liệu: {{ $product->material ?? 'Da tổng hợp' }}</p>
                                            <p>Kích cỡ: {{ $product->size ?? '40-44' }}</p>
                                            <p>Màu sắc: {{ $product->color ?? 'Trắng/Đen' }}</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Nhận xét của bạn</h6>
                                            @if (session('user'))
                                                <div class="row">
                                                    {{-- bình luận --}}
                                                    <div class="col-md-6">
                                                        <form action="{{ route('product.comment.store', $product->id) }}"
                                                            method="POST" class="mb-4">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="cmt">Bình luận</label>
                                                                <textarea class="form-control" name="cmt" rows="3" required></textarea>
                                                            </div>
                                                            <button type="submit" class="primary-btn mr-2">Gửi bình
                                                                luận</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <p>Vui lòng <a href="{{ route('user.login') }}">đăng nhập</a> để bình luận
                                                    hoặc đánh giá.</p>
                                            @endif
                                            {{-- Hiển thị danh sách bình luận --}}
                                            @if ($comments && $comments->count())
                                                @foreach ($comments as $comment)
                                                    <div class="mb-3 p-3 border rounded bg-white">
                                                        <strong>
                                                            {{ $comment->name }}
                                                            @if (isset($comment->rating))
                                                                <span class="ms-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $comment->rating)
                                                                            <i class="fa fa-star text-warning"></i>
                                                                        @else
                                                                            <i class="fa fa-star-o text-warning"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>
                                                            @endif
                                                        </strong>
                                                        <span
                                                            class="text-muted">({{ $comment->created_at->format('d/m/Y H:i') }})</span>
                                                        <p class="mb-0">{{ $comment->cmt }}</p>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>Chưa có bình luận nào cho sản phẩm này.</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Related Product Section Begin -->
    <div class="related-product mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title ">
                    <h2>Sản phẩm liên quan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($relatedProducts as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product__item h-100 d-flex flex-column">
                        <div class="product__item__pic mb-2">
                            <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}"
                                class="img-fluid rounded" style="height:180px;object-fit:cover;width:100%;">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text flex-grow-1 d-flex flex-column justify-content-between">
                            <h6 class="mb-2">
                                <a
                                    href="{{ route('shop.product.show', ['name' => Str::slug($item->name), 'id' => $item->id]) }}">
                                    {{ $item->name }}
                                </a>
                            </h6>
                            <h5 class="text-danger mb-0">{{ number_format($item->price, 0, ',', '.') }} đ</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Product Details Section End -->
    <script>
        document.querySelectorAll('.optionimage').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('product_variant_id').value = this.getAttribute('rel');

                document.querySelectorAll('.optionimage').forEach(function(el) {
                    el.classList.remove('selected');
                });

                this.classList.add('selected');
            });
        });

        // Khi chọn size thì enable nút Thêm vào giỏ hàng
        document.querySelectorAll('.optionimage').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('product_variant_id').value = this.getAttribute('rel');
                document.getElementById('addToCartBtn').disabled = false;
                // Đổi màu active cho nút size
                document.querySelectorAll('.optionimage').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Khi load trang, luôn disable nếu chưa chọn size
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addToCartBtn').disabled = true;
        });

        // Ngăn submit nếu chưa chọn size (phòng trường hợp hack html)
        document.getElementById('addToCartForm').addEventListener('submit', function(e) {
            if (!document.getElementById('product_variant_id').value) {
                e.preventDefault();
                alert('Vui lòng chọn size trước khi thêm vào giỏ hàng!');
            }
        });
    </script>

    {{-- đánh giá sao --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#interactiveRating .star');
            const ratingInput = document.getElementById('ratingInput');
            const form = document.getElementById('starRatingForm');

            // ⭐ Hiển thị số sao đã chọn khi load trang
            highlightStars(parseInt(ratingInput.value));

            // Gửi đánh giá khi click
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.value);
                    ratingInput.value = rating;
                    highlightStars(rating);
                    form.submit();
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    if (parseInt(star.dataset.value) <= rating) {
                        star.classList.remove('fa-star-o');
                        star.classList.add('fa-star', 'text-warning');
                    } else {
                        star.classList.remove('fa-star', 'text-warning');
                        star.classList.add('fa-star-o');
                    }
                });
            }
        });
    </script>
@endsection
