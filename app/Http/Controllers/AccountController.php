<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $linked_providers = User::find($user_id)->accounts()->select('provider_name')->get();
        $linked_count = count($linked_providers);

        $twitter = "on";
        $facebook = "on";
        $google = "on";
        foreach ($linked_providers as $provider) {
            if($provider->provider_name == "twitter"){
                $twitter = "off";
            }else if($provider->provider_name == "facebook"){
                $facebook = "off";
            }else {
                $google = "off";
            }
        }

        return view('account.index',[
            'linked_count' => $linked_count,
            'twitter' => $twitter,
            'facebook' => $facebook,
            'google' => $google,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm()
    {
        return view('account.confirm');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $user_id = Auth::id();
        User::find($user_id)->delete();

        return redirect()->route('home');
    }
}
