@extends('layouts.app')

@section('title')
<title>Anima | {{ __('error.title.403') }}</title>
@endsection

@section('content')
<div class="container h-100 w-100">
    <div class="row justify-content-center my-4">
        <div class="col-10 col-md-8 text-center my-4">
            <div class="border border-dark rounded p-4">
                <p class="h4 mb-0">{{ __('error.sentence.403.1') }}</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('anima-logo-black.png') }}" width="680px" height="240px">
            </div>
        </div>
    </div>
</div>
@endsection
