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
