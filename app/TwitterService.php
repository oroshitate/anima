<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    public function tweet($twitter_account, string $title, float $score, string $content, string $url){
        $token = $twitter_account->token;
        $token_secret = $twitter_account->token_secret;
        $decrypted_token = decrypt($token);
        $decrypted_token_secret = decrypt($token_secret);
        $twitter = new TwitterOAuth(
                      env('TWITTER_CLIENT_ID'),
                      env('TWITTER_CLIENT_SECRET'),
                      $decrypted_token,
                      $decrypted_token_secret
        );

        $star = str_repeat("★", $score);
        $twitter->post("statuses/update", [
                "status" =>
                    $star.$score."点『".$title."』をレビューしました。\n".$content."\n#anima #".$title."\n".$url
        ]);
    }
}
