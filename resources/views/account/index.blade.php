@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.account.index') }}</title>
@endsection

@section('script')
<script src="{{ asset('js/account.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-md-8">
            <ul class="list-unstyled my-5">
                <li class="py-2 border-bottom">
                    <form name="link-twitter" action="{{ url('login/twitter') }}" method="get">
                        @csrf
                        <div class="form-group row my-4 justify-content-center">
                            <img class="rounded social-icon" src="{{ asset('twitter_icon.png') }}">
                            <span class="h5 ml-2 mr-4">{{ __('app.word.twitter') }}</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $twitter }}">
                            <div class="custom-control custom-switch">
                                @if($linked_count == 1 && $twitter == "off")
                                    <span>{{ __('app.word.account.linked') }}</span>
                                @elseif($linked_count > 1 && $twitter == "off")
                                    <input type="checkbox" class="custom-control-input" id="link-twitter" checked>
                                    <label class="custom-control-label" for="link-twitter">
                                        {{ __('app.word.account.unlinked') }}
                                    </label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="link-twitter">
                                    <label class="custom-control-label" for="link-twitter">
                                        {{ __('app.word.account.link') }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </form>
                </li>

                <li class="py-2 border-bottom">
                    <form name="link-facebook" action="{{ url('login/facebook') }}" method="get">
                      @csrf
                        <div class="form-group row my-4 justify-content-center">
                            <img class="rounded social-icon"src="{{ asset('facebook_icon.jpg') }}">
                            <span class="h5 ml-2 mr-4">{{ __('app.word.facebook') }}</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $facebook }}">
                            <div class="custom-control custom-switch">
                                @if($linked_count == 1 && $facebook == "off")
                                    <span>{{ __('app.word.account.linked') }}</span>
                                @elseif($linked_count > 1 && $facebook == "off")
                                    <input type="checkbox" class="custom-control-input" id="link-facebook" checked>
                                    <label class="custom-control-label" for="link-facebook">
                                        {{ __('app.word.account.unlinked') }}
                                    </label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="link-facebook">
                                    <label class="custom-control-label" for="link-facebook">
                                        {{ __('app.word.account.link') }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </form>
                </li>

                <li class="py-2 border-bottom">
                    <form name="link-google" action="{{ url('login/google') }}" method="get">
                        @csrf
                        <div class="form-group row my-4 justify-content-center">
                            <img class="rounded social-icon"src="{{ asset('google_icon.jpg') }}">
                            <span class="h5 ml-2 mr-4">{{ __('app.word.google') }}</span>
                            <input type="hidden" name="case[]" value="link">
                            <input type="hidden" name="link[]" value="{{ $google }}">
                            <div class="custom-control custom-switch">
                                @if($linked_count == 1 && $google == "off")
                                    <span>{{ __('app.word.account.linked') }}</span>
                                @elseif($linked_count > 1 && $google == "off")
                                    <input type="checkbox" class="custom-control-input" id="link-google" checked>
                                    <label class="custom-control-label" for="link-google">
                                        {{ __('app.word.account.unlinked') }}
                                    </label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="link-google">
                                    <label class="custom-control-label" for="link-google">
                                        {{ __('app.word.account.link') }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </form>
                </li>

                <li class="py-2 border-bottom">
                    <form action="{{ route('logout') }}" method="post">
                        <div class="form-group row my-4 justify-content-center cursor-pointer">
                            @csrf
                            <label class="h5">{{ __('app.word.logout') }}</label>
                        </div>
                    </form>
                </li>

                <li class="py-2 border-bottom cursor-pointer">
                    <div class="form-group row my-4 justify-content-center cursor-pointer">
                        <a href="{{ url('/account/setting/confirm') }}" >
                            <label class="h5">{{ __('app.word.resign') }}</label>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
