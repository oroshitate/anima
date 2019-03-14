@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.home') }}</title>
@endsection

@section('script')
<script src="{{ asset('js/template/masonry.pkgd.min.js') }}" defer></script>
<script src="{{ asset('js/review.js') }}" defer></script>
<script src="{{ asset('js/like.js') }}" defer></script>
<script src="{{ asset('js/pinterest.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_timelines.js') }}" defer></script>
@endsection

@section('content')
@guest
<div class="about">
    <div class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1>{{ __('app.sentence.home.guest.1') }}</h1>
            <p class="lead">{{ __('app.sentence.home.guest.2') }}</p>
            <a href="{{ url('/login') }}">
                <button type="button" class="text-white btn btn-success">{{ __('app.button.register_login_start') }}</button>
            </a>
        </div>
    </div>
    <div class="bg-grey text-dark p-2">
        <span class="h5 text-black">{{ __('app.word.title.popular_anime') }}</span>
    </div>
</div>
@endguest
<div class="container">
  <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            @auth
                @if(count($reviews) > 0)
                    <div class="bg-grey text-dark p-3 my-3">
                        <span class="h5 text-black">{{ __('app.word.title.timeline') }}</span>
                    </div>
                    <ul id="timelines" class="list-unstyled mb-5">
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
                                                    <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $review->user_image }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-8 pr-0">
                                            <p class="h5-5">{{ $review->user_name }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                        <p class="h5-5 mb-0">{{ $review->item_title }}</p>
                                        <div class="star-rating d-inline-block">
                                            <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                                            <div class="star-rating-back">★★★★★</div>
                                        </div>
                                        <pre class="py-2 h5-5 content-length">{{ $review->review_content }}</pre>
                                    </a>
                                </div>
                                @if($review->user_id == Auth::user()->id)
                                    <div class="col-1 mt-3 cursor-pointer d-inline-block text-right">
                                        <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                            <i class="fas fa-angle-down fa-2x"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="col-1"></div>
                                @endif
                                <div class="d-inline-block col-3 mt-3 align-top text-right">
                                    <p class="created-date" >{{ $review->review_created }}</p>
                                    <a href="{{ route('item', ['item_id' => $review->item_id]) }}">
                                        @if($review->item_image == null)
                                            <img src="{{ asset('anima-img.png') }}" class="w-75">
                                        @else
                                            <img class="w-75" src="{{ config('app.image_path') }}/items/{{ $review->item_image }}">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="text-center">
                                @if($review->like_id)
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-2x mx-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h5-5">
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
                                        <i class="far fa-heart fa-2x mx-2"></i>
                                        <span id="likes-review-count-{{ $review->review_id }}" class="h5-5">
                                            @if($review->likes_count > 0)
                                                {{ $review->likes_count }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                        <span>{{ __('app.word.count') }}</span>
                                    </div>
                                @endif
                                <a class="cursor-pointer" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                                    <i class="far fa-comment fa-2x mx-2"></i>
                                    <span class="h5-5">
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
                      <div id="show-more-timelines">
                          <div class="text-center mb-5">
                              <button type="button" id="show-more-timelines-button" class="btn btn-outline-secondary w-100">{{ __('app.button.show_more') }}</button>
                          </div>
                      </div>
                  @endif
                @else
                    <div class="mx-auto col-12 my-5">
                        <p class="lead">{{ __('app.sentence.home.auth.1') }}</p>
                        <p class="lead">{{ __('app.sentence.home.auth.2') }}</p>
                        <br>
                        <p class="lead">{{ __('app.sentence.home.auth.3') }}</p>
                        <div class="text-center">
                            <img src="{{ asset('anima-logo-black.png') }}" width="340px" height="120px">
                        </div>
                    </div>
                @endif
                <div class="bg-grey text-dark p-2">
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
                                <img src="{{ asset('anima-img.png') }}" class="w-100">
                            @else
                                <img src="{{ config('app.image_path') }}/items/{{ $item->image }}" class="w-100">
                            @endif
                        </a>
                        <div class="bg-secondary text-white text-center">
                            <span class="text-white name-length">{{ $item->title }}</span>
                            <div class="d-inline-block">
                                <div class="one-star-rating d-inline-block">
                                    <div class="one-star-rating-front">★</div>
                                </div>
                                <span class="text-warning">{{ $item->item_avg }}</span>
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
