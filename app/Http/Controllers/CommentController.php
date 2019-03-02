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
        $comment->reply_id = $request->input('reply_id');

        $comment->save();

        return redirect()->back();
    }

    /**
     * Edit comment
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
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

        $comment_id = $request->input('comment_id');
        $content = $request->input('content');

        $comment_detail = Comment::find($comment_id);
        $comment_detail->content = $content;

        $comment_detail->save();

        return redirect()->back();
    }

    /**
     * Delete comment
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $comment_id = $request->input('comment_id');

        Comment::find($comment_id)->delete();

        return redirect()->back();
    }
}
