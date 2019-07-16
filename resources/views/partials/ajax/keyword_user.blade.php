@foreach($users as $user)
    <li class="border-bottom row justify-content-center no-gutters">
        <div class="align-top col-8 col-md-6 pl-0">
            <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                <div class="row align-items-center">
                        @if($user->image == null)
                            <img class="m-3 rounded-circle align-top profile" src="{{ asset('user_image.jpg') }}">
                        @else
                            <img class="m-3 rounded-circle align-top profile" src="{{ config('app.image_path') }}/users/{{ $user->image }}">
                        @endif
                    <div class="col-7 px-0 text-left">
                        <p class="h7 m-0 font-bold">{{ $user->name }}</p>
                        <p class="m-0 h7 text-secondary">{{ "@".$user->nickname }}</p>
                    </div>
                </div>
            </a>
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
                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}">{{ __('app.button.following') }}</button>
                    @else
                        <button type="button" id="follow-button-{{ $user->id }}" class="{{ $user->follow_status }} follow-button btn btn-outline-success" data-user_id="{{ $user->id }}" data-follow_id="{{ $user->follow_id }}">{{ __('app.button.follow') }}</button>
                    @endif
                @endif
            @endguest
        </div>
    </li>
@endforeach
