<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Notification;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 認証済みユーザーのみ
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $notification = new Notification();
                $notifications_count = $notification->checkUserNotifications(Auth::id());
                $request->session()->put('notifications_count', $notifications_count);
                return $next($request);
            }
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNotifications(string $nickname, Request $request)
    {
        $user_id = Auth::id();
        $notification = new Notification();
        $notifications = $notification->getUserNotifications($user_id);

        Notification::where('receive_id', $user_id)->delete();
        $request->session()->put('notifications_count', 0);

        return view('user.notifications', [
            'notifications' => $notifications,
        ]);
    }
}
