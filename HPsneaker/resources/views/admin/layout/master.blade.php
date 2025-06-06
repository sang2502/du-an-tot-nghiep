<!-- filepath: c:\wamp64\www\du-an-tot-nghiep\HPsneaker\resources\views\admin\layout\master.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <style>
        .sidebar-header .account-info {
            margin-top: 10px;
            padding: 8px 0;
            background: #f8f9fa;
            border-radius: 6px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-header .account-info .fw-bold {
            color: #2c3e50;
        }

        .sidebar-header {
            border-bottom: 1px solid #e5e5e5;
            margin-bottom: 10px;
        }

        .sidebar-menu .menu .sidebar-item .sidebar-link:hover,
        .sidebar-menu .menu .sidebar-item .sidebar-link:hover i,
        .sidebar-menu .menu .sidebar-item .sidebar-link:hover span {
            background: #435EBE;
            color: #fff !important;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .sidebar-menu .menu .sidebar-item .sidebar-link {
            transition: background 0.2s, color 0.2s;
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ url('admin') }}">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="height: 40px;">
                            </a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                    @if(Auth::check())
                        <div class="account-info">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </div>
                    @endif
                </div>
                <div class="sidebar-menu">



                    <ul class="menu">
                        <li class="sidebar-item">
                            <a href="{{ url('admin/statistics') }}" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Thống kê</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/order') }}" class='sidebar-link'>
                                <i class="bi bi-cart-fill"></i>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/user') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Người dùng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/category') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Danh mục </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/product') }}" class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Sản phẩm</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/voucher') }}" class='sidebar-link'>
                                <i class="bi bi-ticket-perforated-fill"></i>
                                <span>Mã giảm giá</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/shipping') }}" class='sidebar-link'>
                                <i class="bi bi-truck"></i>
                                <span>Quản lý giao hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/contact') }}" class='sidebar-link'>
                                <i class=""></i>
                                <span>Contact</span>
                            </a>
                        </li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-journal-text"></i>
                                <span>Bài viết</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item">
                                    <a href="{{ url('admin/blog-category') }}">Danh mục bài viết</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ url('admin/Blog') }}">Bài viết</a>   
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ url('admin') }}">Tag bài viết</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ url('admin/comment') }}" class='sidebar-link'>
                                <i class="bi bi-chat-left-text-fill"></i>
                                <span>Bình luận</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('admin/settings') }}" class='sidebar-link'>
                                <i class="bi bi-gear-fill"></i>
                                <span>Cài đặt</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.logout') }}"
                                onclick="return confirm('Bạn có chắc muốn đăng xuất?')" class='sidebar-link'>
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            @yield('main')
            <footer>
                <div class="footer clearfix mb-0 text-muted fixed-bottom">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
