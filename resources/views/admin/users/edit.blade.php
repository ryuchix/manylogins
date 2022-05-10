@extends('layouts.admin')

@section('title', 'Edit user')

@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 flex flex-col bg-gray-100 font-sans overflow-hidden px-4 md:px-10">
        <div class="mt-6 w-full justify-start items-center flex">
            <span>Edit User</span>
        </div>

        <div class="bg-white mt-5 p-8 rounded-md">
            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PATCH')
                
                @include('admin.partials.session-message')

                <!-- Name -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="name">
                        Name
                    </label>

                    <input value="{{ $user->name }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus">
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="email">
                        Email
                    </label>

                    <input value="{{ $user->email }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" required="required">
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="email">
                        Role
                    </label>

                    <select id="role" name="role" required="required" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password">
                        Password
                    </label>

                    <input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" autocomplete="new-password">
                </div>

                <!-- Profile picture -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="password">
                        Picture
                    </label>
                    <span class="sr-only">Choose File</span>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Clear
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Add user
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection