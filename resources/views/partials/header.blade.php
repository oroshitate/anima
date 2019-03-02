<nav class="navbar navbar-expand-md navbar-light bg-black border border-0">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            <img src="{{ asset('anima-logo.png') }}" width="170px" height="50px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li id="switch-search-button" class="nav-item btn py-md-2 px-md-4">
                    <i class="fas fa-search text-white fa-2x"></i>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white btn btn-success" href="{{ route('login') }}">登録・ログイン</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user', ['nickname' => Auth::user()->nickname ]) }}">
                            マイページ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('account') }}">
                            アカウント設定
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            ログアウト
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
    <div class="text-center py-md-2 text-white">
        <form name="search" method="post" action="{{ route('search', ['keyword' => '']) }}">
            @csrf
            <input type="text" name="keyword" class="d-inline w-50 mr-md-4 py-md-1 border border-0 rounded" value="{{ old('keyword') }}" placeholder="アニメ作品・ユーザーを検索">
            <button type="button" id="search-button"  class="btn btn-success ml-md-2">
                検索
            </button>
        </form>
    </div>
</div>
