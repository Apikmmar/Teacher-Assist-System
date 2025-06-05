@extends('layouts.app', ['title' => 'Registered Subject of Classroom '. $class->name])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Registered Subjects Section -->
        <div class="card-header bg-white border-bottom-0">
            <h2 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>List of Registered Subjects</h2>
            <p class="text-muted mb-0">Class: {{ $class->name }}</p>
        </div>
        
        <div class="card-body">
        @if ($subjectsTaken->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px">#</th>
                            <th scope="col"><i class="bi bi-book me-1"></i>Subject Name</th>
                            <th scope="col"><i class="bi bi-person-badge me-1"></i>Current Teacher</th>
                            <th scope="col"><i class="bi bi-person-plus me-1"></i>Assign New Teacher</th>
                            <th scope="col" class="text-center" style="width: 200px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjectsTaken as $index => $subject)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td class="fw-medium">{{ $subject->subject->name }}</td>
                                <td>{{ $teacherNames[$subject->id] ?? 'Not assigned' }}</td>
                                <td>
                                    <form action="{{ route('edit.classsubject_teacher') }}" method="post" class="mb-0">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="subject" value="{{ $subject->subject->id }}">
                                        <input type="hidden" name="class" value="{{ $class->id }}">
                                        <select name="new_teacher" class="form-select form-select-sm">
                                            <option selected disabled>Select Teacher</option>
                                            @foreach ($registeredTeachers[$subject->id] as $teacher)
                                                <option value="{{ $teacher->teacher->id }}">{{ $teacher->teacher->name }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-warning text-white px-3 rounded-pill">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                    <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" 
                                            class="btn btn-sm btn-danger px-3 rounded-pill">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    </div>
                                </td>

                                @include('layouts.partials.modal', [
                                    'id' => $subject->id, 
                                    'name' => "Are you sure you want to remove " . $subject->subject->name . " from class ". $class->name ."?",
                                    'deleteRoute' => route('edit.dropclassroom_subject', ['id' => $subject->id, 'class_id' => $class->id]),
                                    'method' => 'DELETE'
                                ])
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-journal-x" style="font-size: 3rem; opacity: 0.2"></i>
                </div>
                <h4 class="text-muted">No Subjects Registered</h4>
                <p class="text-muted">Add subjects from the available list below</p>
            </div>
        @endif

        </div>
        <hr>
        <!-- Available Subjects Section -->
    @if ($subjectsNotTaken->isNotEmpty())
        <div class="card-header bg-white border-bottom-0 py-3">
            <h2 class="mb-0"><i class="bi bi-journal-plus me-2"></i>Available Subjects</h2>
        </div>
        
        <div class="card-body">
            <form action="{{ route('add.class_subject', ['id' => $class->id]) }}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px">Select</th>
                                <th scope="col" style="width: 50px">#</th>
                                <th scope="col"><i class="bi bi-book me-1"></i>Subject Name</th>
                                <th scope="col"><i class="bi bi-person-plus me-1"></i>Assign Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjectsNotTaken as $index => $subject)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                    name="subjects[{{ $subject->id }}][selected]" value="1">
                                        </div>
                                    </td>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>
                                        {{ $subject->name }}
                                        <input type="hidden" name="subjects[{{ $subject->id }}][subject_id]" value="{{ $subject->id }}">
                                    </td>
                                    <td>
                                        <select name="subjects[{{ $subject->id }}][assigned_teacher]" class="form-select form-select-sm">
                                            <option selected disabled>Select Teacher</option>
                                            @foreach ($notRegisteredTeachers[$subject->id] as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-save me-1"></i> Submit Selected
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    </div>
@endsection