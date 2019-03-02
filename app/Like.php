<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [

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
}
