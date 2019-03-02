@extends('layouts.app')

@section('title')
<title>Anima | {{ $user->name }}のプロフィール</title>
@endsection

@section('script')
<script src="{{ asset('js/follow.js') }}" defer></script>
<script src="{{ asset('js/ajax/show_more_items.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 my-md-5">
            <div id="user-detail" class="row col-md-8 mx-auto" data-nickname="{{ $user->nickname }}">
                <div class="col-md-4 text-left">
                    <img class="rounded-circle align-top profile-lg" src="/storage/images/users/{{ $user->image }}">
                </div>
                <div class="d-inline-block col-md-8">
                    <div class="row text-center h-25">
                        <span class="col-md-4">{{ $reviews_count }}</span>
                        <a id="followings-link" class="follow-link col-md-4" href="">{{ $followings_count }}</a>
                        <a id="followers-link" class="follow-link col-md-4" href="">{{ $followers_count }}</a>
                    </div>
                    <div class="row text-center h-25">
                        <span class="col-md-4">レビュー</span>
                        <span class="col-md-4">フォロー</span>
                        <span class="col-md-4">フォロワー</span>
                    </div>
                    <div class="text-center h-25">
                        <div class="d-inline-block w-100">
                            @guest
                                <a href="{{ url('/login') }}">
                                    <button type="button" class="btn btn-success w-100">フォローする</button>
                                </a>
                            @else
                                @if(Auth::user()->id == $user->id)
                                    <form method="post" action="{{ route('mypage') }}">
                                        @csrf
                                        <input type="hidden" name="nickname" value="{{ $user->nickname }}">
                                        <button type="submit" id="profile-edit-button" class="btn btn-outline-secondary w-100">プロフィールを編集</button>
                                    </form>
                                @else
                                    @if($follow_status === "active")
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $follow_status }} follow-button btn btn-success w-100" data-user_id="{{ $user->id }}" data-follow_id="{{ $follow_id }}"></button>
                                    @else
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $follow_status }} follow-button btn btn-outline-success w-100" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"></button>
                                    @endif
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-left mx-auto my-md-2">
                <span class="h4 ml-md-2">{{ $user->name }}</span>
            </div>
            <div class="col-md-8 text-left mx-auto my-md-2">
                <span class="h5 text-secondary ml-md-2">{{ "@".$user->nickname }}</span>
            </div>
            <div class="col-md-8 text-left mx-auto ">
                <pre class="ml-md-2">{{ $user->content }}</pre>
            </div>
            <div class="col-md-12 bg-grey text-dark p-md-2 my-md-4 mx-auto">
                <span class="h4 text-black">レビューしたアニメ</span>
            </div>
            <div class="text-center">
                <ul id="items" class="list-inline text-center my-md-4">
                @foreach($items as $item)
                    <li class="list-inline-item my-md-2">
                        <a href="{{ route('item', ['item_id' => $item->id]) }}">
                            <img src="/storage/images/items/{{ $item->image }}.jpg">
                        </a>
                        <div class="bg-secondary text-white">
                            <span class="text-white mr-md-1">タイトル</span>
                            <span class="text-white">評価</span>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
