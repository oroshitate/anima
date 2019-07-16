<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Review;
use App\Comment;
use App\Like;
use App\Watchlist;
use App\Notification;

class ItemController extends Controller
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
    public function index(int $id, Request $request)
    {
        $item = new Item();
        $review = new Review();
        $watchlist = new Watchlist();
        $item_detail = $item->getItem($id);
        $item_avg = $review->getReviewsAvg($item_detail);
        $item_detail->item_avg = $item_avg->item_avg;
        $reviews = $review->getReviews($item_detail);

        $user_id = Auth::id();
        foreach ($reviews as $review) {
            $comment = new Comment();
            $like = new Like();
            $review->comments_count = $comment->getCommentsCount($review->review_id);
            $review->likes_count = $like->getLikesCount($review->review_id);
            if (Auth::check()) {
                $my_like = $like->getMyLike($user_id, $review->review_id);
                $like_id = "";
                if(count($my_like) == 1){
                    $review->like_status = "active";
                    $review->like_id = $my_like[0]->id;
                }else{
                    $review->like_status = "";
                    $review->like_id = "";
                }
            }
        }

        $review_status = "";
        foreach ($reviews as $review) {
            if($review->user_id == $user_id){
                $review_status = "active";
                break;
            }
        }


        $watchlist->status = "";
        $watchlist->id = "";
        if (Auth::check()) {
            $my_watchlist = $watchlist->getMyWatchlist($id, Auth::id());
            if(count($my_watchlist) == 1){
                $watchlist->status = "active";
                $watchlist->id = $my_watchlist[0]->id;
            }
        }

        return view('item', [
            'item' => $item_detail,
            'reviews' => $reviews,
            'review_status' => $review_status,
            'watchlist' => $watchlist,
        ]);
    }
}
