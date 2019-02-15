@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--
            タイムライン処理
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            -->
            <span class="mr-2">アニメ検索</span><br>
            <form name="search" method="post" action="{{ route('search', ['keyword' => '']) }}">
                @csrf
                <input type="text" name="keyword" class="form-control" value="">
                作品<input type="checkbox" name="filter[]" class="form-control" value="title">
                声優<input type="checkbox" name="filter[]" class="form-control" value="cast">
                ユーザー<input type="checkbox" name="filter[]" class="form-control" value="username">
                <button type="submit" id="search">検索</button>
            </form>
            <span class="mr-2">人気アニメ一覧</span><br>
            <ul id="items">
            @foreach($items as $item)
                <li>
                    <a href="{{ route('item', ['item_id' => $item->id]) }}">
                        <img src="/storage/images/items/{{ $item->image }}.jpg"><br>
                    </a>
                </li>
            @endforeach
            </ul>

            <button type="button" id="show-more">もっと表示する</button>
        </div>
    </div>
</div>
@endsection
