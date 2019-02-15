<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Validator;

class CommentController extends Controller
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
     * Store comment
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'content' => 'required|max:500',
        ];

        // エラーメッセージを設定
        $messages = [
            'content.required' => 'コメント入力は必須です',
            'content.max' => 'コメントは500文字以内です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $comment = new Comment;
        $comment->user_id = Auth::id();
        $comment->review_id = $request->input('review_id');
        $comment->content = $request->input('content');

        $comment->save();

        return redirect()->back();
    }
}
