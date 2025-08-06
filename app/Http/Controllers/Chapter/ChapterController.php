<?php

namespace App\Http\Controllers\Chapter;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chapter;

class ChapterController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $book = Book::with('author')->find($id); // Pastikan ini di atas
        $bookTitle = $book ? $book->title : 'Unknown Book';
        $listChapters = Chapter::with('book')->where('book_id', $id)->get();
        $status = Chapter::where('book_id', $id)->distinct()->pluck('status')->toArray();

        // Statistik
        $countChapters = $listChapters->count();
        $countComments = Chapter::where('book_id', $id)->withCount('comments')->get()->sum('comments_count');
        $countViews = Chapter::where('book_id', $id)->withCount('reader')->get()->sum('reader_count');
        $author = $book && $book->author ? $book->author->name : '-';
        $publisher = $book && $book->publisher ? $book->publisher->name : '-';
        $bookCount = Book::count();

        return view('chapters.index', [
            'bookId' => $id,
            'bookTitle' => $bookTitle,
            'listChapters' => $listChapters,
            'author' => $author,
            'publisher' => $publisher,
            'book' => $bookCount,
            'countChapters' => $countChapters,
            'views' => $countViews,
            'comments' => $countComments,
            'user' => $user,
            'status' => $status,
        ]);
    }
    
    public function show($bookId, $chapterId)
    {
        // Logic to display a specific chapter of a book can be added here
        return view('chapters.show', ['bookId' => $bookId, 'chapterId' => $chapterId]);
    }

    public function create($bookId)
    {
        $book = Book::find($bookId);
        $user = auth()->user(); 

        return view('chapters.create', [
            'bookId' => $bookId,
            'bookTitle' => $book ? $book->title : '',
            'user' => $user
        ]);
    }

    public function store(Request $request, $bookId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_cover' => 'nullable|image|max:2048',
            'status' => 'nullable|in:published,draft,archived', // Optional status field

        ]);

        $chapter = new Chapter($validated);
        $chapter->book_id = $bookId;

        if ($request->hasFile('chapter_cover')) {
            $chapter->chapter_cover = $request->file('chapter_cover')->store('covers', 'public');
        }

        $chapter->save();

        return redirect()->route('books.chapters', ['id' => $bookId])
                         ->with('success', 'Chapter created successfully');
    }

    public function edit($id, $chapterId)
    {
        $chapter = Chapter::find($chapterId);
        $book = Book::find($id);
        $user = auth()->user();
        $books = Book::all(); 

        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found');
        }
        return view('chapters.edit', [
            'mode' => 'edit',
            'bookId' => $id,
            'bookTitle' => $book ? $book->title : '',
            'chapter' => $chapter,
            'user' => $user,
            'books' => $books 
        ]);
    }

    public function update(Request $request, $bookId, $chapterId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_cover' => 'nullable|image|max:2048',
            'status' => 'nullable|in:published,draft,archived',
        ]);

        $chapter = Chapter::find($chapterId);
        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found');
        }

        $chapter->title = $validated['title'];
        $chapter->content = $validated['content'];
        $chapter->status = $validated['status'] ?? $chapter->status;

        // Update cover jika ada file baru
        if ($request->hasFile('chapter_cover')) {
            $chapter->chapter_cover = $request->file('chapter_cover')->store('covers', 'public');
        }

        $chapter->save();

        return redirect()->route('books.chapters', ['id' => $bookId])
                         ->with('success', 'Chapter updated successfully');
    }

    public function download_pdf($bookId, $chapterId)
    {
        $chapter = Chapter::find($chapterId);
        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found');
        }

        $title = $chapter->title;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('chapters.pdf_chapter', ['chapter' => $chapter]);
        return $pdf->download("chapter_{$title}.pdf");
    }

    public function destroy($bookId, $chapterId)
    {
        $chapter = Chapter::find($chapterId);
        if ($chapter) {
            $chapter->delete();
            return redirect()->route('books.chapters', ['id' => $bookId])->with('success', 'Chapter deleted successfully');
        }
        return redirect()->back()->with('error', 'Chapter not found');
    }
}
