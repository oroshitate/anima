<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Follow;
use App\User;

class FollowController extends Controller
{
    public function showFollowings(string $nickname){
        $user = new User;
        $show_user = $user->getUser($nickname);
        $show_user_id = $show_user->id;
        $followings = $show_user->follows;

        $users = array();
        if(count($followings) > 0){
            $users = $user->getFollowings($followings);
            foreach ($users as $user) {
                if (Auth::check()) {
                    $follow = new Follow();
                    $my_follow = $follow->getMyFollow($user->id);

                    if(count($my_follow) > 0){
                        $user->follow_id = $my_follow[0]->id;
                        $user->follow_status = "active";
                    }else{
                        $user->follow_id = "";
                        $user->follow_status = "";
                    }
                } else {
                    $user->follow_id = "";
                    $user->follow_status = "";
                }
            }
        }

        return view('user.followings', [
            'show_user' => $show_user,
            'users' => $users
        ]);
    }

    public function showFollowers(string $nickname){
        $user = new User;
        $show_user = $user->getUser($nickname);
        $user_id = $show_user->id;
        $followers = Follow::where('follow_id', $user_id)->get();

        $users = array();
        if(count($followers) > 0){
            $users = $user->getFollowers($followers);
            foreach ($users as $user) {
                if (Auth::check()) {
                    $follow = new Follow();
                    $my_follow = $follow->getMyFollow($user->id);

                    if(count($my_follow) > 0){
                        $user->follow_id = $my_follow[0]->id;
                        $user->follow_status = "active";
                    }else{
                        $user->follow_id = "";
                        $user->follow_status = "";
                    }
                } else {
                    $user->follow_id = "";
                    $user->follow_status = "";
                }
            }
        }

        return view('user.followers', [
            'show_user' => $show_user,
            'users' => $users,
        ]);
    }

    public function store(Request $request){
        \Log::info("FollowController : store() : Start");
        $user_id = $request->input('user_id');

        DB::beginTransaction();
        try {
            $data = [
              'user_id' => Auth::id(),
              'follow_id' => $user_id
            ];
            $follow = Follow::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("FollowController : store() : Failed Follow User! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

        return $follow->id;
    }

    public function delete(Request $request){
        $follow_id = $request->input('follow_id');

        Follow::find($follow_id)->delete();
    }
}
