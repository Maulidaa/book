<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Comment;
use App\Read;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
        }

        // Filter buku hanya milik author yang sedang login (berdasarkan author_id)
        if ($user->role_id == 2) {
            $books = Book::with(['category', 'chapters'])
                ->where('author_id', $user->id)
                ->paginate(10);
        } elseif ($user->role_id == 3) {
            $books = Book::with(['category', 'chapters'])
                ->whereHas('reads', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->paginate(10);
        } else {
            $books = Book::with(['category', 'chapters'])->limit(10)->get();
        }

        $countChapters = $books->sum(function ($book) {
            return $book->chapters->count();
        });
        $author = User::where('role_id', 2)->count();
        $publisher = User::where('role_id', 3)->count();
        $book = Book::count();
        $comments = Comment::count();
        $views = Read::count();
        $bookId = $books->pluck('id')->first() ?? null;

        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Book', 'url' => route('books.index')],
        ];

        return view('book.index', compact('author', 'publisher', 'book', 'books', 'user', 'countChapters', 'comments', 'views', 'bookId', 'breadcrumb'));
    }

    public function yourBook(Request $request)
    {
        $role = $request->user()->role_id;
        if($role==1){
            $query = Book::with(['category', 'author'])->withCount('chapters');
        }
        elseif($role==2){
            $query = Book::with(['category', 'author'])
                ->withCount('chapters')
                ->where('author_id', $request->user()->id);
        }
        elseif($role==3){
            // Publisher: ambil buku yang pernah dibaca oleh user ini
            $query = Book::with(['category', 'author', 'reads'])
                ->withCount('chapters')
                ->whereHas('reads', function ($q) use ($request) {
                    $q->where('user_id', $request->user()->id);
                });
        }
        return DataTables::of($query)
            ->addColumn('action', function ($book) {
                return view('book.partials.actions', compact('book'))->render();
            })
            ->make(true);
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

            $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Create', 'url' => '']
            ];

            return view('book.create', compact('categories', 'user', 'authors', 'breadcrumb'));
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

            $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Book', 'url' => route('books.index')],
                ['title' => 'Edit', 'url' => '']
            ];

            return view('book.edit', compact('book', 'categories', 'user', 'authors', 'breadcrumb'));
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
