@extends('layouts.admin')

@section('title', 'Create post')

@section('style')
<link rel="stylesheet" href="{{ asset('trumbowyg/dist/ui/trumbowyg.min.css') }}">
<link href="{{ asset('css/select2.css') }}" rel="stylesheet" />

<style>
    h1 {
        font-size: 3rem;
        line-height: 1;
    }

    h2 {
        font-size: 2.25rem;
        line-height: 2.5rem;
    }

    h3 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    h4 {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    
    p {
        font-size: 1rem;
        line-height: 1.5rem;
        margin-bottom: 15px;
    }
</style>
@endsection
@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 flex flex-col bg-gray-100 font-sans overflow-hidden px-4 md:px-10">
        <div class="mt-6 w-full justify-start items-center flex text-xl">
            <span>Add Post</span>
        </div>

        <div class="bg-white mt-5 p-8 rounded-md">
            <form method="POST" action="{{ route('posts.store') }}" x-data="{status: '0'}" enctype="multipart/form-data">
                @csrf
                
                @include('admin.partials.session-message')

                <!-- Title -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="title">
                        Headline
                    </label>

                    <input  class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="title" type="text" name="title" required="required" autofocus="autofocus">
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="content">
                        Content
                    </label>

                    <textarea id="content" name="content" cols="30" rows="10" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"></textarea>
                </div>

                <!-- Cover -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="cover">
                        Featured Image
                    </label>
                    <span class="sr-only">Choose File</span>
                    <input type="file" accept="image/*" name="cover" class="block w-max text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <!-- Category -->
                <div class="mt-4 w-full">
                    <label class="block font-medium text-sm text-gray-700 mb-2" for="select-category">
                        Categories
                    </label>
                    <select class="select-category rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1 w-1/2" name="category[]" multiple="multiple">
                        @foreach ($category as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- status -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="status">
                        Status
                    </label>
                    <label class="inline-flex items-center mt-3 ml-1">
                        <input id="status" name="status" type="checkbox" class="form-checkbox h-5 w-5 text-darkblue rounded-sm" checked><span class="ml-2 text-gray-700">Published</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Clear
                    </button>
                    <button type="submit" class="submit-btn inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                        Add post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('trumbowyg/dist/trumbowyg.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script src="{{ asset('trumbowyg/dist/jquery-resizable.min.js') }}"></script>
<script src="{{ asset('trumbowyg/dist/plugins/upload/trumbowyg.upload.min.js') }}"></script>
<script src="{{ asset('trumbowyg/dist/plugins/resizimg/trumbowyg.resizimg.min.js') }}"></script>
<script>
    $(".select-category").select2({
        tags: true,
        placeholder: "Create or select a category",
        tokenSeparators: [','],
        width: 'resolve'
    })

    $('.submit-btn').on('click', function() {
        var content = $('#content').trumbowyg('html');
    });

    $('#content').trumbowyg({
        changeActiveDropdownIcon: true,
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['image'], // Our fresh created dropdown
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        btnsDef: {
            // Create a new dropdown
            image: {
                dropdown: ['insertImage', 'upload'],
                ico: 'insertImage'
            }
        },
        plugins: {
            // Add imagur parameters to upload plugin for demo purposes
            upload: {
                serverPath: "{{ route('admin.upload') }}",
                fileFieldName: 'image',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                urlPropertyName: 'link'
            },
            resizimg: {
                minSize: 64,
                step: 16,
            }
        }
    });

</script>
@endsection