<div class="fixed w-full flex items-center justify-between h-14 text-white z-10">
    <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-darkblue dark:bg-gray-800 border-none">
        @if (auth()->user()->image != null) 
        <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden" src="{{ asset('images/users/'.auth()->user()->image) }}" />
        @else
        <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden" src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
        @endif
        <span class="hidden md:block">{{ auth()->user()->name }}</span>
    </div>
    <div class="flex justify-end items-center h-14 bg-darkblue dark:bg-gray-800 header-right">
        <ul class="flex items-center">
            <li>
            <button
                aria-hidden="true"
                @click="toggleTheme"
                class="mr-4 group p-2 transition-colors duration-200 rounded-full shadow-md bg-blue-200 hover:bg-blue-200 dark:bg-gray-50 dark:hover:bg-gray-200 text-gray-900 focus:outline-none"
            >
                <svg
                x-show="isDark"
                width="24"
                height="24"
                class="fill-current text-gray-700 group-hover:text-gray-500 group-focus:text-gray-700 dark:text-gray-700 dark:group-hover:text-gray-500 dark:group-focus:text-gray-700"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke=""
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                />
                </svg>
                <svg
                x-show="!isDark"
                width="24"
                height="24"
                class="fill-current text-gray-700 group-hover:text-gray-500 group-focus:text-gray-700 dark:text-gray-700 dark:group-hover:text-gray-500 dark:group-focus:text-gray-700"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke=""
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                />
                </svg>
            </button>
            </li>
        </ul>
    </div>
</div>