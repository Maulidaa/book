@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>View Chapter of {{ $bookTitle }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="mb-1">Chapter Cover</label><br>
                <img src="{{ $chapter->book && $chapter->book->url_cover ? asset('storage/' . $chapter->book->url_cover) : asset('storage/covers/book.jpg') }}"
                     alt="Cover Preview"
                     style="max-width:150px; margin-top:10px;" />
            </div>
            <div class="form-group">
                <label class="mb-1">Title</label>
                <input type="text" class="form-control" value="{{ $chapter->title }}" readonly>
            </div>
            <div class="form-group">
                <label class="mb-1">Content</label>
                <textarea class="form-control" rows="10" readonly>{{ $chapter->content }}</textarea>
            </div>
        </div>
    </div>
</div>
@endsection