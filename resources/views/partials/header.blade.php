<nav class="shadow bg-darkblue">
    <div class="px-4 lg:px-12">
        <div class="relative flex items-center justify-around h-16 md:h-20">
            <div class="flex-1 flex items-center sm:items-stretch sm:justify-start space-x-40">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/settings/'.$setting->header_logo) }}" alt="Logo" class="md:h-10 h-8"></a>
                </div>
                @if (\Route::currentRouteName() == 'home')
                <div class="hidden pt-2 mb-2 relative mx-auto text-gray-600 lg:flex flex-wrap justify-between md:flex-row md:w-4/5 w-full" id="keyword_search">
                    <form method="POST" action="{{ route('search.post') }}" class="search-form flex flex-initial justify-between md:flex-row bg-white items-center rounded-full w-full group" id="search-keyword">
                        @csrf
                        <input id="typeahead" type="search" name="search" placeholder="Ex: Facebook Login..." required="required" class="typeahead w-full flex-1 h-12 md:h-10 px-6 rounded-full text-gray-700 placeholder-gray-400 bg-transparent focus:ring-none border-none appearance-none lg:h-12 dark:text-gray-200 focus:ring-white focus:ring-inset focus:border-white focus:outline-0 focus:ring-0 focus:border-0"> 
                        <input type="hidden" class="user_input" name="user_input">
                        <button id="submitBtn" type="submit" class="flex items-center justify-center text-gray-700 transition-colors duration-300 transform rounded-full h-12 w-16 lg:w-16 lg:h-12 lg:p-0 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>