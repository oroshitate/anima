@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.user.followings', ['name' => $show_user->name]) }}</title>
@endsection

@section('script')
<script src="{{ asset('js/follow.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
          <div class="bg-grey text-dark p-3 my-3">
              <span class="h4 text-black">{{ __('app.word.followings') }}</span>
          </div>
            <ul id="users" class="list-unstyled text-center my-4">
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
                        <div class="col-4 px-0 row align-items-center justify-content-end">
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
        </div>
    </div>
</div>
@endsection