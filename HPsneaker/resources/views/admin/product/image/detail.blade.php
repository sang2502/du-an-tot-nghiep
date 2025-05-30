
@extends('admin.layout.master')
@section('main')
<style>
    .img-action-group .btn-delete-img {
        display: none;
    }
    .img-action-group:hover .btn-delete-img {
        display: inline-block;
    }
</style>
<div class="page-heading mb-4">
    <h3 class="fw-bold">Ảnh của sản phẩm: {{ $productImgDetail->name }}</h3>
</div>
<div class="card shadow border-0">
    <div class="card-body">
        <div class="row g-3">
            @forelse($productImgDetail->images as $img)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
                    <div class="position-relative img-action-group">
                        <img src="{{ asset($img->url) }}" class="img-fluid rounded border mb-2" style="height:110px;object-fit:cover;">
                        <form action="{{ route('product.image.delete', $img->id) }}" method="GET" onsubmit="return confirm('Xóa ảnh này?');" class="d-inline">
                            @csrf
                            
                            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-delete-img" title="Xóa">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Chưa có ảnh nào cho sản phẩm này.</div>
            @endforelse 
        </div>
    </div>
</div>
<a href="{{ route('product.image.index') }}" class="btn btn-outline-secondary mt-4">Quay lại kho ảnh</a>
@endsection