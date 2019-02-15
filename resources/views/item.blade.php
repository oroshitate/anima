@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>タイトル</p>
            <span class="mr-2">{{ $item->title }}</span><br>
            <img src="/storage/images/items/{{ $item->image }}.jpg"><br>

            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-url="{{ url()->current() }}" data-text="<!-- ここにTweetしたときにデフォルトでいれておきたい文字列を入れる -->" data-lang="ja">Tweet</a>
            <div class="line-it-button" data-lang="ja" data-type="share-a" data-ver="2" data-url="{{ url()->current() }}" style="display: none;"></div>
            <div class="fb-share-button" data-href="http://anima.com" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fanima.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">シェア</a></div>

            <p>シーズン</p>
            <span class="mr-2">{{ $item->season }}</span><br>
            <p>製作会社</p>
            <span class="mr-2">{{ $item->company }}</span><br>
            <p>あらすじ</p>
            <span class="mr-2">{{ $item->story }}</span><br>
            <p>キャスト</p>
            <span class="mr-2">{{ $item->cast }}</span><br>
            <p>スタッフ</p>
            <span class="mr-2">{{ $item->staff }}</span><br>
            <p>音楽</p>
            <span class="mr-2">{{ $item->music }}</span><br>
            <p>リンク</p>
            <span class="mr-2">{{ $item->link }}</span><br>
        </div>

        <ul id="reviews">
        @foreach($reviews as $review)
            <li>
                <a href="{{ route('review', ['review_id' => $review->review_id]) }}">
                    名前
                    <p>{{ $review->user_name }}</p>
                    画像
                    <img src="/storage/images/users/{{ $review->user_image }}"><br>
                    評価
                    <p>{{ $review->review_score }}</p>
                    コメント
                    <p>{{ $review->review_content }}</p>
                </a>
            </li>
        @endforeach
        </ul>

        @guest

        @else
            <form method="post" action="{{ url('/review/store') }}">
                @csrf
                <div id="slider"></div>
                <p id="slider-count"></p>
                <textarea name="content" rows="40" cols="50" placeholder="コメントが入力できます。"></textarea>
                <br>
                <input type="checkbox" name="share">ツイッターでシェアする
                <br>
                <input type="hidden" name="score">
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <button type="submit" id="review">レビューを投稿</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endguest
</div>
@endsection
