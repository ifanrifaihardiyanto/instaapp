<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $alreadyLiked = $user->likes()->where('post_id', $post->id)->exists();

        if ($alreadyLiked) {
            $user->likes()->detach($post->id);
            $liked = false;
        } else {
            $user->likes()->attach($post->id);
            $liked = true;
        }

        $likesCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount,
        ]);
    }
}
