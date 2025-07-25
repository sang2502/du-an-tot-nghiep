<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bán Hàng HP Sneaker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #fbeaea;
        }

        .sidebar {
            background: #fff0f0;
            color: #a94442;
            min-height: 100vh;
            border-right: 2px solid #a94442;
        }

        .sidebar .nav-link {
            color: #a94442;
            font-size: 18px;
            padding: 14px 24px;
            border-bottom: 1px solid #f3c6c6;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #f3c6c6;
            color: #a94442;
        }

        .sidebar h2 {
            margin: 24px 0 24px 0;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        .btn-create {
            background: #2563eb !important;
            color: #fff !important;
            border-radius: 8px;
            font-weight: bold;
            margin: 18px 0 0 0;
            width: 90%;
        }

        .main-content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(169, 68, 66, 0.08);
            padding: 24px;
            min-height: 100vh;
        }

        .rightbar {
            background: #fff7f7;
            border-left: 2px solid #a94442;
            padding: 24px 16px;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar py-0">
                <h2>HP Sneaker</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('pos.index')}}">🛒 Bán Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pos.index')}}">🧾 Hoá Đơn</a>
                    </li>
                    {{-- <li class="nav-item"><a class="nav-link" href="#">📂 Danh Mục</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">👕 Sản Phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">🏷️ Khuyến Mại</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">📊 Thống Kê</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">👤 Nhân Viên</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">🔒 Đổi Mật Khẩu</a></li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">🚪 Đăng Xuất</a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('pos.store') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">➕ Tạo Hoá Đơn</button>
                </form>

            </nav>
            <!-- Main Content -->
            <main class="col-md-8 main-content">
                @yield('content')
            </main>
            <!-- Rightbar (tuỳ ý, nếu cần) -->
            {{-- <aside class="col-md-2 rightbar">
                <!-- Nội dung rightbar -->
            </aside> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
