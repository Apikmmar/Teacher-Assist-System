@extends('layouts.app', ['title' => 'Register New Subject'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Subject Information Section -->
        <div class="mb-4">
            <h4 class="mb-3"><i class="bi bi-book me-2"></i>Subject Information</h4>
            
            <form action="{{ route('new_subject.create') }}" method="post">
                @csrf
                
                <div class="row g-3">
                    <!-- Subject Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Subject Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Form -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small mb-1">Form <span class="text-danger">*</span></label>
                        <select id="form" name="form" class="form-select @error('form') is-invalid @enderror">
                            <option selected disabled>Select Form</option>
                            @foreach ($forms as $form)
                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                            @endforeach
                        </select>
                        @error('form')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Subject Description -->
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small mb-1">Subject Description <span class="text-danger">*</span></label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="3"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <hr>
                <!-- Assign Teacher Section -->
                <div>
                    <h4 class="mb-3"><i class="bi bi-person-plus me-2"></i>Assign Teacher to Teach Subject</h4>
                    
                    @if ($teachers->isNotEmpty())
                        <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px">#</th>
                                        <th scope="col"><i class="bi bi-person-vcard me-1"></i>Teacher IC Number</th>
                                        <th scope="col"><i class="bi bi-person me-1"></i>Teacher Name</th>
                                        <th scope="col" class="text-center"><i class="bi bi-check-circle me-1"></i>Assign</th>
                                    </tr>
                                </thead>
                                <tbody id="teacherTableBody">
                                    @foreach ($teachers as $index => $teacher)
                                    <tr class="align-middle teacher-list" data-age="{{ $teacher->age ?? 0 }}">
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $teacher->ic }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" value="{{ $teacher->id }}" 
                                                       name="teachers[]" id="teacher-{{ $teacher->id }}"
                                                       {{ in_array($teacher->id, $teacherSelected) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="bi bi-person-x" style="font-size: 3rem; opacity: 0.2"></i>
                            </div>
                            <h5 class="text-muted">No Teachers Registered</h5>
                            <p class="text-muted">There are currently no teachers available to assign</p>
                        </div>
                    @endif
                    
                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Add Subject
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection