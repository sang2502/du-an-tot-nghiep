{{-- filepath: resources/views/admin/pos/update.blade.php --}}
@extends('admin.layout.index')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Bên trái: Danh sách sản phẩm -->
        <div class="col-lg-8">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#filterProductModal">
                Thêm sản phẩm
            </button>
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
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('pos.update', $posOrder->id) }}" id="checkoutForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Ngày:</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tổng Tiền:</label>
                            <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mã giảm giá:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="discountCode" name="discount_code" placeholder="Nhập mã giảm giá...">
                                <button type="button" class="btn btn-outline-primary" id="btnApplyVoucher">Áp dụng</button>
                            </div>
                            <div id="voucherMessage" class="mt-1"></div>
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
                            <label>Phương thức thanh toán</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="Tiền mặt">Tiền mặt</option>
                                <option value="VNPAY">Chuyển khoản</option>
                            </select>
                        </div>
                        <div class="mb-3" id="cashFields">
                            <label>Tiền khách đưa</label>
                            <input type="number" class="form-control" name="cash_given" id="customerPaid" min="0">
                            <label class="mt-2">Tiền trả lại</label>
                            <input type="number" class="form-control" name="change" id="changeAmount" min="0" readonly>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="reset" class="btn btn-outline-danger flex-fill"><i class="bi bi-trash"></i>
                                Xoá</button>
                            <button type="submit" class="btn btn-success flex-fill" id="btnCheckout"><i class="bi bi-cash-coin"></i>
                                Thanh Toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal lọc sản phẩm -->
<div class="modal fade" id="filterProductModal" tabindex="-1" aria-labelledby="filterProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterProductModalLabel">Lọc sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <input type="text" id="productSearch" class="form-control mb-3" placeholder="Tìm theo tên...">
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
                                    <form action="{{ route('pos.add', $pv->id) }}" method="POST" style="display:inline;">
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

<!-- Thêm jQuery nếu chưa có -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Lọc sản phẩm theo tên
    $('#productSearch').on('keyup', function() {
        const keyword = $(this).val().toLowerCase();
        $('#productTable tbody tr').each(function() {
            const name = $(this).find('td').eq(1).text().toLowerCase();
            $(this).toggle(name.includes(keyword));
        });
    });

    // Ẩn/hiện trường tiền khách đưa và tiền trả lại theo phương thức thanh toán
    function toggleCashFields() {
        let paymentMethod = $('#payment_method').val();
        if (paymentMethod === 'VNPAY') {
            $('#cashFields').hide();
        } else {
            $('#cashFields').show();
        }
    }
    $('#payment_method').on('change', toggleCashFields);
    $(document).ready(toggleCashFields);

    // Tính tổng tiền và cập nhật các trường liên quan
    function updateTotal() {
        let total = 0;
        $('.item-price').each(function() {
            total += parseFloat($(this).data('price'));
        });
        $('#totalAmount').val(total);

        let discount = parseFloat($('#discountApplied').val()) || 0;
        let finalAmount = total - discount;
        $('#finalAmount').val(finalAmount);

        // Tiền khách đưa & tiền trả lại
        let customerPaid = parseFloat($('#customerPaid').val()) || 0;
        let changeAmount = customerPaid - finalAmount;
        $('#changeAmount').val(changeAmount >= 0 ? changeAmount : 0);
    }
    $(document).ready(updateTotal);
    $('#discountApplied').on('input', updateTotal);
    $('#customerPaid').on('input', updateTotal);

    // Kiểm tra hóa đơn có ít nhất 1 sản phẩm trước khi thanh toán
    $('#checkoutForm').on('submit', function(e) {
        let paymentMethod = $('#payment_method').val();
        let rowCount = $('#orderItemTable tbody tr').length;
        if (rowCount < 1) {
            e.preventDefault();
            alert('Hóa đơn phải có ít nhất 1 sản phẩm mới được thanh toán!');
            return;
        }
        if (paymentMethod === 'Tiền mặt') {
            let cash = $('#customerPaid').val();
            if (!cash || parseFloat(cash) <= 0) {
                e.preventDefault();
                alert('Vui lòng nhập số tiền khách đưa!');
            }
        }
    });

    // Áp dụng mã giảm giá khi bấm nút
    $('#btnApplyVoucher').on('click', function() {
        let code = $('#discountCode').val().trim();
        let total = parseFloat($('#totalAmount').val()) || 0;
        let msg = $('#voucherMessage');
        if (!code) {
            $('#discountApplied').val(0);
            msg.text('Vui lòng nhập mã giảm giá!').removeClass('text-success').addClass('text-danger');
            updateTotal();
            return;
        }
        $.ajax({
            url: '{{ route('pos.checkVoucher') }}',
            type: 'POST',
            data: {
                code: code,
                total: total,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success) {
                    $('#discountApplied').val(data.discount);
                    msg.text(data.message).removeClass('text-danger').addClass('text-success');
                } else {
                    $('#discountApplied').val(0);
                    msg.text(data.message).removeClass('text-success').addClass('text-danger');
                }
                updateTotal();
            },
            error: function() {
                $('#discountApplied').val(0);
                msg.text('Có lỗi xảy ra khi kiểm tra mã!').removeClass('text-success').addClass('text-danger');
                updateTotal();
            }
        });
    });
</script>
@endsection
