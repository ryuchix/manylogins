<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <meta name="keyword" content="@yield('keyword')">
        <meta name="description" content="@yield('description')">

        <meta name="msapplication-TileColor" content="#123f6e">
        <meta name="theme-color" content="#123f6e">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @yield('styles')
    </head>
    
    <body onunload=""> 
        <div class="main">
            @include('partials.header')
            @yield('content')
            @include('partials.footer')
        </div>   

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        @yield('script')
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    </body>
</html>