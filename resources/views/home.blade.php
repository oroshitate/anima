@extends('layouts.app')

@section('title')
<title>Anima | ホーム</title>
@endsection

@section('script')
<script src="{{ asset('js/review.js') }}" defer></script>
<script src="{{ asset('js/like.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_timelines.js') }}" defer></script>
@endsection

@section('content')
@guest
<div class="about">
    <div class="bg-dark text-white py-md-5">
        <div class="container text-center">
            <h1>アニメ情報・感想・レビュー評価ならAnima</h1>
            <p class="lead">****件以上のアニメから観たいアニメを見つけて、評価して、共有しよう。</p>
            <a href="{{ url('/login') }}">
                <button type="button" class="text-white btn btn-success">登録・ログインしてはじめる</button>
            </a>
        </div>
    </div>
    <div class="bg-grey text-dark p-md-2">
        <span class="h4 text-black">話題のアニメ</span>
    </div>
</div>
@endguest
<div class="container">
  <div class="row justify-content-center">
        <div class="col-md-12">
            @auth
                @if(count($reviews) > 0)
                    <div class="bg-grey text-dark p-md-3 my-md-4">
                        <span class="h4 text-black">タイムライン</span>
                    </div>
                    <ul id="timelines" class="list-unstyled mb-md-5">
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
                  </ul>
                  @if(count($reviews) == 20)
                      <div id="show-more-timelines">
                          <div class="text-center mb-md-5">
                              <p class="h4 text-danger">Show 20 Reviews</p>
                          </div>
                          <div class="text-center mb-md-5">
                              <button type="button" id="show-more-timelines-button" class="btn btn-outline-secondary w-100">さらに読み込む</button>
                          </div>
                      </div>
                  @endif
                @else
                    <div class="mx-auto col-md-7 my-md-5">
                        <p class="lead">Animaでは、見たアニメのレビューを投稿したり、レビューを投稿している</p>
                        <p class="lead">他のユーザーをフォローすることで、タイムラインが作成されます。</p>
                        <br>
                        <p class="lead">まずは見たアニメのレビューを投稿するか、気になる他のユーザーをフォローしてみましょう！。</p>
                        <div class="text-center">
                            <img src="{{ asset('anima-logo-black.png') }}" width="340px" height="120px">
                        </div>
                    </div>
                @endif
                <div class="bg-grey text-dark p-md-2">
                    <span class="h4 text-black">人気アニメ一覧</span>
                </div>
            @endauth
            <ul id="items" class="list-inline text-center my-md-4">
            @foreach($items as $item)
                <li class="list-inline-item my-md-2">
                    <a href="{{ route('item', ['item_id' => $item->id]) }}">
                        <img src="/storage/images/items/{{ $item->image }}.jpg">
                    </a>
                    <div class="bg-secondary text-white">
                        <span class="text-white name-length">{{ $item->title }}</span>
                        <div class="d-inline-block ml-md-2">
                            <div class="one-star-rating d-inline-block">
                                <div class="one-star-rating-front">★</div>
                            </div>
                            <span class="text-warning">{{ $item->item_avg }}</span>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>
@include('partials.form.review.operate')
@include('partials.form.review.edit')
@include('partials.form.review.delete')
@endsection
