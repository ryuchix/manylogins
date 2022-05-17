@extends('layouts.main')

@section('title', $title . ' - ' . $setting->site_title)
@section('keyword', $search_result != null ? $keyword : $title)
@section('description', $search_result != null ? $description : $title . ' ' . $keyword)

@section('content')
@php 
    $hashids = new \Hashids\Hashids();
@endphp
    <section class="bg-bodybg px-4 max-w-6xl mx-auto">
        <div class="flex flex-col pb-10 pt-6 md:px-5 px-1 w-full ">
            <div class="pt-2 relative text-gray-600 flex flex-wrap justify-between flex-row w-full" id="keyword_search">
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
                @include('components.share')
            </div>

            <div class="py-3 mt-5 px-5 mb-4 bg-blue-100 text-blue-900 text-sm rounded-md border border-blue-200 w-full">
                <ul class="flex">
                    <li><a href="{{ route('home') }}" class="underline font-semibold">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li>{{ $title ?? $search}}</li>
                </ul>
            </div>

            <div class="search-title text-4xl mt-1 text-left text-darkblue">
                {{ $title }}
            </div>
            
            @if ($search_result != null && count($search_result->relatedSearch) > 0)
            <div class="bg-white shadow rounded-md placeholder: mb-6 p-4 w-full w-full mt-5 ">
                <div class="block text-xl text-gray-500">Related Search</div>
                <div>
                    <ul class="gap-2 columns-1 md:columns-2 list-inside mt-1">
                        <?php $__currentLoopData = $search_result->relatedSearch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex space-x-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            <a class="text-blue-500 hover:text-blue-600" href="{{ route('search', str_replace(' ', '-', $item->keywords)) }}" class="" data-href="{{ route('search', str_replace(' ', '-', $item->keywords)) }}" title="{{ $item->keywords }}​">
                                <?php echo e($item->keywords); ?>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            @endif

            @if ($search_result === null)
                <h2 class="text-2xl mt-2">
                    0 results found for: <span class="text-darkblue">{{ e(str_replace('-', ' ', $search)) }}</span>
                </h2>
            @else
                <h2 class="text-2xl mt-2">
                    {{ e($search_result->organic->count()) }} results found for: <span class="text-darkblue"> {{ e(str_replace('-', ' ', $search)) }} </span>
                </h2>

                <?php $__currentLoopData = $search_result->organic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white shadow rounded-md placeholder: mb-1 p-4 w-full w-full mt-5 break-words">
                    <div class="block text-xl text-link hover:text-opacity-80">
                        <a href="{{ route('visit', ['visit' => $search, 'cid' => $hashids->encode($item->id)]) }}">{{ e($item->title) }}</a>
                    </div>
                    <div class="text-blue-500 hover:text-blue-600 mt-1 break-words">
                        <a href="{{ route('visit', ['visit' => $search, 'cid' => $hashids->encode($item->id)]) }}">{{ e($item->url) }}</a>
                    </div>
                    <div class="text-sm text-gray-500 font-light mt-1 break-words">
                        {{ e($item->desc) }}
                    </div>
                    <a href="{{ route('visit', ['visit' => $search, 'cid' => $hashids->encode($item->id)]) }}" class="w-max flex items-center py-2 px-4 rounded-lg text-sm bg-link hover:bg-opacity-80 text-white shadow-lg mt-3">Visit Site
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="bg-white shadow rounded-md placeholder: mb-6 p-4 w-full w-full mt-10">
                    <div class="block text-2xl text-gray-800 font-bold">How do you collect data for {{ e($title) }}?</div>
                    <div class="text-darkblue mt-2">
                          We research pages with information related to {{ e($title) }}. These will include the official login link along with the information for the login process and requirements about each login.
                    </div>
                </div>
            @endif
    </section>
@endsection

@section('script')
<script>var home_url = "{{ route('home') }}";</script>
@endsection