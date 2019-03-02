@extends('layouts.app')

@section('title')
<title>Anima | 検索：{{ $keyword }}</title>
@endsection

@section('script')
<script src="{{ asset('js/follow.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_keyword_items.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_keyword_users.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ul class="nav nav-pills my-md-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center bg-grey-opacity" style="width:50%;">
                    <a class="nav-link active" id="pills-items-tab" data-toggle="pill" href="#pills-items" role="tab" aria-controls="pills-items" aria-selected="true">アニメ作品</a>
                </li>
                <li class="nav-item text-center bg-grey-opacity" style="width:50%">
                    <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">ユーザー</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-items" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="bg-grey text-dark p-md-3 mb-md-5">
                        <span class="h4 text-black">
                            「{{ $keyword }}」に関する検索結果 : {{ count($items) }}件
                        </span>
                    </div>
                    <ul id="keyword-items" class="list-inline text-center my-md-5">
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
                    @if (count($items) == 20)
                    <div id="show-more-keyword-items">
                        <div class="text-center mb-md-5">
                            <p class="h4 text-danger">Show 20 Items</p>
                        </div>
                        <div class="text-center mb-md-5">
                            <button type="button" id="show-more-keyword-items-button" class="btn btn-outline-secondary w-100">さらに読み込む</button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="bg-grey text-dark p-md-3 my-md-5">
                        <span class="h4 text-black">
                            「{{ $keyword }}」に関する検索結果 : {{ count($users) }}件
                        </span>
                    </div>
                    <ul id="keyword-users" class="list-unstyled text-center mb-md-5">
                        @foreach($users as $user)
                            <li class="py-md-4 border-bottom row justify-content-center">
                                <div class="col-md-3 text-center">
                                    <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                                        <img class="m-md-3 rounded-circle align-top profile" src="/storage/images/users/{{ $user->image }}">
                                    </a>
                                </div>
                                <div class="col-md-3 text-left row align-items-center">
                                    <div>
                                        <p class="m-0 h4">{{ $user->name }}</p>
                                        <p class="m-0 h4 text-secondary">{{ "@".$user->nickname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 row align-items-center">
                                    @guest
                                        <a href="{{ url('/login') }}">
                                            <button type="button" class="btn btn-success">フォローする</button>
                                        </a>
                                    @else
                                        @if(Auth::user()->id == $user->id)
                                            <form method="post" action="{{ route('mypage') }}">
                                                @csrf
                                                <input type="hidden" name="nickname" value="{{ $user->nickname }}">
                                                <button type="submit" id="profile-edit-button" class="btn btn-outline-secondary">プロフィールを編集</button>
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
                            <div class="text-center mb-md-5">
                                <p class="h4 text-danger">Show 20 Users</p>
                            </div>
                            <div class="text-center mb-md-5">
                                <button type="button" id="show-more-keyword-users-button" class="btn btn-outline-secondary w-100">さらに読み込む</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
