<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * ユーザーに関連するいいね情報取得
     */
    public function likes(){
        return $this->hasMany('App\Like');
    }

    /**
     * ユーザーに関連するコメント情報取得
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    /**
     * ユーザーに関連するフォロー情報取得
     */
    public function follows(){
        return $this->hasMany('App\Follow');
    }

    /**
     * ユーザーに関連するウォッチリスト情報取得
     */
    public function watchlists(){
        return $this->hasMany('App\Watchlist');
    }

    /**
     * ユーザー名検索ユーザー情報取得
     */
    public function getSearchByUser(string $keyword){
        $users = User::where('name', 'LIKE', "%{$keyword}%")
                       ->orwhere('nickname', 'LIKE', "%{$keyword}%")
                       ->orWhere('content', 'LIKE', "%{$keyword}%")
                       ->take(20)
                       ->get();
        return $users;
    }

    /**
     * さらにユーザー名検索ユーザー情報取得
     */
    public function getMoreUsersSearchByUser(string $keyword, int $count){
        $users = User::where('name', 'LIKE', "%{$keyword}%")->orwhere('nickname', 'LIKE', "%{$keyword}%")
                                                            ->skip($count)
                                                            ->take(20)
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
