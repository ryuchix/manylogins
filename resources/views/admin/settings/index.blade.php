@extends('layouts.admin')

@section('title', 'Manage Settings')

@section('style')
<style>
    h1 {
        font-size: 3rem;
        line-height: 1;
    }

    h2 {
        font-size: 2.25rem;
        line-height: 2.5rem;
    }

    h3 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    h4 {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    
    p {
        font-size: 1rem;
        line-height: 1.5rem;
        margin-bottom: 15px;
    }
</style>
@endsection
@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 dark:bg-gray-700 flex flex-col bg-gray-100 font-sans overflow-hidden px-4 md:px-10">
        <div class="mt-6 w-full justify-start items-center flex text-xl">
            <span>Settings</span>
        </div>

        <div class="bg-white mt-5 p-8 rounded-md">
            <form method="POST" action="{{ route('settings.update', $setting->id) }}" x-data="{status: '0'}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                @include('admin.partials.session-message')

                <!-- Title -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="site_title">
                        Site title
                    </label>

                    <input value="{{ $setting->site_title }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="site_title" type="text" name="site_title" required="required" autofocus="autofocus">
                </div>

                <!-- keywords -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="site_keywords">
                        Site keywords
                    </label>

                    <textarea class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="site_keywords" name="site_keywords" required="required" autofocus="autofocus">{{ $setting->site_keywords }}</textarea>
                </div>

                <!-- description -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="site_description">
                        Site description
                    </label>

                    <textarea maxlength="158" class="description rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="site_description" name="site_description" required="required" autofocus="autofocus">{{ $setting->site_description }}</textarea>
                    <div class="text-xs font-light mt-1 w-full text-right" id="the-count">
                        <span id="current">0</span>
                        <span id="maximum">/ 158</span>
                    </div>
                </div>

                <!-- banned words -->
                <div class="">
                    <label class="block font-medium text-sm text-gray-700" for="banned_keywords">
                        Banned words
                    </label>

                    <textarea class="description rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="banned_keywords" name="banned_keywords" required="required" autofocus="autofocus">{{ $setting->banned_keywords }}</textarea>
                    <div class="text-sm font-light mt-1 w-full text-left text-gray-400">
                        Separated by comma
                    </div>
                </div>

                <!-- Copyright text -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="copyright_text">
                        Copyright text
                    </label>

                    <input value="{{ $setting->copyright_text }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="copyright_text" type="text" name="copyright_text" required="required" autofocus="autofocus">
                </div>

                <!-- Facebook -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="facebook_url">
                        Facebook url
                    </label>

                    <input value="{{ $setting->facebook_url }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="facebook_url" type="text" name="facebook_url" required="required" autofocus="autofocus">
                </div>

                <!-- Twitter -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="twitter_url">
                        Twitter url
                    </label>

                    <input value="{{ $setting->twitter_url }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="twitter_url" type="text" name="twitter_url" required="required" autofocus="autofocus">
                </div>

                <!-- Google -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="google_url">
                        Google url
                    </label>

                    <input value="{{ $setting->google_url }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="google_url" type="text" name="google_url" required="required" autofocus="autofocus">
                </div>

                <!-- Youtube -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="youtube_url">
                        Youtube url
                    </label>

                    <input value="{{ $setting->youtube_url }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="youtube_url" type="text" name="youtube_url" required="required" autofocus="autofocus">
                </div>

                <!-- header logo -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="header_logo">
                        Header logo
                    </label>
                    @if ($setting->header_logo != null)
                    <div class="mt-3 mb-2">
                        <img class="w-60 h-40 object-cover" src="{{ asset('images/settings/'.$setting->header_logo) }}" alt="Logo">
                    </div>
                    @endif
                    <span class="sr-only">Choose File</span>
                    <input type="file" accept="image/*" name="header_logo" class="block w-max text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <!-- footer logo -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="footer_logo">
                        Footer logo
                    </label>
                    @if ($setting->footer_logo != null)
                    <div class="mt-3 mb-2">
                        <img class="w-60 h-40 object-cover" src="{{ asset('images/settings/'.$setting->footer_logo) }}" alt="Logo">
                    </div>
                    @endif
                    <span class="sr-only">Choose File</span>
                    <input type="file" accept="image/*" name="footer_logo" class="block w-max text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="submit-btn inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
$(function() {

    function init() {
        var characterCount = $('.description').val().length,
            current = $('#current'),
            maximum = $('#maximum'),
            theCount = $('#the-count');

        current.text(characterCount);
    }

    init();

    $('.description').on('keyup', function() {
        init()
    });
})
</script>
@endsection