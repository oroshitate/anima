<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Item;
use App\User;
use App\Review;
use App\Follow;
use App\Watchlist;

class UserController extends Controller
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
    public function index(string $nickname)
    {
        $user = new User();
        $user_detail = $user->getUser($nickname);
        $reviews = $user_detail->reviews;
        $reviews_count = count($reviews);
        $items = array();
        if($reviews_count > 0){
            $item = new Item();
            $items = $item->getReviewItems($reviews);
        }

        $follow = new Follow();
        $followings_count = $follow->getFollowingsCount($user_detail);
        $followers_count = $follow->getFollowersCount($user_detail);
        $my_follow = $follow->getMyFollow($user_detail->id);

        $follow_id = "";
        $follow_status = "";
        if(count($my_follow) > 0){
            $follow_status = "active";
            $follow_id = $my_follow[0]->id;
        }

        return view('user.index', [
            'user' => $user_detail,
            'items' => $items,
            'reviews_count' => $reviews_count,
            'followings_count' => $followings_count,
            'followers_count' => $followers_count,
            'follow_status' => $follow_status,
            'follow_id' => $follow_id,
        ]);
    }

    public function edit(){
        $user_id = Auth::id();
        $user = User::find($user_id);
        return view('user.edit',[
            'user' => $user,
        ]);
    }

    public function store(Request $request){
        \Log::info("UserController : store() : Start");
        $inputs = $request->all();
        $upload_file = $request->image;
        $name = $request->input('name');
        $nickname = $request->input('nickname');
        $content = $request->input('content');

        // ルールを設定
        $rules = [
            'name' => 'required|string|max:20',
            'image' => 'nullable|image',
            'content' => 'nullable|string|max:300',
        ];

        // エラーメッセージを設定
        $messages = [
            'name.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'name.string' => \Lang::get('validation.string', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'name.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.label.auth_user.user_name')]),
            'image.image' => \Lang::get('validation.image', ["attribute" => \Lang::get('app.label.auth_user.profile')]),
            'content.string' => \Lang::get('validation.content', ["attribute" => \Lang::get('app.label.auth_user.content')]),
            'content.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.label.auth_user.content')]),
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $user = new User();
        $user_detail = $user->getUser($nickname);

        DB::beginTransaction();
        try {
            $image = null;
            if($upload_file == null){
                $user_detail->name = $name;
                $user_detail->nickname = $nickname;
                $user_detail->content = $content;

                $user_detail->save();
            }else{
                $disk = \Storage::disk('s3');
                if($user_detail->image != null){
                    if(\App::environment('production')){
                        $exists = $disk->exists('images/users/'.$user_detail->image);
                        if($exists){
                            $disk->delete('images/users/'.$user_detail->image);
                        }
                    } else {
                        \Storage::delete('public/images/users/'.$user_detail->image);
                    }
                }

                $image_encode = base64_encode($user_detail->nickname);
                $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
                $image = $image_name.'.jpg';
                if(\App::environment('production')){
                    $image_contents = file_get_contents($upload_file->getRealPath());
                    $disk->put('images/users/'.$image, $image_contents, 'public');
                } else {
                    $upload_file->storeAs('/public/images/users', $image);
                }

                $user_detail->name = $name;
                $user_detail->nickname = $nickname;
                $user_detail->content = $content;
                $user_detail->image = $image;

                $user_detail->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("UserController : store() : Failed Edit User! : user_id = ".$user_detail->id);
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
        }

        return redirect()->route('user', ['nickname' => $nickname]);
    }
}
