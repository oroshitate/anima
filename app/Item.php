<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Review;

class Item extends Model
{
    protected $fillable = [

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
        $item->reviews_count = $item->reviews->count();

        return $item;
    }

    public function getPopularItems(){
        $reviews_item = review::select(DB::raw("count(item_id) as item_count, round(avg(score), 1) as item_avg, item_id"))->groupBy("item_id")->orderBy("item_count", "desc")->take(20)->get();
        $items = array();
        foreach ($reviews_item as $review_item) {
            $item = Item::find($review_item->item_id);
            if($review_item->item_avg == null){
                $item->item_avg = 0;
            }else {
                $item->item_avg = $review_item->item_avg;
            }
            array_push($items, $item);
        }

        return $items;
    }

    /**
     * アニメ作品検索作品情報取得
     */
    public function getSearchByItem(string $keyword){
        $items = item::where('title', 'LIKE', "%{$keyword}%")
                       ->orWhere('cast', 'LIKE', "%{$keyword}%")
                       ->take(20)->get();

        foreach ($items as $item) {
            $avg = $item->reviews()->select(DB::raw("round(avg(score), 1) as item_avg"))->first();
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
                       ->orWhere('cast', 'LIKE', "%{$keyword}%")
                       ->skip($count)
                       ->take(20)
                       ->get();

        foreach ($items as $item) {
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
