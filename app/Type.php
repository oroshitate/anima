<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * タイプに関連する通知情報取得
     */
    public function notifications(){
        return $this->hasMany('App\Notification');
    }
}
