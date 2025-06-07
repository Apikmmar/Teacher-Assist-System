@extends('layouts.app', ['title' => 'My Class Feedback'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-chat-square-text me-2"></i>Class Feedback</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-journal-bookmark me-1"></i>{{ $exam->name }} | 
                    <i class="bi bi-people-fill me-1"></i>{{ $classroom->name }}
                </p>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="exam-name" class="col-sm-4 col-form-label fw-medium text-muted">Examination Name</label>
                        <div class="col-sm-8">
                            <input id="exam-name" type="text" class="form-control-plaintext" 
                                value="{{ $exam->name }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="classroom-name" class="col-sm-4 col-form-label fw-medium text-muted">Classroom Name</label>
                        <div class="col-sm-8">
                            <input id="classroom-name" type="text" class="form-control-plaintext" 
                                value="{{ $classroom->name }}" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="num-students" class="col-sm-4 col-form-label fw-medium text-muted">Number of Students</label>
                        <div class="col-sm-8">
                            <input id="num-students" type="text" class="form-control-plaintext" 
                                value="{{ $classroom->num_student }} students" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="card-header bg-white border-0 pt-3 pb-2">
            <h4 class="fw-medium mb-0"><i class="bi bi-people me-2"></i>Student List</h4>
        </div>
        <div class="card-body p-0">
            @if ($classroom->students->isNotEmpty())
                <div class="table-responsive rounded-3 border overflow-hidden">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Student ID</th>
                                <th scope="col" class="fw-medium text-center pe-4"><i class="bi bi-clipboard-data me-2"></i>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classroom->students as $student)
                                <tr class="border-top">
                                    <td class="ps-4 text-muted fw-medium">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->ic }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('student_ferformance.feedback', ['examID' => $exam->id, 'stdID' => $student->id]) }}" 
                                            class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 my-4">
                    <div class="mb-3">
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
                    </div>
                    <h4 class="text-muted mb-2">No students found</h4>
                    <p class="text-muted">There are no students in this classroom</p>
                </div>
            @endif
        </div>
    </div>
@endsection