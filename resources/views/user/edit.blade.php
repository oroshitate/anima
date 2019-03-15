@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.user.edit') }}</title>
@endsection

@section('script')
<script src="{{ asset('js/mypage.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <form method="POST" action="{{ url('/mypage/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row my-4 justify-content-center">
                    <div class="col-12 col-md-10 text-center">
                        @if($user->image == null)
                            <img id="user-image" class="rounded-circle profile-lg" src="{{ asset('no-image.jpg') }}">
                        @else
                            <img id="user-image" class="rounded-circle profile-lg" src="{{ config('app.image_path') }}/users/{{ $user->image }}">
                        @endif

                        <label class="my-2">
                            <span class="btn btn-secondary w-100">
                                {{ __('app.button.change') }}
                                <input type="file" name="image" id="upload-image" style="display:none">
                            </span>
                        </label>

                        @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group text-left">
                    <div class="col-12 col-md-10 mx-auto">
                        <label for="nickname" class="h5">{{ __('app.label.auth_user.nickname') }}{{ __('app.label.20_words') }}</label>
                        <p>{{ __('app.sentence.user.cannot_edit') }}</p>
                    </div>
                    <div class="col-12 col-md-10 mx-auto">
                        <input id="nickname" type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" value="{{ $user->nickname }}" readonly>

                        @if ($errors->has('nickname'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nickname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group text-left">
                    <div class="col-12 col-md-10 mx-auto">
                        <label for="name" class="h5">{{ __('app.label.auth_user.user_name') }}{{ __('app.label.20_words') }}</label><span class="text-danger">{{ __('app.word.user.necessary') }}</span>
                    </div>
                    <div class="col-12 col-md-10 mx-auto">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group text-left">
                    <div class="col-12 col-md-10 mx-auto">
                        <label for="content" class="h5">{{ __('app.label.auth_user.content') }}{{ __('app.label.300_words') }}</label><span class="text-secondary">{{ __('app.word.user.any') }}</span>
                    </div>
                    <div class="col-12 col-md-10 mx-auto">
                        <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" rows="10" cols="30">{{ $user->content }}</textarea>

                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-6 mx-auto text-center">
                        <button type="submit" id="edit-user-button" class="btn btn-success">{{ __('app.button.user.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
