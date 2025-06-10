
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị - HPsneaker</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <style>
        html, body {
            height: 100%;
        }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #auth {
            width: 100%;
        }
        .auth-title {
            color: #2d3748;
        }
        .auth-logo img {
            max-width: 120px;
        }
        .card {
            border-radius: 1.5rem;
        }
        .btn-primary {
            background: #6366f1;
            border: none;
        }
        .btn-primary:hover {
            background: #4f46e5;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
                <div class="col-lg-5 col-12">
                    <div class="card shadow p-4 border-0" id="auth-left">
                        <div class="auth-logo text-center mb-3">
                            <a href="#"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"></a>
                        </div>
                        <h1 class="auth-title text-center mb-2">Đăng nhập</h1>
                        <p class="auth-subtitle mb-4 text-center text-gray-600">Vui lòng đăng nhập để tiếp tục quản lý hệ thống.</p>

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input type="email" class="form-control form-control-xl" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                @error('email')
                                    <p style="color:red; margin-bottom:0;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input type="password" class="form-control form-control-xl" name="password" placeholder="Mật khẩu" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                @error('password')
                                    <p style="color:red; margin-bottom:0;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-check form-check-lg d-flex align-items-center mb-3">
                                <input class="form-check-input me-2" type="checkbox" value="1" id="flexCheckDefault" name="remember">
                                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                            <button class="btn btn-primary btn-block btn-lg shadow-lg w-100 mt-3">Đăng nhập</button>
                        </form>
                        <div class="text-center mt-4 text-lg fs-5">
                            <p class="text-gray-600 mb-1">
                                <a class="font-bold" href="#">Quên mật khẩu?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>