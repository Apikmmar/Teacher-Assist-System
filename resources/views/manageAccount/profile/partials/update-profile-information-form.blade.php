<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Profile') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your information is correct.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-4">
                <div class="d-flex justify-content-center align-items-center">

                @if (!empty($user->photo))
                    <img src="{{ asset('storage/asset/profile-photos/' . $user->photo) }}" style="width: 250px; height: 250px; object-fit: cover;" class="img-fluid rounded-circle" alt="SMK Baling.png">
                @else    
                    <img src="{{ asset('asset/default-image/profile.png') }}" style="width: 250px; height: 250px; object-fit: cover;" class="img-fluid rounded-circle" alt="SMK Baling.png">
                @endif

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
                    <label for="teacher_id" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Teacher ID') }}</label>
                    
                    <div class="col-md-6">
                        <input id="teacher_id" type="text" class="form-control @error('teacher_id') is-invalid @enderror" name="teacher_id" value="{{ $user->teacher_id }}" placeholder="Teacher ID" autocomplete="teacher_id" autofocus>
                        
                        @error('teacher_id')
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
                    <label for="gender" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }} <label class="red-aestrist">*</label></label>
        
                        <div class="col-md-6">
                            <select id="user_gender" name="gender" class="form-select" aria-label="Gender">
                                <option value="Men" {{ $user->gender === 'Men' ? 'selected' : '' }}>Men</option>
                                <option value="Women" {{ $user->gender === 'Women' ? 'selected' : '' }}>Women</option>
                            </select>
                        </div>                        
                    </div>
        
                <div class="row mb-3">
                    <label for="contact" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Contact') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ $user->contact }}" placeholder="Contact" required autocomplete="contact" autofocus>
                        
                        @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" placeholder="Email" required autocomplete="email" autofocus>
                        
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="verification" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Verification') }} <label class="red-aestrist">*</label></label>

                    <div class="col-md-6">
                        <input id="verification" type="file" class="form-control" name="verification">
                        @if($user->verification)
                            <small class="d-flex justify-content-end"><a href="{{ asset('storage/asset/verification-files/' . $user->verification) }}" download>View Current Verification</a></small>
                        @endif
                    </div>
                    
                </div>

                <div class="row mb-3">
                    <label for="verification" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('New Photo') }}</label>

                    <div class="col-md-6">
                        <input id="photo" type="file" class="form-control" name="photo" value="{{ $user->photo }}">
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
