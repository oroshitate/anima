<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\TwitterService;
use App\User;
use App\Item;
use App\Review;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider, Request $request, \App\SocialAccountService $accountService)
    {
        $case = $request->input('case')[0];
        $review_id = $request->session()->get('review_id');
        if($review_id){
            $case = 'share';
        }

        if($case){
            if($case == 'link'){
                $link = $request->input('link')[0];
                if($link == 'off'){
                    $user_id = Auth::id();
                    $user = User::find($user_id);

                    $result = $user->accounts()->where('provider_name', $provider)->delete();

                    return redirect()->back();
                }
                $request->session()->put('link', $link);
            }else{
                $request->session()->put('link', 'on');
            }
        }

        $request->session()->put('provider', $provider);
        return \Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback(\App\SocialAccountService $accountService, $provider, Request $request)
    {
        $link = $request->session()->get('link');
        $request->session()->forget('link');
        if($link){
            $user = \Socialite::with($provider)->user();

            if($link == 'on'){
                $result = $accountService->linkSocialAccount($user, $provider);
                $review_id = $request->session()->get('review_id');
                $request->session()->forget('review_id');
                if($review_id){
                    $review = Review::find($review_id);
                    $content = $review->content;
                    $score = $review->score;
                    $item_id = $review->item_id;
                    $item = Item::find($item_id);
                    $title = $item->title;
                    $url = route('review', ['review_id' => $review_id]);
                    $twitter_service = new TwitterService;
                    $twitter_service->tweet($result,$title,$score,$content,$url);

                    return redirect()->route('review', ['review_id' => $review_id]);
                }
            }

            return redirect('/account/setting');
        }

        try {
            $user = \Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = $accountService->find(
            $user,
            $provider
        );

        if($authUser == null){
            $request->session()->put('user', $user);
            return redirect()->to('register');
        }else{
            auth()->login($authUser, true);
            return redirect()->to('/');
        }
    }
}
