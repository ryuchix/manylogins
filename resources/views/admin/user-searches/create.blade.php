@extends('layouts.admin')

@section('title', 'Add keywords')

@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 dark:bg-gray-700 flex flex-col bg-gray-100 font-sans overflow-hidden px-4 md:px-10">
        <div class="mt-6 w-full justify-start items-center flex text-xl">
            <span>Add Keywords</span>
        </div>

        <div class="bg-white mt-5 p-8 rounded-md">
            <form method="POST" action="{{ route('user-search.store') }}">
                @csrf
                
                @include('admin.partials.session-message')

                <!-- Name -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="keywords">
                        Keywords
                    </label>

                    <textarea  class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="keywords" type="text" name="keywords" required="required" autofocus="autofocus"></textarea>
                    <span class="text-sm text-gray-500">Add keywords separated by comma.</span>
                </div>

                <div>
                    @if (Session::has('banned'))
                        <div class="mb-2 text-green-600 mt-2">
                            <div>Banned keywords found and was skipped.</div>
                            <ul class="list-disc list-inside">
                            @foreach (Session::get('banned') as $message)
                                <li class="text-red-600">{{ $message }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('duplicate'))
                        <div class="mb-2 text-green-600 mt-2">
                            <div>Some keywords already exists and was skipped.</div>
                            <ul class="list-disc list-inside">
                            @foreach (Session::get('duplicate') as $message)
                                <li class="text-red-600">{{ $message }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Clear
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Add Keywords
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection