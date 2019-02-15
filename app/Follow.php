<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * フォローに関連するユーザー情報取得
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
