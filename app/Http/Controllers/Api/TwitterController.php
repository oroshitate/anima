<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{

    public function tweet(Request $request){
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
                    'aaa'
        ]);

        return redirect()->route('home');;
    }
}
