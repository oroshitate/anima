@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.item', ['title' => $item->title]) }}</title>
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
        <div class="col-12 col-md-10 my-5">
            <div class="row justify-content-center no-gutters">
                <div class="col-12 text-center mb-2">
                    <p class="h5">{{ $item->title }}</p>
                </div>
                <div class="col-6 text-center">
                    @if($item->image == null)
                        <img src="{{ asset('anima-img.png') }}" class="w-75">
                    @else
                        <img src="/storage/images/items/{{ $item->image }}" class="w-75">
                    @endif
                    <p class="mb-0">{{ __('app.word.item.source') }}</p>
                </div>
                <div class="col-4">
                    <div class="row text-left">
                        <span class="w-100">{{ __('app.word.item.season', ['season' => $item->season]) }}</span>
                        <span class="w-100">{{ __('app.word.item.company', ['company' => $item->company]) }}</span>
                        <span class="w-100">{{ __('app.word.item.reviews_count', ['count' => $item->reviews_count]) }}</span>
                    </div>
                </div>
                <div class="col-10 my-2 text-right">
                    @guest
                        <a href="{{ url('/login') }}">
                            <button type="button" class="btn btn-success">{{ __('app.button.review.create') }}</button>
                        </a>
                    @else
                        <button type="button" id="create-review-modal-button" class="btn btn-success" data-toggle="modal" data-target="#create-review-modal" data-item_id="{{ $item->id }}">{{ __('app.button.review.create') }}</button>
                    @endguest
                </div>
                <div class="col-12 mt-4 row justify-content-center">
                    <div class="col-8 text-center">
                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-url="{{ url()->current() }}" data-text="" data-lang="ja"></a>
                        <div class="line-it-button" data-lang="ja" data-type="share-a" data-ver="2" data-url="{{ url()->current() }}" style="display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="bg-grey text-dark p-2">
                    <span class="h5 text-black">{{ __('app.word.title.item.link') }}</span>
                </div>
                <p class="p-2">{{ __('app.word.item.link') }}<a class="border-bottom border-dark"href="{{ $item->link }}">{{ __('app.word.item.here') }}</a></p>
            </div>
            <div class="my-4">
                <div class="bg-grey text-dark p-2">
                    <span class="h5 text-black">{{ __('app.word.title.item.official_link') }}</span>
                </div>
                <p class="p-2">{{ __('app.word.item.official_link') }}<a class="border-bottom border-dark"href="{{ $item->official_link }}">{{ $item->official_link }}</a></p>
            </div>
            <div class="my-4">
                <div class="bg-grey text-dark p-2">
                    <span class="h5 text-black">{{ __('app.word.review') }}</span>
                </div>
                <ul id="reviews" class="list-unstyled mb-5">
                @foreach($reviews as $review)
                    <li class="py-4 border-bottom">
                        <div class="row">
                            <div class="align-top col-8">
                                <div class="row align-items-center mb-2">
                                    <div class="col-4 col-md-2">
                                        <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                                            @if($review->user_image == null)
                                                <img class="rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                            @else
                                                <img class="rounded-circle align-top profile" src="/storage/images/users/{{ $review->user_image }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-8 pr-0">
                                        <p class="h6">{{ $review->user_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-4 justify-content-end">
                                @auth
                                    @if($review->user_id == Auth::user()->id)
                                        <div class="d-inline-block mt-3 mx-md-3 cursor-pointer text-right">
                                            <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                                <i class="fas fa-angle-down fa-2x"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-inline-block"></div>
                                    @endif
                                @endauth
                                <div class="d-inline-block text-right align-top mt-3">
                                    <p class="created-date" >{{ $review->review_created }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                            <div class="star-rating d-inline-block">
                                <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                                <div class="star-rating-back">★★★★★</div>
                            </div>
                            <pre class="py-3 h5 content-length">{{ $review->review_content }}</pre>
                        </a>
                        <div class="text-center">
                            @guest
                                <div class="d-inline-block cursor-pointer">
                                    <a href="{{ url('/login') }}">
                                        <i class="far fa-heart fa-3x mx-2"></i>
                                        <span class="h5">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </a>
                                </div>
                            @else
                                @if($review->like_id)
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-3x mx-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h5">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </div>
                                @else
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-3x mx-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h5">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </div>
                                @endif
                            @endguest
                            <a class="cursor-pointer" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                <i class="far fa-comment fa-3x mx-2"></i>
                                <span class="h5">
                                    @if($review->comments_count > 0)
                                        {{ $review->comments_count }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span>{{ __('app.word.count') }}</span>
                            </a>
                        </div>
                    </li>
                @endforeach
                </ul>
                @if(count($reviews) == 20)
                    <div id="show-more-reviews">
                        <div class="mb-5 text-center">
                            <button type="button" id="show-more-reviews-button" class="btn btn-outline-secondary w-100" data-item_id="{{ $item->id }}">{{ __('app.button.show_more') }}</button>
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
