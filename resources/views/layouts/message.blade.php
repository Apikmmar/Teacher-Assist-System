@if (session('blue-message'))
    <div class="alert alert-primary text-primary" id="quick-message">
        {{ session('blue-message') }}
    </div>
@elseif (session('red-message'))
    <div class="alert alert-danger text-danger" id="quick-message">
        {{ session('red-message') }}
    </div>
@endif
