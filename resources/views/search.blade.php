@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span class="mr-2">アニメ検索</span><br>
            <form name="search" method="post" action="{{ route('search', ['keyword' => '']) }}">
                @csrf
                <input type="text" name="keyword" class="form-control" value="{{ $keyword }}">
                作品<input type="checkbox" name="filter[]" class="form-control" value="title">
                声優<input type="checkbox" name="filter[]" class="form-control" value="cast">
                ユーザー<input type="checkbox" name="filter[]" class="form-control" value="username">
                <button type="submit" id="search">検索</button>
            </form>
            @if($filter != "username")
                @foreach($items as $item)
                    <a href="{{ route('item', ['item_id' => $item->id]) }}">
                        <img src="/storage/images/items/{{ $item->image }}.jpg"><br>
                    </a>
                @endforeach
            @else
                @foreach($users as $user)
                    <a href="{{ route('user', ['nickname' => $user->nickname]) }}">
                        <img src="/storage/images/users/{{ $user->image }}"><br>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
