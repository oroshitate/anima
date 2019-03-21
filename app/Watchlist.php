<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [
      'user_id', 'item_id'
    ];

    /**
     * ウォッチリストに関連するユーザー情報取得
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * ウォッチリストに関連する作品情報取得
     */
    public function item(){
        return $this->belongsTo('App\Item');
    }

    /**
     * ウォッチリスト確認
     */
    public function getMyWatchlist(int $item_id, int $user_id){
        $my_watchlist = Watchlist::where([
            ['item_id', '=', $item_id],
            ['user_id', '=', $user_id],
        ])->get();

        return $my_watchlist;
    }

    /**
     * ウォッチリスト情報取得
     */
    public function getWatchlists(int $user_id){
        $watchlists = Watchlist::where('user_id', $user_id)->take(20)->get();
        foreach ($watchlists as $watchlist) {
            $item = $watchlist->item()->get();
            $watchlist->item_id = $item[0]->id;
            $watchlist->item_title = $item[0]->title;
            $watchlist->item_image = $item[0]->image;
        }

        return $watchlists;
    }

    /**
     * さらにウォッチリスト情報取得
     */
    public function getMoreWatchlists(int $user_id, int $count){
        $watchlists = Watchlist::where('user_id', $user_id)->skip($count)->take(20)->get();
        foreach ($watchlists as $watchlist) {
            $item = $watchlist->item()->get();
            $watchlist->item_id = $item[0]->id;
            $watchlist->item_title = $item[0]->title;
            $watchlist->item_image = $item[0]->image;
        }

        return $watchlists;
    }
}
