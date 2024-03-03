<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Gallery $gallery)
    {
        $comments = $gallery->comments()->with('user')->get();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = $gallery->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        if($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Ovo cu kasnije promijenit da se ne vidit edit za tudje komentare'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'i ovo isto moram promijenit da se ne vidi delete od tudjih komentara'], 403);
        }
        $comment->delete();
        return response()->json(['message' => 'Komentar obrisan']);
    }
}
