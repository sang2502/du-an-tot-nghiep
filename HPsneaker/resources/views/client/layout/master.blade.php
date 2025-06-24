<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="HP Sneaker">
    <meta name="keywords" content="Sneaker, Shop, Shoes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HP Sneaker</title>

    <!-- Google Fonts -->
     <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <style>
        body {
            font-family: 'Roboto', 'Montserrat', Arial, sans-serif;
            font-size: 16px;
            color: #111827;
            background: #fafafa;
            padding-top: 100px;
        }

        /* Nút (Buttons) */
        button,
        .btn,
        .site-btn {
            background-color: #032878 !important;
            /* đen than */
            color: #fff !important;
            border: none;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(17, 24, 39, 0.1);
        }

        button:hover,
        .btn:hover,
        .site-btn:hover {
            background-color: #ffffff !important;
            /* cam cháy khi hover */
            color: #000000 !important;
            box-shadow: 0 4px 16px rgba(249, 115, 22, 0.3);
        }

        /* Tiêu đề */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .section-title h2 {
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 700;
            color: #111827;
        }

        /* Footer */
        .footer {
            background-color: #ffffff;
            color: #d1d5db;
        }

        .footer__widget h6,
        .footer__about__logo a,
        .footer__widget__social a {
            color: #fff;
        }

        .footer__widget__social a:hover {
            color: #facc15;
            /* vàng mù tạt */
        }

        /* Header */
        .header {
            background-color: #ffffff;
            border-bottom: 0.1px solid #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: #023163;
            box-shadow: 0 2px 8px rgb(255, 255, 255);
            transition: all 0.3s;
        }

        .header__top {
            will-change: transform;
        }

        .header.shrink {
            min-height: 38px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header.shrink .site-branding img {
            max-height: 28px;
            transition: max-height 0.3s;
        }

        .header.shrink .header__menu ul li a {
            font-size: 12px;
            padding: 3px 7px;
        }

        .header__menu ul li a {
            color: #ffffff;
            font-weight: 500;
        }

        .header__menu ul li a:hover,
        .header__menu ul li.active a {
            color: #000000;
        }

        /* Cart and auth icons */
        .header__cart ul li a,
        .header__top__right__auth a {
            color: #ffffff;
            margin-top: 30px;
        }

        .header__top__right__auth a:hover {
            color: #000000;
        }

        /* Language switch */
        .header__top__right__language>div {
            color: #111827;
        }

        .product__details__option .btn,
        .product__details__option .optionimage {
            background: #fff !important;
            color: #000000 !important;
            border-color: #000000f1 !important;
            border-radius: 5px !important;
            margin-right: 5px !important;
            cursor: pointer;
            transition: 0.2s;
        }

        .product__details__option .btn:hover,
        .product__details__option .optionimage:hover {
            background: #000000 !important;
            color: #ffffff !important;
        }

        .roduct__details__option .optionimage.active,
        .product__details__option .optionimage:active {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }

        .hero__categories ul {
            display: none;
            position: absolute;
            top: 47px;
            left: 15px;
            width: 255px;
            z-index: 1000;
            background: #fff;
        }

        .hero__categories.active ul {
            display: block;
        }
        .hero__categories__all {
            color: #fff;
            padding: 10px 15px;
            background-color: #002f95;
        }

    </style>

</head>

<body>
    <!-- Loader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Mobile Menu -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="{{ asset('img/language.png') }}" alt="">
                <div>Tiếng Việt</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">English</a></li>
                    <li><a href="#">Tiếng Việt</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Đăng nhập</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li><a href="{{ url('/') }}">Trang chủ</a></li>
                <li><a href="{{ url('/shop') }}">Cửa hàng</a></li>
                <li><a href="#">Trang</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="{{ url('/shop-details') }}">Chi tiết sản phẩm</a></li>
                        <li><a href="{{ url('/shopping-cart') }}">Giỏ hàng</a></li>
                        <li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
                        <li><a href="{{ url('/blog-details') }}">Chi tiết tin tức</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/blog') }}">Tin tức</a></li>
                <li><a href="{{ route('shop.contact.index') }}"">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Miễn phí vận chuyển cho đơn từ 99$</li>
            </ul>
        </div>
    </div>
    <!-- End Mobile Menu -->

    <!-- Desktop Header -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li><a href="{{ url('/shop') }}">Cửa hàng</a></li>
                            {{-- <li><a href="#">Trang</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="{{ url('/shop-details') }}">Chi tiết sản phẩm</a></li>
                                    <li><a href="{{ url('/shopping-cart') }}">Giỏ hàng</a></li>
                                    <li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
                                    <li><a href="{{ url('/blog-details') }}">Chi tiết tin tức</a></li>
                                </ul>
                            </li> --}}
                            <li><a href="{{ url('/blog') }}">Tin tức</a></li>
                            <li><a href="{{ route('shop.contact.index') }}">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="header__cart">
                        <ul>
                            <li><a href="{{ url('/shop/cart') }}"><i class="fa fa-shopping-bag" style="color: #fff"></i>
                                    <span>3</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__top__right__auth">
                        @if (session('user'))
                            <span style="display: flex; align-items: center;">
                                <i class="fa fa-user"></i>
                                <a href="{{ route('user.profile.show') }}"
                                    style="margin: 0 8px 0 4px; color: #222; font-weight: 600; text-decoration: none;">
                                    {{ session('user.name') }}
                                </a>
                                <a href="{{ route('user.logout') }}" style="margin-left: 10px; color: #435EBE;"
                                    onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                                    <i class="fa fa-sign-out"></i> Đăng xuất
                                </a>
                            </span>
                        @else
                            <a href="{{ route('user.login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- End Desktop Header -->
    @yield('main')
    <!-- Footer -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}"
                                    alt="Logo"></a>
                        </div>
                        <ul>
                            <li>Địa chỉ: 60-49 Road 11378 New York</li>
                            <li>Điện thoại: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Liên kết hữu ích</h6>
                        <ul>
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Về cửa hàng</a></li>
                            <li><a href="#">Mua sắm an toàn</a></li>
                            <li><a href="#">Thông tin giao hàng</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Sơ đồ trang</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Chúng tôi là ai</a></li>
                            <li><a href="#">Dịch vụ</a></li>
                            <li><a href="#">Dự án</a></li>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">Đổi mới</a></li>
                            <li><a href="#">Khách hàng nói gì</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Đăng ký nhận tin</h6>
                        <p>Nhận thông tin mới nhất về cửa hàng và ưu đãi đặc biệt.</p>
                        <form action="#">
                            <input type="text" placeholder="Nhập email của bạn">
                            <button type="submit" class="site-btn">Đăng ký</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This
                                template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                    href="https://colorlib.com" target="_blank">Colorlib</a>
                            </p>
                        </div>
                        <div class="footer__copyright__payment">
                            <img src="{{ asset('img/payment-item.png') }}" alt="Payment">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product__details__option .optionimage').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.product__details__option .optionimage').forEach(
                        function(b) {
                            b.classList.remove('active');
                        });
                    this.classList.add('active');
                });
            });
        });
    </script>
    {{-- Category toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const catAll = document.querySelector('.hero__categories__all');
            const heroCat = document.querySelector('.hero__categories');
            catAll.addEventListener('click', function() {
                heroCat.classList.toggle('active');
            });
        });
    </script>
    {{-- Menu --}}
    <script>
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const topBar = document.getElementById('topBar');
            if (!topBar) return;
            if (window.scrollY > 30) {
                topBar.style.transform = 'translateY(-100%)';
                topBar.style.transition = 'transform 0.3s';
            } else {
                topBar.style.transform = 'translateY(0)';
            }

        });
        // 
    </script>
</body>

</html>
