@extends('layouts.admin')

@section('title', 'Manage Keywords Search')

@section('content')
<div class="overflow-x-auto">
    <div class="min-w-screen bg-gray-100 dark:bg-gray-700 flex flex-col items-center justify-center bg-gray-100 font-sans overflow-hidden">
        <div class="mt-6 w-full justify-between items-center px-4 md:px-10 flex text-xl">
            <div>Keywords Search Lists</div>
        </div>
        <div class="w-full px-4 md:px-10">
            @include('admin.partials.session-message')
            <form method="GET" action="{{ route('keywords.index') }}" class="my-2 flex md:flex-row flex-col mt-4 items-center space-y-2 md:space-y-0">
                <div class="flex flex-row">
                    <div class="relative">
                        <select name="status"
                            class="appearance-none h-full rounded-l rounded-r lg:rounded-r-none border-t border-r-1 lg:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-200 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:rounded lg:focus:border-r-2 focus:border-r focus:bg-white focus:border-[#2563eb]">
                            <option value="0">All</option>
                            <option value="1" {{ isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' }}>Scraped</option>
                            <option value="2" {{ isset($_GET['status']) && $_GET['status'] == 2 ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input placeholder="Search" type="search" name="search"
                        class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-200 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:outline-none focus:border focus:bg-white focus:border-[#2563eb]" />
                </div>
                <div class="block relative">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-sm font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-[#2563eb] disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                        Filter
                    </button>
                </div>
                <div class="block relative flex flex-col md:flex-row items-center space-y-2 md:space-y-0">
                    <div class="block relative">
                        <button type="button" class="mass-delete-btn hidden inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-sm font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-[#2563eb] disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                            Mass Delete
                        </button>
                    </div>
                    <div class="block relative">
                        <button type="button" class="mass-update-btn hidden inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-sm font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-[#2563eb] disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                            Mass Update
                        </button>
                    </div>
                </div>
            </form>
            <form id="mass-delete" class="hidden" method="POST" action="{{ route('keywords.mass.delete') }}">
                @csrf
                <input type="hidden" name="ids" class="deleted_ids">
            </form>
            <form id="mass-update" class="hidden" method="POST" action="{{ route('keywords.mass.update') }}">
                @csrf
                <input type="hidden" name="ids" class="updated_ids">
                <input type="hidden" name="status" class="updated_status">
            </form>
            <div class="bg-white shadow-md rounded mb-6 mt-4 overflow-x-auto">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-darkblue bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-darkblue dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Keyword</th>
                            <th class="py-3 px-6 text-left">Url</th>
                            <th class="py-3 px-6 text-left">Organic</th>
                            <th class="py-3 px-6 text-left">Related</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($keywords as $keyword)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
							<div class="flex items-center chk">
								<input value="{{ $keyword->id }}" name="chkid[]" type="checkbox" class="checkbox-id w-4 h-4 text-darkblue bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-darkblue dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
								<label for="checkbox-table-search-1" class="sr-only">{{ $keyword->id }}</label>
							</div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $keyword->id }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $keyword->keywords }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $keyword->slug }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ count($keyword->organic) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ count($keyword->relatedSearch) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span class="capitalize">
                                        <div class="px-2 py-1 rounded text-xs flex justify-center items-center {{ $keyword->status == 1 ? 'bg-green-600' : 'bg-gray-500' }} text-white">{{ $keyword->status == 1 ? 'Scraped' : 'Pending' }}</div>
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center">
                                    @if ($keyword->status == 1)
                                    <a href="{{ route('search', $keyword->slug) }}" target="_blank" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class='flex items-center justify-center mt-10 bg-gray-100'>
                <div class="flex flex-col items-center mb-8 px-4 mx-auto mt-8">
                    <div class="font-sans flex justify-end space-x-1 select-none">
                        {!! $keywords->appends(array('status' => request()->status))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function() {

        const showMassUpdate = async () => {
            const { value: fruit } = await Swal.fire({
                title: 'Select a status',
                text: 'Selected Ids will be updated based on selected status.',
                input: 'select',
                confirmButtonText: 'Update',
                inputOptions: {
                    '1': 'Scraped',
                    '2': 'Pending'
                },
                inputPlaceholder: 'Select a status',
                showCancelButton: true,
                inputAttributes: {
                    'class': 'appearance-none'
                },
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value != '') {
                            $('.updated_ids').val(deletedIds);
                            $('.updated_status').val(value);
                            $('#mass-update').trigger('submit');
                            resolve()
                        } else {
                            resolve('Please select a status, if you want to continue.')
                        }
                    })
                }
            })
        }

        $('.mass-update-btn').on('click', function() {
             showMassUpdate()
        })

        $('#checkbox-all').on('change', function() {
            console.log($(this).is(':checked'))
            if ($(this).is(':checked')) {
                $('.mass-delete-btn').removeClass('hidden')
                $('.mass-update-btn').removeClass('hidden')
                deletedIds = [];
                $('.checkbox-id').each(function() {
                    $(this).prop('checked', true);
                    deletedIds.push($(this).val());
                })
            } else {
                $('.mass-delete-btn').addClass('hidden')
                $('.mass-update-btn').addClass('hidden')
                $('.checkbox-id').each(function() {
                    $(this).prop('checked', false);
                    deletedIds = [];
                })
            }
        })

        $('.checkbox-id').on('change', function() {
            if (!$(this).is(':checked')) {
                $('#checkbox-all').prop('checked', false);

                const index = deletedIds.indexOf($(this).val());
                if (index > -1) {
                    deletedIds.splice(index, 1);
                }
            } else {
                $('.mass-delete-btn').removeClass('hidden');
                $('.mass-update-btn').removeClass('hidden');
                deletedIds.push($(this).val())
            }

            var boxes = [];
            $('.checkbox-id').each(function() {
                boxes.push($(this).is(':checked'));
            })

            if (checker(boxes)) {
                $('#checkbox-all').prop('checked', true);
            }

            if (checker2(boxes)) {
                $('.mass-delete-btn').addClass('hidden')
                $('.mass-update-btn').addClass('hidden')
            }
        })

        let checker = arr => arr.every(v => v === true);
        let checker2 = arr => arr.every(v => v === false);
        let deletedIds = [];

        $('.mass-delete-btn').on('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This process is permanent!',
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deleted_ids').val(deletedIds);
                    $('#mass-delete').trigger('submit');
                }
            })
        })
    })
</script>
@endsection