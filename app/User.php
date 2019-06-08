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
     * ユーザー詳細情報取得(ニックネーム)
     */
    public function getUser(string $nickname){
        $user = User::where('nickname', $nickname)->first();

        return $user;
    }

    /**
     * ユーザーフォロー情報取得
     */
    public function getFollowings($followings){
        $users = User::where(function ($query) use ($followings) {
            foreach ($followings as $following) {
                $query->orWhere('users.id', $following->follow_id);
            }
        })->take(20)->get();

        return $users;
    }

    /**
     * ユーザーフォロワー情報取得
     */
    public function getFollowers($followers){
        $users = User::where(function ($query) use ($followers) {
            foreach ($followers as $follower) {
                $query->orWhere('users.id', $follower->user_id);
            }
        })->take(20)->get();

        return $users;
    }

    /**
     * ユーザー名検索ユーザー情報取得
     */
    public function getSearchByUserCount(string $keyword){
        $users_count = User::where('name', 'LIKE', "%{$keyword}%")
                       ->orwhere('nickname', 'LIKE', "%{$keyword}%")
                       ->orWhere('content', 'LIKE', "%{$keyword}%")
                       ->count();

        return $users_count;
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
     * おすすめユーザー取得
     */
    public function getRecommendUsers($many_review_users, $auth_id){
        $users = array();
        foreach ($many_review_users as $many_review_user) {
            $user_id = $many_review_user->user_id;
            if($user_id == $auth_id){
                continue;
            }
            
            $user = User::find($user_id);
            array_push($users,$user);
        }

        return $users;
    }
}
