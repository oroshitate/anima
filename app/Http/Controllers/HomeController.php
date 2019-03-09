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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 認証済みユーザーのみ
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $user = User::find($user_id);
            $follows = $user->follows;
            $follow_ids = array();
            foreach ($follows as $follow) {
                $follow_id = $follow->follow_id;
                array_push($follow_ids, $follow_id);
            }
            array_push($follow_ids, $user_id);

            if(count($follow_ids) > 0){
                $review = new Review();
                $reviews = $review->getTimelines($user_id,$follow_ids);
            }else{
                $reviews = array();
            }

            $item = new Item();
            $items = $item->getPopularItems();

            return view('home', [
                'reviews' => $reviews,
                'items' => $items,
            ]);
        }

        $item = new Item();
        $items = $item->getPopularItems();
        return view('home', [
            'items' => $items,
        ]);
    }
}
