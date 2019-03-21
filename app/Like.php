<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
      'user_id', 'review_id', 'comment_id'
    ];

    /**
     * いいねに関連するユーザー情報取得
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * いいねに関連するレビュー情報取得
     */
    public function review(){
        return $this->belongsTo('App\Review');
    }

    /**
     * いいねに関連するコメント情報取得
     */
    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    /**
     * レビューに関するいいね数取得
     */
    public function getLikesCount(int $review_id){
        $likes_count = Like::where('review_id',$review_id)->count();
        return $likes_count;
    }

    /**
     * レビューに関するユーザーいいね取得
     */
    public function getMyLike(int $user_id, int $review_id){
        $my_like = Like::where([
                    ['review_id', '=', $review_id],
                    ['user_id', '=', $user_id],
        ])->get();

        return $my_like;
    }
}
