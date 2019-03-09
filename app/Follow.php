<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    /**
     * ユーザーに関するフォロー数取得
     */
    public function getFollowingsCount(User $user){
        $followings_count = $user->follows()->count();
        return $followings_count;
    }

    /**
     * ユーザーに関するフォロワー数取得
     */
    public function getFollowersCount(User $user){
        $followers_count = Follow::where('follow_id', $user->id)->count();
        return $followers_count;
    }

    /**
     * 認証ユーザーに関するフォロー情報取得
     */
    public function getMyFollow(int $user_id){
        $my_follow = Follow::where([
            ['user_id' ,'=', Auth::id()],
            ['follow_id', '=', $user_id]
        ])->get();

        return $my_follow;
    }
}
