<x-guest-layout>

    <div class="row justify-content-center">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- SMB Photo --}}
            <div class="row mb-4 justify-content-center">
                <img src="{{ asset('asset/default-image/smkb_logo.jpg') }}" style="max-width: 180px" class="img-fluid" alt="SMK Baling.png">
            </div>
            
            <!-- IC Number -->
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ old('ic') }}" placeholder="Identity Card Number" required autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <!-- Password -->
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Password') }}</label>
                
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="d-flex justify-content-end mt-2">
                        @if (Route::has('password.request'))
                            <a class="fw-normal" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div>
                    <button type="submit" class="btn text-white fw-bold login-guest-button">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</x-guest-layout>
