<nav class="navbar navbar-expand-md navbar-light bg-black border border-0">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            <img src="{{ asset('anima-logo.png') }}" width="136px" height="40px">
        </a>
        <div class="ml-auto row align-items-center">
            <div class="d-sm-none switch-search-button">
                <i class="fas fa-search text-white fa-2x"></i>
            </div>
            @guest
                <div class="mx-3 d-sm-none">
                    <a class="text-white btn btn-success" href="{{ route('login') }}">{{ __('app.button.register_login') }}</a>
                </div>
            @endguest
        </div>

        @auth
            <button class="navbar-toggler d-sm-none ml-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        @endauth

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item btn py-2 px-4 d-none d-md-block switch-search-button">
                    <i class="fas fa-search text-white fa-2x"></i>
                </li>
                @guest
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link text-white btn btn-success" href="{{ route('login') }}">{{ __('app.button.register_login') }}</a>
                    </li>
                @else
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
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div id="search-box" class="bg-secondary" style="display:none">
    <div class="text-center py-2 text-white">
        <form name="search" method="post" action="{{ route('search', ['keyword' => '']) }}">
            @csrf
            <input type="text" name="keyword" class="d-inline w-75 py-1 border border-0 rounded" value="{{ old('keyword') }}" placeholder="{{ __('app.label.search.placeholder') }}">
            <button type="button" id="search-button"  class="btn btn-success ml-2">
                {{ __('app.button.search') }}
            </button>
        </form>
    </div>
</div>
<div id="ad-box" class="bg-danger my-4" style="display:none; height:100px;">
</div>
