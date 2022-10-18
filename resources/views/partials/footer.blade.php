<footer class="shadow bg-darkblue">
    <div class="pt-10 md:pt-5 pb-5 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-evenly gap-10 pt-10 w-full max-w-5xl mx-auto">
            <div class="overflow-hidden w-full transform transition duration-200 ease-in">
                <div class="text-xl text-white">About ManyLogins.com</div>
                <div class="text-gray-400 leading-6 pt-4">Many Logins is a useful website for people all over the world to find the correct login pages, and helps seekers easily access the login portals of the thousands of websites without a lot of effort.</div>
                
                {{-- <div class="flex justify-center">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/settings/'.$setting->footer_logo) }}" alt="Logo" class="h-36"></a>
                </div> --}}

            </div>

            <div class="overflow-hidden w-full transform transition duration-200 ease-in md:ml-10">
                <div class="text-xl text-white">Links</div>
                <ul class="text-gray-400 leading-6 pt-4 list-inside list-disc">
                    <li><a class="text-gray-400 hover:text-white capitalize" href="{{ route('home') }}">Home</a></li>
                    <li><a class="text-gray-400 hover:text-white capitalize" href="{{ route('blog.lists') }}">Guides</a></li>
                    <li><a class="text-gray-400 hover:text-white capitalize" href="{{ route('view.contact') }}">Contact Us</a></li>
                    <li><a class="text-gray-400 hover:text-white capitalize" href="{{ route('privacy') }}">Privacy Policy</a></li>
                </ul>

            </div>

            <div class="overflow-hidden w-full transform transition duration-200 ease-in">
                <div class="text-xl text-white">Popular Logins</div>
                <ul class="text-gray-400 leading-6 pt-4 list-inside list-disc">
                    @foreach ($popular_posts as $popular)
                        <li class="ml-1 ">
                            <a href="{{ route('search', $popular->slug) }}" class="text-gray-400 hover:text-white capitalize">{{ $popular->keywords }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex justify-center border-t border-gray-700 pt-5 mt-10 w-full max-w-5xl mx-auto">
            <div class="flex md:justify-between flex-col md:flex-row w-full space-y-3 md:space-y-0">
                <div class="font-light text-gray-400 md:text-left text-center">
                    {{ $setting->copyright_text }}
                </div>
                <div class="flex space-x-3 justify-center md:justify-end">
                    @if ($setting->facebook_url != null || $setting->facebook_url != '#')
                    <a href="{{ $setting->facebook_url }}" target="_blank">
                        <svg class="fill-gray-200 h-4 w-4" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title>
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if ($setting->twitter_url != null || $setting->twitter_url != '#')
                    <a href="{{ $setting->twitter_url }}" target="_blank">
                        <svg class="fill-gray-200 h-4 w-4" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Twitter</title>
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>