<!-- filepath: c:\wamp64\www\du-an-tot-nghiep\HPsneaker\resources\views\admin\product\create.blade.php -->
@extends('admin.layout.master')
@section('main')
    <div class="page-heading">
        <h3>Thêm sản phẩm</h3>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card w-100">
                <div class="card-header">
                    <strong>Thêm sản phẩm</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id" required
                                style="max-width: 200px;">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="image" name="image" style="max-width: 200px;">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status" style="max-width: 110px;">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        {{-- Biến thể sản phẩm --}}
                        <div class="mb-3">
                            <label class="form-label">Biến thể sản phẩm</label>
                            <table class="table table-bordered" id="variant-table">
                                <thead>
                                    <tr>
                                        <th>Kích cỡ</th>
                                        <th>Màu sắc</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="variants[0][size_id]" class="form-select">
                                                <option value="">-- Chọn kích cỡ --</option>
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="variants[0][color_id]" class="form-select">
                                                <option value="">-- Chọn màu --</option>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="variants[0][price]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="variants[0][stock]" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                                <th>
                                    <button type="button" class="btn btn-success btn-sm" id="add-variant">Thêm biến thể</button>
                                </th>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Script thêm/xóa dòng biến thể --}}
    <script>
        let variantIndex = 1;
        document.getElementById('add-variant').onclick = function () {
            const tbody = document.querySelector('#variant-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                    <td>
                        <select name="variants[${variantIndex}][size_id]" class="form-select">
                            <option value="">-- Chọn kích cỡ --</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="variants[${variantIndex}][color_id]" class="form-select">
                            <option value="">-- Chọn màu --</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][price]" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][stock]" class="form-control">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-variant">Xoá</button>
                    </td>
                `;
            tbody.appendChild(row);
            variantIndex++;
        };
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection