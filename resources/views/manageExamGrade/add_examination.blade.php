@extends('layouts.app', ['title' => 'Add New Examination'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <form action="{{ route('create.add_examination') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <h4 class="mb-3"><i class="bi bi-clipboard2-plus me-2"></i>Examination Details</h4>
                
                <div class="row g-3">
                    <!-- Examination Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Examination Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" placeholder="Examination Name" autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Empty column for alignment -->
                    <div class="col-md-6"></div>
                    
                    <!-- Start Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Start Date <span class="text-danger">*</span></label>
                        <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               name="start_date" required>
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- End Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">End Date <span class="text-danger">*</span></label>
                        <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               name="end_date" required>
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Mark Release Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Mark Release Date <span class="text-danger">*</span></label>
                        <input id="release_date" type="date" class="form-control @error('release_date') is-invalid @enderror" 
                               name="release_date" required>
                        @error('release_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Empty column for alignment -->
                    <div class="col-md-6"></div>
                    
                    <!-- Examination Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Examination Type <span class="text-danger">*</span></label>
                        <select id="exam_type" name="type" class="form-select @error('type') is-invalid @enderror">
                            <option selected disabled value="NULL">Select Examination Type</option>
                            <option value="Early Term Examination">Early Term Examination</option>
                            <option value="Mid Term Examination">Mid Term Examination</option>
                            <option value="Final Term Examination">Final Term Examination</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Other Examination Type (conditional) -->
                    <div class="col-md-6" id="otherExam" style="display: none;">
                        <label class="form-label fw-bold text-muted small mb-1">Specify Examination Type</label>
                        <input type="text" name="otherExam" class="form-control" placeholder="Please specify">
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="col-12 text-end pt-3">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Register
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Show/hide other exam type field based on selection
        document.getElementById('exam_type').addEventListener('change', function() {
            const otherExamField = document.getElementById('otherExam');
            otherExamField.style.display = this.value === 'Other' ? 'block' : 'none';
        });
    </script>
@endsection