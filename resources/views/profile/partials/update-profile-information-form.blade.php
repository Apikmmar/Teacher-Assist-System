<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Profile') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your information is correct.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-4">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('asset/default-image/profile.png') }}" style="max-width: 250px;" class="img-fluid" alt="SMK Baling.png">
                </div>
            </div>

            <div class="col-8">
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                    
                    <div class="col-md-6">
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->ic }}" placeholder="Identity Card Number" readonly autocomplete="ic" autofocus>
                        
                        @error('ic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" placeholder="Name" required autocomplete="name" autofocus>
                        
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Teacher ID') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->teacher_id }}" placeholder="Teacher ID" required autocomplete="ic" autofocus>
                        
                        @error('ic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }} <label class="red-aestrist">*</label></label>
        
                        <div class="col-md-6">
                            <select id="user_gender" name="gender" class="form-select" aria-label="Gender">
                                <option value="Men" {{ $user->gender === 'Men' ? 'selected' : '' }}>Men</option>
                                <option value="Women" {{ $user->gender === 'Women' ? 'selected' : '' }}>Women</option>
                            </select>
                        </div>                        
                    </div>
        
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Contact') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->contact }}" placeholder="Contact" required autocomplete="ic" autofocus>
                        
                        @error('ic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->email }}" placeholder="Email" required autocomplete="ic" autofocus>
                        
                        @error('ic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Verification') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->verification }}" placeholder="Verification" required autocomplete="ic" autofocus>
                        
                        @error('ic')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="d-flex justify-content-center align-items-center mt-2 mb-4">
                <button type="submit" class="btn text-white user-save-button">Save</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </div>

    </form>
</section>
