@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span class="mr-2">{{ $user->name }}</span><br>
            <span class="mr-2">{{ $user->nickname }}</span><br>
            <img src="/storage/images/users/{{ $user->image }}"><br>
        </div>
    </div>
</div>
@endsection
