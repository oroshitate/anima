@foreach($comments as $comment)
    <li class="py-2 border-bottom" id="comment-li-{{ $comment->comment_id }}">
        <div class="row">
            <div class="align-top col-8">
              <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                  <div class="row align-items-center mb-2">
                      <div class="col-2 col-md-1">
                              <img class="rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $comment->user_image }}">
                      </div>
                      <div class="col-8 pr-0">
                          <p class="h7 font-bold mb-0">{{ $comment->user_name }}</p>
                      </div>
                  </div>
              </a>
            </div>
            <div class="row col-4 justify-content-end">
                @auth
                    @if(Auth::user()->id == $comment->user_id)
                        <div class="d-inline-block mx-md-3 cursor-pointer text-right">
                            <button type="button" class="bg-white border border-0 comment-modal-button" data-toggle="modal" data-target="#operate-comment-modal" data-comment_id="{{ $comment->comment_id }}" data-content="{{ $comment->comment_content }}">
                                <i class="fas fa-angle-down fa-15x"></i>
                            </button>
                        </div>
                    @else
                        <div class="d-inline-block"></div>
                    @endif
                @endauth
                <div class="d-inline-block text-right align-top">
                    <p class="created-date h7">{{ $comment->comment_created }}</p>
                </div>
            </div>
        </div>
        @if($comment->comment_reply_user_nickname)
            <div class="align-top reply-box d-inline-block bg-secondary text-white rounded cursor-pointer" data-reply_id="{{ $comment->comment_reply_id }}" >
                <span class="p-2 h7">{{ "To @".$comment->comment_reply_user_nickname}}</span>
            </div>
            <pre id="comment-content-{{ $comment->comment_id }}" class="py-1 h7 content-length">{{ $comment->comment_content}}</pre>
        @else
            <pre id="comment-content-{{ $comment->comment_id }}" class="py-1 h7 content-length">{{ $comment->comment_content}}</pre>
        @endif
        <div class="text-center">
            @guest
                <div class="d-inline-block cursor-pointer">
                    <a href="{{ url('/login') }}">
                        <i class="far fa-heart fa-15x"></i>
                        @if($comment->comment_likes_count > 0)
                            <span class="h7">
                                {{ $comment->comment_likes_count }}
                            </span>
                            <span class="h7">{{ __('app.word.count') }}</span>
                        @endif
                    </a>
                </div>
                <div class="d-inline-block cursor-pointer">
                    <a href="{{ url('/login') }}">
                        <span class="h6">返信</span>
                        @if($comment->reply_count > 0)
                            <span class="h7">
                                {{ $comment->reply_count }}
                            </span>
                            <span class="h7">{{ __('app.word.count') }}</span>
                        @endif
                    </a>
                </div>
            @else
                @if($comment->comment_like_id)
                    <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer text-danger" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                        <i class="far fa-heart fa-15x"></i>
                        @if($comment->comment_likes_count > 0)
                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h7">
                                {{ $comment->comment_likes_count }}
                            </span>
                            <span class="comment-count-word-{{$comment->comment_id}} h7">{{ __('app.word.count') }}</span>
                        @endif
                    </div>
                @else
                    <div id="like-comment-button-{{ $comment->comment_id }}" class="{{ $comment->comment_like_status }} like-comment-button d-inline-block cursor-pointer" data-review_id="{{ $review[0]->review_id }}" data-comment_id="{{ $comment->comment_id }}" data-like_id="{{ $comment->comment_like_id }}">
                        <i class="far fa-heart fa-15x"></i>
                        @if($comment->comment_likes_count > 0)
                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h7">
                                {{ $comment->comment_likes_count }}
                            </span>
                            <span class="h7">{{ __('app.word.count') }}</span>
                        @else
                            <span id="likes-comment-count-{{ $comment->comment_id }}" class="h7">
                            </span>
                            <span class="comment-count-word-{{$comment->comment_id}} h7"></span>
                        @endif
                    </div>
                @endif
                <div class="d-inline-block reply-button cursor-pointer" data-comment_id="{{ $comment->comment_id }}" data-user_nickname="{{ $comment->user_nickname }}">
                    <span class="h6">返信</span>
                    @if($comment->reply_count > 0)
                        <span class="h7">
                            {{ $comment->reply_count }}
                        </span>
                        <span class="h7">{{ __('app.word.count') }}</span>
                    @endif
                </div>
            @endguest
        </div>
    </li>
@endforeach
