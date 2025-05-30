@extends('admin.layout.master')
@section('main')
    <div class="page-heading mb-4">
        <h3 class="fw-bold">Bảng kho ảnh sản phẩm</h3>
    </div>



    {{-- Modal thêm ảnh cho từng sản phẩm --}}
    @foreach($products as $product)
        <div class="modal fade" id="addImageModal-{{ $product->id }}" tabindex="-1"
            aria-labelledby="addImageModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('product.image.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addImageModalLabel-{{ $product->id }}">Thêm ảnh cho: {{ $product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Chọn ảnh</label>
                            <input type="file" name="images[]" class="form-control" multiple required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tải lên</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    {{-- Bộ lọc theo tên sản phẩm --}}
    <form method="GET" class="mb-4 row g-2">
        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên sản phẩm..."
                value="{{ request('keyword') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary" type="submit">Lọc</button>
        </div>
    </form>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng ảnh</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->images->count() }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success mb-1" data-bs-toggle="modal"
                                        data-bs-target="#addImageModal-{{ $product->id }}">
                                        <i class="bi bi-plus-circle"></i> Thêm ảnh
                                    </button>
                                    <a href="{{route('product.image.detail', $product->id)}}" class="btn btn-sm btn-info mb-1">
                                        <i class="bi bi-images"></i> Xem ảnh
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Không có sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Hiển thị phân trang --}}
                {{ $products->withQueryString()->links() }}
            </div>
            
        </div>
        
    </div>
    {{-- Nút quay lại trang sản phẩm --}}
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
@endsection