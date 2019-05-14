@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.user.followings', ['name' => $show_user->name]) }}</title>
<meta property="og:title" content="Anima | {{ __('app.title.user.followings', ['name' => $show_user->name]) }}">
@endsection

@section('script')
<script>
    var following = "{{ __('app.button.following') }}";
    var follow = "{{ __('app.button.follow') }}";
</script>
<script src="{{ asset('js/follow.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
          <div class="bg-grey text-dark p-1 mt-3">
              <span class="h7 text-black font-bold">{{ __('app.word.followings') }}</span>
          </div>
            <ul id="users" class="list-unstyled text-center my-2">
                @foreach($users as $user)
                    <li class="py-4 border-bottom row justify-content-center no-gutters">
                        <div class="align-top col-8 col-md-6 pl-0">
                            <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                                <div class="row align-items-center">
                                    @if($user->image == null)
                                        <img class="m-3 rounded-circle align-top profile" src="{{ asset('no-image.jpg') }}">
                                    @else
                                        <img class="m-3 rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $user->image }}">
                                    @endif
                                    <div class="col-7 px-0 text-left">
                                        <p class="h7 font-bold m-0">{{ $user->name }}</p>
                                        <p class="m-0 h7 text-secondary">{{ "@".$user->nickname }}</p>
                                    </div>
                                </div>
                            </a>
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
                                        <button type="submit" id="profile-edit-button" class="btn border dark-grey">{{ __('app.button.edit_profile') }}</button>
                                    </form>
                                @else
                                    @if($user->follow_status === "active")
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn border" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"><i class="fa fa-check mr-2"></i><span class="dark-grey">{{ __('app.button.following') }}</span></button>
                                    @else
                                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}"><span class="">{{ __('app.button.follow') }}</span></button>
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
