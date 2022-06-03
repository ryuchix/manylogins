<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', $setting->site_title)</title>
        <meta name="keyword" content="@yield('keyword', $setting->site_keywords)">
        <meta name="description" content="@yield('description', $setting->site_description)">

        <meta property="og:title" content="@yield('title', $setting->site_title)" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ \URL::current() }}" />
        <meta property="og:image" content="@yield('cover', asset('images/settings/'.$setting->footer_logo))" />
        <meta property="og:image:alt" content="{{ $setting->site_title }}" />
        <meta property="og:description" content="@yield('description', $setting->site_description)" />
        <meta property="og:locale" content="en_GB" />

        <link rel="stylesheet" href="{{ asset('css/app.css?t='.time()) }}">

        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons') }}/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons') }}/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons') }}/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons') }}/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons') }}/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons') }}/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons') }}/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons') }}/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons') }}/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons') }}/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons') }}/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons') }}/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons') }}/favicon-16x16.png">
        <link rel="manifest" href="{{ asset('favicons') }}/manifest.json">
        <meta name="msapplication-TileColor" content="#0b2239">
        <meta name="msapplication-TileImage" content="{{ asset('favicons') }}/ms-icon-144x144.png">
        <meta name="theme-color" content="#0b2239">

        @yield('style')

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FWKMCV9J8S"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FWKMCV9J8S');
        </script>

        <!-- Google ads -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1168128372434984" crossorigin="anonymous"></script>
    </head>
    
    <body onunload=""> 
        <div class="wrapper">
            @include('partials.header')
            @if (\Request::route()->getName() == 'home')
            @yield('content')
            @else
            <div class="main flex mx-auto w-full justify-between max-w-8xl mx-auto lg:flex-row flex-col max-w-full">
                @include('home.left')
                <main class="content bg-bodybg order-1 lg:order-2 px-2 w-full">
                    @yield('content')
                </main>
                @include('home.right')
            </div>
            @endif
            @include('partials.footer')
        </div>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        @yield('script')
        <script src="{{ asset('js/script.js?t='.time()) }}"></script>
        <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    </body>
</html>