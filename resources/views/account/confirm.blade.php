@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.account.confirm') }}</title>
<meta property="og:title" content="Anima | {{ __('app.title.account.confirm') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="my-3">
                <div class="text-center">
                    <p class="h5-5">{{ __('app.sentence.account.confirm.1') }}</p>
                    <p class="h5-5">{{ __('app.sentence.account.confirm.2') }}</p>
                    <p class="h5-5">{{ __('app.sentence.account.confirm.3') }}</p>
                </div>

                <form method="post" action="{{ url('/account/setting/delete') }}">
                    <div class="form-group row my-4 justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">{{ __('app.word.resign') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
