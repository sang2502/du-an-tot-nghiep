@extends('client.layout.master')

@section('main')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết đơn hàng #HPS{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><b>Ngày đặt:</b> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p>
                        <b>Trạng thái:</b>
                        @switch($order->status)
                            @case('delivering')
                                <span class="badge bg-warning text-dark">Đang giao hàng</span>
                                @break
                            @case('processing')
                                <span class="badge bg-warning text-dark">Đang xử lý</span>
                                @break
                            @case('completed')
                                <span class="badge bg-success">Hoàn thành</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                                @break
                            @case('paid')
                                <span class="badge bg-info text-dark">Đã thanh toán</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endswitch
                    </p>
                </div>
                <div class="col-md-6">
                    <p><b>Tổng tiền:</b> <span class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span></p>
                </div>
            </div>
            <hr>
            <h5 class="mb-3">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Màu & Size</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->variant->product->name ?? '' }}</td>
                            <td>
                                @if($item->variant)
                                    <span class="badge bg-secondary">Màu: {{ $item->variant->color->name ?? '' }}</span>
                                    <span class="badge bg-secondary">Size: {{ $item->variant->size->value ?? '' }}</span>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Nút huỷ đơn hàng --}}
                @if($order->status === 'processing')
                    <button id="btnCancelOrder" class="btn-cancel">Huỷ đơn hàng</button>
                @elseif($order->status !== 'cancelled')
                    <div class="alert alert-info mt-3">Đơn hàng đang trong quá trình vận chuyển hoặc đã hoàn thành, không thể huỷ!</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal huỷ đơn hàng --}}
<div id="cancelWarningModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h2>Xác nhận huỷ đơn hàng</h2>
        <p>Vui lòng nhập lý do bạn muốn huỷ đơn hàng:</p>
        <form method="POST" id="cancelForm" action="{{ route('profile.orders.cancel', $order->id) }}">
            @csrf
            <textarea name="cancel_reason" placeholder="Ví dụ: Đã thay đổi ý định, không cần hàng nữa..." required></textarea>
            <div class="modal-buttons">
                <button type="submit" class="btn-confirm">Xác nhận huỷ</button>
                <button type="button" id="btnCloseModal" class="btn-close">Đóng</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnCancel = document.getElementById('btnCancelOrder');
    const modal = document.getElementById('cancelWarningModal');
    const btnClose = document.getElementById('btnCloseModal');

    // Gán sự kiện cho nút huỷ nếu tồn tại
    if (btnCancel && modal) {
        btnCancel.addEventListener('click', function () {
            modal.style.display = 'flex';
        });
    }

    // Gán sự kiện cho nút đóng nếu tồn tại
    if (btnClose && modal) {
        btnClose.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }
});
</script>




{{-- CSS --}}
<style>
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal-content {
    background: #fff;
    border-radius: 10px;
    padding: 25px 30px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    font-family: "Segoe UI", sans-serif;
    text-align: center;
}
.modal-content h2 {
    font-size: 20px;
    margin-bottom: 10px;
}
.modal-content p {
    font-size: 14px;
    color: #333;
    margin-bottom: 15px;
}
.modal-content textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    resize: none;
    font-size: 14px;
}
.modal-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
}
.btn-confirm, .btn-close, .btn-cancel {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
.btn-confirm {
    background-color: #dc3545;
    color: white;
}
.btn-close {
    background-color: #6c757d;
    color: white;
}
.btn-cancel {
    background-color: #fff;
    border: 2px solid #dc3545;
    color: #dc3545;
    transition: background-color 0.3s;
    margin-top: 15px;
}
.btn-cancel:hover {
    background-color: #dc3545;
    color: white;
}
</style>
@endsection
