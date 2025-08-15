@php
    $isAdmin = auth()->check() && auth()->user()->role_id == 1;
    $loginRoute = route('login');
@endphp

@if($isAdmin)
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary" title="Edit">
        <i class="icon-pencil7 mr-2"></i>
        <span class="d-none d-sm-inline">Edit</span>
    </a>
@endif

@if(auth()->check())
    <a href="{{ route('books.chapters', $book->id) }}" class="btn btn-sm btn-info" title="Detail">
        <i class="icon-eye mr-2"></i>
        <span class="d-none d-sm-inline">Detail</span>
    </a>
@else
    <a href="{{ $loginRoute }}" class="btn btn-sm btn-info" title="Detail">
        <i class="icon-eye mr-1"></i>
        <span class="d-none d-sm-inline">Detail</span>
    </a>
@endif
