@extends('layouts.app', ['title' => 'Edit Student'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Student Edit Form -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Student Information</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('edit_student.update', ['id' => $std->id]) }}" method="post">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ $std->name }}" autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Identity Card Number -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Identity Card Number</label>
                        <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" 
                               name="ic" value="{{ $std->ic }}" autocomplete="ic">
                        @error('ic')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Age (Readonly) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Age</label>
                        <div class="form-control bg-light">{{ $age }} years old</div>
                    </div>
                    
                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                            <option disabled value="NULL" {{ is_null($std->status) ? 'selected' : '' }}>Student Status</option>
                            <option value="Active" {{ $std->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $std->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Student ID (Readonly) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Student ID</label>
                        <div class="form-control bg-light">{{ $std->student_id }}</div>
                    </div>
                    
                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Date of Birth</label>
                        <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" 
                               name="dob" value="{{ $std->dob }}">
                        @error('dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Date of Joining School -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Date of Joining School</label>
                        <input id="join_school_date" type="date" class="form-control @error('join_school_date') is-invalid @enderror" 
                               name="join_school_date" value="{{ $std->join_school_date }}">
                        @error('join_school_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Classroom (if assigned) -->
                    @if ($std_class)
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Classroom</label>
                        <select id="classroom_id" name="classroom_id" class="form-select @error('classroom_id') is-invalid @enderror">
                            <option value="">Select Classroom</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @if($class->id == $std_class->id) selected @endif>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @endif
                    
                    <!-- Form Actions -->
                    <div class="col-12 text-end pt-3">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Update Student
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Classroom Section (for students without class) -->
        @if (is_null($std->classroom_id) && ($std->status == 'Active'))
        <hr>
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Assign Classroom</h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('edit_student.add_class', ['id' => $std->id]) }}" method="post">
                @csrf
                @method('PATCH')
                
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-muted small mb-1">Select Classroom</label>
                        <select id="classroom_id" name="classroom_id" class="form-select @error('classroom_id') is-invalid @enderror">
                            <option value="">Select Classroom</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('classroom_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-center pt-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i>Add Class
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <!-- Drop Student Section (Coordinator Only) -->
        @can('coordinator')
        @if ($std->status == 'Active')
        <hr>
        <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-person-x me-2"></i>Drop Student</h5>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="dropStudentSwitch" style="transform: scale(1.3);">
            </div>
        </div>
        
        <div class="card-body" id="dropStudentForm" style="display: none;">
            <form action="{{ route('transition_student.create', ['id' => $std->id]) }}" method="post">
                @csrf
                <div class="row g-3">
                    <!-- Reason for Change School -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Reason for Changing School</label>
                        <input type="text" class="form-control @error('change_school_reason') is-invalid @enderror" 
                               name="change_school_reason" placeholder="Enter reason">
                        @error('change_school_reason')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- New School Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">New School Name</label>
                        <input type="text" class="form-control @error('new_school_name') is-invalid @enderror" 
                               name="new_school_name" placeholder="Enter school name">
                        @error('new_school_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Reason for Drop School -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Reason for Dropping School</label>
                        <input type="text" class="form-control @error('reason_drop') is-invalid @enderror" 
                               name="reason_drop" placeholder="Enter reason">
                        @error('reason_drop')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Transition Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Transition Date</label>
                        <input type="date" class="form-control @error('transition_date') is-invalid @enderror" 
                               name="transition_date">
                        @error('transition_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="col-12 text-end pt-3">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-person-x me-1"></i>Drop Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endif
        @endcan
    </div>

    <script>
        // Toggle drop student form
        document.getElementById('dropStudentSwitch').addEventListener('change', function() {
            const form = document.getElementById('dropStudentForm');
            form.style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection