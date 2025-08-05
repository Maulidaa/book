<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chapter; 

class ChepterController extends Controller
{
    /**
     * Display a listing of the chapters.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Logic to list paginated chapters
        $chapters = Chapter::paginate(10);
        return response()->json($chapters);
    }

    /**
     * Show the form for creating a new chapter.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    /**
     * Store a newly created chapter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     // Logic to store a new chapter
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'book_id' => 'required|exists:books,id',
        ]);
        $chapter = Chapter::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'book_id' => $validatedData['book_id'],
        ]);
        return response()->json([
            'message' => 'Chapter created successfully',
            'chapter' => $chapter,
        ], 201);
    }

    /**
     * Display the specified chapter.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Logic to show a specific chapter
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);
        }
        return response()->json($chapter);
    }

    /**
     * Update the specified chapter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Logic to update an existing chapter
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);
        }
        $chapter->update($validatedData);
        return response()->json(['message' => 'Chapter updated successfully']);
    }

    /**
     * Remove the specified chapter from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Logic to delete a chapter
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);   
        }
        $chapter->delete();
        return response()->json(['message' => 'Chapter deleted successfully']);
    }
}