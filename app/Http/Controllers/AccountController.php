<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\LinkedSocialAccount;
use App\Notification;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $notification = new Notification();
            $notifications_count = $notification->checkUserNotifications(Auth::id());
            $request->session()->put('notifications_count', $notifications_count);
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $account = new LinkedSocialAccount();
        $linked_providers = $account->getUserLinkedProvider($user);
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
        \Log::info("AccountController : delete() : Start");
        $user_id = Auth::id();

        DB::beginTransaction();
        try {
            User::find($user_id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("AccountController : delete() : Failed Delete User! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            abort(500);
        }

        return redirect()->route('home');
    }
}
