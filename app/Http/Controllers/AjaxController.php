<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Item;

class AjaxController extends Controller
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
    public function showMoreItems(Request $request)
    {
      $count = $request->input('count');
      $item = new Item();
      $items = $item->getMoreItems($count);
      return response()->json($items);
    }
}
