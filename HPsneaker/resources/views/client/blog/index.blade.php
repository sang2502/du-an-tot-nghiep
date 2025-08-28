@extends('client.layout.master')
@section('main')
<div class="container py-4">
    <h2 class="mb-4">Tin tức & Blog</h2>
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                    {{-- <a href="{{ route('client.blog.show', $blog->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a> --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $blogs->withQueryString()->links() }}
    </div>
</div>
@endsection
