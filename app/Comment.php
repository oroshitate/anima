<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * コメントに関連するレビュー情報取得
     */
    public function review(){
        return $this->belongsTo('App\Review');
    }

    /**
     * コメントに関する作品情報取得
     */
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
