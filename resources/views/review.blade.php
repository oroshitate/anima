@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('user', ['nickname' => $review[0]->user_nickname]) }}">
                名前
                <p>{{ $review[0]->user_name }}</p>
                画像
                <img src="/storage/images/users/{{ $review[0]->user_image }}"><br>
            </a>
            評価
            <p>{{ $review[0]->review_score }}</p>
            コメント
            <p>{{ $review[0]->review_content }}</p>
        </div>

        <ul id="comments">
            @foreach($comments as $comment)
                <li>
                    <a href="{{ route('user', ['nickname' => $comment->user_nickname]) }}">
                        名前
                        <p>{{ $comment->user_name }}</p>
                        画像
                        <img src="/storage/images/users/{{ $comment->user_image }}"><br>
                    </a>
                    コメント
                    <p>{{ $comment->comment_score }}</p>
                </li>
            @endforeach
        </ul>

        <form method="post" action="{{ url('comment/store') }}">
            @csrf
            <textarea name="content" rows="10" cols="50" placeholder="コメントが入力できます。"></textarea>
            <input type="hidden" name="review_id" value="{{ $review[0]->review_id }}">
            <button type="submit" id="comment">コメント</button>
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
</div>
@endsection
