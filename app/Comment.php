<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

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

    public function getComments(Review $review){
        $comments = $review->comments()
                           ->join('users','users.id','=','comments.user_id')
                           ->orderBy('comments.created_at', 'desc')
                           ->get([
                                "comments.id as comment_id",
                                "comments.content as comment_content",
                                "users.id as user_id",
                                "users.name as user_name",
                                "users.nickname as user_nickname",
                                "users.image as user_image",
                           ]);
        return $comments;
    }
}
