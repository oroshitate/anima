<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\User;
use App\Review;
use App\Comment;
use App\Like;
use Carbon\Carbon;

class AjaxController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoreTimelines(Request $request)
    {
        $count = $request->input('count');

        $user_id = Auth::id();
        $follows = User::find($user_id)->follows;
        $follow_ids = array();
        foreach ($follows as $follow) {
            $follow_id = $follow->follow_id;
            array_push($follow_ids, $follow_id);
        }
        array_push($follow_ids, $user_id);

        if(count($follow_ids) > 0){
            $reviews = Review::where(function ($query) use ($user_id, $follow_ids) {
                foreach ($follow_ids as $follow_id) {
                    $query->orwhere('reviews.user_id', $follow_id);
                }
            })
            ->join('users','users.id','=','reviews.user_id')
            ->join('items','items.id','=','reviews.item_id')
            ->orderBy('reviews.created_at', 'desc')
            ->skip($count)
            ->take(20)
            ->get([
                "reviews.id as review_id",
                "reviews.score as review_score",
                "reviews.content as review_content",
                "reviews.created_at as review_created",
                "users.id as user_id",
                "users.name as user_name",
                "users.nickname as user_nickname",
                "users.image as user_image",
                "items.id as item_id",
                "items.title as item_title",
                "items.image as item_image"
             ]);
            foreach ($reviews as $review) {
                $review->review_created = Carbon::createFromFormat('Y-m-d H:i:s', $review->review_created)->format('Y/m/d H:i:s');
                $review->comments_count = Comment::where('review_id',$review->review_id)->count();
                $review->likes_count = Like::where('review_id',$review->review_id)->count();
                $like = Like::where([
                            ['review_id', '=', $review->review_id],
                            ['user_id', '=', $user_id],
                ])->get();
                $like_id = "";
                if(count($like) == 1){
                    $review->like_status = "active";
                    $review->like_id = $like[0]->id;
                }else{
                    $review->like_status = "";
                    $review->like_id = "";
                }
            }
        }else{
            $reviews = array();
        }

        $html = response()->json((view('partials.ajax.timeline', [
            'reviews' => $reviews,
        ])->render()));

        return $html;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoreKeywordItems(Request $request)
    {
        $keyword = $request->input('keyword');
        $count = $request->input('count');

        $items = '';
        $item = new Item;
        $items = $item->getMoreItemsSearchByItem($keyword, $count);

        $html = response()->json((view('partials.ajax.keyword_item', [
            'items' => $items,
        ])->render()));

        return $html;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoreKeywordUsers(Request $request)
    {
        $keyword = $request->input('keyword');
        $count = $request->input('count');

        $user = new User;
        $users = $user->getMoreUsersSearchByUser($keyword, $count);

        $html = response()->json((view('partials.ajax.keyword_user', [
            'users' => $users,
        ])->render()));

        return $html;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoreReviews(Request $request)
    {
        $item_id = $request->input('item_id');
        $count = $request->input('count');

        $item = new Item;
        $review = new Review;
        $item_detail = $item->getItem($item_id);
        $reviews = $review->getMoreReviews($item_detail, $count);

        $user_id = Auth::id();
        foreach ($reviews as $review) {
            $review->comments_count = Comment::where('review_id',$review->review_id)->count();
            $review->likes_count = Like::where('review_id',$review->review_id)->count();
            $like = Like::where([
                        ['review_id', '=', $review->review_id],
                        ['user_id', '=', $user_id],
            ])->get();
            $like_id = "";
            if(count($like) == 1){
                $review->like_status = "active";
                $review->like_id = $like[0]->id;
            }else{
                $review->like_status = "";
                $review->like_id = "";
            }
        }

        $html = response()->json((view('partials.ajax.review', [
            'reviews' => $reviews,
        ])->render()));

        return $html;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoreComments(Request $request)
    {
        $review_id = $request->input('review_id');
        $count = $request->input('count');

        $review = new Review;
        $review = $review->getReview($review_id);
        $comment = new Comment;
        $comments = $comment->getMoreComments(Review::find($review_id), $count);

        $html = response()->json((view('partials.ajax.comment', [
            'review' => $review,
            'comments' => $comments,
        ])->render()));

        return $html;
    }

    public function showMoreReviewItems(Request $request)
    {
        $user_id = $request->input('user_id');
        $count = $request->input('count');

        $user = User::find($user_id);
        $reviews = $user->reviews;
        $item = new Item();
        $items = $item->getMoreReviewItems($reviews, $count);

        $html = response()->json((view('partials.ajax.review_item', [
            'items' => $items,
        ])->render()));

        return $html;
    }
}
