@extends('layouts.main')

@section('title', 'Home - ManyLogins')

@section('content')
    
    <section class="bg-bodybg px-4">
        <div class="flex flex-col justify-center items-center py-28 text-center">
            <h1 class="text-5xl font-bold text-darkblue mb-8">Effortlessly Access Login Pages</h1>

            <div class="font-light md:text-lg text-gray-500 text-base mb-8">
                Allow people to find and access login portals with the most optimized process.
            </div>

            <div class="pt-2 relative mx-auto text-gray-600 flex flex-wrap justify-between md:flex-row md:w-1/2 w-full" id="keyword_search">
                <form action="/search" class="flex flex-initial justify-between md:flex-row border-2 bg-white items-center rounded-md w-full group" id="search-keyword">
                    @csrf
                    <input type="text" name="search" placeholder="Ex: Facebook Login..." required="required" class="typeahead w-full flex-1 h-12 md:h-10 px-4 rounded-none text-gray-700 placeholder-gray-400 bg-transparent border-none appearance-none lg:h-12 dark:text-gray-200 group-focus:outline-none group-focus:placeholder-transparent group-focus:ring-0"> 
                    <button type="submit" class="flex items-center justify-center text-white transition-colors duration-300 transform rounded-tr-md rounded-br-md h-12 w-16 lg:w-16 lg:h-12 lg:p-0 bg-darkblue hover:bg-darkblue/70 focus:outline-none focus:bg-darkblue/70">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="bg-gray-300 bg-opacity-60 px-4">
        <div class="flex flex-col justify-center items-center py-16 text-center">
            <h2 class="text-4xl font-bold text-darkblue mb-5">Most-Accessed Logins</h2>

            <div class="font-light text-gray-500 text-sm mb-8">
                A list of the most-accessed correct login pages is below for your reference.
            </div>
        </div>
    </section>

@endsection