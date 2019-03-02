<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikeController extends Controller
{
    public function store(Request $request){
        $review_id = $request->input('review_id');
        $comment_id = $request->input('comment_id');

        if($comment_id){
            $like = new Like;

            $like->user_id = Auth::id();
            $like->review_id = $review_id;
            $like->comment_id = $comment_id;
            $like->save();

            return $like->id;
        }else {
            $like = new Like;

            $like->user_id = Auth::id();
            $like->review_id = $review_id;

            $like->save();

            return $like->id;
        }
    }

    public function delete(Request $request){
        $like_id = $request->input('like_id');

        Like::find($like_id)->delete();
    }
}
