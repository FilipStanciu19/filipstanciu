<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'is_approved' => false, // Comments need admin approval
        ]);

        return back()->with('success', 'Comment submitted and will be reviewed by an admin.');
    }

    public function destroy(Comment $comment)
    {
        // Users can only delete their own comments
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'You can only delete your own comments.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}