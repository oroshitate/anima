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
    public function users(){
        return $this->hasMany('App\User');
    }

    /**
     * ウォッチリストに関連する作品情報取得
     */
    public function items(){
        return $this->hasMany('App\Item');
    }
}
