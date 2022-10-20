@extends('layouts.main')

@section('title', $blog->title . ' - ' . $setting->site_title)
@section('keyword', $blog->title)
@section('description', substr_replace($blog->content, strlen($blog->content) <= 200 ? "" : "...", 200) )
@section('cover', asset($blog->cover) )

@section('style')
<link rel="stylesheet" href="{{ asset('css/blog.css?t='.time()) }}">
@endsection

@section('content')
<div class="flex flex-col pb-10 pt-6 md:px-5 px-1 w-full blog-content ">
    <h1 class="title capitalize font-semibold text-gray-700">
        {{ $blog->title }}
    </h1>
    <div class="meta">
        <div class="__user flex space-x-2 items-center">
            @if (!empty($blog->user->image))
            <img class="w-8 h-8 rounded-md object-cover" src="{{ asset('images/users/'. $blog->user->image) }}" alt="Author">
            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            @endif
            <div class="font-semibold text-gray-500">
                by {{ $blog->user->name }}
            </div>
            <span>-</span>
            <div class="flex space-x-1 text-gray-500 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                @php $date = date_create($blog->created_at); @endphp
                <span>{{ date_format($date,"M d, Y") }}</span>
            </div>
        </div>
    </div>
    <div class="w-full mt-4">
        <img class="w-full object-cover" src="{{ asset($blog->cover) }}" alt="{{ $blog->title }}">
    </div>
    <div class="w-full mt-4 text-gray-700">
        {!! ($blog->content) !!}
    </div>

    <div class="border-t border-b border-gray-200 py-5 flex lg:flex-row lg:space-y-0 space-y-2 flex-col justify-between">
        <div class="flex space-x-2 items-center">
            <span class="text-base text-gray-400 font-semibold">Categories </span>
            <div class="flex">
                @foreach ($blog->categories as $cat)
                <div class="text-xs mr-2 py-1.5 px-4 text-gray-200 bg-[#718096] rounded-2xl hover:text-white hover:bg-link cursor-pointer">
                    {{ $cat->name }}
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex space-x-2 items-center">
            <div class="flex">
                @include('components.share')
            </div>
        </div>
    </div>

    @if (count($related) > 0)
    <div class="related-posts mt-10 ">
        <div class="text-lg text-link">
            Related Post
        </div>
        <div class="text-xl text-gray-700 py-3">
            YOU MAY ALSO LIKE
        </div>

        <div class="related-lists">

            <div class="grid justify-center md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-7 mt-3 mb-10">
                @foreach($related as $post)
                <div class="article h-full rounded-md shadow-cla-pink bg-bodybg overflow-hidden">
                    <img class="lg:h-42 md:h-28 w-full object-cover object-centertransition-all duration-400" src="{{ asset($post->cover) }}" alt="{{ $post->title }}">
                    <div class="px-4 py-4">
                        <h1 class="title-font text-base font-medium mb-1 line-clamp-none md:line-clamp-2"><a href="{{ route('show.blog', ['blog' => $post->slug]) }}" class="block text-xl text-link hover:text-opacity-80">{{ $post->title }}</a></h1>
                        <div class="leading-relaxed mb-3 text-gray-500 text-sm">{!! substr_replace(strip_tags($post->content), strlen($post->content) <= 100 ? "" : "...", 100); !!}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection