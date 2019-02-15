<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Review;

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
    public function index(int $id)
    {
        $item = new Item;
        $review = new Review;
        $item_detail = $item->getItem($id);
        $reviews = $review->getReviews($item_detail);

        return view('item', [
            'item' => $item_detail,
            'reviews' => $reviews,
        ]);
    }
}
