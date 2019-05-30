<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Item;
use App\User;
use App\LinkedSocialAccount;
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
    public function index(int $review_id, Request $request)
    {
        $review = new Review;
        $comment = new Comment;
        $user_id = Auth::id();

        $raw_review = Review::find($review_id);
        $review_item = $raw_review->item;

        $item = Item::find($review_item->id);

        $reviews_count = $review->getReviewsCount($item);
        $review = $review->getReview($review_id);

        $comments = $comment->getComments($raw_review);
        $comments_count = $comment->getCommentsCount($review_id);

        $like = new Like();
        $likes_review_count = $like->getLikesCount($review_id);

        if (Auth::check()) {
            $my_like_review = $like->getMyLike($user_id, $review_id);

            if(count($my_like_review) > 0){
                $like_review_status = "active";
                $like_review_id = $my_like_review[0]->id;
            }else{
                $like_review_status = "";
                $like_review_id = "";
            }
        } else {
            $like_review_status = "";
            $like_review_id = "";
        }

        return view('review',[
            'item' => $item,
            'reviews_count' => $reviews_count,
            'review' => $review,
            'comments' => $comments,
            'comments_count' => $comments_count,
            'likes_review_count' => $likes_review_count,
            'like_review_id' => $like_review_id,
            'like_review_status' => $like_review_status,
        ]);
    }

    /**
     * Store review
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info("ReviewController : store() : Start");
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'score' => 'required',
        ];

        // エラーメッセージを設定
        $messages = [
            'score.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.word.score')]),
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $item_id = $request->input('item_id');
        $content = $request->input('content');
        $score = $request->input('score');

        DB::beginTransaction();
        try {
            $data = [
              'user_id' => Auth::id(),
              'item_id' => $item_id,
              'content' => $content,
              'score' => $score
            ];
            $review = Review::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("ReviewController : store() : Failed Create Review! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

        $review_id = $review->id;

        $share = $request->input('share');
        if($share == "on"){
            $user = User::find(Auth::id());
            $account = new LinkedSocialAccount();
            $twitter_account = $account->getUserLinkedProviderExists($user, "twitter");
            if($twitter_account == null){
                $request->session()->put('review_id', $review_id);
                return redirect('/login/twitter');
            }

            $twitter_service = new TwitterService;
            $title = Item::find($item_id)->title;
            if(mb_strlen($content) >= 80){
                $shorten_content = mb_substr($content, 0, 80);
                $content = $shorten_content." …";
            }

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
        \Log::info("ReviewController : edit() : Start");
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'score' => 'required',
        ];

        // エラーメッセージを設定
        $messages = [
            'score.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.word.score')]),
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

        DB::beginTransaction();
        try {
            $data = [
              'content' => $content,
              'score' => $score
            ];
            $review_detail->fill($data)->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("ReviewController : edit() : Failed Edit Review! : user_id = ".Auth::id()." review_id = ".$review_id);
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
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
        $item_id = $review->item_id;

        $comments = $review->comments()->get();
        $likes = $review->likes()->get();

        if(count($comments) > 0){
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        if(count($likes) > 0){
            foreach ($likes as $like) {
                $like->delete();
            }
        }

        $review->delete();

        return redirect()->route('item', ['item_id' => $item_id]);
    }
}
