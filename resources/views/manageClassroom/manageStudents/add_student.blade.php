@extends('layouts.app', ['title' => 'Register New Student'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Student Registration Form -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Student Registration</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('add_student.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Identity Card Number -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Identity Card Number <span class="text-danger">*</span></label>
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" 
                               name="ic" placeholder="Identity Card Number" autocomplete="ic" autofocus>
                        @error('ic')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" placeholder="Name" required autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Gender <span class="text-danger">*</span></label>
                        <select id="user_gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option selected disabled>Select Gender</option>
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Date of Birth <span class="text-danger">*</span></label>
                        <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" 
                               name="dob" value="{{ old('dob') }}" required>
                        @error('dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Date of Joining School -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Date of Joining School <span class="text-danger">*</span></label>
                        <input id="jsd" type="date" class="form-control @error('jsd') is-invalid @enderror" 
                               name="jsd" value="{{ old('jsd') }}" required>
                        @error('jsd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select">
                            <option selected value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <!-- Classroom -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-muted small mb-1">Classroom</label>
                        <select id="classroom" name="classroom" class="form-select">
                            <option selected value="">Not Applicable</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="col-12 text-end pt-3">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Add Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        
        <!-- Bulk Upload Section -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Upload Students</h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('import.student') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-muted small mb-1">CSV File</label>
                        <input type="file" class="form-control @error('import_csv') is-invalid @enderror" 
                               id="import_csv" name="import_csv" accept=".csv">
                        @error('import_csv')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Upload a CSV file containing student data</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm w-100">
                            <i class="bi bi-upload me-1"></i>Import Students
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection