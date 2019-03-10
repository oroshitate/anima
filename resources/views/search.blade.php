@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.search', ['keyword' => $keyword]) }}</title>
@endsection

@section('script')
<script src="{{ asset('js/template/masonry.pkgd.min.js') }}" defer></script>
<script src="{{ asset('js/follow.js') }}" defer></script>
<script src="{{ asset('js/pinterest.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_keyword_items.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_keyword_users.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center bg-grey-opacity" style="width:50%;">
                    <a class="nav-link active" id="pills-items-tab" data-toggle="pill" href="#pills-items" role="tab" aria-controls="pills-items" aria-selected="true">{{ __('app.word.search.item') }}</a>
                </li>
                <li class="nav-item text-center bg-grey-opacity" style="width:50%">
                    <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">{{ __('app.word.search.user') }}</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-items" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="bg-grey text-dark p-3 mb-5">
                        <span class="h5 text-black">
                          {{ __('app.word.search.result', ['keyword' => $keyword, 'count' => $items_count ]) }}
                        </span>
                    </div>
                    <div id="keyword-items">
                        <div class="grid-index my-4">
                            <div class="grid-sizer col-4"></div>
                            @foreach($items as $item)
                            <div class="grid-item col-4 my-1 px-1 keyword-item">
                                <div class="card">
                                    <a href="{{ route('item', ['item_id' => $item->id]) }}">
                                        @if($item->image == null)
                                            <img src="{{ asset('anima-img.png') }}" class="w-100">
                                        @else
                                            <img src="/storage/images/items/{{ $item->image }}" class="w-100">
                                        @endif
                                    </a>
                                    <div class="bg-secondary text-white text-center">
                                        <span class="text-white name-length">{{ $item->title }}</span>
                                        <div class="d-inline-block">
                                            <div class="one-star-rating d-inline-block">
                                                <div class="one-star-rating-front">★</div>
                                            </div>
                                            <span class="text-warning">{{ $item->item_avg }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @if (count($items) == 20)
                    <div id="show-more-keyword-items">
                        <div class="text-center mb-5">
                            <button type="button" id="show-more-keyword-items-button" class="btn btn-outline-secondary w-100">{{ __('app.button.show_more') }}</button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="bg-grey text-dark p-3 mb-4">
                        <span class="h5 text-black">
                            {{ __('app.word.search.result', ['keyword' => $keyword, 'count' => $users_count ]) }}
                        </span>
                    </div>
                    <ul id="keyword-users" class="list-unstyled text-center mb-4">
                        @foreach($users as $user)
                            <li class="py-4 border-bottom row justify-content-center">
                                <div class="align-top col-8 col-md-6 pl-0">
                                    <div class="row align-items-center">
                                        <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                                            @if($user->image == null)
                                                <img class="m-3 rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                            @else
                                                <img class="m-3 rounded-circle align-top profile" src="/storage/images/users/{{ $user->image }}">
                                            @endif
                                        </a>
                                        <div class="col-7 px-0 text-left">
                                            <p class="h5-5 m-0">{{ $user->name }}</p>
                                            <p class="m-0 h7 text-secondary">{{ "@".$user->nickname }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 px-0 row align-items-center justify-content-center">
                                    @guest
                                        <a href="{{ url('/login') }}">
                                            <button type="button" class="btn btn-success">{{ __('app.button.follow') }}</button>
                                        </a>
                                    @else
                                        @if(Auth::user()->id == $user->id)
                                            <form method="post" action="{{ route('mypage') }}">
                                                @csrf
                                                <input type="hidden" name="nickname" value="{{ $user->nickname }}">
                                                <button type="submit" id="profile-edit-button" class="btn btn-outline-secondary">{{ __('app.button.edit_profile') }}</button>
                                            </form>
                                        @else
                                            @if($user->follow_status === "active")
                                                <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"></button>
                                            @else
                                                <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-outline-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"></button>
                                            @endif
                                        @endif
                                    @endguest
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($users) == 20)
                        <div id="show-more-keyword-users">
                            <div class="text-center mb-5">
                                <button type="button" id="show-more-keyword-users-button" class="btn btn-outline-secondary w-100">{{ __('app.button.show_more') }}</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
