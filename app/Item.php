<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Review;

class Item extends Model
{
    protected $fillable = [
        'title', 'image', 'season', 'company', 'anime_url', 'official_link'
    ];

    /**
     * 作品に関連するウォッチリスト情報取得
     */
    public function watchlists(){
        return $this->hasMany('App\Watchlist');
    }

    /**
     * 作品に関連するレビュー情報取得
     */
    public function reviews(){
        return $this->hasMany('App\Review');
    }

    /**
     * 作品に関連するコメント情報取得
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    /**
     * 作品詳細情報取得
     */
    public function getItem(int $id){
        $item = item::where('id', $id)->first();
        $item->reviews_count = $item->reviews()->count();

        return $item;
    }

    /**
     * ユーザーレビューに関する作品情報取得
     */
    public function getReviewItems($reviews){
        $items = Item::where(function ($query) use ($reviews) {
            foreach ($reviews as $review) {
                $query->orWhere('items.id', $review->item_id);
            }
        })->take(20)->get();

        foreach($items as $item){
            $review = new Review();
            $review_score = $review->select('score')->where('item_id',$item->id)->first();
            $item->review_score = $review_score->score;
        }

        return $items;
    }

    /**
     * ユーザーレビューに関する作品情報取得
     */
    public function getMoreReviewItems($reviews, $count){
        $items = Item::where(function ($query) use ($reviews) {
            foreach ($reviews as $review) {
                $query->orWhere('items.id', $review->item_id);
            }
        })->skip($count)->take(20)->get();

        foreach($items as $item){
            $review = new Review();
            $review_score = $review->select('score')->where('item_id',$item->id)->first();
            $item->review_score = $review_score->score;
        }

        return $items;
    }

    /**
     * 話題の作品情報取得
     * レビュー数の多い作品で評価の高い作品を取得
     */
    public function getPopularItems(){
        $review = new Review();
        $reviews_avg_list = $review->getReviewsAvgs();
        $items = array();
        foreach ($reviews_avg_list as $review_avg) {
            $item = Item::find($review_avg->item_id);
            if($review_avg->item_avg == null){
                $item->item_avg = 0;
            }else {
                $item->item_avg = $review_avg->item_avg;
            }
            array_push($items, $item);
        }

        return $items;
    }

    /**
     * アニメ作品検索作品件数取得
     */
    public function getSearchByItemCount(string $keyword){
        $items_count = item::where('title', 'LIKE', "%{$keyword}%")->count();

        return $items_count;
    }

    /**
     * アニメ作品検索作品情報取得
     */
    public function getSearchByItem(string $keyword){
        $items = item::where('title', 'LIKE', "%{$keyword}%")->take(20)->get();

        foreach ($items as $item) {
            $count = $item->reviews()->count();
            $item->reviews_count = $count;
            $review = new Review();
            $avg = $review->getReviewsAvg($item);
            if($avg->item_avg == null){
                $item->item_avg = 0;
            }else {
                $item->item_avg = $avg->item_avg;
            }
        }

        return $items;
    }

    /**
     * さらにアニメ作品検索作品情報取得
     */
    public function getMoreItemsSearchByItem(string $keyword, int $count){
        $items = item::where('title', 'LIKE', "%{$keyword}%")
                       ->skip($count)
                       ->take(20)
                       ->get();

        foreach ($items as $item) {
            $count = $item->reviews()->count();
            $item->reviews_count = $count;
            $avg = $item->reviews()->select(DB::raw("round(avg(score), 1) as item_avg"))->first();
            if($avg->item_avg == null){
                $item->item_avg = 0;
            }else {
                $item->item_avg = $avg->item_avg;
            }
        }

        return $items;
    }
}
