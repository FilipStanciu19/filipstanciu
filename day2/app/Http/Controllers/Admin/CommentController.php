<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'post')
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        $comment->load('user', 'post', 'parent', 'replies.user');
        return view('admin.comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'is_approved' => 'boolean',
        ]);

        $comment->update([
            'content' => $request->content,
            'is_approved' => $request->boolean('is_approved'),
        ]);

        return redirect()->route('admin.comments.show', $comment)
            ->with('success', 'Comment updated successfully.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Comment approved successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}