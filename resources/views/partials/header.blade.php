<nav class="navbar navbar-expand-md navbar-light bg-black border border-0 p-0">
    <div class="container py-2">
        <a class="navbar-brand text-white p-0" href="{{ url('/') }}">
            <img src="{{ asset('anima-logo.png') }}" width="115px" height="32px">
        </a>
        @guest
            <div class="row align-items-center col-6 m-0 pr-0">
                <div class="mx-3 d-sm-none">
                    <a class="header-register-login text-white btn btn-success font-bold px-0" href="{{ route('login') }}">{{ __('app.button.register_login') }}</a>
                </div>
                <div class="d-sm-none switch-search-button">
                    <img src="{{ asset('search.png') }}" class="header-icon header-search float-right">
                </div>
            </div>
        @else
            <div class="d-sm-none switch-search-button" style="width:35%">
                <img src="{{ asset('search.png') }}" class="header-icon header-search float-right">
            </div>
            <div class="d-sm-none text-center" style="width:10%; position:relative;">
                <a class="notifications-link">
                    <img src="{{ asset('noti.png') }}" class="header-icon">
                </a>
                @if(Session::get('notifications_count') != 0)
                    <span class="text-white bg-success rounded text-center" style="position: absolute;top: 0;right: 0;width: 17px;font-size: 0.75rem;height: 17px;">{{ Session::get('notifications_count') }}</span>
                @endif
            </div>
            <button class="navbar-toggler d-sm-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        @endguest

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-center">
                @guest
                    <li class="nav-item d-none d-md-block">
                        <a class="header-register-login text-white btn btn-success font-bold" href="{{ route('login') }}">{{ __('app.button.register_login') }}</a>
                    </li>
                @endguest
                <li class="nav-item btn py-0 px-2 d-none d-md-block switch-search-button">
                    <img src="{{ asset('search.png') }}" class="header-icon header-search">
                </li>
                @auth
                    <li class="nav-item btn py-0 px-2 d-none d-md-block" style="position: relative;">
                        <a class="notifications-link">
                            <img src="{{ asset('noti.png') }}" class="header-icon">
                        </a>
                        @if(Session::get('notifications_count') != 0)
                            <span class="text-white bg-success rounded" style="position: absolute;top: 0;right: 0;width: 17px;font-size: 0.75rem;height: 17px;">{{ Session::get('notifications_count') }}</span>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user', ['nickname' => Auth::user()->nickname ]) }}">
                            {{ __('app.word.mypage') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('account') }}">
                            {{ __('app.word.setting') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('app.word.logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div id="search-box" class="bg-secondary" style="display:none">
    <div class="text-center py-2 text-white">
        <form name="search" method="post" action="{{ route('search', ['keyword' => '']) }}">
            @csrf
            <input type="text" name="keyword" class="d-inline border border-0 rounded" value="{{ old('keyword') }}" placeholder="{{ __('app.label.search.placeholder') }}">
            <button type="button" id="search-button">
                <i class="fas fa-search text-grey header-search"></i>
            </button>
        </form>
    </div>
</div>
<div id="ad-box" class="bg-danger my-4" style="display:none; height:100px;">
</div>
