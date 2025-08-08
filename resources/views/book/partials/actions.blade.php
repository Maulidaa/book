@php
    $isAdmin = auth()->check() && auth()->user()->role_id == 1;
    $loginRoute = route('login');
@endphp

@if($isAdmin)
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
@endif

@if(auth()->check())
    <a href="{{ route('books.chapters', $book->id) }}" class="btn btn-sm btn-info">Detail</a>
@else
    <a href="{{ $loginRoute }}" class="btn btn-sm btn-info">Detail</a>
@endif
