<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [

    ];

    /**
     * いいねに関連する作品情報取得
     */
    public function items(){
        return $this->hasMany('App\Item');
    }

    /**
     * いいねに関連するレビュー情報取得
     */
    public function review(){
        return $this->belongsTo('App\Review');
    }
}
