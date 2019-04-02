<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'review_id', 'content', 'reply_id'
    ];

    /**
     * コメントに関連するいいね情報取得
     */
    public function likes(){
        return $this->hasMany('App\Like');
    }

    /**
     * コメントに関連するユーザー情報取得
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * コメントに関連するレビュー情報取得
     */
    public function review(){
        return $this->belongsTo('App\Review');
    }

    /**
     * コメントに関する作品情報取得
     */
    public function item(){
        return $this->belongsTo('App\Item');
    }

    /**
     * レビューに関するコメント数取得
     */
    public function getCommentsCount(int $review_id){
        $comments_count = Comment::where('review_id',$review_id)->count();
        return $comments_count;
    }

    /**
     * レビューに関するコメント情報取得
     */
    public function getComments(Review $review){
        $review_id = $review->id;
        $comments = $review->comments()
                           ->join('users','users.id','=','comments.user_id')
                           ->orderBy('comments.created_at', 'asc')
                           ->take(20)
                           ->get([
                                "comments.id as comment_id",
                                "comments.content as comment_content",
                                "comments.reply_id as comment_reply_id",
                                "comments.created_at as comment_created",
                                "users.id as user_id",
                                "users.name as user_name",
                                "users.nickname as user_nickname",
                                "users.image as user_image",
                           ]);

        foreach ($comments as $comment) {
            $likes_count = comment::find($comment->comment_id)->likes()->count();
            $comment->comment_likes_count = $likes_count;

            $like_comment = Like::where([
                                ['review_id', '=', $review_id],
                                ['comment_id', '=', $comment->comment_id],
                                ['user_id', '=', Auth::id()],
                            ])->get();

            if(count($like_comment) == 1){
                $comment->comment_like_status = "active";
                $comment->comment_like_id = $like_comment[0]->id;
            }else{
                $comment->comment_like_status = "";
                $comment->comment_like_id = "";
            }

            $reply_count = comment::where("reply_id", $comment->comment_id)->count();
            $comment->reply_count = $reply_count;
            $reply_id = $comment->comment_reply_id;
            if($reply_id){
                $user = comment::find($reply_id)->user()->first();
                $comment->comment_reply_user_nickname = $user->nickname;
            }

            $comment->comment_created = Carbon::createFromFormat('Y-m-d H:i:s', $comment->comment_created)->format('Y/m/d H:i:s');
        }

        return $comments;
    }

    /**
     * さらにレビューに関するコメント情報取得
     */
    public function getMoreComments(Review $review, int $count){
        $review_id = $review->id;
        $comments = $review->comments()
                           ->join('users','users.id','=','comments.user_id')
                           ->orderBy('comments.created_at', 'desc')
                           ->skip($count)
                           ->take(20)
                           ->get([
                                "comments.id as comment_id",
                                "comments.content as comment_content",
                                "comments.reply_id as comment_reply_id",
                                "comments.created_at as comment_created",
                                "users.id as user_id",
                                "users.name as user_name",
                                "users.nickname as user_nickname",
                                "users.image as user_image",
                           ]);

        foreach ($comments as $comment) {
            $likes_count = comment::find($comment->comment_id)->likes()->count();
            $comment->comment_likes_count = $likes_count;

            $like_comment = Like::where([
                                ['review_id', '=', $review_id],
                                ['comment_id', '=', $comment->comment_id],
                                ['user_id', '=', Auth::id()],
                            ])->get();

            if(count($like_comment) == 1){
                $comment->comment_like_status = "active";
                $comment->comment_like_id = $like_comment[0]->id;
            }else{
                $comment->comment_like_status = "";
                $comment->comment_like_id = "";
            }

            $reply_count = comment::where("reply_id", $comment->comment_id)->count();
            $comment->reply_count = $reply_count;
            $reply_id = $comment->comment_reply_id;
            if($reply_id){
                $user = comment::find($reply_id)->user()->first();
                $comment->comment_reply_user_nickname = $user->nickname;
            }

            $comment->comment_created = Carbon::createFromFormat('Y-m-d H:i:s', $comment->comment_created)->format('Y/m/d H:i:s');
        }

        return $comments;
    }
}
