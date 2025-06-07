<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-primary">
            <i class="bi bi-person-lines-fill me-2"></i>{{ __('Profile Information') }}
        </h3>
        <p class="text-muted mb-0">
            {{ __('Update your account\'s profile information and photo.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        @if (!empty($user->photo))
                            <img src="{{ asset('storage/asset/profile-photos/' . $user->photo) }}" 
                                 class="img-thumbnail rounded-circle profile-photo" 
                                 alt="Profile Photo">
                        @else    
                            <img src="{{ asset('asset/default-image/profile.png') }}" 
                                 class="img-thumbnail rounded-circle profile-photo" 
                                 alt="Default Profile">
                        @endif
                        <label for="photo" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle">
                            <i class="bi bi-camera"></i>
                        </label>
                        <input id="photo" type="file" class="d-none" name="photo">
                    </div>
                    <small class="text-muted d-block mt-2">Click photo to change</small>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row mb-3">
                    <label for="ic" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-credit-card me-1"></i>IC Number
                    </label>
                    <div class="col-md-9">
                        <input id="ic" type="text" class="form-control bg-light" 
                               value="{{ $user->ic }}" readonly>
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="teacher_id" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-person-badge me-1"></i>Teacher ID
                    </label>
                    <div class="col-md-9">
                        <input id="teacher_id" name="teacher_id" type="text" 
                               class="form-control @error('teacher_id') is-invalid @enderror" 
                               value="{{ $user->teacher_id }}" required>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="name" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-person me-1"></i>Full Name
                    </label>
                    <div class="col-md-9">
                        <input id="name" name="name" type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ $user->name }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="gender" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-gender-ambiguous me-1"></i>Gender
                    </label>
                    <div class="col-md-9">
                        <select id="gender" name="gender" class="form-select">
                            <option value="Men" {{ $user->gender === 'Men' ? 'selected' : '' }}>Male</option>
                            <option value="Women" {{ $user->gender === 'Women' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>                        
                </div>
        
                <div class="row mb-3">
                    <label for="contact" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-telephone me-1"></i>Contact
                    </label>
                    <div class="col-md-9">
                        <input id="contact" name="contact" type="text" 
                               class="form-control @error('contact') is-invalid @enderror" 
                               value="{{ $user->contact }}" required>
                        @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="email" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <div class="col-md-9">
                        <input id="email" name="email" type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ $user->email }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="verification" class="col-md-3 col-form-label fw-bold">
                        <i class="bi bi-file-earmark-check me-1"></i>Verification
                    </label>
                    <div class="col-md-9">
                        <input id="verification" name="verification" type="file" 
                               class="form-control">
                        @if($user->verification)
                            <small class="text-muted">
                                <a href="{{ asset('storage/asset/verification-files/' . $user->verification) }}" 
                                   target="_blank" class="text-decoration-none">
                                    <i class="bi bi-download me-1"></i>View Current Verification
                                </a>
                            </small>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-4">
                    <button type="reset" class="btn btn-outline-secondary px-4 rounded-pill">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                        <i class="bi bi-save me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    .profile-photo {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }
</style>

<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.profile-photo').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>