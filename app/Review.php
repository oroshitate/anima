<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'content','score'
    ];

    /**
     * レビューに関連するいいね情報取得
     */
    public function likes(){
        return $this->hasMany('App\Like');
    }

    /**
     * レビューに関連するコメント情報取得
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    /**
     * レビューに関連するユーザー情報取得
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * レビューに関連する作品情報取得
     */
    public function item(){
        return $this->belongsTo('App\Item');
    }

    public function getReview(int $id){
        $review = review::where('reviews.id', $id)->join('users','users.id','=','reviews.user_id')
                                                  ->join('comments','comments.review_id','=','reviews.id')
                                                  ->get([
                                                       "reviews.id as review_id",
                                                       "reviews.score as review_score",
                                                       "reviews.content as review_content",
                                                       "users.id as user_id",
                                                       "users.name as user_name",
                                                       "users.nickname as user_nickname",
                                                       "users.image as user_image",
                                                       "comments.content as comment_content",
                                                  ]);
        return $review;
    }

    public function getReviews(Item $item_detail){
        $reviews = $item_detail->reviews()
                               ->join('users','users.id','=','reviews.user_id')
                               ->orderBy('reviews.created_at', 'desc')
                               ->get([
                                    "reviews.id as review_id",
                                    "reviews.score as review_score",
                                    "reviews.content as review_content",
                                    "users.id as user_id",
                                    "users.name as user_name",
                                    "users.nickname as user_nickname",
                                    "users.image as user_image",
                               ]);
        return $reviews;
    }
}
