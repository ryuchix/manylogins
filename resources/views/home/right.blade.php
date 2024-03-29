<aside class="right-sidebar order-3 lg:order-3 xl:min-w-[22rem] w-full lg:w-[22rem]">
    {{-- <div class="mt-3">
        <div class="text-lg text-gray-700 p-2 w-full text-left font-semibold">Popular Search</div>
        <div class="popular">
            <ul class="ml-2 flex flex-col space-y-1">
                @foreach ($popular_posts as $popular)
                <li class="ml-1 space-x-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('search', $popular->slug) }}" class="block text-gray-500 hover:text-link capitalize">{{ $popular->keywords }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div> --}}

    @if (\Request::route()->getName() == 'blog.lists' || \Request::route()->getName() == 'show.blog')
    <div class="mt-4">
        <div class="text-lg text-gray-700 p-2 w-full text-left font-semibold">Popular Guides</div>

        <div class="blog_card flex space-y-4 flex-col">
            @foreach ($posts as $post)
            <div class="p-2 w-full flex-col space-y-4 group">
                <div class="article  h-full rounded-md shadow-cla-pink bg-bodybg overflow-hidden">
                    <img class="lg:h-48 md:h-36 w-full object-cover object-center transition-all duration-400" src="{{ asset($post->cover) }}" alt="{{ $post->title }}">
                    <div class="flex flex-wrap justify-start items-center mt-2 pt-2 px-4">
                        @foreach ($post->categories as $cat)
                        <div class="text-xs mr-2 mt-1 py-1.5 px-4 text-gray-200 bg-[#718096] rounded-2xl hover:text-white hover:bg-link cursor-pointer">
                            {{ $cat->name }}
                        </div>
                        @endforeach
                    </div>
                    <div class="px-4 py-4">
                        <div class="title-font text-lg font-medium mb-1"><a href="{{ route('show.blog', ['blog' => $post->slug]) }}" class="block text-xl text-gray-500 group-hover:text-link">{{ $post->title }}</a></div>
                        <div class="leading-relaxed mb-3 text-gray-500">{!! substr_replace(strip_tags($post->content), strlen($post->content) <= 200 ? "" : "...", 200); !!}</div>
                        <div class="flex items-center flex-wrap mt-1">
                            <a href="{{ route('show.blog', ['blog' => $post->slug]) }}" class="w-full flex items-center py-2 px-4 rounded-sm text-sm bg-link hover:bg-opacity-80 text-white shadow-md text-center justify-center">Read more...</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else 
    <div class="mt-4">
        <div class="text-lg text-gray-700 p-2 w-full text-left font-semibold">Guides</div>
        <div class="blogs">
            @foreach ($posts as $post)
            <div class="p-2 w-full flex-col space-y-4 group">
                <div class="article  h-full rounded-md shadow-cla-pink bg-bodybg overflow-hidden">
                    <img class="lg:h-48 md:h-36 w-full object-cover object-centertransition-all duration-400" src="{{ asset($post->cover) }}" alt="{{ $post->title }}">
                    <div class="flex flex-wrap justify-start items-center mt-2 pt-2 px-4">
                        @foreach ($post->categories as $cat)
                        <div class="text-xs mr-2 mt-1 py-1.5 px-4 text-gray-200 bg-[#718096] rounded-2xl hover:text-white hover:bg-link cursor-pointer">
                            {{ $cat->name }}
                        </div>
                        @endforeach
                    </div>
                    <div class="px-4 py-4">
                        <div class="title-font text-lg font-medium mb-1"><a href="{{ route('show.blog', ['blog' => $post->slug]) }}" class="block text-xl text-gray-500 group-hover:text-link">{{ $post->title }}</a></div>
                        <div class="leading-relaxed mb-3 text-gray-500">{!! substr_replace(strip_tags($post->content), strlen($post->content) <= 200 ? "" : "...", 200); !!}</div>
                        <div class="flex items-center flex-wrap mt-1">
                            <a href="{{ route('show.blog', ['blog' => $post->slug]) }}" class="w-full flex items-center py-2 px-4 rounded-sm text-sm bg-link hover:bg-opacity-80 text-white shadow-md text-center justify-center">Read more...</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</aside>