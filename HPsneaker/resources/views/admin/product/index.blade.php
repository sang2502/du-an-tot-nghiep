@extends('admin.layout.master')
@section('main')
    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif
    {{-- end Thông báo thành công --}}

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
                        <a href="{{route('product.create')}}" class="btn btn-primary mb-2 mb-md-0" data-bs-toggle="modal">
                            + Thêm sản phẩm
                        </a>
                        {{-- Nút tìm kiếm --}}
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
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->category ? $product->category->name : '' }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}VND</td>
                                        <td>
                                            @if($product->thumbnail)
                                                <img src="{{ asset($product->thumbnail) }}" alt="Ảnh sản phẩm" style="max-width: 80px;">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->status == 1)
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('d/m/Y')}}</td>
                                        <td class="text-center">
                                            <a href="{{ route('product.show', $product->id) }}"
                                                class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-eye me-1"></i> Chi tiết
                                            </a>
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-pencil-square me-1"></i> Sửa
                                            </a>
                                            <a href="{{ route('product.delete', $product->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                                <i class="bi bi-trash me-1"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-3">{{ $categories->appends(request()->query())->links() }}</div> --}}
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- End Danh mục sản phẩm --}}
@endsection