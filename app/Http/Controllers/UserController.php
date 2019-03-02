<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Item;
use App\User;
use App\Review;
use App\Follow;

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
            $items = Item::where(function ($query) use ($reviews) {
                foreach ($reviews as $review) {
                    $query->orWhere('items.id', $review->item_id);
                }
            })->take(20)->get();
        }
        $followings_count = $user_detail->follows()->count();
        $followers_count = Follow::where('follow_id', $user_detail->id)->count();
        $follow = Follow::where([
                                    ['user_id', '=', Auth::id()],
                                    ['follow_id', '=', $user_detail->id]
                                ])
                              ->get();

        $follow_id = "";
        $follow_status = "";
        if(count($follow) > 0){
            $follow_status = "active";
            $follow_id = $follow[0]->id;
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

    public function edit(Request $request){
        $user = new User();
        $nickname = $request->input('nickname');
        $user_detail = $user->getUser($nickname);
        return view('user.edit',[
            'user' => $user_detail,
        ]);
    }

    public function store(Request $request){
        $inputs = $request->all();
        $upload_file = $request->image;
        $name = $request->input('name');
        $nickname = $request->input('nickname');
        $content = $request->input('content');

        // ルールを設定
        $rules = [
            'image' => 'image',
            'name' => 'required|max:255',
            'content' => 'max:300',
        ];

        // エラーメッセージを設定
        $messages = [
            'image.image' => '画像(jpg、png、bmp、gif、svg)であることを確認してください',
            'name.required' => 'ユーザー名は必須です',
            'name.max' => 'ユーザー名は255文字以内です',
            'content.max' => 'コメントは300文字以内です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $user = new User();
        $user_detail = $user->getUser($nickname);

        $image = "";
        if($upload_file == null){
            $user_detail->name = $name;
            $user_detail->nickname = $nickname;
            $user_detail->content = $content;

            $user_detail->save();
        }else{
            // 以前アバター画像を削除
            \Storage::delete('public/images/users/'.$user_detail->image);
            // アバター画像を保存
            $image_encode = base64_encode($user_detail->nickname);
            $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
            $image = $image_name.'.jpg';
            $upload_file->storeAs('/public/images/users', $image);

            $user_detail->name = $name;
            $user_detail->nickname = $nickname;
            $user_detail->content = $content;
            $user_detail->image = $image;

            $user_detail->save();
        }

        return redirect()->route('user', ['nickname' => $nickname]);
    }
}
