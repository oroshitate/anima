<?php

namespace App;

use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    public function tweet(Request $request, string $title, float $score, string $content, string $url){
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
