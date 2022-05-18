<aside class="right-sidebar order-3 lg:order-3 xl:min-w-[22rem] w-full lg:w-[22rem]">
    <div class="mt-3">
        <div class="text-lg text-gray-700 p-2 w-full text-left font-semibold">Popular Search</div>
        <div class="popular">
            <ul class="ml-2 flex flex-col space-y-1">
                @foreach ($popular_posts as $popular)
                <li class="ml-1 space-x-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-link" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('search', $popular->slug) }}" class="block text-link hover:text-opacity-80 capitalize">{{ $popular->keywords }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <div class="text-lg text-gray-700 p-2 w-full text-left font-semibold">Blogs</div>
        <div class="blogs">
            @foreach ($posts as $post)
            <div class="p-2 w-full flex-col space-y-4">
                <div class="h-full rounded-md shadow-cla-pink bg-gradient-to-r from-fuchsia-50 to-pink-50 overflow-hidden">
                    <img class="lg:h-48 md:h-36 w-full object-cover object-centertransition-all duration-400" src="{{ asset('images/posts/'.$post->cover) }}" alt="{{ $post->title }}">
                    <div class="flex flex-wrap justify-start items-center mt-2 pt-2 px-4 lg:space-y-1 xl:space-y-0">
                        @foreach ($post->categories as $cat)
                        <div class="text-xs mr-2 py-1.5 px-4 text-gray-600 bg-blue-200 rounded-2xl">
                            #{{ $cat->name }}
                        </div>
                        @endforeach
                    </div>
                    <div class="px-4 py-4">
                        <h1 class="title-font text-lg font-medium mb-1"><a href="#" class="block text-xl text-link hover:text-opacity-80">{{ $post->title }}</a></h1>
                        <div class="leading-relaxed mb-3 text-gray-500">{!! substr_replace($post->content, strlen($post->content) <= 200 ? "" : "...", 200); !!}</div>
                        <div class="flex items-center flex-wrap mt-1">
                            <a href="#" class="w-full flex items-center py-2 px-4 rounded-sm text-sm bg-link hover:bg-opacity-80 text-white shadow-md text-center justify-center">Read more...</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</aside>