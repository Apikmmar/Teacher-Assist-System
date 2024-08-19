<x-guest-layout>
    
    <div class="row mb-4 justify-content-center">
        <img src="https://upload.wikimedia.org/wikipedia/ms/6/67/UMP.png" style="max-width: 350px" class="img-fluid" alt="SMK Baling.png">
    </div>
    
    <div class="fade-in-text">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Oops! Forgot your password? Don’t worry—just enter your email address below, and we’ll send you a link to quickly reset it. You’ll be back to teaching in no time!') }}
        </div>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
    
    
            <!-- Email Address -->
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Registered Email') }}</label>
                
                <div class="col-md-6">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Registered Email" required autocomplete="email" autofocus>
                    
                    @error('email')
                    <span class="invalid-feedback text-start" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
    
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn text-white fw-bold verification-button">
                            {{ __('Send Verification') }}
                        </button>
                    </div>
                </div>
            </div>
    
        </form>
    </div>
</x-guest-layout>
