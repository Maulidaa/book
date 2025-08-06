<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Category;

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
            $user = auth()->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
            }

            // Filter buku hanya milik author yang sedang login (berdasarkan nama)
            if ($user->role_id == 2) {
                $books = Book::with(['category', 'chapters'])
                    ->where('author', $user->name)
                    ->paginate(10);
            } else {
                $books = Book::with(['category', 'chapters'])->limit(10)->get();
            }

            $author = User::where('role_id', 2)->count();
            $publisher = User::where('role_id', 3)->count();
            $book = Book::count();

            return view('book.list_book', compact('author', 'publisher', 'book', 'books', 'user'));
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
        try {
            $user = auth()->user();
            $categories = Category::all();
            $authors = null;
            if ($user->role_id == 1) {
                $authors = User::where('role_id', 2)->pluck('name', 'id');
            }
            if (!$user) {
                return redirect()->route('login')->with('error', 'You must be logged in to create a book.');
            }
            
            return view('book.create', compact('categories', 'user', 'authors'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load create book form'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $book = Book::findOrFail($id);
            $categories = Category::all();
            $user = auth()->user();
            $authors = null;
            if ($user->role_id == 1) {
                $authors = User::where('role_id', 2)->pluck('name', 'id');
            }
            return view('book.edit', compact('book', 'categories', 'user', 'authors'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load edit book form'], 500);
        }
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'isbn' => 'nullable|string|max:255',
                // author_id hanya required jika admin
                'author_id' => $user->role_id == 1 ? 'required|exists:users,id' : '',
            ]);

            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('covers', 'public');
                $validatedData['url_cover'] = $coverPath;
            }

            // Set author_id sesuai role
            $author_id = $user->role_id == 1 ? $request->input('author_id') : $user->id;

            $book = Book::create([
                'title' => $validatedData['title'],
                'url_cover' => $validatedData['url_cover'] ?? null,
                'author_id' => $author_id,
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'isbn' => $validatedData['isbn'],
            ]);

            if ($book) {
                return redirect()->route('books.create')->with('success', 'Book created successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to create book.');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create book'], 500);
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
        $book = Book::with(['category', 'author', 'chapters'])->findOrFail($id);
        return view('book.show', compact('book'));
    }

    public function download_excel()
    {
        return Excel::download(new BookExport, 'books.xlsx');
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $user = auth()->user();

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'isbn' => 'nullable|string|max:255',
                // author_id hanya required jika admin
                'author_id' => $user->role_id == 1 ? 'required|exists:users,id' : '',
            ]);

            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('covers', 'public');
                $validatedData['url_cover'] = $coverPath;
            }

            // Set author_id sesuai role
            $author_id = $user->role_id == 1 ? $request->input('author_id') : $user->id;

            $book->update([
                'title' => $validatedData['title'],
                'url_cover' => $validatedData['url_cover'] ?? $book->url_cover,
                'author_id' => $author_id,
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'isbn' => $validatedData['isbn'],
            ]);

            return redirect()->route('dashboard', ['id' => $id])->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update book'], 500);
        }
    }
}
