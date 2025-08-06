<?php

namespace App\Http\Controllers\Chapter;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chapter;
use Barryvdh\DomPDF\PDF;

class ChapterController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $bookTitle = Book::find($id)->title ?? 'Unknown Book';
        $listChapters = Chapter::with('book')->where('book_id', $id)->get();
        return view('chapters.index', [
            'bookId' => $id,
            'bookTitle' => $bookTitle,
            'listChapters' => $listChapters,
            'user' => $user
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
            'bookTitle' => $book->title,
            'user' => $user 
        ]);
    }

    public function store(Request $request, $bookId)
    {
        // Logic to store a new chapter for a specific book
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $book = Book::find($bookId);
        $chapter = new Chapter($validated);
        $chapter->book_id = $bookId;
        $chapter->save();

        return redirect()->route('chapters.create', ['id' => $bookId]);
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
