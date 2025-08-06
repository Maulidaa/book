<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Book;

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
        // Ambil data buku beserta relasi category dan chapters
        $books = Book::with(['category', 'chapters', 'author'])->limit(10)->get();

        return view('full.index', compact('author', 'publisher', 'book', 'books', 'user'));
    }

    public function book()
    {
    }
}
