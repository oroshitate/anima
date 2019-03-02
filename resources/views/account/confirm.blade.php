@extends('layouts.app')

@section('title')
<title>Anima | 退会確認</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="my-md-5">
                <div class="my-md-3">
                    <p class="h5">本当にAnimaを退会してもよろしいですか？</p>
                    <p class="h5">これまでのレビュー記録やコメントが全て削除される可能性があります。</p>
                    <p class="h5">また、再度ご登録される際の復元は保証いたしません。</p>
                </div>

                <form method="post" action="{{ url('/account/setting/delete') }}">
                    <div class="form-group row my-md-4 justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
