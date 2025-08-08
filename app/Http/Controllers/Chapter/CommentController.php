<?php

namespace App\Http\Controllers\Chapter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $id, $chapterId)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Pastikan chapter ada
        $chapter = \App\Chapter::find($chapterId);
        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found!');
        }

        // Create a new comment
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->chapter_id = $chapterId;
        $comment->user_id = auth()->id(); // Assuming the user is authenticated

        // Save the comment
        $comment->save();

        // Redirect back to the chapter page with a success message
        return redirect()->route('chapters.show', ['id' => $id, 'chapterId' => $chapterId])
                         ->with('success', 'Comment added successfully!');
    }
}
