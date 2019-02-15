<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Review;
use App\Comment;
use Validator;
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
    public function index(int $id)
    {
        $review = new Review;
        $comment = new Comment;
        $review = $review->getReview($id);
        $comments = $comment->getComments(Review::find($id));
        return view('review',[
            'review' => $review,
            'comments' => $comments,
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
            'content' => 'required|max:2000',
        ];

        // エラーメッセージを設定
        $messages = [
            'content.required' => 'コメント入力は必須です',
            'content.max' => 'コメントは2000文字以内です',
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
            $title = Item::find($item_id)->title;
            $url = route('review', ['review_id' => $review_id]);
            \Log::info($title);
            \Log::info($score);
            \Log::info($content);
            \Log::info($url);
            $twitter_service = new TwitterService;
            $twitter_service->tweet($request,$title,$score,$content,$url);
        }
        
        return redirect()->back();

    }

    /**
     * Back to before page
     *
     * @return \Illuminate\Http\Response
     */
    public function back(Request $request)
    {
        $item_id = $request->session()->get('item_id');
        $request->session()->forget('item_id');
        return redirect()->route('item', ['item_id' => $item_id]);
    }
}
