@extends('layouts.app', ['title' => 'Students Examination Mark'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-clipboard-plus me-2"></i>Add Examination Marks</h2>
                <p class="text-muted mb-0"><i class="bi bi-people-fill me-1"></i>Class: {{ $class->name }}</p>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="exam_name" class="col-sm-4 col-form-label fw-medium text-muted">Examination Name</label>
                        <div class="col-sm-8">
                            <input id="exam_name" type="text" class="form-control-plaintext" value="{{ $exam->name }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="subject_name" class="col-sm-4 col-form-label fw-medium text-muted">Subject Name</label>
                        <div class="col-sm-8">
                            <input id="subject_name" type="text" class="form-control-plaintext" value="{{ $subject->name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="class_name" class="col-sm-4 col-form-label fw-medium text-muted">Class Name</label>
                        <div class="col-sm-8">
                            <input id="class_name" type="text" class="form-control-plaintext" value="{{ $class->name }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="card-body">
            <h4 class="mb-3"><i class="bi bi-upload me-2"></i>Upload Student Marks</h4>
            <form id="uploadForm" enctype="multipart/form-data" class="mb-2">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <label for="marksFile" class="form-label text-muted">Select CSV File:</label>
                        <input type="file" id="marksFile" name="marksFile" accept=".csv" class="form-control" />
                    </div>
                    <div class="col-md-4 mt-md-0 mt-2 pt-4">
                        <button type="button" id="uploadButton" class="btn btn-success px-4 py-2 shadow-sm w-100">
                            <i class="bi bi-upload me-1"></i>Import Marks
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <hr>

        <form action="{{ route('add_exam_mark.create') }}" method="post">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <div class="card-header bg-white border-0 pt-3 pb-2">
                <h4 class="fw-medium mb-0"><i class="bi bi-list-check me-2"></i>Student Marks Entry</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive rounded-3 border overflow-hidden">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                                <th scope="col" class="fw-medium text-center"><i class="bi bi-percent me-2"></i>Marks</th>
                                <th scope="col" class="fw-medium text-center"><i class="bi bi-award me-2"></i>Grade</th>
                                <th scope="col" class="fw-medium text-center"><i class="bi bi-chat-left-text me-2"></i>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <input type="hidden" value="{{ $student->id }}" name="students_id[]">
                                <input type="hidden" value="{{ $class->id }}" name="class_id">

                                <tr class="border-top">
                                    <td class="ps-4 text-muted fw-medium">{{ 1 + $index }}</td>
                                    <td>{{ $student->ic }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group" style="max-width: 100px;">
                                                <input type="text" class="form-control text-center mark-input" name="student_marks[]" placeholder="Mark" aria-label="Mark input">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group" style="max-width: 100px;">
                                                <input type="text" class="form-control text-center grade-output" name="student_grades[]" placeholder="Grade" aria-label="Grade input" readonly>
                                            </div>
                                        </div>
                                        <input type="hidden" name="grade_values[]" class="grade-val-output">
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group" style="max-width: 200px;">
                                                <input type="text" class="form-control text-center" name="student_feedbacks[]" placeholder="Feedback" aria-label="Feedback input">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                    <i class="bi bi-check-circle me-1"></i>Save Marks
                </button>
                <button type="reset" class="btn btn-outline-danger px-4 py-2 shadow-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
            </div>
        </form>
    </div>
    
    <script>
        window.gradeRanges = @json($grades);
        window.students = @json($students)
    </script>
@endsection