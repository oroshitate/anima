<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Like;

class LikeController extends Controller
{
    public function store(Request $request){
        \Log::info("LikeController : store() : Start");
        $review_id = $request->input('review_id');
        $comment_id = $request->input('comment_id');

        DB::beginTransaction();
        try {
            $like = new Like;
            if($comment_id){
                $like->user_id = Auth::id();
                $like->review_id = $review_id;
                $like->comment_id = $comment_id;
                $like->save();
            }else {
                $like->user_id = Auth::id();
                $like->review_id = $review_id;

                $like->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("LikeController : store() : Failed Store Like! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

        return $like->id;
    }

    public function delete(Request $request){
        $like_id = $request->input('like_id');

        Like::find($like_id)->delete();
    }
}
