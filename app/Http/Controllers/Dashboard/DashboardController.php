<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Book;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $author = User::where('role_id', 2)->count();
        $publisher = User::where('role_id', 3)->count();
        $book = Book::count();
        // Jangan ambil $books di sini!
        return view('full.index', compact('author', 'publisher', 'book', 'user'));
    }

    public function booksData(Request $request)
    {
        $query = Book::with(['category', 'author'])->withCount('chapters');
        return DataTables::of($query)
            ->addColumn('action', function ($book) {
                return view('book.partials.actions', compact('book'))->render();
            })
            ->make(true);
    }
}
