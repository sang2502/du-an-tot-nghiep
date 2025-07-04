@extends('admin.layout.master')
@section('main')
    <div class="page-heading">
        <h3>Đơn hàng</h3>
    </div>

    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Tìm kiếm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <form method="GET" action="{{ route('order.index') }}" class="d-flex" style="gap: 8px;">
                            <input type="text" name="keyword" placeholder="Tìm theo User ID..." value="{{ request('keyword') }}">
                            <select name="status" onchange="this.form.submit()">
                                <option value="">-- Tất cả trạng thái --</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            <button type="submit">Tìm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Tổng tiền</th>
                                <th>Voucher</th>
                                <th>Giảm giá</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Địa chỉ giao</th>
                                <th>Ngày tạo</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ number_format($item->total_amount, 0, ',', '.') }}₫</td>
                                    <td>{{ $item->voucher_id ?? 'Không áp dụng' }}</td>
                                    <td>{{ number_format($item->discount_applied, 0, ',', '.') }}₫</td>
                                    <td>
                                        <form action="{{ route('order.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                                                <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                                <option value="paid" {{ $item->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ ucfirst($item->payment_method) }}</td>
                                    <td>{{ $item->shipping_address }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('order.show', $item->id) }}"
                                           class="btn btn-sm btn-info rounded-pill px-3 py-1">
                                            <i class="bi bi-eye me-1"></i> Chi tiết
                                        </a>
                                        <a href="{{ route('order.delete', $item->id) }}"
                                           onclick="return confirm('Bạn có chắc muốn xoá đơn hàng này?')"
                                           class="btn btn-sm btn-danger rounded-pill px-3 py-1">
                                            <i class="bi bi-trash me-1"></i> Xoá
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
