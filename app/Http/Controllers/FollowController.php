<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\User;

class FollowController extends Controller
{
    public function showFollowings(string $nickname){
        $user = new User;
        $user = $user->getUser($nickname);
        $user_id = $user->id;
        $followings = User::find($user_id)->follows()->get();

        $users = array();
        if(count($followings) > 0){
            $users = User::where(function ($query) use ($followings) {
                foreach ($followings as $following) {
                    $query->orWhere('users.id', $following->follow_id);
                }
            })->take(20)->get();

            foreach ($users as $user) {
                $follow = Follow::where([
                    ['follows.user_id' ,'=', Auth::id()],
                    ['follows.follow_id', '=', $user->id]
                ])->get();
                $user->follow_id = $follow[0]->id;
                $user->follow_status = "active";
            }
        }

        return view('user.followings', [
            'users' => $users
        ]);
    }

    public function showFollowers(string $nickname){
        $user = new User;
        $user = $user->getUser($nickname);
        $user_id = $user->id;
        $followers = Follow::where('follow_id', $user_id)->get();

        $users = array();
        if(count($followers) > 0){
            $users = User::where(function ($query) use ($followers) {
                foreach ($followers as $follower) {
                    $query->orWhere('users.id', $follower->user_id);
                }
            })->take(20)->get();

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

        return view('user.followers', [
            'users' => $users,
        ]);
    }

    public function store(Request $request){
        $user_id = $request->input('user_id');
        $follow = new Follow;

        $follow->user_id = Auth::id();
        $follow->follow_id = $user_id;

        $follow->save();

        return $follow->id;
    }

    public function delete(Request $request){
        $follow_id = $request->input('follow_id');

        Follow::find($follow_id)->delete();
    }
}
