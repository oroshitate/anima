<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = LinkedSocialAccount::whereProviderName($provider)
                   ->whereProviderId($providerUser->id)
                   ->first();
        if ($account) {
            return $account->user;
        } else {
            //アバター画像取得
            $avatar_url = $providerUser->avatar;
            $image_contents = file_get_contents($avatar_url);
            $image_encode = base64_encode($providerUser->name);
            $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
            $image = $image_name.'.jpg';
            //アバター画像を保存
            \Storage::put('public/images/users/'.$image, $image_contents);
            if ($providerUser->email) {
                $user = User::whereEmail($providerUser->email)->first();
                if (! $user) {
                    $user = User::create([
                        'email' => $providerUser->email,
                        'name'  => $providerUser->name,
                        'nickname' => $providerUser->nickname,
                        'image' => $image,
                    ]);
                }
                $user->accounts()->create([
                    'provider_id'   => $providerUser->id,
                    'provider_name' => $provider,
                ]);

                return $user;
            } else {
                // emailがなかったら
                $user = User::create([
                    'email' => $providerUser->email,
                    'name'  => $providerUser->name,
                    'nickname' => $providerUser->nickname,
                    'image' => $image,
                ]);
                $user->accounts()->create([
                    'provider_id'   => $providerUser->id,
                    'provider_name' => $provider,
                ]);

                return $user;
            }
        }
    }

    public function tweet(string $title, float $score, string $content, string $url){
        \Log::info('tweet');
        $token = $request->session()->get('provider_access_token');
        $token_secret = $request->session()->get('provider_access_token_secret');

        $twitter = new TwitterOAuth(
                      env('TWITTER_CLIENT_ID'),
                      env('TWITTER_CLIENT_SECRET'),
                      $token,
                      $token_secret
        );

        $twitter->post("statuses/update", [
                "status" =>
                    $title.$score.$content.$url
        ]);
    }
}
