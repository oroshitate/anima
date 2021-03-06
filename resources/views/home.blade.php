@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.home') }}</title>
<meta property="og:title" content="Anima | {{ __('app.title.home') }}">
@endsection

@section('script')
<script>
    var following = "{{ __('app.button.following') }}";
    var follow = "{{ __('app.button.follow') }}";
</script>
<script src="{{ asset('js/template/masonry.pkgd.min.js') }}" defer></script>
<script src="{{ asset('js/review.js') }}" defer></script>
<script src="{{ asset('js/like.js') }}" defer></script>
<script src="{{ asset('js/pinterest.js') }}" defer></script>
<script src="{{ asset('js/follow.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_timelines.js') }}" defer></script>
@endsection

@section('content')
@guest
<div class="about">
    <div class="bg-dark text-white py-4">
        <div class="container text-center font-bold">
            <div class="mb-4">
                <p>{{ __('app.sentence.home.guest.1') }}</p>
                <p>{{ __('app.sentence.home.guest.2') }}</p>
            </div>
            <a href="{{ url('/login') }}">
                <button type="button" class="w-100 text-white btn btn-success font-bold py-3">
                    <span class="h5">{{ __('app.button.register_login_start') }}</span>
                </button>
            </a>
        </div>
    </div>
    <div class="bg-grey text-dark p-1 pl-2">
        <span class="h7 content-title text-black font-bold">{{ __('app.word.title.popular_anime') }}</span>
    </div>
</div>
@endguest
<div class="container">
  <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            @auth
                @if(count($reviews) > 0)
                    <ul id="timelines" class="list-unstyled mb-5">
                    @foreach($reviews as $review)
                        <li class="py-2 border-bottom">
                            <div class="row">
                                <div class="align-top col-8">
                                    <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 col-md-1">
                                                    @if($review->user_image == null)
                                                        <img class="rounded-circle align-top profile" src="{{ asset('user_image.jpg') }}">
                                                    @else
                                                        <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $review->user_image }}">
                                                    @endif
                                            </div>
                                            <div class="col-8 pr-0">
                                                <p class="h7 font-bold mb-0 light-black">{{ $review->user_name }}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <p class="h7 mb-0 font-bold light-black">{{ $review->item_title }}</p>
                                    <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                        <div class="star-rating d-inline-block">
                                            <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                                            <div class="star-rating-back">★★★★★</div>
                                        </div>
                                        <span class="text-warning h7">{{ $review->review_score }}</span>
                                        <pre class="py-1 h7 content-length light-black">{{ $review->review_content }}</pre>
                                    </a>
                                </div>
                                @if($review->user_id == Auth::user()->id)
                                    <div class="col-1 cursor-pointer d-inline-block text-right p-0">
                                        <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                            <img src="{{ asset('edit.png') }}" class="zwicon-icon">
                                        </button>
                                    </div>
                                @else
                                    <div class="col-1"></div>
                                @endif
                                <div class="d-inline-block col-3 align-top text-right">
                                    <p class="created-date h7">{{ $review->review_created }}</p>
                                    <a href="{{ route('item', ['item_id' => $review->item_id]) }}">
                                        @if($review->item_image == null)
                                            <img src="{{ asset('anima_image.png') }}" class="w-100">
                                        @else
                                            <img class="w-100" src="{{ config('app.image_path') }}/items/{{ $review->item_image }}">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="text-left">
                                @if($review->like_id)
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <img src="{{ asset('like_on.png') }}" class="zwicon-icon">
                                        @if($review->likes_count > 0)
                                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                                {{ $review->likes_count }}
                                            </span>
                                            <span class="h7 count-word-{{ $review->review_id }}">{{ __('app.word.count') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <img src="{{ asset('like.png') }}" class="zwicon-icon">
                                        @if($review->likes_count > 0)
                                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                                {{ $review->likes_count }}
                                            </span>
                                            <span class="h7 count-word">{{ __('app.word.count') }}</span>
                                        @else
                                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                            </span>
                                            <span class="h7 count-word-{{ $review->review_id }}"></span>
                                        @endif
                                    </div>
                                @endif
                                <a class="cursor-pointer" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                    <img src="{{ asset('comment.png') }}" class="zwicon-icon">
                                    @if($review->comments_count > 0)
                                        <span class="h7">
                                            {{ $review->comments_count }}
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    @endif
                                </a>
                            </div>
                        </li>
                    @endforeach
                  </ul>
                  @if(count($reviews) == 20)
                      <div id="show-more-timelines">
                          <div class="text-center mb-5">
                              <button type="button" id="show-more-timelines-button" class="btn btn-outline-secondary w-100">{{ __('app.button.show_more') }}</button>
                          </div>
                      </div>
                  @endif
                @else
                    <div class="mx-auto col-12 my-5 text-center">
                        <p class="h7">{!! nl2br(e(__('app.sentence.home.auth.1'))) !!}</p>
                        <p class="h7">{!! nl2br(e(__('app.sentence.home.auth.1'))) !!}</p>
                        <div class="text-center">
                            <img src="{{ asset('anima_image.png') }}" style="width:156px; height:152px;">
                        </div>
                    </div>
                    <div class="bg-grey text-dark p-1">
                        <span class="h5 text-black">{{ __('app.word.title.recommend_user') }}</span>
                    </div>
                    <ul id="users" class="list-unstyled text-center my-2">
                        @foreach($users as $user)
                            <li class="py-4 border-bottom row justify-content-center no-gutters">
                                <div class="align-top col-8 col-md-6 pl-0">
                                    <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                                        <div class="row align-items-center">
                                            @if($user->image == null)
                                                <img class="m-3 rounded-circle align-top profile" src="{{ asset('user_image.jpg') }}">
                                            @else
                                                <img class="m-3 rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $user->image }}">
                                            @endif
                                            <div class="col-7 px-0 text-left">
                                                <p class="h7 font-bold m-0">{{ $user->name }}</p>
                                                <p class="m-0 h7 text-secondary">{{ "@".$user->nickname }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-4 px-0 row align-items-center justify-content-center">
                                    @if($user->follow_status === "active")
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn border" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"><i class="fa fa-check mr-2"></i><span class="dark-grey">{{ __('app.button.following') }}</span></button>
                                    @else
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"><span class="">{{ __('app.button.follow') }}</button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="bg-grey text-dark p-1">
                    <span class="h5 text-black">{{ __('app.word.title.popular_anime') }}</span>
                </div>
            @endauth
            <div class="grid-index my-4">
                <div class="grid-sizer col-4"></div>
                @foreach($items as $item)
                <div class="grid-item col-4 my-1 px-1">
                    <div class="card">
                        <a href="{{ route('item', ['item_id' => $item->id]) }}">
                            @if($item->image == null)
                                <img src="{{ asset('anima_image.png') }}" class="w-100">
                            @else
                                <img src="{{ config('app.image_path') }}/items/{{ $item->image }}" class="w-100">
                            @endif
                        </a>
                        <div class="bg-secondary text-white text-center">
                            <span class="text-white name-length h7">{{ $item->title }}</span>
                            <div class="d-inline-block">
                                <div class="one-star-rating d-inline-block">
                                    <div class="one-star-rating-front">★</div>
                                </div>
                                <span class="text-warning h7">{{ $item->item_avg }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="ad-box" class="bg-danger my-4" style="display:none; height:100px;">
</div>
@include('partials.form.review.operate')
@include('partials.form.review.edit')
@include('partials.form.review.delete')
@endsection
