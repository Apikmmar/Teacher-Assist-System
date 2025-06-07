@if (session('blue-message'))
    <div class="alert alert-light border border-primary text-primary bg-white shadow-sm mb-4" id="quick-message" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>{{ session('blue-message') }}</div>
        </div>
    </div>
@elseif (session('red-message'))
    <div class="alert alert-light border border-danger text-danger bg-white shadow-sm mb-4" id="quick-message" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>{{ session('red-message') }}</div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-light border border-danger text-danger bg-white shadow-sm mb-4" id="quick-message" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-x-circle-fill me-2 mt-1"></i>
            <div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif