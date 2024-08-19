<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

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
                <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $user->gender }}" placeholder="Gender" required autocomplete="ic" autofocus>
                
                @error('ic')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
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
        <button type="submit" class="btn text-white fw-bold user-save-button">Save</button>
        <button type="button" class="btn btn-outline-primary">Save</button>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <hr>
</section>
