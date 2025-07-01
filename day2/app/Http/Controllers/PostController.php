<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }

        $post->load('user', 'approvedComments.user', 'approvedComments.approvedReplies.user');

        return view('posts.show', compact('post'));
    }
}