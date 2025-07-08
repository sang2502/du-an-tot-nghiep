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
                                        <form action="{{ route('order.updateStatus', $item->id) }}" method="POST" class="update-status-form" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm order-status-dropdown" data-order-id="{{ $item->id }}">
                                                <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                                                <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                                <option value="paid" {{ $item->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                            </select>
                                            <input type="hidden" name="cancel_reason" class="cancel-reason-input">
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

                    <!-- Modal lý do hủy -->
                    <div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="cancelReasonForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelReasonLabel">Nhập lý do hủy đơn</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control" name="cancel_reason" id="cancelReasonInput" rows="3" placeholder="Nhập lý do hủy..." required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Script cho modal và xử lý submit --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let currentForm = null;
                            let oldStatus = null;

                            document.querySelectorAll('.order-status-dropdown').forEach(function(dropdown) {
                                dropdown.addEventListener('focus', function() {
                                    oldStatus = this.value;
                                });
                                dropdown.addEventListener('change', function(e) {
                                    if (this.value === 'cancelled') {
                                        currentForm = this.closest('form');
                                        var cancelModal = new bootstrap.Modal(document.getElementById('cancelReasonModal'));
                                        cancelModal.show();
                                    } else {
                                        this.closest('form').submit();
                                    }
                                });
                            });

                            document.getElementById('cancelReasonForm').addEventListener('submit', function(e) {
                                e.preventDefault();
                                let reason = document.getElementById('cancelReasonInput').value;
                                if(currentForm) {
                                    currentForm.querySelector('.cancel-reason-input').value = reason;
                                    currentForm.submit();
                                }
                                bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal')).hide();
                                document.getElementById('cancelReasonInput').value = '';
                            });

                            document.getElementById('cancelReasonModal').addEventListener('hidden.bs.modal', function () {
                                if(currentForm && currentForm.querySelector('.order-status-dropdown').value === 'cancelled' && !currentForm.querySelector('.cancel-reason-input').value) {
                                    currentForm.querySelector('.order-status-dropdown').value = oldStatus;
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
@endsection
