@if ($message = Session::get('success'))
    <div class="mb-2 text-green-600">
        {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-2 text-red-600">
        <strong>Error!</strong> 
        {{ $message }}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif