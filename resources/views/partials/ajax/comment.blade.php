@foreach($comments as $comment)
    <li class="py-md-4 border-bottom" id="comment-li-{{ $comment->comment_id }}">
        <div class="clearfix">
            <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $comment->user_image }}">
            </a>
            <div class="d-inline-block align-top col-md-8">
                <p class="h4">{{ $comment->user_name }}</p>
                <p class="h4 text-secondary">{{ "@".$comment->user_nickname }}</p>
                @if($comment->comment_reply_user_nickname)
                    <div class="align-top reply-box d-inline-block bg-secondary text-white rounded cursor-pointer" data-reply_id="{{ $comment->comment_reply_id }}" >
                        <span class="p-md-2">{{ "To @".$comment->comment_reply_user_nickname}}</span>
                    </div>
                    <pre id="comment-content-{{ $comment->comment_id }}" class="py-md-3 h4 content-length">{{ $comment->comment_content}}</pre>
                @else
                    <pre id="comment-content-{{ $comment->comment_id }}" class="py-md-3 h4 content-length">{{ $comment->comment_content}}</pre>
                @endif
            </div>
            @auth
                @if(Auth::user()->id == $comment->user_id)
                    <div class="d-inline-block cursor-pointer">
                        <button type="button" class="bg-white border border-0 comment-modal-button" data-toggle="modal" data-target="#operate-comment-modal" data-comment_id="{{ $comment->comment_id }}" data-content="{{ $comment->comment_content }}">
                            <i class="fas fa-angle-down fa-2x"></i>
                        </button>
                    </div>
                @else
                    <div class="d-inline-block"></div>
                @endif
            @endauth
            <div class="col-md-2 d-inline-block text-right">
                <p class="h5 created-date" >{{ $comment->comment_created }}</p>
            </div>
            <div class="text-center my-md-2">
                @guest
                    <div class="d-inline-block cursor-pointer">
                        <a href="{{ url('/login') }}">
                            <i class="far fa-heart fa-3x mx-md-2"></i>
                            <span class="h4">
                                @if($comment->comment_likes_count > 0)
                                    {{ $comment->comment_likes_count }}
                                @else
                                    0
                                @endif
                            </span>
                            <span>件</span>
                        </a>
                    </div>
                    <div class="d-inline-block cursor-pointer">
                        <a href="{{ url('/login') }}">
                            <i class="fas fa-reply fa-3x mx-md-2"></i>
                            <span class="h4">
                                {{ $comment->reply_count }}件
                            </span>
                        </a>
                    </div>
                @else
                    @if($comment->comment_like_id)

                        <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                            <i class="far fa-heart fa-3x mx-md-2"></i>
                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h4">
                                @if($comment->comment_likes_count > 0)
                                    {{ $comment->comment_likes_count }}
                                @else
                                    0
                                @endif
                            </span>
                            <span>件</span>
                        </div>
                    @else
                        <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                            <i class="far fa-heart fa-3x mx-md-2"></i>
                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h4">
                                @if($comment->comment_likes_count > 0)
                                    {{ $comment->comment_likes_count }}
                                @else
                                    0
                                @endif
                            </span>
                            <span>件</span>
                        </div>
                    @endif
                    <div class="d-inline-block reply-button cursor-pointer" data-comment_id="{{ $comment->comment_id }}" data-user_nickname="{{ $comment->user_nickname }}">
                        <i class="fas fa-reply fa-3x mx-md-2"></i>
                        <span class="h4">
                            {{ $comment->reply_count }}件
                        </span>
                    </div>
                @endguest
            </div>
        </div>
    </li>
@endforeach
