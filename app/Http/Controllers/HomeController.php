<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\User;
use App\Review;
use App\Comment;
use App\Like;
use Carbon\Carbon;
use App\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $notification = new Notification();
                $notifications_count = $notification->checkUserNotifications(Auth::id());
                $request->session()->put('notifications_count', $notifications_count);
            }
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = new Item();
        $items = $item->getPopularItems();
        if (Auth::check()) {
            $user_id = Auth::id();
            $user = User::find($user_id);

            $notification = new Notification();
            $notifications_count = $notification->checkUserNotifications($user_id);

            $follows = $user->follows;
            $follow_ids = array();
            foreach ($follows as $follow) {
                $follow_id = $follow->follow_id;
                array_push($follow_ids, $follow_id);
            }
            array_push($follow_ids, $user_id);

            $review = new Review();
            $reviews = array();
            if(count($follow_ids) > 1){
                $reviews = $review->getTimelines($user_id,$follow_ids);
                return view('home', [
                    'reviews' => $reviews,
                    'items' => $items,
                    'notifications_count' => $notifications_count
                ]);
            }else{
                $many_review_users = $review->getManyReviewUsers();
                $user = new User();
                $users = $user->getRecommendUsers($many_review_users, $user_id);
                return view('home', [
                    'reviews' => $reviews,
                    'items' => $items,
                    'users' => $users,
                    'notifications_count' => $notifications_count
                ]);
            }

        }

        return view('home', [
            'items' => $items,
        ]);
    }
}
