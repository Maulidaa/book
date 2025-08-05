<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Ambil relasi jika perlu
            $author = User::where('role_id', 2)->count();
            $publisher = User::where('role_id', 3)->count();
            $book = Book::count();
            // Ambil data buku beserta relasi category dan chapters
            $books = Book::with(['category', 'chapters'])->limit(10)->get();

            return view('book.list_book', compact('author', 'publisher', 'book', 'books'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load books'], 500);
        }
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Logic to show the form for creating a new book
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Logic to store a new book
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            // Handle file upload if cover image is provided
            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('covers', 'public');
                $validatedData['url_cover'] = $coverPath;
            }

            // Create a new book instance
            $book = Book::create([
                'title' => $validatedData['title'],
                'url_cover' => $validatedData['url_cover'],
                'author' => $validatedData['author'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'isbn' => $request->input('isbn'),
            ]);

            if ($book) {
                return response()->json([
                    'message' => 'Book created successfully',
                    'book' => $book,
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load create book form'], 500);
        }
    }

    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Logic to display a specific book by ID
    }

    public function download_excel()
    {
        return Excel::download(new BookExport, 'books.xlsx');
    }
}
