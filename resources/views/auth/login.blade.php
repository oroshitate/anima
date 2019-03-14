@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.auth.login') }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-md-8 my-5">
            <div class="mb-4 text-center">
                <p>{{ __('app.sentence.auth.login') }}</p>
            </div>
            <div class="box-social-twitter my-3 col-12 rounded mx-auto p-0">
                <a class="btn d-block"  href="login/twitter">
                    <span class="fab fa-twitter text-white"></span>
                    <span class="text-white">{{ __('app.button.auth.twitter') }}</span>
                </a>
            </div>
            <div class="box-social-facebook my-3 col-12 rounded mx-auto p-0">
              <a class="btn d-block" href="login/facebook">
                  <span class="fab fa-facebook text-white"></span>
                  <span class="text-white">{{ __('app.button.auth.facebook') }}</span>
              </a>
            </div>
            <div class="box-social-google my-3 border border-secondary col-12 rounded mx-auto p-0">
                <a class="btn d-block"  href="login/google">
                    <span class="fab fa-google text-danger"></span>
                    <span class="text-secondary">{{ __('app.button.auth.google') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
