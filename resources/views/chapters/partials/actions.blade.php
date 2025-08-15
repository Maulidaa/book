<?php 
$isAdmin = auth()->user()->role_id==1;
$isAuthor = auth()->user()->id == $chapter->author_id;
if ($isAdmin || $isAuthor): ?>
    <a href="{{ route('chapters.download_pdf', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="btn btn-sm btn-success mr-1" title="Download">
        <i class="icon-file-pdf"></i>
    </a>
    <a href="{{ route('chapters.edit', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="btn btn-sm btn-primary mr-1" title="Edit">
        <i class="icon-pencil7"></i>
    </a>
    <form action="{{ route('chapters.destroy', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger mr-1" onclick="return confirm('Delete this chapter?')" title="Delete">
            <i class="icon-trash"></i>
        </button>
    </form>
<?php endif; ?>
<a href="{{ route('chapters.show', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="btn btn-sm btn-info" title="Detail">
    <i class="icon-eye"></i>
</a>

