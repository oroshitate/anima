<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!-- OGP -->
        <meta property="og:site_name" content="Anima">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        @if(str_contains(request()->fullUrl(), 'item'))
            <meta name="description" content="{{ __('app.sentence.home.guest.2') }}">
            <meta property="og:description" content="{{ __('app.sentence.home.guest.2') }}">
            @if($item->image == null)
                <meta property="og:image" content="{{ asset('anima-img.png') }}">
            @else
                <meta property="og:image" content="{{ config('app.image_path') }}/items/{{ $item->image }}">
            @endif
        @elseif(str_contains(request()->fullUrl(), 'review'))
            <meta name="description" content="{{ $review[0]->review_content }}">
            <meta property="og:description" content="{{ $review[0]->review_content }}">
            @if($item->image == null)
                <meta property="og:image" content="{{ asset('anima-img.png') }}">
            @else
                <meta property="og:image" content="{{ config('app.image_path') }}/items/{{ $item->image }}">
            @endif
        @elseif(str_contains(request()->fullUrl(), 'user') && !str_contains(request()->fullUrl(), 'follow'))
            <meta name="description" content="{{ $user->content }}">
            <meta property="og:description" content="{{ $user->content }}">
            @if($user->image == null)
                <meta property="og:image" content="{{ asset('no-image.jpg') }}">
            @else
                <meta property="og:image" content="{{ config('app.image_path') }}/users/{{ $user->image }}">
            @endif
        @else
            <meta name="description" content="{{ __('app.sentence.home.guest.2') }}">
            <meta property="og:description" content="{{ __('app.sentence.home.guest.2') }}">
            <meta property="og:image" content="{{ asset('anima-img.png') }}">
        @endif
        <meta property="og:locale" content="ja_JP">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@Anima65551958">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/partials/header.css') }}" rel="stylesheet">

    <!-- Google Tag Manager -->
    @if(App::environment() == 'production')
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MKG4R2V');</script>
        <!-- End Google Tag Manager -->

        <!-- Adsense -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-8913763404323126",
            enable_page_level_ads: true
          });
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135090666-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-135090666-1');
        </script>
    @endif

    <!-- slider -->
  	<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.min.css" />
  	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" defer></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js' defer></script>

    <!-- Script variable -->
    <script>
        var minutes = "{{ __('app.word.minutes') }}";
        var hours = "{{ __('app.word.hours') }}";
        var days = "{{ __('app.word.days') }}";
        var show_more = "{{ __('app.button.show_more') }}";
        var count_word = "{{ __('app.word.count') }}";
    </script>
    @if(App::environment() == 'production')
    <script>var base_url = "https://www.anima.fan";</script>
    @else
    <script>var base_url = "http://localhost:8080";</script>
    @endif
    @yield('script')
    @yield('stylesheet')
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKG4R2V"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
    </div>
</body>
</html>
