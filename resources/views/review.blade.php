@extends('layouts.app')

@section('title')
<title>Anima | {{ $review[0]->user_name }}さんのレビュー</title>
@endsection

@section('script')
<script src="{{ asset('js/like.js') }}" defer></script>
<script src="{{ asset('js/comment.js') }}" defer></script>
<script src="{{ asset('js/review.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_comments.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 my-md-4">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-md-2">
                    <p class="h4">{{ $item->title }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <img src="/storage/images/items/{{ $item->image }}.jpg">
                </div>
                <div class="col-md-4 mt-md-2">
                    <div class="row w-100 text-left">
                        <span class="w-100">シーズン : {{ $item->season }}</span>
                        <span class="w-100">製作会社 : {{ $item->company }}</span>
                        <span class="w-100">レビュー件数 : {{ $reviews_count }}件</span>
                    </div>
                </div>
            </div>
            <div class="my-md-4">
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">レビュー</span>
                </div>
                <ul id="reviews" class="list-unstyled mb-md-5">
                    <li class="py-md-4">
                        <div class="clearfix" href="{{ route('review', ['review_id' => $review[0]->review_id]) }}">
                            <a href="{{ route('user', ['nickname' => $review[0]->user_nickname]) }}">
                                <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $review[0]->user_image }}">
                            </a>
                            <div class="d-inline-block align-top col-md-8">
                                <p class="h4">{{ $review[0]->user_name }}</p>
                                <div class="star-rating d-inline-block">
                                    <div class="star-rating-front" style="width:{{ $review[0]->review_score*20 }}%">★★★★★</div>
                                    <div class="star-rating-back">★★★★★</div>
                                </div>
                                <pre class="py-md-3 h4 content-length">{{ $review[0]->review_content }}</pre>
                            </div>
                            @auth
                                @if($review[0]->user_id == Auth::user()->id)
                                    <div class="d-inline-block cursor-pointer">
                                        <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review[0]->review_id }}" data-score="{{ $review[0]->review_score }}" data-content="{{ $review[0]->review_content }}">
                                            <i class="fas fa-angle-down fa-2x"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="d-inline-block"></div>
                                @endif
                            @endauth
                            <div class="col-md-2 d-inline-block text-right">
                                <p class="h5 created-date" >{{ $review[0]->review_created }}</p>
                            </div>
                            <div class="text-center my-md-2">
                                @guest
                                    <div class="d-inline-block cursor-pointer">
                                        <a href="{{ url('/login') }}">
                                            <i class="far fa-heart fa-3x mx-md-2"></i>
                                            <span class="h4">
                                                @if($likes_review_count > 0)
                                                    {{ $likes_review_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>件</span>
                                        </a>
                                    </div>
                                @else
                                    @if($like_review_id)
                                        <div id="like-review-button-{{ $review[0]->review_id }}" class="{{ $like_review_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-like_id="{{ $like_review_id }}">
                                            <i class="far fa-heart fa-3x mx-md-2"></i>
                                            <span id="likes-review-count-{{ $review[0]->review_id }}" class="h4">
                                                @if($likes_review_count > 0)
                                                    {{ $likes_review_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>件</span>
                                        </div>
                                    @else
                                        <div id="like-review-button-{{ $review[0]->review_id }}" class="{{ $like_review_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-like_id="{{ $like_review_id }}">
                                            <i class="far fa-heart fa-3x mx-md-2"></i>
                                            <span id="likes-review-count-{{ $review[0]->review_id }}" class="h4">
                                                @if($likes_review_count > 0)
                                                    {{ $likes_review_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>件</span>
                                        </div>
                                    @endif
                                @endguest
                                <a href="{{ route('review', ['review_id' => $review[0]->review_id]) }}">
                                    <i class="far fa-comment fa-3x mx-md-2"></i>
                                    <span class="h4">
                                        @if($comments_count > 0)
                                            {{ $comments_count }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                    <span>件</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="my-md-4">
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">コメント</span>
                </div>
                <ul id="comments" class="list-unstyled mb-md-5">
                    @foreach($comments as $comment)
                        <li class="py-md-4 border-bottom" id="comment-li-{{ $comment->comment_id }}">
                            <div class="clearfix">
                                <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                                    <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $comment->user_image }}">
                                </a>
                                <div class="d-inline-block align-top col-md-8">
                                    <p class="h4">{{ $comment->user_name }}</p>
                                    <p class="h4 text-secondary">{{ "@".$comment->user_nickname }}</p>
                                    @if($comment->comment_reply_user_nickname)
                                        <div class="align-top reply-box d-inline-block bg-secondary text-white rounded cursor-pointer" data-reply_id="{{ $comment->comment_reply_id }}" >
                                            <span class="p-md-2">{{ "To @".$comment->comment_reply_user_nickname}}</span>
                                        </div>
                                        <pre id="comment-content-{{ $comment->comment_id }}" class="py-md-3 h4 content-length">{{ $comment->comment_content}}</pre>
                                    @else
                                        <pre id="comment-content-{{ $comment->comment_id }}" class="py-md-3 h4 content-length">{{ $comment->comment_content}}</pre>
                                    @endif
                                </div>
                                @auth
                                    @if(Auth::user()->id == $comment->user_id)
                                        <div class="d-inline-block cursor-pointer">
                                            <button type="button" class="bg-white border border-0 comment-modal-button" data-toggle="modal" data-target="#operate-comment-modal" data-comment_id="{{ $comment->comment_id }}" data-content="{{ $comment->comment_content }}">
                                                <i class="fas fa-angle-down fa-2x"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-inline-block"></div>
                                    @endif
                                @endauth
                                <div class="col-md-2 d-inline-block text-right">
                                    <p class="h5 created-date" >{{ $comment->comment_created }}</p>
                                </div>
                                <div class="text-center my-md-2">
                                    @guest
                                        <div class="d-inline-block cursor-pointer">
                                            <a href="{{ url('/login') }}">
                                                <i class="far fa-heart fa-3x mx-md-2"></i>
                                                <span class="h4">
                                                    @if($comment->comment_likes_count > 0)
                                                        {{ $comment->comment_likes_count }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                                <span>件</span>
                                            </a>
                                        </div>
                                        <div class="d-inline-block cursor-pointer">
                                            <a href="{{ url('/login') }}">
                                                <i class="fas fa-reply fa-3x mx-md-2"></i>
                                                <span class="h4">
                                                    {{ $comment->reply_count }}件
                                                </span>
                                            </a>
                                        </div>
                                    @else
                                        @if($comment->comment_like_id)

                                            <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                                                <i class="far fa-heart fa-3x mx-md-2"></i>
                                                <span id="likes-comment-count-{{ $comment->comment_id }}" class="h4">
                                                    @if($comment->comment_likes_count > 0)
                                                        {{ $comment->comment_likes_count }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                                <span>件</span>
                                            </div>
                                        @else
                                            <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                                                <i class="far fa-heart fa-3x mx-md-2"></i>
                                                <span id="likes-comment-count-{{ $comment->comment_id }}" class="h4">
                                                    @if($comment->comment_likes_count > 0)
                                                        {{ $comment->comment_likes_count }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                                <span>件</span>
                                            </div>
                                        @endif
                                        <div class="d-inline-block reply-button cursor-pointer" data-comment_id="{{ $comment->comment_id }}" data-user_nickname="{{ $comment->user_nickname }}">
                                            <i class="fas fa-reply fa-3x mx-md-2"></i>
                                            <span class="h4">
                                                {{ $comment->reply_count }}件
                                            </span>
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if(count($comments) == 20)
                    <div id="show-more-comments">
                        <div class="text-center mb-md-5">
                            <p class="h4 text-danger">Show 20 Comments</p>
                        </div>
                        <div class="text-center mb-md-5">
                            <button type="button" id="show-more-comments-button" class="btn btn-outline-secondary w-100" data-review_id="{{ $review[0]->review_id }}">さらに読み込む</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('partials.form.review.operate')
@include('partials.form.review.edit')
@include('partials.form.review.delete')
@include('partials.form.comment.operate')
@include('partials.form.comment.create')
@include('partials.form.comment.edit')
@include('partials.form.comment.delete')
@endsection
