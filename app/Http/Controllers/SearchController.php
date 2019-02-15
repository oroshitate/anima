<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\User;

class SearchController extends Controller
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
     * Search by keywords
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $filter = $request->input('filter')[0];

        $item = new Item();
        $user = new User();
        $items = '';
        $users = '';

        if($filter == 'title'){
            $items = $item->getSearchByTitle($keyword);
        }else if($filter == 'cast'){
            $items = $item->getSearchByCast($keyword);
        }else{
            $users = $user->getSearchByUser($keyword);
        }

        return view('search', [
            'items' => $items,
            'users' => $users,
            'keyword' => $keyword,
            'filter' => $filter,
        ]);
    }
}
