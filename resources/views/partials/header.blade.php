<nav class="shadow bg-darkblue">
    <div class="px-4 lg:px-12">
        <div class="relative flex items-center justify-around h-16 md:h-20">
            <div class="flex-1 flex items-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/settings/'.$setting->header_logo) }}" alt="Logo" class="md:h-10 h-8"></a>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-end">
                <div class="flex-shrink-0 flex items-center">
                    <a class="text-white" href="{{ route('view.contact') }}">Contact Us</a>
                </div>
                <div class="flex-shrink-0 flex items-center ml-4">
                    <a class="text-white" href="{{ route('privacy') }}">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</nav>