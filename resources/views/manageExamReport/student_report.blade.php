@extends('layouts.app', ['title' => 'Student Report'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h2 class="mb-1"><i class="bi bi-file-earmark-text me-2"></i>Student Examination Report</h2>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Detailed performance report for {{ $student->name }}</p>
                </div>
                <a href="{{ route('download_report', ['exam' => $examination->id ,'stdID' => $student->id]) }}" 
                    class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-download me-1"></i>Download Report
                </a>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-credit-card me-1"></i>Identity Card Number
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $student->ic }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-gender-ambiguous me-1"></i>Gender
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $student->gender }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-people me-1"></i>Class Name
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $class->name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-person me-1"></i>Student Name
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $student->name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-calendar me-1"></i>Date of Birth
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $student->dob }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-journal-text me-1"></i>Examination Name
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $examination->name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-calendar-range me-1"></i>Examination Duration
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" class="form-control-plaintext border-bottom py-2" value="{{ $examination->start_date.' - '.$examination->end_date }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h4 class="card-title mb-4"><i class="bi bi-list-check me-2"></i>Subject Results</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col" class="text-center">Mark</th>
                            <th scope="col" class="text-center">Grade</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stdResult as $index => $result)
                            <tr>
                                <th scope="row" class="text-center">{{ 1 + $index }}</th>
                                <td>{{ $result->subName }}</td>
                                <td class="text-center">{{ $result->marks }}</td>
                                <td class="text-center">{{ $result->grade }}</td>
                                <td class="text-center text-uppercase fw-bold {{ $result->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                                    {{ $result->is_passed }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body">
            <h4 class="card-title mb-4"><i class="bi bi-graph-up me-2"></i>Performance Summary</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex flex-column p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold"><i class="bi bi-trophy me-2"></i>Position In Class</span>
                            <span class="badge bg-primary rounded-pill">{{ $placeInClass }} / {{ $totalStudentInClass }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><i class="bi bi-award me-2"></i>Position In Form</span>
                            <span class="badge bg-primary rounded-pill">{{ $placeInForms }} / {{ $totalStudentInForm }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex flex-column p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold"><i class="bi bi-calculator me-2"></i>Total Marks</span>
                            <span class="badge bg-info rounded-pill">{{ $stdReport->total_mark }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Average Mark</span>
                            <span class="badge bg-info rounded-pill">{{ $stdReport->average_mark }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex flex-column p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold"><i class="bi bi-star me-2"></i>Pointer</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $stdReport->pointer }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><i class="bi bi-check-circle me-2"></i>Overall Status</span>
                            <span class="badge rounded-pill {{ $stdReport->is_passed === 'passed' ? 'bg-success' : 'bg-danger' }}">
                                {{ strtoupper($stdReport->is_passed) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h4 class="card-title mb-3"><i class="bi bi-chat-left-text me-2"></i>Teacher's Feedback</h4>
            <div class="p-3 bg-light rounded">
                <p class="mb-0">{{ $stdReport->feedback ?: 'No feedback provided yet.' }}</p>
            </div>
        </div>
    </div>
@endsection