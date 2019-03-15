@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.review', ['name' => $review[0]->user_name]) }}</title>
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
        <div class="col-12 col-md-10 my-4">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-2">
                    <p class="h5">{{ $item->title }}</p>
                </div>
                <div class="col-6 mx-auto text-center">
                    @if($item->image == null)
                        <img src="{{ asset('anima-img.png') }}" class="w-75">
                    @else
                        <img src="{{ config('app.image_path') }}/items/{{ $item->image }}" class="w-75">
                    @endif
                </div>
            </div>
            <div class="my-4">
                <div class="bg-grey text-dark p-2">
                    <span class="h5 text-black">{{ __('app.word.review') }}</span>
                </div>
                <ul id="reviews" class="list-unstyled mb-5">
                    <li class="py-4">
                        <div class="row">
                            <div class="align-top col-8">
                                <div class="row align-items-center mb-2">
                                    <div class="col-4 col-md-2">
                                        <a href="{{ route('user', ['nickname' => $review[0]->user_nickname]) }}">
                                            @if($review[0]->user_image == null)
                                                <img class="rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                            @else
                                                <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $review[0]->user_image }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-8 pr-0">
                                        <p class="h5-5">{{ $review[0]->user_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-4 justify-content-end">
                                @auth
                                    @if($review[0]->user_id == Auth::user()->id)
                                        <div class="d-inline-block mt-3 mx-md-3 cursor-pointer text-right">
                                            <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review[0]->review_id }}" data-score="{{ $review[0]->review_score }}" data-content="{{ $review[0]->review_content }}">
                                                <i class="fas fa-angle-down fa-2x"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-inline-block"></div>
                                    @endif
                                @endauth
                                <div class="d-inline-block text-right align-top mt-3">
                                    <p class="created-date" >{{ $review[0]->review_created }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="star-rating d-inline-block">
                            <div class="star-rating-front" style="width:{{ $review[0]->review_score*20 }}%">★★★★★</div>
                            <div class="star-rating-back">★★★★★</div>
                        </div>
                        <pre class="py-3 h5-5 content-length">{{ $review[0]->review_content }}</pre>
                        <div class="text-center">
                            @guest
                                <div class="d-inline-block cursor-pointer">
                                    <a href="{{ url('/login') }}">
                                        <i class="far fa-heart fa-2x mx-2"></i>
                                        <span class="h5-5">
                                            @if($likes_review_count > 0)
                                                {{ $likes_review_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </a>
                                </div>
                            @else
                                @if($like_review_id)
                                    <div id="like-review-button-{{ $review[0]->review_id }}" class="{{ $like_review_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-like_id="{{ $like_review_id }}">
                                        <i class="far fa-heart fa-2x mx-2"></i>
                                        <span id="likes-review-count-{{ $review[0]->review_id }}" class="h5-5">
                                            @if($likes_review_count > 0)
                                                {{ $likes_review_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </div>
                                @else
                                    <div id="like-review-button-{{ $review[0]->review_id }}" class="{{ $like_review_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-like_id="{{ $like_review_id }}">
                                        <i class="far fa-heart fa-2x mx-2"></i>
                                        <span id="likes-review-count-{{ $review[0]->review_id }}" class="h5-5">
                                            @if($likes_review_count > 0)
                                                {{ $likes_review_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </div>
                                @endif
                            @endguest
                            <a href="{{ route('review', ['review_id' => $review[0]->review_id]) }}">
                                <i class="far fa-comment fa-2x mx-2"></i>
                                <span class="h5-5">
                                    @if($comments_count > 0)
                                        {{ $comments_count }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span>{{ __('app.word.count') }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <div class="bg-grey text-dark p-2">
                    <span class="h5 text-black">{{ __('app.word.comment') }}</span>
                </div>
                <ul id="comments" class="list-unstyled mb-5">
                    @foreach($comments as $comment)
                        <li class="py-4 border-bottom" id="comment-li-{{ $comment->comment_id }}">
                            <div class="row">
                                <div class="align-top col-8">
                                  <div class="row align-items-center mb-2">
                                      <div class="col-4 col-md-2">
                                          <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                                              <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $comment->user_image }}">
                                          </a>
                                      </div>
                                      <div class="col-8 pr-0">
                                          <p class="h5-5">{{ $comment->user_name }}</p>
                                      </div>
                                  </div>
                                </div>
                                <div class="row col-4 justify-content-end">
                                    @auth
                                        @if(Auth::user()->id == $comment->user_id)
                                            <div class="d-inline-block mt-3 mx-md-3 cursor-pointer text-right">
                                                <button type="button" class="bg-white border border-0 comment-modal-button" data-toggle="modal" data-target="#operate-comment-modal" data-comment_id="{{ $comment->comment_id }}" data-content="{{ $comment->comment_content }}">
                                                    <i class="fas fa-angle-down fa-2x"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="d-inline-block"></div>
                                        @endif
                                    @endauth
                                    <div class="d-inline-block text-right align-top mt-3">
                                        <p class="created-date" >{{ $comment->comment_created }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($comment->comment_reply_user_nickname)
                                <div class="align-top reply-box d-inline-block bg-secondary text-white rounded cursor-pointer" data-reply_id="{{ $comment->comment_reply_id }}" >
                                    <span class="p-2">{{ "To @".$comment->comment_reply_user_nickname}}</span>
                                </div>
                                <pre id="comment-content-{{ $comment->comment_id }}" class="py-3 h5-5 content-length">{{ $comment->comment_content}}</pre>
                            @else
                                <pre id="comment-content-{{ $comment->comment_id }}" class="py-3 h5-5 content-length">{{ $comment->comment_content}}</pre>
                            @endif
                            <div class="text-center">
                                @guest
                                    <div class="d-inline-block cursor-pointer">
                                        <a href="{{ url('/login') }}">
                                            <i class="far fa-heart fa-2x mx-2"></i>
                                            <span class="h5-5">
                                                @if($comment->comment_likes_count > 0)
                                                    {{ $comment->comment_likes_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>{{ __('app.word.count') }}</span>
                                        </a>
                                    </div>
                                    <div class="d-inline-block cursor-pointer">
                                        <a href="{{ url('/login') }}">
                                            <i class="fas fa-reply fa-2x mx-2"></i>
                                            <span class="h5-5">
                                                {{ $comment->reply_count }}{{ __('app.word.count') }}
                                            </span>
                                        </a>
                                    </div>
                                @else
                                    @if($comment->comment_like_id)
                                        <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                                            <i class="far fa-heart fa-2x mx-2"></i>
                                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h5-5">
                                                @if($comment->comment_likes_count > 0)
                                                    {{ $comment->comment_likes_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>{{ __('app.word.count') }}</span>
                                        </div>
                                    @else
                                        <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                                            <i class="far fa-heart fa-2x mx-2"></i>
                                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h5-5">
                                                @if($comment->comment_likes_count > 0)
                                                    {{ $comment->comment_likes_count }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>{{ __('app.word.count') }}</span>
                                        </div>
                                    @endif
                                    <div class="d-inline-block reply-button cursor-pointer" data-comment_id="{{ $comment->comment_id }}" data-user_nickname="{{ $comment->user_nickname }}">
                                        <i class="fas fa-reply fa-2x mx-2"></i>
                                        <span class="h5-5">
                                            {{ $comment->reply_count }}{{ __('app.word.count') }}
                                        </span>
                                    </div>
                                @endguest
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if(count($comments) == 20)
                    <div id="show-more-comments">
                        <div class="text-center mb-5">
                            <button type="button" id="show-more-comments-button" class="btn btn-outline-secondary w-100" data-review_id="{{ $review[0]->review_id }}">{{ __('app.button.show_more') }}</button>
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
