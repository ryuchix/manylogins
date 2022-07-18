@extends('layouts.main')

@section('title', 'Home - ' . $setting->site_title )

@section('style')
<link rel="stylesheet" href="{{ asset('css/home.css?t='.time()) }}">
@endsection

@php
    $randomColors = [
        '#8A6FC2',
        '#28B949',
        '#CDDF2D',
        '#B28533',
        '#B29BE0',
        '#0FE1FA',
        '#68E869',
        '#691151',
        '#B28533',
    ]
@endphp

@section('content')
    <section class="bg-bodybg px-4">
        <div class="w-full max-w-6xl mx-auto">
            <div class="flex flex-col justify-center items-center pt-28 pb-10 text-center">
                <h1 class="text-5xl font-bold text-darkblue mb-8">Effortlessly Access Login Pages</h1>

                <div class="font-light md:text-lg text-gray-500 text-base mb-8">
                    Allowing people to find and access login portals with the most optimized process.
                </div>

                <div class="pt-2 relative mx-auto text-gray-600 flex flex-wrap justify-between md:flex-row md:w-4/5 w-full" id="keyword_search">
                    <form method="POST" action="{{ route('search.post') }}" class="search-form flex flex-initial justify-between md:flex-row border-2 bg-white items-center rounded-md w-full group" id="search-keyword">
                        @csrf
                        <input id="typeahead" type="search" name="search" placeholder="Ex: Facebook Login..." required="required" class="typeahead w-full flex-1 h-12 md:h-10 px-4 rounded-none text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 group-focus:outline-none group-focus:placeholder-transparent group-focus:ring-0"> 
                        <input type="hidden" class="user_input" name="user_input">
                        <button id="submitBtn" type="submit" class="flex items-center justify-center text-white transition-colors duration-300 transform rounded-tr-md rounded-br-md h-12 w-16 lg:w-16 lg:h-12 lg:p-0 bg-darkblue hover:bg-darkblue/70 focus:outline-none focus:bg-darkblue/70">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="keywords-buttons mb-12">
                <ul class="top-sites-list justify-center grid justify-items-center grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-8 gap-2 lg:gap-2 mt-3 mb-10">
                    @php $shuff = shuffle($randomColors) @endphp
                    @foreach($popularSearch as $k => $keyword)
                    <li class="top-site-outer {{ $k == 8 ? 'md:hidden' : '' }}">
                        <div class="top-site-inner">
                            <a class="top-site-button" href="{{ route('search', $keyword->slug) }}" tabindex="0" draggable="true">
                                <div class="tile" aria-hidden="true">
                                    <div class="icon-wrapper letter-fallback" data-fallback="{{ $keyword->keywords[0] ?? '' }}" style="background-color: {{ $randomColors[$k] ?? '' }};">
                                    <div class=""></div>
                                    </div>
                                </div>
                                <div class="title">
                                    <a href="{{ route('search', $keyword->slug) }}">
                                        <span dir="auto" class=" break-words capitalize text-sm">{{ $keyword->keywords }}</span>
                                    </a>
                                </div>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="login-guides">
                <div class="flex space-x-4 items-end">
                    <h3 class="text-3xl font-semibold text-gray-700">Login Guides</h3>
                    <a href="{{ route('blog.lists') }}" class="text-blue-500 hover:text-blue-600 mb-1 text-sm">View all</a>
                </div>
                <div class="grid justify-center md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 gap-5 lg:gap-7 mt-3 pb-10">
                    @foreach($posts as $blog)
                    <div class="article h-full rounded-md shadow-cla-pink bg-white overflow-hidden">
                        <img class="lg:h-42 md:h-28 w-full object-cover object-centertransition-all duration-400" src="{{ asset($blog->cover) }}" alt="{{ $blog->title }}">
                        <div class="px-4 py-4">
                            <h1 class="title-font text-base font-medium mb-1 line-clamp-none md:line-clamp-2"><a href="{{ route('show.blog', ['blog' => $blog->slug]) }}" class="block text-xl text-link hover:text-opacity-80">{{ $blog->title }}</a></h1>
                            <div class="leading-relaxed mb-3 text-gray-500 text-sm">{!! substr_replace(strip_tags($blog->content), strlen($blog->content) <= 100 ? "" : "...", 100); !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>

@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection