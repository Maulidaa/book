
<?php 
$isAdmin = auth()->user()->role_id==1;
$isAuthor = auth()->user()->id == $chapter->author_id;
if ($isAdmin || $isAuthor): ?>
    <a href="{{ route('chapters.download_pdf', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="btn btn-sm btn-success">Download</a>
    <a href="{{ route('chapters.edit', array('id' => $chapter->book_id, 'chapterId' => $chapter->id)) }}" class="btn btn-sm btn-primary">Edit</a>
    <form action="{{ route('chapters.destroy', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this chapter?')">Delete</button>
    </form>
<?php endif; ?>
<a href="{{ route('chapters.show', ['id' => $chapter->book_id, 'chapterId' => $chapter->id]) }}" class="btn btn-sm btn-info">Detail</a>

