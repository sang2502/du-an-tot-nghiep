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
                        <form action="{{ route('order.index') }}" method="GET" class="d-flex w-auto"
                              style="max-width: 250px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                   placeholder="Tìm theo User ID..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm</button>
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
                                        @if($item->status == 1)
                                            <span class="badge bg-success rounded-pill px-3 py-2">Đang xử lý</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">Hoàn tất</span>
                                        @endif
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

