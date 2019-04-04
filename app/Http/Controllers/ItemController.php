<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Review;
use App\Comment;
use App\Like;
use App\Watchlist;

class ItemController extends Controller
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
    public function index(int $id, Request $request)
    {
        $item = new Item();
        $review = new Review();
        $watchlist = new Watchlist();
        $item_detail = $item->getItem($id);
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
            'watchlist' => $watchlist,
        ]);
    }
}
