<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Item;
use App\User;
use App\Review;
use App\Comment;
use App\Like;
use App\TwitterService;

class ReviewController extends Controller
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
     * Show review
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id, Request $request)
    {
        $review = new Review;
        $comment = new Comment;
        $user_id = Auth::id();

        $item = Review::find($id)->item;
        $reviews_count = Item::find($item->id)->reviews()->count();
        $review = $review->getReview($id);
        $comments = $comment->getComments(Review::find($id));
        $comments_count = Comment::where('review_id',$id)->count();

        $likes_review = Like::where('review_id',$id)->get();
        $likes_review_count = count($likes_review);
        $like_review = $like = Like::where([
                            ['review_id', '=', $id],
                            ['user_id', '=', $user_id],
                        ])->get();

        if(count($like_review) == 1){
            $like_review_status = "active";
            $like_review_id = $like_review[0]->id;
        }else{
            $like_review_status = "";
            $like_review_id = "";
        }

        $login_provider = $request->session()->get('provider');

        return view('review',[
            'item' => $item,
            'reviews_count' => $reviews_count,
            'review' => $review,
            'comments' => $comments,
            'comments_count' => $comments_count,
            'likes_review_count' => $likes_review_count,
            'like_review_id' => $like_review_id,
            'like_review_status' => $like_review_status,
            'provider' => $login_provider,
        ]);
    }

    /**
     * Store review
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'score' => 'required',
        ];

        // エラーメッセージを設定
        $messages = [
            'score.required' => '評価は必須です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $review = new Review;
        $item_id = $request->input('item_id');
        $content = $request->input('content');
        $score = $request->input('score');

        $review->user_id = Auth::id();
        $review->item_id = $item_id;
        $review->content = $content;
        $review->score = $score;

        $review->save();

        $review_id = $review->id;

        $share = $request->input('share');
        if($share == "on"){
            $twitter_account = User::find(Auth::id())->accounts()->where("provider_name", "twitter")->first();
            if($twitter_account == null){
                $request->session()->put('review_id', $review_id);
                return redirect('/login/twitter');
            }
            $twitter_service = new TwitterService;
            $title = Item::find($item_id)->title;
            $url = route('review', ['review_id' => $review_id]);
            $twitter_service->tweet($twitter_account,$title,$score,$content,$url);
        }

        return redirect()->back();
    }

    /**
     * Delete review
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'score' => 'required',
        ];

        // エラーメッセージを設定
        $messages = [
            'score.required' => '評価は必須です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $review_id = $request->input('review_id');
        $content = $request->input('content');
        $score = $request->input('score');

        $review_detail = Review::find($review_id);
        $item_id = $review_detail->item_id;

        $review_detail->user_id = Auth::id();
        $review_detail->item_id = $item_id;
        $review_detail->content = $content;
        $review_detail->score = $score;

        $review_detail->save();

        $review_id = $review_detail->id;

        $share = $request->input('share');
        if($share == "on"){
            $twitter_account = User::find(Auth::id())->accounts()->where("provider_name", "twitter")->first();
            if($twitter_account == null){
                $request->session()->put('review_id', $review_id);
                return redirect('/login/twitter');
            }
            $twitter_service = new TwitterService;
            $title = Item::find($item_id)->title;
            $url = route('review', ['review_id' => $review_id]);
            $twitter_service->tweet($twitter_account,$title,$score,$content,$url);
        }

        return redirect()->back();
    }

    /**
     * Delete review
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $review_id = $request->input('review_id');

        $review = Review::find($review_id);
        $comments = Review::find($review_id)->comments()->get();
        $item_id = $review->item_id;

        if(count($comments) > 0){
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        $review->delete();

        return redirect()->route('item', ['item_id' => $item_id]);
    }
}
