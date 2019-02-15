<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use Validator;

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
     * Show review form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'content' => 'required|max:255',
        ];

        // エラーメッセージを設定
        $messages = [
            'content.required' => 'コメント入力は必須です',
            'content.max' => 'コメントは255文字以内です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $review = new Review;
        $review->user_id = Auth::id();
        $review->item_id = $request->input('item_id');
        $review->content = $request->input('content');
        $review->score = $request->input('score');

        $review->save();

        $share = $request->input('share');

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
