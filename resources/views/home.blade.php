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
        <span class="content-title text-black font-bold">{{ __('app.word.title.popular_anime') }}</span>
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
                                    <div class="row align-items-center mb-2">
                                        <div class="col-2 col-md-1">
                                            <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                                                @if($review->user_image == null)
                                                    <img class="rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                                @else
                                                    <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $review->user_image }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-8 pr-0">
                                            <p class="h7 font-bold mb-0 light-black">{{ $review->user_name }}</p>
                                        </div>
                                    </div>
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
                                    <div class="col-1 cursor-pointer d-inline-block text-right">
                                        <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                            <i class="fas fa-angle-down fa-15x"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="col-1"></div>
                                @endif
                                <div class="d-inline-block col-3 align-top text-right">
                                    <p class="created-date h7">{{ $review->review_created }}</p>
                                    <a href="{{ route('item', ['item_id' => $review->item_id]) }}">
                                        @if($review->item_image == null)
                                            <img src="{{ asset('anima-img.png') }}" class="w-100">
                                        @else
                                            <img class="w-100" src="{{ config('app.image_path') }}/items/{{ $review->item_image }}">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="text-left">
                                @if($review->like_id)
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-15x"></i>
                                        @if($review->likes_count > 0)
                                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                                {{ $review->likes_count }}
                                            </span>
                                            <span class="h7 count-word-{{ $review->review_id }}">{{ __('app.word.count') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                                        <i class="far fa-heart fa-15x"></i>
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
                                    <i class="far fa-comment fa-15x mx-1"></i>
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
                            <img src="{{ asset('anima-img.png') }}" style="width:156px; height:152px;">
                        </div>
                    </div>
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
                                <img src="{{ asset('anima-img.png') }}" class="w-100">
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
