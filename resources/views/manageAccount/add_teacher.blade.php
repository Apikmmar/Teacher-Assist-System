@extends('layouts.app', ['title' => 'Register New Teacher'])

@section('content')
    <div class="container fade-in-text">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
                <div>
                    <h2 class="mb-1"><i class="bi bi-person-plus me-2"></i>Teacher Registration</h2>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Fill in the details to register a new teacher</p>
                </div>
            </div>

            <form action="{{ route('register.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <label for="ic" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-credit-card me-1"></i>Identity Card Number <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="ic" type="text" class="form-control border-2 py-2 @error('ic') is-invalid @enderror" 
                            name="ic" placeholder="e.g. 990101-01-1234" autocomplete="ic" autofocus>
                        @error('ic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="name" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-person me-1"></i>Full Name <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="name" type="text" class="form-control border-2 py-2 @error('name') is-invalid @enderror" 
                            name="name" placeholder="e.g. Ahmad bin Ali" required autocomplete="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="teacher_id" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-person-badge me-1"></i>Teacher ID <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="teacher_id" type="text" class="form-control border-2 py-2 @error('teacher_id') is-invalid @enderror" 
                            name="teacher_id" placeholder="e.g. T2023001" required>
                        @error('teacher_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="user_gender" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-gender-ambiguous me-1"></i>Gender <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <select id="user_gender" name="gender" class="form-select border-2 py-2 @error('gender') is-invalid @enderror">
                            <option selected disabled>Select Gender</option>
                            <option value="Men">Male</option>
                            <option value="Women">Female</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="contact" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-telephone me-1"></i>Contact Number <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="contact" type="text" class="form-control border-2 py-2 @error('contact') is-invalid @enderror" name="contact" placeholder="e.g. 012-3456789" required>
                        @error('contact')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="email" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="email" type="email" class="form-control border-2 py-2 @error('email') is-invalid @enderror" 
                            name="email" placeholder="e.g. teacher@school.edu" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="password" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-lock me-1"></i>Password <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <div class="input-group">
                            <input id="password" type="password" class="form-control border-2 py-2 @error('password') is-invalid @enderror" 
                                name="password" placeholder="Create password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-check mt-2 d-flex justify-content-end">
                            <input class="form-check-input" type="checkbox" id="useIcAsPassword">
                            <label class="form-check-label ms-2" for="useIcAsPassword">
                                Set password as IC number
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-person-gear me-1"></i>Roles
                    </label>
                    <div class="col-md-8 col-lg-7 pt-2">
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"{{ isset($userRoles) && in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 pt-3">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-person-add me-1"></i>Register Teacher
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Form
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body p-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1"><i class="bi bi-upload me-2"></i>Bulk Teacher Registration</h4>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Upload a CSV file to register multiple teachers</p>
                </div>
            </div>

            <form action="{{ route('import.teacher') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="import_csv" class="form-label fw-medium">
                                <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV File
                            </label>
                            <div class="input-group">
                                <input type="file" class="form-control border-2 py-2" id="import_csv" name="import_csv" accept=".csv">
                                <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon">
                                    <i class="bi bi-upload me-1"></i>Browse
                                </button>
                            </div>
                            <div class="form-text">File format: .csv (Download template <a href="#">here</a>)</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm w-100">
                            <i class="bi bi-cloud-arrow-up me-1"></i>Import Teachers
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });

        // Set password as IC number
        document.getElementById('useIcAsPassword').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('password').value = document.getElementById('ic').value;
            } else {
                document.getElementById('password').value = '';
            }
        });
    </script>
@endsection