@foreach($reviews as $review)
    <li class="py-md-4 border-bottom">
        <div class="row" href="{{ route('review', ['review_id' => $review->review_id]) }}">
            <div class="align-top col-md-8">
                <div class="row align-items-center my-md-2">
                    <a href="{{ route('user', ['nickname' => $review->user_nickname]) }}">
                        <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $review->user_image }}">
                    </a>
                    <p class="h4">{{ $review->user_name }}</p>
                </div>
                <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                    <p class="h4">{{ $review->item_title }}</p>
                    <div class="star-rating d-inline-block">
                        <div class="star-rating-front" style="width:{{ $review->review_score*20 }}%">★★★★★</div>
                        <div class="star-rating-back">★★★★★</div>
                    </div>
                    <pre class="py-md-3 h4 content-length">{{ $review->review_content }}</pre>
                </a>
            </div>
            @if($review->user_id == Auth::user()->id)
                <div class="col-md-1 cursor-pointer d-inline-block">
                    <button type="button" class="bg-white border border-0 review-modal-button" data-toggle="modal" data-target="#operate-review-modal" data-review_id="{{ $review->review_id }}" data-score="{{ $review->review_score }}" data-content="{{ $review->review_content }}">
                        <i class="fas fa-angle-down fa-2x"></i>
                    </button>
                </div>
            @else
                <div class="col-md-1"></div>
            @endif
            <div class="d-inline-block col-md-3 align-top text-right">
                <p class="h5 created-date" >{{ $review->review_created }}</p>
                <a href="{{ route('item', ['item_id' => $review->item_id]) }}">
                    <img class="w-100" src="/storage/images/items/{{ $review->item_image }}.jpg">
                </a>
            </div>
        </div>
        <div class="text-center">
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
