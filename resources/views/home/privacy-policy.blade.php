@extends('layouts.main')

@section('title', 'Privacy Policy' . ' - ' . $setting->site_title )
@section('keyword', strip_tags(substr_replace($setting->privacy, strlen($setting->privacy) <= 500 ? "" : "...", 500)))
@section('description', strip_tags(substr_replace($setting->privacy, strlen($setting->privacy) <= 500 ? "" : "...", 500)))

@section('content')
    <div class="flex flex-col pb-10 pt-6 md:px-5 px-1 w-full blog-content ">
        <h1 class="title capitalize font-semibold text-gray-700 text-5xl mb-10">Privacy Policy</h1>
        <p>{!! ($setting->privacy) !!}</p>
    </div>
@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection