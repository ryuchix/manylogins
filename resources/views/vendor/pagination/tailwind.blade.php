@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>


                        {{-- <a href="#" class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md">
                            Previous
                        </a>
                        <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                            1
                        </a>
                        <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                            2
                        </a>
                        <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                            3
                        </a>
                        <span class="px-4 py-2 text-gray-700  rounded-md" >
                            ...
                        </span>
                        <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                            10
                        </a>
                        <a href="#" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                            Next
                        </a> --}}



        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between flex-col space-y-3">
            <div>
                <span class="relative z-0 flex rounded-md space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md" aria-hidden="true">
                                Previous
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;" aria-label="{{ __('pagination.previous') }}">
                            Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="px-4 py-2 text-gray-100 bg-gray-400 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-teal-400 hover:text-white" style="transition: all 0.2s ease;" aria-label="{{ __('pagination.next') }}">
                            Next
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md" aria-hidden="true">
                                Next
                            </span>
                        </span>
                    @endif
                </span>
            </div>
            <div>
                <div class="text-sm text-gray-700 dark:text-white leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </div>
            </div>

        </div>
    </nav>
@endif
