<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Review extends Model
{
    protected $fillable = [
        'user_id','item_id','content','score'
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

    /**
     * 作品に関するレビュー数取得
     */
    public function getReviewsCount(Item $item){
        $reviews_count = $item->reviews()->count();
        return $reviews_count;
    }

    /**
     * レビュー詳細情報取得
     */
    public function getReview(int $id){
        $review = review::where('reviews.id', $id)->join('users','users.id','=','reviews.user_id')
                                                  ->get([
                                                       "reviews.id as review_id",
                                                       "reviews.score as review_score",
                                                       "reviews.content as review_content",
                                                       "reviews.created_at as review_created",
                                                       "users.id as user_id",
                                                       "users.name as user_name",
                                                       "users.nickname as user_nickname",
                                                       "users.image as user_image",
                                                  ]);

        $review[0]->review_created = Carbon::createFromFormat('Y-m-d H:i:s', $review[0]->review_created)->format('Y/m/d H:i:s');

        return $review;
    }

    /**
     * 作品に関するレビュー情報取得
     */
    public function getReviews(Item $item_detail){
        $reviews = $item_detail->reviews()
                               ->join('users','users.id','=','reviews.user_id')
                               ->orderBy('reviews.created_at', 'desc')
                               ->take(20)
                               ->get([
                                    "reviews.id as review_id",
                                    "reviews.score as review_score",
                                    "reviews.content as review_content",
                                    "reviews.created_at as review_created",
                                    "users.id as user_id",
                                    "users.name as user_name",
                                    "users.nickname as user_nickname",
                                    "users.image as user_image",
                               ]);

        foreach ($reviews as $review) {
            $review->review_created = Carbon::createFromFormat('Y-m-d H:i:s', $review->review_created)->format('Y/m/d H:i:s');
        }

        return $reviews;
    }

    /**
     * 作品に関するレビュー評価平均取得
     */
    public function getReviewsAvg(Item $item){
        $avg = $item->reviews()->select(DB::raw("round(avg(score), 1) as item_avg"))->first();
        return $avg;
    }

    /**
     * 作品に関するレビュー評価平均リスト取得
     */
    public function getReviewsAvgs(){
        $reviews_avg_list = review::select(DB::raw("count(item_id) as item_count, round(avg(score), 1) as item_avg, item_id"))->groupBy("item_id")->orderBy("item_count", "desc")->take(20)->get();
        $sorted = $reviews_avg_list->sortByDesc('item_avg')->values();

        return $sorted;
    }

    /**
     * さらに作品に関するレビュー情報取得
     */
    public function getMoreReviews(Item $item_detail, int $count){
        $reviews = $item_detail->reviews()
                               ->join('users','users.id','=','reviews.user_id')
                               ->orderBy('reviews.created_at', 'desc')
                               ->skip($count)
                               ->take(20)
                               ->get([
                                    "reviews.id as review_id",
                                    "reviews.score as review_score",
                                    "reviews.content as review_content",
                                    "reviews.created_at as review_created",
                                    "users.id as user_id",
                                    "users.name as user_name",
                                    "users.nickname as user_nickname",
                                    "users.image as user_image",
                               ]);

        foreach ($reviews as $review) {
           $review->review_created = Carbon::createFromFormat('Y-m-d H:i:s', $review->review_created)->format('Y/m/d H:i:s');
        }

        return $reviews;
    }

    /**
     * ユーザーに関するタイムライン取得
     */
    public function getTimelines(int $user_id, array $follow_ids){
        $reviews = Review::where(function ($query) use ($user_id, $follow_ids) {
            foreach ($follow_ids as $follow_id) {
                $query->orwhere('reviews.user_id', $follow_id);
            }
        })
        ->join('users','users.id','=','reviews.user_id')
        ->join('items','items.id','=','reviews.item_id')
        ->orderBy('reviews.created_at', 'desc')
        ->take(20)
        ->get([
            "reviews.id as review_id",
            "reviews.score as review_score",
            "reviews.content as review_content",
            "reviews.created_at as review_created",
            "users.id as user_id",
            "users.name as user_name",
            "users.nickname as user_nickname",
            "users.image as user_image",
            "items.id as item_id",
            "items.title as item_title",
            "items.image as item_image"
         ]);
        foreach ($reviews as $review) {
            $review->review_created = Carbon::createFromFormat('Y-m-d H:i:s', $review->review_created)->format('Y/m/d H:i:s');

            $comment = new Comment();
            $like = new Like();
            $review->comments_count = $comment->getCommentsCount($review->review_id);
            $review->likes_count = $like->getLikesCount($review->review_id);
            $my_like = $like->getMyLike($user_id, $review->review_id);
            $like_id = "";
            if(count($my_like) > 0){
                $review->like_status = "active";
                $review->like_id = $my_like[0]->id;
            }else{
                $review->like_status = "";
                $review->like_id = "";
            }
        }

        return $reviews;
    }

    /**
     * レビュー件数の多いユーザー取得
     */
    public function getManyReviewUsers(){
        $users = review::select(DB::raw("count(user_id) as user_count, user_id"))->groupBy("user_id")->orderBy("user_count", "desc")->take(20)->get();

        return $users;
    }
}
