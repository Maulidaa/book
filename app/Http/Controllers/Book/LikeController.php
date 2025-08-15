<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    /**
     * Store a new like for a book or chapter.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'chapter_id' => 'nullable|exists:chapters,id',
        ]);

        $existingLike = Like::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->where('chapter_id', $request->chapter_id)
            ->first();

        if ($existingLike) {
            // Jika sudah like, maka unlike (hapus)
            $existingLike->delete();
            return response()->json(['message' => 'Unliked successfully!'], 200);
        } else {
            // Jika belum, maka like
            $like = Like::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
                'chapter_id' => $request->chapter_id,
            ]);
            return response()->json(['message' => 'Liked successfully!'], 201);
        }        
    }

    public function destroy($id)
    {
        // Find the like by ID
        $like = Like::find($id);
        if (!$like) {
            return response()->json(['message' => 'Like not found'], 404);
        }

        // Check if the authenticated user is the owner of the like
        if ($like->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the like
        $like->delete();

        return response()->json(['message' => 'Like removed successfully!'], 200);
    }

    public function show($id, $chapterId)
    {
        // $id = book id, $chapterId = chapter id
        $likes = Like::where('book_id', $id)
            ->where('chapter_id', $chapterId)
            ->with('user')
            ->get();

        return response()->json($likes);
    }
}
