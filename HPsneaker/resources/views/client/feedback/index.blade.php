@extends('client.layout.master')
@section('main')
<!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Phản hồi của khách hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <span>Phản hồi của khách hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- feedback Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Số điện thoại</h4>
                        <p>+01-3-8888-6868</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Địa chỉ</h4>
                        <p>Lê Thánh Tông, Ngô Quyền, Hải Phòng</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Thời gian mở cửa</h4>
                        <p>10:00 am to 23:00 pm</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>bebestyasuo@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Begin -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d59650.55823673738!2d106.6331321!3d20.8656047!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7bf67d69c9c7%3A0x4341c6cef1813f18!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1750965518250!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4>Hải Phòng</h4>
                <ul>
                    <li>Số điện thoại: +12-345-6789</li>
                    <li>Địa chỉ: Lê Thánh Tông, Hải Phòng</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Map End -->

    <!-- feedback Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Phản hồi của khách hàng</h2>
                    </div>
                </div>
            </div>
            @if(session('success'))
            <div class="alert alert-success">
            {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('shop.feedback.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <input class="site-btn" id="file-upload" type="file" name="img" />
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea placeholder="Lời nhắn" name="mess" required></textarea>
                        <button type="submit" class="site-btn">Gửi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

            <!-- Hiển thị danh sách phản hồi -->

<div class="row mt-5">
    <div class="col-lg-12">
        <h3 class="text-center mb-4">Phản hồi gần đây</h3>
        <div class="p-4 rounded shadow-sm border bg-light">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($feedbacks as $feedback)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="mb-0">
                                    {{ $feedback->user->name ?? $feedback->name }}
                                    <span class="text-muted">({{ $feedback->created_at->format('d/m/Y H:i') }})</span>
                                    </h6>
                                </div>
                                <p class="mb-2">{{ $feedback->mess }}</p>
                                @if ($feedback->img)
                                    <img src="{{ asset('storage/' . $feedback->img) }}" class="img-fluid rounded" alt="feedback image" style="max-height: 180px; object-fit: cover;">
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Chưa có phản hồi nào.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
    <!-- feedback Form End -->
@endsection
