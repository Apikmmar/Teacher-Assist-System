@extends('layouts.app', ['title' => 'Subject Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <!-- Subject Information Section -->
        <div class="card-header bg-white border-bottom-0">
            <h2 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>Subject Information</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('update_subject.update', ['id' => $subject->id]) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i>Subject Name <span class="text-danger">*</span>
                            </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name', $subject->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="form" class="form-label fw-bold">
                                <i class="bi bi-layers me-1"></i>Form <span class="text-danger">*</span>
                            </label>
                            <select id="form" name="form_id" class="form-select">
                                <option disabled>Select Form</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}" {{ $form->id == $subject->form_id ? 'selected' : '' }}>
                                        {{ $form->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text me-1"></i>Subject Description <span class="text-danger">*</span>
                            </label>
                            <textarea id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                        name="description">{{ old('description', $subject->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center pt-3 gap-3">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-check-circle me-1"></i> Update Info
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <hr>

    <!-- Assigned Teachers Section -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h2 class="mb-0"><i class="bi bi-people me-2"></i>Assigned Teachers</h2>
        </div>
        <div class="card-body">
            @if ($teachers->isNotEmpty())
                <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px">#</th>
                                <th scope="col"><i class="bi bi-person-badge me-1"></i>Teacher IC</th>
                                <th scope="col"><i class="bi bi-person me-1"></i>Teacher Name</th>
                                <th scope="col" class="text-center" style="width: 120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $index => $teacher)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $teacher->ic }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td class="text-center">
                                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" 
                                                class="btn btn-sm btn-danger rounded-pill px-3">
                                            <i class="bi bi-trash"></i> Drop
                                        </button>

                                        @include('layouts.partials.modal', [
                                            'id' => $subject->id, 
                                            'name' => "Are you sure you want to remove " . $teacher->name . " from teaching ". $subject->name ."?",
                                            'deleteRoute' => route('edit_subject.drop_teacher', ['id' => $subject->id, 'teacher_id' => $teacher->id]),
                                            'method' => 'DELETE'
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
                    </div>
                    <h4 class="text-muted">No Teachers Assigned</h4>
                    <p class="text-muted">Add teachers using the section below</p>
                </div>
            @endif
        </div>

        <hr>

    <!-- Add New Teacher Section -->
        <div class="card-header bg-white border-bottom-0 py-3">
            <h2 class="mb-0"><i class="bi bi-person-plus me-2"></i>Add New Teacher</h2>
        </div>
        <div class="card-body">
            @if ($newTeachers->isNotEmpty())
                <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px">#</th>
                                <th scope="col"><i class="bi bi-person-badge me-1"></i>Teacher IC</th>
                                <th scope="col"><i class="bi bi-person me-1"></i>Teacher Name</th>
                                <th scope="col" class="text-center" style="width: 120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newTeachers as $index => $teacher)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $teacher->ic }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('edit_subject.add_teacher', ['id' => $subject->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                            <button class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="bi bi-plus"></i> Add
                                            </button>
                                        </form>
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
                    <h4 class="text-muted">No Available Teachers</h4>
                    <p class="text-muted">All teachers are already assigned to this subject</p>
                </div>
            @endif
        </div>
    </div>
@endsection