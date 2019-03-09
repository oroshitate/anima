<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        \Log::info("CommentController : store() : Start");
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

        DB::beginTransaction();
        try {
            $comment = new Comment;
            $comment->user_id = Auth::id();
            $comment->review_id = $request->input('review_id');
            $comment->content = $request->input('content');
            $comment->reply_id = $request->input('reply_id');

            $comment->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("CommentController : store() : Failed Create Comment! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * Edit comment
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        \Log::info("CommentController : edit() : Start");
        // 入力情報の取得
        $inputs = $request->all();

        // ルールを設定
        $rules = [
            'content' => 'required|string|max:500',
        ];

        // エラーメッセージを設定
        $messages = [
            'content.required' => 'コメント入力は必須です',
            'content.string' => 'コメントは文字入力です',
            'content.max' => 'コメントは500文字以内です',
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $comment_id = $request->input('comment_id');
        $content = $request->input('content');

        DB::beginTransaction();
        try {
            $comment_detail = Comment::find($comment_id);
            $comment_detail->content = $content;

            $comment_detail->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency("CommentController : edit() : Failed Edit Comment! : user_id = ".Auth::id());
            \Log::emergency("Message : ".$e->getMessage());
            \Log::emergency("Code : ".$e->getCode());
            return redirect()->back();
        }

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

        $comment = Comment::find($comment_id);
        $likes = $comment->likes()->get();

        if(count($likes) > 0){
            foreach ($likes as $like) {
                $like->delete();
            }
        }

        $comment->delete();

        return redirect()->back();
    }
}
