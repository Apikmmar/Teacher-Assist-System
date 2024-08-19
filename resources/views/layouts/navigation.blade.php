@php
    $user = auth()->user();
    $call = 'null';

    if (($user->gender == 'Men') || ($user->gender == 'men')) {
        $call = "Mr. ";
    } elseif (($user->gender == 'Women') || ($user->gender == 'women')) {
        $call = "Mr. ";
    } else {
        $call = "";
    }
@endphp

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container-fluid h-100">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex flex-grow-1">
                <p class="navbar-text fw-bold text-dark m-0">Sekolah Menengah Kebangsaan Baling</p>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <p class="m-0 me-2 fw-bold">{{ $call . $user->name }}</p>
                </div>
                <div class="me-4">
                    <a href="{{ route('profile.edit') }}">
                        <img src="{{ asset('asset/default-image/profile.png') }}" style="max-width: 60px;" class="img-fluid" alt="SMK Baling.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>