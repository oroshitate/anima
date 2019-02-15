<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

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
        $item_detail = $item->getItem($id);
        return view('item', [
            'item' => $item_detail,
        ]);
    }
}
