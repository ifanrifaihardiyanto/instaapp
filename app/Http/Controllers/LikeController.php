<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $user = auth()->user();

        if ($user->likes->contains($post)) {
            $user->likes()->detach($post);
            $liked = false;
        } else {
            $user->likes()->attach($post);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
        ]);
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}
