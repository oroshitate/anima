@extends('layouts.app')

@section('title')
<title>Anima | アカウント設定</title>
@endsection

@section('script')
<script src="{{ asset('js/account.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="list-unstyled my-md-5">
                <li class="py-md-2 border-bottom">
                    <form name="link-twitter" action="{{ url('login/twitter') }}" method="get">
                        @csrf
                        <div class="form-group row my-md-4 justify-content-center">
                            <img class="rounded social-icon" src="{{ asset('twitter_icon.png') }}">
                            <span class="h4 ml-md-2 mr-md-4">Twitter</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $twitter }}">
                            <div class="custom-control custom-switch">
                                @if($linked_count == 1 && $twitter == "off")
                                    <span>連携済み</span>
                                @elseif($linked_count > 1 && $twitter == "off")
                                    <input type="checkbox" class="custom-control-input" id="link-twitter" checked>
                                    <label class="custom-control-label" for="link-twitter">
                                        連携解除
                                    </label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="link-twitter">
                                    <label class="custom-control-label" for="link-twitter">
                                        未連携
                                    </label>
                                @endif
                            </div>
                        </div>
                    </form>
                </li>

                <li class="py-md-2 border-bottom">
                    <form name="link-facebook" action="{{ url('login/facebook') }}" method="get">
                      @csrf
                        <div class="form-group row my-md-4 justify-content-center">
                            <img class="rounded social-icon"src="{{ asset('facebook_icon.jpg') }}">
                            <span class="h4 ml-md-2 mr-md-4">Facebook</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $facebook }}">
                            <div class="custom-control custom-switch">
                                @if($linked_count == 1 && $facebook == "off")
                                    <span>連携済み</span>
                                @elseif($linked_count > 1 && $facebook == "off")
                                    <input type="checkbox" class="custom-control-input" id="link-facebook" checked>
                                    <label class="custom-control-label" for="link-facebook">
                                        連携解除
                                    </label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="link-facebook">
                                    <label class="custom-control-label" for="link-facebook">
                                        未連携
                                    </label>
                                @endif
                            </div>
                        </div>
                    </form>
                </li>

                <li class="py-md-2 border-bottom">
                    <form name="link-google" action="{{ url('login/google') }}" method="get">
                        @csrf
                        <div class="form-group row my-md-4 justify-content-center">
                            <img class="rounded social-icon"src="{{ asset('google_icon.jpg') }}">
                            <span class="h4 ml-md-2 mr-md-4">Google</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $google }}">
                                @if($linked_count == 1 && $google == "off")
                                    <span>連携済み</span>
                                @elseif($linked_count > 1 && $google == "off")
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="link-google" checked>
                                        <label class="custom-control-label" for="link-google">
                                            連携解除
                                        </label>
                                    </div>
                                @else
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="link-google">
                                        <label class="custom-control-label" for="link-google">
                                            未連携
                                        </label>
                                    </div>
                                @endif
                        </div>
                    </form>
                </li>

                <li class="py-md-2 border-bottom">
                    <form action="{{ route('logout') }}" method="post">
                        <div class="form-group row my-md-4 justify-content-center cursor-pointer">
                            @csrf
                            <label class="h5">ログアウト</label>
                        </div>
                    </form>
                </li>

                <li class="py-md-2 border-bottom cursor-pointer">
                    <div class="form-group row my-md-4 justify-content-center cursor-pointer">
                        <a href="{{ url('/account/setting/confirm') }}" >
                            <label class="h5">退会する</label>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
