@extends('admin.layout.master')
@section('main')
    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    {{-- Thông báo lỗi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center"
            style="position: fixed; top: 70px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 300px;"
            role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="page-heading">
        <h3>Danh sách sản phẩm</h3>
    </div>
    <!-- Bảng Danh sách sản phẩm -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div class="d-flex gap-2 mb-2 mb-md-0">
                            <a href="{{ route('product.create') }}" class="btn btn-primary" data-bs-toggle="modal">
                                + Thêm sản phẩm
                            </a>

                        </div>
                        <form action="{{ route('product.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        {{-- Bảng danh mục --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Danh mục</th>
                                    <th>Tên</th>
                                    <th>Giá</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->category ? $product->category->name : '' }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}VND</td>
                                        <td>
                                            @if ($product->thumbnail)
                                                <img src="{{ asset($product->thumbnail) }}" alt="Ảnh sản phẩm"
                                                    style="max-width: 80px;">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->status == 1)
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            {{-- Thêm ảnh --}}
                                            <a href="{{ route('product.image.index', $product->id) }}"
                                                class="btn btn-sm btn-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center me-1"
                                                title="Kho ảnh">
                                                <i class="fa-solid fa-images me-1"></i>
                                            </a>
                                            {{-- Xem chi tiết --}}
                                            <a href="{{ route('product.show', $product->id) }}"
                                                class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1"
                                                title="Xem chi tiết">
                                                <i class="fa-solid fa-eye me-1"></i>
                                            </a>
                                            {{-- Sửa --}}
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-3 py-1 d-inline-flex align-items-center me-1"
                                                title="Sửa">
                                                <i class="fa-solid fa-pen-to-square me-1"></i>
                                            </a>
                                            {{-- Xóa --}}
                                            <a href="{{ route('product.delete', $product->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center"
                                                title="Xóa">
                                                <i class="fa-solid fa-trash me-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $products->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- End Danh mục sản phẩm --}}
@endsection
