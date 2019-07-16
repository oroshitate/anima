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
