@extends('client.layout.master')

@section('main')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div>
                        <i class="fa fa-user-circle" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="mb-0 mt-2">Thông tin tài khoản</h4>
                </div>
                <div class="card-body px-4 py-4">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-user me-2 text-primary"></i> Tài khoản:</span>
                            <span class="fw-bold">{{ $user['name'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-envelope me-2 text-primary"></i> Email:</span>
                            <span>{{ $user['email'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-phone me-2 text-primary"></i> Số điện thoại:</span>
                            <span>{{ $user['phone'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-venus-mars me-2 text-primary"></i> Giới tính:</span>
                            <span>
                                @if(($user['gender'] ?? '') == 'male') Nam
                                @elseif(($user['gender'] ?? '') == 'female') Nữ
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-birthday-cake me-2 text-primary"></i> Ngày sinh:</span>
                            <span>{{ $user['birth_date'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-map-marker me-2 text-primary"></i> Địa chỉ:</span>
                            <span>{{ $user['address'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-star me-2 text-primary"></i> Cấp độ thành viên:</span>
                            <span>{{ ucfirst($user['tier'] ?? '') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-gift me-2 text-primary"></i> Điểm thưởng:</span>
                            <span>{{ $user['points'] ?? '' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-calendar me-2 text-primary"></i> Ngày tạo:</span>
                            <span>{{ isset($user['created_at']) ? \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y H:i') : '' }}</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('user.profile.edit', $user['id']) }}" class="btn btn-primary px-4">
                            <i class="fa fa-edit me-1"></i> Chỉnh sửa thông tin
                        </a>
                        <a href="{{ route('profile.orders') }}" class="btn btn-primary" > <i class="fa fa-history me-1"></i> Lịch sử mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
