<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class=" fade-in-text">
        
            <div class="row mb-4 justify-content-center">
                <img src="https://upload.wikimedia.org/wikipedia/ms/6/67/UMP.png" style="max-width: 350px" class="img-fluid" alt="SMK Baling.png">
            </div>
    
            <div class="mb-4 h5">
                {{ __('Please Enter your new password below.') }}
            </div>
    
            <!-- Email Address -->
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }}</label>
    
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" readonly required autofocus autocomplete="username">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <!-- Password -->
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('New Password') }}</label>
    
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <!-- Confirm Password -->
            <div class="row mb-3">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Confirm Password') }}</label>
    
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="confirm-password">
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="d-flex justify-content-center mt-2">
                <button type="submit" class="btn text-white fw-bold verification-button">
                    {{ __('Reset Password') }}
                </button>
            </div>

        </div>

    </form>
</x-guest-layout>
