@extends('layouts.main')

@section('title', $title)
@section('keyword', $keyword)
@section('description', $description . ' ' . $keyword)

@section('content')
    <section class="bg-bodybg px-4 max-w-6xl mx-auto">
        <div class="flex flex-col pb-10 pt-6 md:px-5 px-1 w-full ">
            <div class="pt-2 relative text-gray-600 flex flex-wrap justify-between flex-row w-full" id="keyword_search">
                <form method="POST" action="/search" class="flex flex-initial justify-between md:flex-row border-2 bg-white items-center rounded-md w-full group" id="search-keyword">
                    @csrf
                    <input id="typeahead" type="text" name="search" placeholder="Ex: Facebook Login..." required="required" class="typeahead w-full flex-1 h-12 md:h-10 px-4 rounded-none text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 group-focus:outline-none group-focus:placeholder-transparent group-focus:ring-0"> 
                    <button id="submitBtn" type="button" class="flex items-center justify-center text-white transition-colors duration-300 transform rounded-tr-md rounded-br-md h-12 w-16 lg:w-16 lg:h-12 lg:p-0 bg-darkblue hover:bg-darkblue/70 focus:outline-none focus:bg-darkblue/70">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
                @include('components.share')
            </div>

            <div class="bg-white shadow rounded-md placeholder: mb-6 p-4 w-full mt-10">
                <div class="block text-2xl text-gray-800 font-bold text-center">Customer Login</div>

                <div class="text-center mt-3">
                    {{ $result->desc }}
                </div>


                <div class="flex flex-col md:flex-row space-x-0 md:space-x-4 mt-5">
                    <a href="{{ route('search', $visit) }}" class="w-full flex space-x-1 items-center justify-center py-2 px-4 rounded-md text-sm bg-blue-500 hover:bg-opacity-80 text-white shadow-lg mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        <span>Back to list</span>
                    </a>
                    <a href="{{ $result->url }}" target="_blank" class="w-full flex space-x-1 items-center justify-center py-2 px-4 rounded-md text-sm bg-link hover:bg-opacity-80 text-white shadow-lg mt-3">
                        <span>Go to login page </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                </div>

            </div>     

            <div class="bg-white shadow rounded-md placeholder: mb-6 p-4 w-full w-full mt-10">
                <div class="block text-2xl text-gray-800 font-bold">How do you collect data for {{ $title }}?</div>
                <div class="text-darkblue mt-2">
                    We select pages with information related to {{ $title }}. These will include the official login link and all the information, notes, and requirements about the login.
                </div>
            </div>
    </section>
@endsection