<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Watchlist;

class WatchlistController extends Controller
{
    public function store(Request $request)
    {
        \Log::info("WatchlistController : store() : Start");
        $user_id = $request->input('user_id');
        $item_id = $request->input('item_id');

        DB::beginTransaction();
        try {
            $data = [
              'user_id' => $user_id,
              'item_id' => $item_id
            ];
            $watchlist = Watchlist::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("WatchlistController : store() : Failed Store Watchlist! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

        return $watchlist->id;
    }

    public function delete(Request $request)
    {
        $watchlist_id = $request->input('watchlist_id');

        Watchlist::find($watchlist_id)->delete();
    }
}
