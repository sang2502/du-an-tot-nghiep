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
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên SP</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posOrderItem as $pi)
                                    <tr>
                                        <td>{{ $pi->id }}</td>
                                        <td>{{ $pi->productVariant->product->name }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm">-</button>
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
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Ngày:</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Lượng SP:</label>
                                <input type="number" class="form-control" min="1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tổng Tiền:</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Khuyến Mại:</label>
                                <input type="text" class="form-control" placeholder="Mã giảm giá...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tiền Được Giảm:</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tổng Thanh Toán:</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phương Thức TT:</label>
                                <select class="form-select">
                                    <option>Tiền mặt</option>
                                    <option>Chuyển khoản</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tiền Khách Đưa:</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tiền Trả Lại:</label>
                                <input type="number" class="form-control" readonly>
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
                                            <input type="hidden" name="pos_order" value="{{ $posOrder->id }}">
                                            <input type="hidden" name="product_variant_id" value="{{ $pv->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Chọn</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Thêm các sản phẩm khác tại đây -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- JS lọc -->
    <script>
        document.getElementById('productSearch').addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('#productTable tbody tr').forEach(row => {
                const name = row.querySelector('td').textContent.toLowerCase();
                row.style.display = name.includes(keyword) ? '' : 'none';
            });
        });
    </script>
@endsection
