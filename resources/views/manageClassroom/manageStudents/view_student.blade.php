@extends('layouts.app', ['title' => 'Student Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <!-- Student Actions (Coordinator Only) -->
        @can('coordinator')
        <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-end">
            <div class="btn-group">
                <button type="button" class="btn btn-info text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear me-1"></i>Manage Student
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('edit_student', ['id' => $std->id]) }}"><i class="bi bi-pencil me-2"></i>Edit Student Info</a></li>
                    @if ($std->classroom_id && $std->status == 'Active')
                    <li><a class="dropdown-item" href="{{ route('student_subject', ['id' => $std->id]) }}"><i class="bi bi-book me-2"></i>Registered Subjects</a></li>
                    @endif
                </ul>
            </div>
        </div>
        @endcan

        <!-- Student Information Section -->
        @include('manageClassroom.partials.student_info')

        <!-- Subjects Taken Section -->
        @if ($std->classroom_id && $std->status == 'Active')
        <hr>
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-book me-2"></i>Subjects Taken</h5>
        </div>
        
        <div class="card-body">
            @if ($subsTaken->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="max-width: 400px;">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px">#</th>
                                <th scope="col"><i class="bi bi-book me-1"></i>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subsTaken as $index => $subs)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $subs }}</td>
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
                    <h5 class="text-muted">No Subjects Registered</h5>
                    <p class="text-muted">This student is not currently registered for any subjects</p>
                </div>
            @endif
        </div>
        @endif

        <!-- Transition Data Section -->
        @if ($transition)
        <hr>
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Transition Data</h5>
        </div>
        
        <div class="card-body">
            <div class="row g-3">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small mb-1">Transition Date</label>
                        <div class="form-control bg-light">{{ $transition->transition_date }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small mb-1">Reason of Changing School</label>
                        <div class="form-control bg-light">{{ $transition->change_school_reason }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small mb-1">Reason of Dropping School</label>
                        <div class="form-control bg-light">{{ $transition->reason_drop }}</div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small mb-1">Last Classroom</label>
                        <div class="form-control bg-light">{{ $transition->classID->name ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small mb-1">New School Name</label>
                        <div class="form-control bg-light">{{ $transition->new_school_name }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Delete Button -->
        @can('coordinator')
        <div class="d-flex justify-content-end pt-3">
            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $std->id }}" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i>Delete Student
            </button>
        </div>

        @include('layouts.partials.modal', [
            'id' => $std->id, 
            'name' => "Are you sure you want to remove " . $std->name . " from the database?",
            'deleteRoute' => route('delete_student.delete', ['id' => $std->id]),
            'method' => 'DELETE'
        ])
        @endcan
    </div>
@endsection