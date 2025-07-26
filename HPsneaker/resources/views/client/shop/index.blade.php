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
                    <form method="GET" action="{{ route('shop.index') }}">
                        <div class="sidebar">
                            <div class="sidebar__item">
                                <h4>Danh mục giày</h4>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <label>
                                                <input type="radio" name="category" value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'checked' : '' }}>
                                                {{ $category->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="sidebar__item">
                                <h4>Khoảng giá</h4>
                                <div class="range-slider" style="margin-bottom:10px;">
                                    <input type="range" min="0" max="5000000" step="50000"
                                        value="{{ request('min_price', 0) }}" id="minRange" name="min_price"
                                        style="width:100%;">
                                    <input type="range" min="0" max="5000000" step="50000"
                                        value="{{ request('max_price', 5000000) }}" id="maxRange" name="max_price"
                                        style="width:100%;margin-top:6px;">
                                    <div style="display:flex;justify-content:space-between;margin-top:4px;">
                                        <span>Giá từ: <b id="minValue">{{ number_format(request('min_price', 0)) }}</b> đ
                                        </span>
                                        <span>đến: <b id="maxValue">{{ number_format(request('max_price', 5000000)) }}</b>
                                            đ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar__item sidebar__item__color--option">
                                <h4>Màu sắc</h4>
                                <div class="sidebar__item__color">
                                    @foreach ($colors as $color)
                                        <label for="color-{{ $color->id }}"
                                            class="color-label {{ request('color') == $color->id ? 'active' : '' }}"
                                            style="background-color: {{ $color->hex_code }};"
                                            title="{{ $color->name }}">
                                            <input type="radio" name="color" value="{{ $color->id }}"
                                                id="color-{{ $color->id }}"
                                                style="opacity:0;position:absolute;inset:0;margin:0;"
                                                {{ request('color') == $color->id ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sidebar__item">
                                <h4>Kích cỡ phổ biến</h4>
                                <div class="sidebar__item__size">
                                    @foreach ($sizes as $size)
                                        <label for="size-{{ $size->id }}"

                                            class="size-label {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'active' : '' }}">
                                            {{ $size->value }}
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                id="size-{{ $size->id }}"
                                                style="display:none"
                                                {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Lọc</button>
                            <a href="{{ route('shop.index') }}" class="btn btn-secondary mt-2">Làm mới</a>
                        </div>
                    </form>
                </div>
                <!-- End Sidebar -->

                <!-- Danh sách sản phẩm -->
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="filter__sort">
                                    <form method="GET" id="sortForm">
                                        <!-- Giữ lại các tham số lọc khác -->
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                        <input type="hidden" name="color" value="{{ request('color') }}">
                                        @if(is_array(request('sizes')))
                                            @foreach(request('sizes') as $size)
                                                <input type="hidden" name="sizes[]" value="{{ $size }}">
                                            @endforeach
                                        @endif
                                        <select name="sort" onchange="document.getElementById('sortForm').submit()">
                                            <option value="0" {{ request('sort') == 0 ? 'selected' : '' }}>Mặc định
                                            </option>
                                            <option value="1" {{ request('sort') == 1 ? 'selected' : '' }}>Giá tăng
                                                dần
                                            </option>
                                            <option value="2" {{ request('sort') == 2 ? 'selected' : '' }}>Giá giảm
                                                dần
                                            </option>
                                            <option value="3" {{ request('sort') == 3 ? 'selected' : '' }}>Mới nhất
                                            </option>
                                        </select>
                                    </form>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const minValue = document.getElementById('minValue');
    const maxValue = document.getElementById('maxValue');

    minRange.addEventListener('input', function() {
        minValue.textContent = Number(minRange.value).toLocaleString();
        if (Number(minRange.value) > Number(maxRange.value)) {
            maxRange.value = minRange.value;
            maxValue.textContent = Number(maxRange.value).toLocaleString();
        }
    });
    maxRange.addEventListener('input', function() {
        maxValue.textContent = Number(maxRange.value).toLocaleString();
        if (Number(maxRange.value) < Number(minRange.value)) {
            minRange.value = maxRange.value;
            minValue.textContent = Number(minRange.value).toLocaleString();
        }
    });
});
</script>
