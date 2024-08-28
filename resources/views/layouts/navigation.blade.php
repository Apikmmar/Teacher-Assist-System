@php
    $user = auth()->user();
    $call = 'null';

    $call = ($user->gender === 'Men') ? 'Mr. ' : (($user->gender === 'Women') ? 'Mrs. ' : '');
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
                    @if (!empty($user->photo))
                        <img src="{{ asset('storage/asset/profile-photos/' . $user->photo) }}" style="max-width: 60px; border-radius: 50%" class="img-fluid" alt="SMK Baling.png">
                    @else    
                        <img src="{{ asset('asset/default-image/profile.png') }}" style="max-width: 60px;" class="img-fluid" alt="SMK Baling.png">
                    @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>