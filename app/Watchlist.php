<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [

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
}
