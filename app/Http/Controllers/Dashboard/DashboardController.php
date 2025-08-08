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
        $bookId = Book::latest()->first()->id;
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
        ];
        // Jangan ambil $books di sini!
        return view('full.index', compact('author', 'publisher', 'book', 'user', 'breadcrumb'));
    }

    public function booksData(Request $request)
    {
        $user = $request->user();
        $role = $user ? $user->role_id : 0;

        if($role == 1){
            $query = Book::with(['category', 'author'])->withCount('chapters');
        }
        else{
            $query = Book::with(['category', 'author'])
                ->withCount(['chapters' => function($q) {
                    $q->where('status', 'published');
                }])
                ->whereHas('chapters', function($q) {
                    $q->where('status', 'published');
                });
        }
        return DataTables::of($query)
            ->addColumn('action', function ($book) {
                return view('book.partials.actions', compact('book'))->render();
            })
            ->make(true);
    }
    public function redirectToDashboard()
    {
        return redirect()->route('dashboard');
    }
}
