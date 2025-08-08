<?php

namespace App\Http\Controllers\Chapter;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chapter;
use App\Read;
use Yajra\DataTables\Facades\DataTables;

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

        $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Chapter', 'url' => '']
        ];

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
            'breadcrumb' => $breadcrumb
        ]);

        
    }
    
    public function show($bookId, $chapterId)
    {
        $user = auth()->user();
        $chapter = Chapter::with('book')->findOrFail($chapterId);
        $book = $chapter->book;
        $bookTitle = $book ? $book->title : 'Unknown Book';
        $comments = $chapter->comments;

        $penulis = $book && $book->author ? $book->author->name : '-';
        $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Chapter', 'url' => route('books.chapters', ['id' => $bookId])],
                ['title' => 'Detail', 'url' => '']
        ];
        if($user != $penulis){
            Read::create([
                'user_id' => $user->id,
                'chapter_id' => $chapterId,
                'book_id' => $bookId,
            ]);
        }

        
        return view('chapters.show', [
            'chapter' => $chapter,
            'bookId' => $bookId,
            'chapterId' => $chapterId,
            'comments' => $comments,
            'bookTitle' => $bookTitle,
            'user' => $user,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function create($bookId)
    {
        $book = Book::find($bookId);
        $user = auth()->user(); 

        $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Chapter', 'url' => route('books.chapters', ['id' => $bookId])],
                ['title' => 'Create', 'url' => '']
        ];
        return view('chapters.create', [
            'bookId' => $bookId,
            'bookTitle' => $book ? $book->title : '',
            'user' => $user,
            'breadcrumb' => $breadcrumb
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
        $bookId = $book ? $book->id : null;
         $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Chapter', 'url' => route('books.chapters', ['id' => $bookId])],
                ['title' => 'Edit', 'url' => '']
        ];

        return view('chapters.edit', [
            'mode' => 'edit',
            'bookId' => $id,
            'bookTitle' => $book ? $book->title : '',
            'chapter' => $chapter,
            'user' => $user,
            'books' => $books,
            'breadcrumb' => $breadcrumb
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

    public function download_all_chapters($bookId)
    {
        $chapters = Chapter::where('book_id', $bookId)->get();
        if ($chapters->isEmpty()) {
            return redirect()->back()->with('error', 'No chapters found for this book');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('chapters.pdf_all_chapters', ['chapters' => $chapters]);
        return $pdf->download("all_chapters_book_{$bookId}.pdf");
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

    public function chapterData(Request $request, $bookId)
    {
        $query = Chapter::where('book_id', $bookId)->with(['book', 'comments', 'reader']);
        return DataTables::of($query)
            ->addColumn('action', function ($chapter) {
                // Ganti ke partial yang sudah ada
                return view('chapters.partials.actions', compact('chapter'))->render();
            })
            ->make(true);
    }
}
