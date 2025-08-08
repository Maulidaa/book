<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Book;

class StatistikController extends Controller
{
    public function index()
    {
        $author = User::where('role_id', 2)->count();
        $publisher = User::where('role_id', 3)->count();
        $book = Book::count();

        return response()->json([
            'author' => $author,
            'publisher' => $publisher,
            'book' => $book,
        ]);
    }
}
