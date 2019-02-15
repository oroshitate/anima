<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'image', 'content',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * ユーザーに関連するSNSアカウント取得
     */
    public function accounts(){
        return $this->hasMany('App\LinkedSocialAccount');
    }

    /**
     * ユーザーに関連するレビュー情報取得
     */
    public function reviews(){
        return $this->hasMany('App\Review');
    }

    /**
     * ユーザーに関連するフォロー情報取得
     */
    public function follow(){
        return $this->belongsTo('App\Follow');
    }

    /**
     * ユーザーに関連するウォッチリスト情報取得
     */
    public function watchlist(){
        return $this->belongsTo('App\Watchlist');
    }

    /**
     * ユーザー名検索ユーザー情報取得
     */
    public function getSearchByUser(string $keyword){
        $users = User::take(20)->where('name', 'LIKE', "%{$keyword}%")
                               ->orwhere('nickname', 'LIKE', "%{$keyword}%")
                               ->get();
        return $users;
    }

    /**
     * ユーザー詳細情報取得
     */
    public function getUser(string $nickname){
        $user = User::where('nickname', $nickname)->first();
        return $user;
    }
}
