@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('app.login') }}</div>

                <div class="card-body">
                  <a class="btn btn-block btn-social btn-twitter"  href="login/twitter">
                    <span class="fa fa-twitter"></span> Sign in with Twitter
                  </a>
                  <a class="btn btn-block btn-social btn-facebook" href="login/facebook">
                    <span class="fa fa-facebook"></span> Sign in with Facebook
                  </a>
                  <a class="btn btn-block btn-social btn-google"  href="login/google">
                    <span class="fa fa-google"></span> Sign in with Google
                  </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
