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
            'content.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.word.comment')]),
            'content.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.word.comment')]),
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $data = [
              'user_id' => Auth::id(),
              'review_id' => $request->input('review_id'),
              'content' => $request->input('content'),
              'reply_id' => $request->input('reply_id')
            ];
            $comment = Comment::create($data);
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
            'content' => 'required|max:500',
        ];

        // エラーメッセージを設定
        $messages = [
            'content.required' => \Lang::get('validation.required', ["attribute" => \Lang::get('app.word.comment')]),
            'content.max' => \Lang::get('validation.max.string', ["attribute" => \Lang::get('app.word.comment')]),
        ];

        $validation = Validator::make($inputs, $rules, $messages);

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $comment_id = $request->input('comment_id');
        $content = $request->input('content');

        DB::beginTransaction();
        try {
            Comment::find($comment_id)->fill(['content' => $content])->save();

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
