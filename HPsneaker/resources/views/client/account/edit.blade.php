@extends('client.layout.master')

@section('main')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div>
                        <i class="fa fa-user-edit" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="mb-0 mt-2">Chỉnh sửa thông tin tài khoản</h4>
                </div>
                <form action="{{ route('user.profile.update') }}" method="POST" class="px-4 py-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-user me-2 text-primary"></i>Họ tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user['name'] ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-envelope me-2 text-primary"></i>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user['email'] ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-phone me-2 text-primary"></i>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user['phone'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-venus-mars me-2 text-primary"></i>Giới tính</label>
                        <select name="gender" class="form-select">
                            <option value="male" {{ old('gender', $user['gender'] ?? '') == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender', $user['gender'] ?? '') == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender', $user['gender'] ?? '') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-birthday-cake me-2 text-primary"></i>Ngày sinh</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $user['birth_date'] ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fa fa-map-marker me-2 text-primary"></i>Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $user['address'] ?? '') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="fa fa-lock me-2 text-primary"></i>Mật khẩu mới <span class="text-muted">(bỏ qua nếu không đổi)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới nếu muốn đổi">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa fa-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection