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
        <h3>Danh mục sản phẩm</h3>
    </div>
    <!-- Bảng Danh mục sản phẩm -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                {{-- <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh mục</h4>
                    </div> --}}
                    <div class="card-content">
                        <div class="mb-2 text-start">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+
                                Thêm danh mục</a>
                        </div>
                        <!-- table head dark -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead class="table-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Slug</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                @if($category->status == 1)
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Hiển thị</span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill px-3 py-2">Ẩn</span>
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>{{ $category->updated_at }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="btn btn-sm btn-warning rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                    <i class="bi bi-pencil-square me-1"></i> Sửa
                                                </a>
                                                <a href="{{ route('category.delete', $category->id) }}"
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Danh mục sản phẩm --}}

    @include('admin.category.create')
@endsection