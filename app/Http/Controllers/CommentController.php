<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        \Log::info('Posting comment', ['post_id' => $post->id, 'user' => auth()->user()]);

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Comment posted successfully.',
            'comment' => [
                'user' => auth()->user()->name,
                'content' => $comment->content,
            ],
        ]);
    }
}
