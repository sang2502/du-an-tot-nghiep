@extends('admin.layout.index')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Bên trái: Danh sách sản phẩm -->
            <div class="col-lg-8">
                <!-- Link mở modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#filterProductModal">
                    Thêm sản phẩm
                </button>
                <!-- Danh sách sản phẩm -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h4 class="mb-0 text-primary">🛒Sản Phẩm</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle mb-0" id="orderItemTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên SP</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posOrderItem as $pi)
                                    <tr>
                                        <td>{{ $pi->id }}</td>
                                        <td>{{ $pi->productVariant->product->name }}</td>
                                        <td>{{ $pi->quantity }}</td>
                                        <td class="item-price" data-price="{{ $pi->productVariant->price * $pi->quantity }}">
                                            {{ number_format($pi->productVariant->price * $pi->quantity, 0, ',', '.') }} VNĐ
                                        </td>
                                        <td>
                                            <form action="{{ route('pos.deleteItem', $pi->id) }}" method="GET" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xoá không?')">-</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Bên phải: Thông tin hoá đơn -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h4 class="mb-0 text-primary">📄 Thông Tin Hoá Đơn</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pos.update', $posOrder->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Ngày:</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tổng Tiền:</label>
                                <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Khuyến Mại:</label>
                                <input type="text" class="form-control" id="discountCode" name="discount_code" placeholder="Mã giảm giá...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giá trị giảm:</label>
                                <input type="number" class="form-control" id="discountApplied" name="discount_applied" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tổng Thanh Toán:</label>
                                 <input type="number" class="form-control" id="finalAmount" name="final_amount" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phương Thức TT:</label>
                                <select class="form-select" name="payment_method">
                                    <option value="Tiền mặt">Tiền mặt</option>
                                    <option value="Chuyển khoản">Chuyển khoản</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tiền Khách Đưa:</label>
                                <input type="number" class="form-control" id="customerPaid">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tiền Trả Lại:</label>
                                <input type="number" class="form-control" id="changeAmount" readonly>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button type="reset" class="btn btn-outline-danger flex-fill"><i class="bi bi-trash"></i>
                                    Xoá</button>
                                <button type="submit" class="btn btn-success flex-fill"><i class="bi bi-cash-coin"></i>
                                    Thanh Toán</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal lọc sản phẩm -->
    <div class="modal fade" id="filterProductModal" tabindex="-1" aria-labelledby="filterProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterProductModalLabel">Lọc sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <!-- Ô tìm kiếm -->
                    <input type="text" id="productSearch" class="form-control mb-3" placeholder="Tìm theo tên...">

                    <!-- Bảng danh sách sản phẩm -->
                    <table class="table table-striped" id="productTable">
                        <thead>
                            <tr>
                                <th>Mã SP</th>
                                <th>Tên SP</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Giá</th>
                                <th>Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productVariant as $pv)
                                <tr>
                                    <td>{{ $pv->id }}</td>
                                    <td>{{ $pv->product->name }}</td>
                                    <td>{{ $pv->color->name }}</td>
                                    <td>{{ $pv->size->value }}</td>
                                    <td>{{ number_format($pv->price, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <form action="{{ route('pos.add', $pv->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="pos_order_id" value="{{ $posOrder->id }}">
                                            <input type="hidden" name="product_variant_id" value="{{ $pv->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">+</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- JS lọc & cập nhật tổng tiền -->
    <script>
        // Lọc sản phẩm theo tên
        document.getElementById('productSearch').addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('#productTable tbody tr').forEach(row => {
                const name = row.querySelectorAll('td')[1].textContent.toLowerCase();
                row.style.display = name.includes(keyword) ? '' : 'none';
            });
        });

        // Tính tổng tiền và cập nhật các trường liên quan
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.item-price').forEach(item => {
                total += parseFloat(item.getAttribute('data-price'));
            });
            document.getElementById('totalAmount').value = total;

            // Khuyến mãi
            let discount = 0;
            let discountCode = document.getElementById('discountCode').value;
            if (discountCode.trim().toUpperCase() === 'hp10') {
                discount = 50000;
            }
            document.getElementById('discountApplied').value = discount;
            let finalAmount = total - discount;
            document.getElementById('finalAmount').value = finalAmount;

            // Tiền khách đưa & tiền trả lại
            let customerPaid = parseFloat(document.getElementById('customerPaid').value) || 0;
            let changeAmount = customerPaid - finalAmount;
            document.getElementById('changeAmount').value = changeAmount >= 0 ? changeAmount : 0;
        }

        document.addEventListener('DOMContentLoaded', updateTotal);
        document.getElementById('discountCode').addEventListener('input', updateTotal);
        document.getElementById('customerPaid').addEventListener('input', updateTotal);
    </script>
@endsection
