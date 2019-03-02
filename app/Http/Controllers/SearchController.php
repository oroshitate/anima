<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\User;
use App\Follow;

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
        $request->flash();

        $item = new Item();
        $user = new User();
        $items = array();
        $users = array();

        $items = $item->getSearchByItem($keyword);
        $users = $user->getSearchByUser($keyword);

        if(count($users) > 0){
            foreach ($users as $user) {
                $follow = Follow::where([
                    ['follows.user_id' ,'=', Auth::id()],
                    ['follows.follow_id', '=', $user->id]
                ])->get();

                if(count($follow) > 0){
                    $user->follow_id = $follow[0]->id;
                    $user->follow_status = "active";
                }else{
                    $user->follow_id = "";
                    $user->follow_status = "";
                }
            }
        }

        return view('search', [
            'items' => $items,
            'users' => $users,
            'keyword' => $keyword,
        ]);
    }
}
