<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $fillable = ['provider_name', 'provider_id', 'token', 'token_secret'];

    /**
     * アカウントに関するユーザー情報取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * アカウントに関するユーザー情報取得
     */
    public function getUserLinkedProvider(User $user)
    {
        $linked_providers = $user->accounts()->select('provider_name')->get();
        return $linked_providers;
    }

    /**
     * 連携アカウントに関するユーザー情報取得
     */
    public function getUserLinkedProviderExists(User $user, string $provider){
        $account = $user->accounts()->where("provider_name", $provider)->first();
        return $account;
    }
}
