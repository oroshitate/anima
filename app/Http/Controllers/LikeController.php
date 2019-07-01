<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Like;
use App\Review;
use App\Comment;
use App\Notification;

class LikeController extends Controller
{
    public function store(Request $request){
        \Log::info("LikeController : store() : Start");
        $review_id = $request->input('review_id');
        $comment_id = $request->input('comment_id');

        DB::beginTransaction();
        try {
            if($comment_id){
                $data = [
                  'user_id' => Auth::id(),
                  'review_id' => $review_id,
                  'comment_id' => $comment_id
                ];

                $like = Like::create($data);

                // 通知格納
                $user = Comment::find($comment_id)->user;

                $receive_id = $user->id;
                if($receive_id != Auth::id()){
                    $data = [
                      'type_id' => 4,
                      'receive_id' => $receive_id,
                      'send_id' => Auth::id(),
                      'review_id' => $review_id,
                    ];

                    Notification::create($data);
                }
            }else {
                $data = [
                  'user_id' => Auth::id(),
                  'review_id' => $review_id
                ];

                $like = Like::create($data);

                // 通知格納
                $user = Review::find($review_id)->user;

                $receive_id = $user->id;
                if($receive_id != Auth::id()){
                    $data = [
                      'type_id' => 1,
                      'receive_id' => $receive_id,
                      'send_id' => Auth::id(),
                      'review_id' => $review_id,
                    ];

                    Notification::create($data);
                }
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
