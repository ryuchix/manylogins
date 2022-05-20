@extends('layouts.main')

@section('title', 'Blog Lists' . ' - ' . $setting->site_title)
@section('keyword', 'Blog list, Many Login blogs, Manylogin posts, Read blog at Many Login')
@section('description', substr_replace('Read articles and blogs provided by Many Logins. Get motivated and learn tips, hacks from the expert', strlen('Read articles and blogs provided by Many Logins. Get motivated and learn tips, hacks from the expert') <= 200 ? "" : "...", 200) )

@section('style')
<link rel="stylesheet" href="{{ asset('css/blog.css?t='.time()) }}">
@endsection

@section('content')
<div class="flex flex-col pb-10 pt-6 md:px-5 px-1 w-full blog-content ">
    <h1 class="title capitalize font-semibold text-gray-700">
        Guides
    </h1>
    <div class="grid justify-center md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-5 lg:gap-7 mt-3 mb-10">
        @foreach($blogs as $blog)
        <div class="article h-full rounded-md shadow-cla-pink bg-gradient-to-r from-fuchsia-50 to-pink-50 overflow-hidden">
            <img class="lg:h-42 md:h-28 w-full object-cover object-centertransition-all duration-400" src="{{ asset('images/posts/'.$blog->cover) }}" alt="{{ $blog->title }}">
            <div class="px-4 py-4">
                <h1 class="title-font text-base font-medium mb-1 line-clamp-none md:line-clamp-2"><a href="{{ route('show.blog', ['blog' => $blog->slug]) }}" class="block text-xl text-link hover:text-opacity-80">{{ $blog->title }}</a></h1>
                <div class="leading-relaxed mb-3 text-gray-500 text-sm">{!! substr_replace(strip_tags($blog->content), strlen($blog->content) <= 100 ? "" : "...", 100); !!}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $blogs->links('vendor.pagination.simple-tailwind') }}
</div>
@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection