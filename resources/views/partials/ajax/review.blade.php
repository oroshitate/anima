@foreach($reviews as $review)
    <li class="py-4 border-bottom">
        <div class="row">
            <div class="align-top col-8">
                <div class="row align-items-center mb-2">
                    <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                        @if($review->user_image == null)
                            <img class="m-3 rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                        @else
                            <img class="m-3 rounded-circle align-top profile" src="/storage/images/users/{{ $review->user_image }}">
                        @endif
                    </a>
                    <p class="h5">{{ $review->user_name }}</p>
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
