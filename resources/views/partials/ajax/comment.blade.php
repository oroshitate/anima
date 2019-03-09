@foreach($comments as $comment)
    <li class="py-4 border-bottom" id="comment-li-{{ $comment->comment_id }}">
        <div class="row">
            <div class="align-top col-8">
                <div class="row align-items-center mb-2">
                    <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                        @if($comment->user_image == null)
                            <img class="m-3 rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                        @else
                            <img class="m-3 rounded-circle align-top profile" src="/storage/images/users/{{ $comment->user_image }}">
                        @endif
                    </a>
                    <p class="h5">{{ $comment->user_name }}</p>
                </div>
            </div>
            <div class="row col-4 justify-content-end">
                @auth
                    @if(Auth::user()->id == $comment->user_id)
                        <div class="d-inline-block mt-3 mx-md-3 cursor-pointer text-right">
                            <button type="button" class="bg-white border border-0 comment-modal-button" data-toggle="modal" data-target="#operate-comment-modal" data-comment_id="{{ $comment->comment_id }}" data-content="{{ $comment->comment_content }}">
                                <i class="fas fa-angle-down fa-2x"></i>
                            </button>
                        </div>
                    @else
                        <div class="d-inline-block"></div>
                    @endif
                @endauth
                <div class="d-inline-block text-right align-top mt-3">
                    <p class="created-date" >{{ $comment->comment_created }}</p>
                </div>
            </div>
        </div>
        @if($comment->comment_reply_user_nickname)
            <div class="align-top reply-box d-inline-block bg-secondary text-white rounded cursor-pointer" data-reply_id="{{ $comment->comment_reply_id }}" >
                <span class="p-2">{{ "To @".$comment->comment_reply_user_nickname}}</span>
            </div>
            <pre id="comment-content-{{ $comment->comment_id }}" class="py-3 h5 content-length">{{ $comment->comment_content}}</pre>
        @else
            <pre id="comment-content-{{ $comment->comment_id }}" class="h5 content-length">{{ $comment->comment_content}}</pre>
        @endif
        <div class="text-center">
            @guest
                <div class="d-inline-block cursor-pointer">
                    <a href="{{ url('/login') }}">
                        <i class="far fa-heart fa-3x mx-2"></i>
                        <span class="h5">
                            @if($comment->comment_likes_count > 0)
                                {{ $comment->comment_likes_count }}
                            @else
                                0
                            @endif
                        </span>
                        <span>{{ __('app.word.count') }}</span>
                    </a>
                </div>
                <div class="d-inline-block cursor-pointer">
                    <a href="{{ url('/login') }}">
                        <i class="fas fa-reply fa-3x mx-2"></i>
                        <span class="h5">
                            {{ $comment->reply_count }}{{ __('app.word.count') }}
                        </span>
                    </a>
                </div>
            @else
                @if($comment->comment_like_id)
                    <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                        <i class="far fa-heart fa-3x mx-2"></i>
                        <span id="likes-comment-count-{{ $comment->comment_id }}" class="h5">
                            @if($comment->comment_likes_count > 0)
                                {{ $comment->comment_likes_count }}
                            @else
                                0
                            @endif
                        </span>
                        <span>{{ __('app.word.count') }}</span>
                    </div>
                @else
                    <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                        <i class="far fa-heart fa-3x mx-2"></i>
                        <span id="likes-comment-count-{{ $comment->comment_id }}" class="h5">
                            @if($comment->comment_likes_count > 0)
                                {{ $comment->comment_likes_count }}
                            @else
                                0
                            @endif
                        </span>
                        <span>{{ __('app.word.count') }}</span>
                    </div>
                @endif
                <div class="d-inline-block reply-button cursor-pointer" data-comment_id="{{ $comment->comment_id }}" data-user_nickname="{{ $comment->user_nickname }}">
                    <i class="fas fa-reply fa-3x mx-2"></i>
                    <span class="h5">
                        {{ $comment->reply_count }}{{ __('app.word.count') }}
                    </span>
                </div>
            @endguest
        </div>
    </li>
@endforeach
