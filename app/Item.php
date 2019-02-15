<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * 作品に関連するいいね情報取得
     */
    public function likes(){
        return $this->hasMany('App\Like');
    }

    /**
     * 作品に関連するコメント情報取得
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    /**
     * レビュー評価の高い作品情報取得
     */
    public function getItems(){
        $items = item::take(20)->get();
        return $items;
    }

    /**
     * 作品詳細情報取得
     */
    public function getItem(int $id){
        $item = item::where('id', $id)->first();
        return $item;
    }

    /**
     * タイトル検索作品情報取得
     * 条件：作品タイトル
     */
    public function getSearchByTitle(string $keyword){
        $items = item::take(20)->where('title', 'LIKE', "%{$keyword}%")->get();
        return $items;
    }

    /**
     * キャスト検索作品情報取得
     */
    public function getSearchByCast(string $keyword){
        $items = item::take(20)->where('cast', 'LIKE', "%{$keyword}%")->get();
        return $items;
    }

    /**
     * さらに作品情報取得
     */
    public function getMoreItems(int $count){
        $items = item::skip($count)->take(20)->get();
        return $items;
    }

    /**
     * さらにタイトル検索作品情報取得
     */
    public function getMoreItemsSearchByTitle(int $count, string $string){
        $items = item::where('title', 'LIKE', "%{$keyword}%")->skip($count)->take(20)->get();
        return $items;
    }

    /**
     * さらにキャスト検索作品情報取得
     */
    public function getMoreItemsSearchByCast(int $count, string $string){
        $items = item::where('cast', 'LIKE', "%{$keyword}%")->skip($count)->take(20)->get();
        return $items;
    }
}
