@extends('layouts.app', ['title' => 'Examination Classroom'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-journal-bookmark me-2"></i>Examination Classroom</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>{{ $examination->name }}</p>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-4 col-form-label fw-medium text-muted">Examination Name</label>
                        <div class="col-sm-8">
                            <input id="name" type="text" class="form-control-plaintext" value="{{ $examination->name }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="release_date" class="col-sm-4 col-form-label fw-medium text-muted">Release Date</label>
                        <div class="col-sm-8">
                            <input id="release_date" type="text" class="form-control-plaintext" value="{{ $examination->release_date }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 row">
                        <label for="start_date" class="col-sm-4 col-form-label fw-medium text-muted">Duration</label>
                        <div class="col-sm-8">
                            <input id="start_date" type="text" class="form-control-plaintext" value="{{ $examination->start_date }} until {{ $examination->end_date }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="type" class="col-sm-4 col-form-label fw-medium text-muted">Examination Type</label>
                        <div class="col-sm-8">
                            <input id="type" type="text" class="form-control-plaintext" value="{{ $examination->type }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>

        <div class="card-header bg-white border-0 pt-3 pb-2">
            <h4 class="fw-medium mb-0"><i class="bi bi-list-check me-2"></i>Select Classroom To Insert Marks</h4>
        </div>
        <div class="card-body">
            @if ($subjectClass)
                <div class="table-responsive rounded-3 border overflow-hidden" style="max-width: 700px;">
                    <table class="table table-hover align-middle mb-0" >
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-book me-2"></i>Subject Name</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-sort-numeric-up me-2"></i>Form</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-people me-2"></i>Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjectClass as $index => $subject)
                                <tr class="border-top">
                                    <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $subject['subjectTeach'] }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $subject['subjectForm'] }}</span>
                                    </td>
                                    <td>
                                        @foreach ($subject['classes'] as $class)
                                            <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                                <span>{{ $class['className'] }}</span>
                                                <div class="d-flex gap-2">
                                                    @if ($class['markAvailability'] == 'No Grade')
                                                        <a href="{{ route('students_exam_mark', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                            <i class="bi bi-plus-lg me-1"></i>Add Marks
                                                        </a>
                                                    @elseif($class['markAvailability'] == 'Has Grade')
                                                        <a href="{{ route('registered_exam_marks', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm text-white">
                                                            <i class="bi bi-pencil me-1"></i>Update
                                                        </a>
                                                        <a href="{{ route('exam_mark_feedbacks', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                            <i class="bi bi-chat-left-text me-1"></i>Feedback
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 my-4">
                    <div class="mb-3">
                        <i class="bi bi-journal-x" style="font-size: 3rem; opacity: 0.2"></i>
                    </div>
                    <h4 class="text-muted mb-2">No classes found</h4>
                    <p class="text-muted mb-3">You don't have any assigned classes for this examination</p>
                </div>
            @endif
        </div>

        <hr>

        @if ($subjectStudentElective)
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <h4 class="fw-medium mb-0"><i class="bi bi-list-stars me-2"></i>Elective Subject To Insert Marks</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive rounded-3 border overflow-hidden">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-book me-2"></i>Subject Name</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person me-2"></i>Student's Name</th>
                                <th scope="col" class="fw-medium text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjectStudentElective as $index => $subject)
                                <tr class="border-top">
                                    <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $subject['subjectTeach'] }}</div>
                                    </td>
                                    <td>{{ $subject['studentName'] }}</td>
                                    <td class="text-end pe-4">
                                        @if ($subject['stdMarkAvailability'] == 'No Grade')
                                            <a href="{{ route('elective_subject_mark', ['std_id' => $subject['studentID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-plus-lg me-1"></i>Add Mark
                                            </a>
                                        @elseif (($subject['stdMarkAvailability'] == 'Has Grade'))
                                            <a href="{{ route('edit_elective_subject_mark', ['std_id' => $subject['studentID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm text-white">
                                                <i class="bi bi-pencil me-1"></i>Update Mark
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection