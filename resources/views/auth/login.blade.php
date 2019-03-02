@extends('layouts.app')

@section('title')
<title>Anima | 登録・ログイン</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-md-5">
            <div class="my-md-2 text-center">
                <p>お使いのSNSアカウントを使って<br>登録・ログインができます。</p>
            </div>
            <div class="box-social-twitter my-md-3 w-50 rounded mx-auto">
                <a class="btn d-block"  href="login/twitter">
                    <span class="fab fa-twitter text-white"></span>
                    <span class="text-white">Twitterで登録・ログイン</span>
                </a>
            </div>
            <div class="box-social-facebook my-md-3 w-50 rounded mx-auto">
              <a class="btn d-block" href="login/facebook">
                  <span class="fab fa-facebook text-white"></span>
                  <span class="text-white">Facebookで登録・ログイン</span>
              </a>
            </div>
            <div class="box-social-google my-md-3 border border-secondary w-50 rounded mx-auto">
                <a class="btn d-block"  href="login/google">
                    <span class="fab fa-google text-danger"></span>
                    <span class="text-secondary">Googleで登録・ログイン</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
