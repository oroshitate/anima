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
