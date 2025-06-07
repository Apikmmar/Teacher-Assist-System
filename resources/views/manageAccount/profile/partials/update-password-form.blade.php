<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-primary">
            <i class="bi bi-shield-lock me-2"></i>{{ __('Update Password') }}
        </h3>
        <p class="text-muted mb-0">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row mb-3">
            <label for="current_password" class="col-md-3 col-form-label fw-bold">
                <i class="bi bi-lock me-1"></i>Current Password
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <input id="current_password" name="current_password" type="password" 
                           class="form-control @error('current_password') is-invalid @enderror" 
                           placeholder="Enter current password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-3 col-form-label fw-bold">
                <i class="bi bi-key me-1"></i>New Password
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <input id="password" name="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter new password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters with letters and numbers</small>
            </div>
        </div>

        <div class="row mb-4">
            <label for="password_confirmation" class="col-md-3 col-form-label fw-bold">
                <i class="bi bi-key-fill me-1"></i>Confirm Password
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           class="form-control" 
                           placeholder="Confirm new password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button type="reset" class="btn btn-outline-secondary px-4 rounded-pill">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
            </button>
            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                <i class="bi bi-save me-1"></i>Update Password
            </button>
        </div>
    </form>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.innerHTML = type === 'password' 
                    ? '<i class="bi bi-eye"></i>' 
                    : '<i class="bi bi-eye-slash"></i>';
            });
        });
    </script>
</section>