@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.account.confirm') }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <div class="my-5">
                <div class="my-3">
                    <p class="h5">{{ __('app.sentence.account.confirm.1') }}</p>
                    <p class="h5">{{ __('app.sentence.account.confirm.2') }}</p>
                    <p class="h5">{{ __('app.sentence.account.confirm.3') }}</p>
                </div>

                <form method="post" action="{{ url('/account/setting/delete') }}">
                    <div class="form-group row my-4 justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ __('app.word.resign') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
