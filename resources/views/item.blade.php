@extends('layouts.app')

@section('title')
<title>Anima | {{ $item->title }}</title>
@endsection

@section('script')
<!-- Twitter share button -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8" defer></script>
<!-- Line share button -->
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer></script>

<script src="{{ asset('js/like.js') }}" defer></script>
<script src="{{ asset('js/review.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_reviews.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 my-md-5">
            <div class="row justify-content-center no-gutters">
                <div class="col-md-12 text-center mb-md-2">
                    <p class="h4">{{ $item->title }}</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="/storage/images/items/{{ $item->image }}.jpg">
                    <p class="mb-0">出展 : アニメハック</p>
                </div>
                <div class="col-md-4">
                    <div class="row text-left">
                        <span class="w-100">シーズン : {{ $item->season }}</span>
                        <span class="w-100">製作会社 : {{ $item->company }}</span>
                        <span class="w-100">レビュー件数 : {{ $item->reviews_count }}件</span>
                    </div>
                </div>
                <div class="col-md-8 text-right">
                    @guest
                        <a href="{{ url('/login') }}">
                            <button type="button" class="btn btn-success">レビューを投稿する</button>
                        </a>
                    @else
                        <button type="button" id="create-review-modal-button" class="btn btn-success" data-toggle="modal" data-target="#create-review-modal" data-item_id="{{ $item->id }}">レビューを投稿する</button>
                    @endguest
                </div>
                <div class="col-md-12 mt-md-4 row justify-content-center">
                    <div class="col-md-8 text-center">
                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-url="{{ url()->current() }}" data-text="" data-lang="ja"></a>
                        <div class="line-it-button" data-lang="ja" data-type="share-a" data-ver="2" data-url="{{ url()->current() }}" style="display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="my-md-4">
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">作品情報</span>
                </div>
                <p class="p-md-2">あらすじ、キャスト、音楽情報はコチラ</p>
            </div>
            <div class="my-md-4">
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">関連リンク</span>
                </div>
                <p class="p-md-2">公式サイト : {{ $item->link }}</p>
            </div>
            <div class="my-md-4">
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">レビュー</span>
                </div>
                <ul id="reviews" class="list-unstyled mb-md-5">
                @foreach($reviews as $review)
                    <li class="py-md-4 border-bottom">
                        <div class="clearfix" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                            <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                                <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $review->user_image }}">
                            </a>
                            <div class="d-inline-block align-top col-md-8">
                                <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                    <p class="h4">{{ $review->user_name }}</p>
                                    <div class="star-rating d-inline-block">
                                        <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                                        <div class="star-rating-back">★★★★★</div>
                                    </div>
                                    <pre class="py-md-3 h4 content-length">{{ $review->review_content }}</pre>
                                </a>
                            </div>
                            @auth
                                @if($review->user_id == Auth::user()->id)
                                    <div class="d-inline-block cursor-pointer">
                                        <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                            <i class="fas fa-angle-down fa-2x"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="d-inline-block"></div>
                                @endif
                            @endauth
                            <div class="col-md-2 d-inline-block text-right">
                                <p class="h5 created-date" >{{ $review->review_created }}</p>
                            </div>
                        </div>
                        <div class="text-center my-md-2">
                            @guest
                                <div class="d-inline-block cursor-pointer">
                                    <a href="{{ url('/login') }}">
                                        <i class="far fa-heart fa-3x mx-md-2"></i>
                                        <span class="h4">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>件</span>
                                    </a>
                                </div>
                            @else
                                @if($review->like_id)
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-3x mx-md-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h4">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>件</span>
                                    </div>
                                @else
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-3x mx-md-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h4">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>件</span>
                                    </div>
                                @endif
                            @endguest
                            <a class="cursor-pointer" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                <i class="far fa-comment fa-3x mx-md-2"></i>
                                <span class="h4">
                                    @if($review->comments_count > 0)
                                        {{ $review->comments_count }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span>件</span>
                            </a>
                        </div>
                    </li>
                @endforeach
                </ul>
                @if(count($reviews) == 20)
                    <div id="show-more-reviews">
                        <div class="text-center mb-md-5">
                            <p class="h4 text-danger">Show 20 Reviews</p>
                        </div>
                        <div class="mb-md-5 text-center">
                            <button type="button" id="show-more-reviews-button" class="btn btn-outline-secondary w-100" data-item_id="{{ $item->id }}">さらに読み込む</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('partials.form.review.operate')
@include('partials.form.review.create')
@include('partials.form.review.edit')
@include('partials.form.review.delete')
@endsection
