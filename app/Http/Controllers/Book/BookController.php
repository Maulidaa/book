<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book; 

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
            $draw = $request->get('draw');
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $searchValue = $request->input('search.value');

            $query = Book::query();

            // Filter pencarian
            if ($searchValue) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('title', 'like', "%{$searchValue}%")
                      ->orWhere('author', 'like', "%{$searchValue}%")
                      ->orWhere('isbn', 'like', "%{$searchValue}%");
                });
            }

            $recordsTotal = Book::count();
            $recordsFiltered = $query->count();

            $books = $query->offset($start)->limit($length)->get();

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $books,
            ]);
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
                'category_id' => 'nullable|exists:categories,id',
            ]);

            // Create a new book instance
            $book = Book::create([
                'title' => $validatedData['title'],
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

}
