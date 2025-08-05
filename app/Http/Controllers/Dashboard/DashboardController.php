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
        $author = User::where('role_id', 2)->count();
        $publisher = User::where('role_id', 3)->count();
        $book = Book::count();
        return view('full.index', compact('author', 'publisher', 'book'));
    }
}
