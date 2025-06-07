@extends('layouts.app', ['title' => 'Student Performance'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-graph-up me-2"></i>Student Performance</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-person-fill me-1"></i>{{ $student->name }} | 
                    <i class="bi bi-journal-bookmark me-1"></i>{{ $examination->name }}
                </p>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Identity Card Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" value="{{ $student->ic }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Gender</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" value="{{ $student->gender }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Class Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" value="{{ $class->name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Student Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" value="{{ $student->name }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Date of Birth</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" value="{{ $student->dob }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-medium text-muted">Examination Duration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext" 
                                    value="{{ $examination->start_date }} to {{ $examination->end_date }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-header bg-white border-0 pt-3 pb-2">
            <h4 class="fw-medium mb-0"><i class="bi bi-list-check me-2"></i>Subject Results</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive rounded-3 border overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-medium text-muted">#</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-book me-2"></i>Subject</th>
                            <th scope="col" class="fw-medium text-center"><i class="bi bi-percent me-2"></i>Mark</th>
                            <th scope="col" class="fw-medium text-center"><i class="bi bi-award me-2"></i>Grade</th>
                            <th scope="col" class="fw-medium text-center"><i class="bi bi-clipboard-check me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stdResult as $index => $result)
                            <tr class="border-top">
                                <td class="ps-4 text-muted fw-medium">{{ 1 + $index }}</td>
                                <td>{{ $result->subName }}</td>
                                <td class="text-center">{{ $result->marks }}</td>
                                <td class="text-center">{{ $result->grade }}</td>
                                <td class="text-center text-uppercase {{ $result->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                                    <span class="badge bg-{{ $result->is_passed === 'passed' ? 'success' : 'danger' }}-subtle text-{{ $result->is_passed === 'passed' ? 'success' : 'danger' }}">
                                        {{ $result->is_passed }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Position In Class</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold">{{ $placeInClass }} / {{ $totalStudentInClass }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Position In Form</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold">{{ $placeInForms }} / {{ $totalStudentInForm }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Total Marks</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold">{{ $stdReport->total_mark }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Average Mark</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold">{{ $stdReport->average_mark }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Pointer</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold">{{ $stdReport->pointer }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-6 col-form-label fw-medium text-muted">Overall Status</label>
                        <div class="col-sm-6">
                            <div class="form-control-plaintext fw-bold text-uppercase {{ $stdReport->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                                <span class="badge bg-{{ $stdReport->is_passed === 'passed' ? 'success' : 'danger' }}-subtle text-{{ $stdReport->is_passed === 'passed' ? 'success' : 'danger' }}">
                                    {{ $stdReport->is_passed }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('student_ferformance.update_feedback', ['id' => $stdReport->id]) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <label for="feedback" class="form-label fw-medium">Feedback:</label>
                        <input type="text" class="form-control" name="feedback" id="feedback" 
                                value="{{ $stdReport->feedback }}" placeholder="Enter feedback">
                    </div>
                    <div class="col-md-4 pt-4">
                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="update" 
                                    class="btn btn-primary px-4 py-2 shadow-sm flex-grow-1">
                                <i class="bi bi-save me-1"></i>Update
                            </button>
                            @if (($stdReport->feedback == '-') || ($stdReport->feedback == ''))
                                <button type="reset" class="btn btn-outline-danger px-4 py-2 shadow-sm">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                </button>
                            @else
                                <button type="submit" name="action" value="delete" 
                                        class="btn btn-outline-danger px-4 py-2 shadow-sm">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection