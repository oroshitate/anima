<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Review;
use App\Comment;
use App\Like;

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
        $item = new Item;
        $review = new Review;
        $item_detail = $item->getItem($id);
        $reviews = $review->getReviews($item_detail);

        $user_id = Auth::id();
        foreach ($reviews as $review) {
            $review->comments_count = Comment::where('review_id',$review->review_id)->count();
            $review->likes_count = Like::where('review_id',$review->review_id)->count();
            $like = Like::where([
                        ['review_id', '=', $review->review_id],
                        ['user_id', '=', $user_id],
            ])->get();
            $like_id = "";
            if(count($like) == 1){
                $review->like_status = "active";
                $review->like_id = $like[0]->id;
            }else{
                $review->like_status = "";
                $review->like_id = "";
            }
        }

        $login_provider = $request->session()->get('provider');

        return view('item', [
            'item' => $item_detail,
            'reviews' => $reviews,
            'provider' => $login_provider,
        ]);
    }
}
