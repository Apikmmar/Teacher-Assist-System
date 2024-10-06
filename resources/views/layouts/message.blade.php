@if (session('blue-message'))
    <div class="alert alert-primary text-primary" id="quick-message">
        {{ session('blue-message') }}
    </div>
@elseif (session('red-message'))
    <div class="alert alert-danger text-danger" id="quick-message">
        {{ session('red-message') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger text-danger" id="quick-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif