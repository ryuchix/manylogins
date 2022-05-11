@extends('layouts.admin')

@section('title', 'Create user')

@section('style')
<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<style>
    
</style>
@endsection
@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 flex flex-col bg-gray-100 font-sans overflow-hidden px-4 md:px-10">
        <div class="mt-6 w-full justify-start items-center flex">
            <span>Add Post</span>
        </div>

        <div class="bg-white mt-5 p-8 rounded-md">
            <form method="POST" action="{{ route('posts.store') }}" x-data="{status: '0'}">
                @csrf
                
                @include('admin.partials.session-message')

                <!-- Title -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="title">
                        Title
                    </label>

                    <input  class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="title" type="text" name="title" required="required" autofocus="autofocus">
                </div>

                <!-- Headline -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="email">
                        Headline
                    </label>

                    <textarea class="editor rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="excerpt" required="required" id="excerpt"></textarea>
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="content">
                        Content
                    </label>

                    <textarea class="editor rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="content" required="required" id="content"></textarea>
                </div>

                <!-- Cover -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="cover">
                        Cover
                    </label>
                    <span class="sr-only">Choose File</span>
                    <input type="file" name="cover" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <!-- status -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="status">
                        Status
                    </label>
                    <div class="relative rounded-full w-12 h-6 transition duration-200 ease-linear"
                        :class="[status === '1' ? 'bg-green-400' : 'bg-gray-400']">
                        <label for="status"
                            class="absolute left-0 bg-white border-2 mb-2 w-6 h-6 rounded-full transition transform duration-100 ease-linear cursor-pointer"
                            :class="[status === '1' ? 'translate-x-full border-green-400' : 'translate-x-0 border-gray-400']"></label>
                        <input type="checkbox" id="status" name="status"
                            class="appearance-none w-full h-full active:outline-none focus:outline-none"
                            @click="status === '0' ? status = '1' : status = '0'"/>
                    </div>

                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Clear
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Add user
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    $(document).ready(function () {
        var editor = new Quill('.editor');
    });
</script>
@endsection