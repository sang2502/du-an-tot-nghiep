
@extends('admin.layout.master')
@section('main')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center bg-primary">
                <h4 class="mb-0 text-white">Sửa trạng thái liên hệ</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('feedback.update', $feedback->id) }}" method="PUT">
                    @csrf
                    @method('POST') {{-- hoặc PUT nếu dùng Route::put --}}
                    {{-- <div class="mb-3">
                        <label class="form-label">Tên người liên hệ</label>
                        <input type="text" class="form-control" name="name" value="{{ $feedback->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $feedback->email }}">
                    </div> --}}
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="1" @if($feedback->status == 1) selected @endif>Hiển thị</option>
                            <option value="0" @if($feedback->status == 0) selected @endif>Chặn</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
