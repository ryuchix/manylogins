@extends('layouts.main')

@section('title', 'Contact us' . ' - ' . $setting->site_title )
@section('keyword', 'Contact ' . $setting->site_title)
@section('description', 'Contact ' . $setting->site_title)

@section('content')
<div class="w-full">
    <div class="max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white w-full shadow rounded p-8 sm:p-12 mt-20">
            <p class="text-3xl font-bold leading-7 text-center">Contact us</p>
            <p class="mt-2">Leave your concern and our user support will give you answer as soon as possible. </p>
            <form action="{{ route('contact') }}" method="post">
                @csrf
                <div class="md:flex items-center mt-12">
                    <div class="w-full md:w-1/2 flex flex-col">
                        <label class="font-semibold leading-none">Name</label>
                        <input type="text" name="name" class="leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200" />
                    </div>
                    <div class="w-full md:w-1/2 flex flex-col md:ml-6 md:mt-0 mt-4">
                        <label class="font-semibold leading-none">Email</label>
                        <input type="email" name="email" class="leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"/>
                    </div>
                </div>
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label class="font-semibold leading-none">Subject</label>
                        <input type="text" name="subject" class="leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"/>
                    </div>
                    
                </div>
                <div>
                    <div class="w-full flex flex-col mt-8">
                        <label class="font-semibold leading-none">Message</label>
                        <textarea type="text" name="message" class="h-40 text-base leading-none text-gray-900 p-3 focus:oultine-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full">
                    <button type="submit" class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-darkblue rounded hover:bg-link focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
                        Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection