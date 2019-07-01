@foreach($reviews as $review)
    <li class="py-2 border-bottom">
        <div class="row">
            <div class="align-top col-8">
                <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                    <div class="row align-items-center mb-2">
                        <div class="col-2 col-md-1">
                                @if($review->user_image == null)
                                    <img class="rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                @else
                                    <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $review->user_image }}">
                                @endif
                        </div>
                        <div class="col-8 pr-0">
                            <p class="h7 font-bold mb-0 light-black">{{ $review->user_name }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row col-4 justify-content-end">
                @auth
                    @if($review->user_id == Auth::user()->id)
                        <div class="d-inline-block mx-md-3 cursor-pointer text-right">
                            <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                                <i class="fas fa-angle-down fa-15x"></i>
                            </button>
                        </div>
                    @else
                        <div class="d-inline-block"></div>
                    @endif
                @endauth
                <div class="d-inline-block text-right align-top">
                    <p class="created-date h7">{{ $review->review_created }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
            <div class="star-rating d-inline-block">
                <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                <div class="star-rating-back">★★★★★</div>
            </div>
            <pre class="py-1 h7 content-length light-black">{{ $review->review_content }}</pre>
        </a>
        <div class="text-center">
            @guest
                <div class="d-inline-block cursor-pointer">
                    <a href="{{ url('/login') }}">
                        <img src="{{ asset('like.png') }}" class="header-icon">
                        @if($review->likes_count > 0)
                            <span class="h7 light-black">
                                {{ $review->likes_count }}
                            </span>
                            <span class="h7 light-black">{{ __('app.word.count') }}</span>
                        @endif
                    </a>
                </div>
            @else
                @if($review->like_id)
                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                        <img src="{{ asset('like_on.png') }}" class="header-icon">
                        @if($review->likes_count > 0)
                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                {{ $review->likes_count }}
                            </span>
                            <span class="count-word-{{$review->review_id}} h7">{{ __('app.word.count') }}</span>
                        @endif
                    </div>
                @else
                    <div id="like-review-button-{{ $review->review_id }}" class="{{ $review->like_status }} like-review-button d-inline-block cursor-pointer" data-review_id="{{ $review->review_id }}" data-like_id="{{ $review->like_id }}">
                        <img src="{{ asset('like.png') }}" class="header-icon">
                        @if($review->likes_count > 0)
                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                                {{ $review->likes_count }}
                            </span>
                            <span class="count-word-{{$review->review_id}} h7">{{ __('app.word.count') }}</span>
                        @else
                            <span id="likes-review-count-{{ $review->review_id }}" class="h7">
                            </span>
                            <span class="count-word-{{$review->review_id}} h7"></span>
                        @endif
                    </div>
                @endif
            @endguest
            <a class="cursor-pointer" href="{{ route('review', ['review_id' => $review->review_id]) }}">
                <img src="{{ asset('comment.png') }}" class="header-icon">
                @if($review->comments_count > 0)
                    <span class="h7">
                        {{ $review->comments_count }}
                    </span>
                    <span class="h7">{{ __('app.word.count') }}</span>
                @endif
            </a>
        </div>
    </li>
@endforeach
