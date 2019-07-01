@extends('layouts.app')

@section('title')
<title>Anima | {{ __('app.title.user.notifications') }}</title>
<meta property="og:title" content="Anima | {{ __('app.title.user.notifications') }}">
@endsection

@section('script')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-4 m-3">
            <p class="font-bold">通知</p>
            @if(count($notifications) > 0)
                <ul class="list-unstyled mb-5">
                    @foreach($notifications as $notification)
                        <li class="py-2">
                            @if($notification->type != "follow")
                                <a href="{{ route('review', ['review_id' => $notification->review_id]) }}">
                                    <div class="row justify-content-start align-items-center no-gutters">
                                        @if($notification->type == "like")
                                            <div class="col-1">
                                                <i class="far fa-heart fa-2x"></i>
                                            </div>
                                            <div class="col-2 text-center">
                                                @if($notification->user->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="rounded-circle profile">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/users/{{ $notification->user->image }}" class="rounded-circle profile">
                                                @endif
                                            </div>
                                            <div class="col-9">
                                                <span>{{ __('app.sentence.user.notification.like',  ['user' => $notification->user->name ]) }}</span>
                                            </div>
                                            <div class="col-12 text-right">
                                                @if($notification->item->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="w-25">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/items/{{ $notification->item->image }}" class="w-25">
                                                @endif
                                            </div>
                                        @elseif($notification->type =="like-comment")
                                            <div class="col-1">
                                                <i class="far fa-heart fa-2x"></i>
                                            </div>
                                            <div class="col-2 text-center">
                                                @if($notification->user->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="rounded-circle profile">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/users/{{ $notification->user->image }}" class="rounded-circle profile">
                                                @endif
                                            </div>
                                            <div class="col-9">
                                                <span>{{ __('app.sentence.user.notification.like-comment',  ['user' => $notification->user->name ]) }}</span>
                                            </div>
                                            <div class="col-12 text-right">
                                                @if($notification->item->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="w-25">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/items/{{ $notification->item->image }}" class="w-25">
                                                @endif
                                            </div>
                                        @elseif($notification->type == "comment")
                                            <div class="col-1">
                                                <i class="far fa-comment fa-2x"></i>
                                            </div>
                                            <div class="col-2 text-center">
                                                @if($notification->user->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="rounded-circle profile">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/users/{{ $notification->user->image }}" class="rounded-circle profile">
                                                @endif
                                            </div>
                                            <div class="col-9">
                                                <span>{{ __('app.sentence.user.notification.comment',  ['user' => $notification->user->name]) }}</span>
                                            </div>
                                            <div class="col-12 text-right">
                                                @if($notification->item->image == null)
                                                    <img src="{{ asset('anima-img.png') }}" class="w-25">
                                                @else
                                                    <img src="{{ config('app.image_path') }}/items/{{ $notification->item->image }}" class="w-25">
                                                @endif
                                            </div>
                                        @endif
                                      </div>
                                </a>
                            @else
                                <a href="{{ route('user', ['nickname' => $notification->user->nickname]) }}">
                                    <div class="row justify-content-start align-items-center no-gutters">
                                        <div class="col-1">
                                            <i class="far fa-user fa-2x"></i>
                                        </div>
                                        <div class="col-2 text-center">
                                            @if($notification->user->image == null)
                                                <img src="{{ asset('anima-img.png') }}" class="rounded-circle profile">
                                            @else
                                                <img src="{{ config('app.image_path') }}/users/{{ $notification->user->image }}" class="rounded-circle profile">
                                            @endif
                                        </div>
                                        <div class="col-9">
                                            <span>{{ __('app.sentence.user.notification.follow',  ['user' => $notification->user->name]) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center my-5">{{ __('app.sentence.user.notification.none') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
