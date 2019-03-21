@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.user.index',['name' => $user->name]) }}</title>
@endsection

@section('script')
<script>
    var following = "{{ __('app.button.following') }}";
    var follow = "{{ __('app.button.follow') }}";
</script>
<script src="{{ asset('js/template/masonry.pkgd.min.js') }}" defer></script>
<script src="{{ asset('js/follow.js') }}" defer></script>
<script src="{{ asset('js/watchlist.js') }}" defer></script>
<script src="{{ asset('js/pinterest.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_review_items.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_watchlists.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 my-5">
            <div id="user-detail" class="row col-12 mx-auto mb-4 px-0" data-nickname="{{ $user->nickname }}">
                <div class="col-3 col-md-2 text-left px-0 mt-2">
                    @if($user->image == null)
                        <img class="rounded-circle align-top w-100" src="{{ asset('no-image.jpg') }}">
                    @else
                        <img class="rounded-circle align-top w-100" src="{{ config('app.image_path') }}/users/{{ $user->image }}">
                    @endif
                </div>
                <div class="col-9 m-md-4">
                    <div class="row text-center mb-2">
                        <span class="col-4">{{ $reviews_count }}</span>
                        <a id="followings-link" class="follow-link col-4" href="">{{ $followings_count }}</a>
                        <a id="followers-link" class="follow-link col-4" href="">{{ $followers_count }}</a>
                    </div>
                    <div class="row text-center my-2">
                        <span class="col-4 h7 px-0">{{ __('app.word.review') }}</span>
                        <span class="col-4 h7 px-0">{{ __('app.word.followings') }}</span>
                        <span class="col-4 h7 px-0">{{ __('app.word.followers') }}</span>
                    </div>
                    <div class="text-center">
                        <div class="d-inline-block w-100">
                            @guest
                                <a href="{{ url('/login') }}">
                                    <button type="button" class="btn btn-success w-100">{{ __('app.button.follow') }}</button>
                                </a>
                            @else
                                @if(Auth::user()->id == $user->id)
                                    <form method="post" action="{{ route('mypage') }}">
                                        @csrf
                                        <input type="hidden" name="nickname" value="{{ $user->nickname }}">
                                        <button type="submit" id="profile-edit-button" class="btn btn-outline-secondary w-100">{{ __('app.button.edit_profile') }}</button>
                                    </form>
                                @else
                                    @if($follow_status === "active")
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $follow_status }} follow-button btn btn-success w-100" data-user_id="{{ $user->id }}" data-follow_id="{{ $follow_id }}">{{ __('app.button.following') }}</button>
                                    @else
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $follow_status }} follow-button btn btn-outline-success w-100" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}">{{ __('app.button.follow') }}</button>
                                    @endif
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-left mx-auto my-2 px-0">
                <span class="h5 ml-2">{{ $user->name }}</span>
            </div>
            <div class="col-12 text-left mx-auto my-2 px-0">
                <span class="h5 text-secondary ml-2">{{ "@".$user->nickname }}</span>
            </div>
            <div class="col-12 text-left mx-auto my-2 px-0">
                <pre class="ml-2 h5">{{ $user->content }}</pre>
            </div>
            <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center bg-grey-opacity" style="width:50%;">
                    <a class="nav-link active" id="pills-review-items-tab" data-toggle="pill" href="#pills-review-items" role="tab" aria-controls="pills-review-items" aria-selected="true">{{ __('app.word.title.reviewd_anime') }}</a>
                </li>
                <li class="nav-item text-center bg-grey-opacity" style="width:50%">
                    <a class="nav-link" id="pills-watchlists-tab" data-toggle="pill" href="#pills-watchlists" role="tab" aria-controls="pills-watchlists" aria-selected="false" data-user_id="{{ $user->id }}">{{ __('app.word.title.watchlist') }}</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-review-items" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="text-center">
                        <div id="review-items">
                            <div class="grid-index my-4">
                                <div class="grid-sizer col-4"></div>
                                @foreach($items as $item)
                                <div class="grid-item col-4 my-1 px-1 review-item">
                                    <div class="card">
                                        <a href="{{ route('item', ['item_id' => $item->id]) }}">
                                            @if($item->image == null)
                                                <img src="{{ asset('anima-img.png') }}" class="w-100">
                                            @else
                                                <img src="{{ config('app.image_path') }}/items/{{ $item->image }}" class="w-100">
                                            @endif
                                        </a>
                                        <div class="bg-secondary text-white text-center">
                                            <span class="text-white name-length">{{ $item->title }}</span>
                                            <div class="d-inline-block">
                                                <div class="one-star-rating d-inline-block">
                                                    <div class="one-star-rating-front">★</div>
                                                </div>
                                                <span class="text-warning">{{ $item->review_score }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if(count($items) == 20)
                        <div id="show-more-review-items">
                            <div class='text-center mb-5'>
                                <button type='button' id='show-more-review-items-button' class='btn btn-outline-secondary w-100' data-user_id="{{ $user->id }}">{{ __('app.button.show_more') }}</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-watchlists" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="text-center">
                        <div id="watchlists">
                        </div>
                        <div id="show-more-watchlists">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
