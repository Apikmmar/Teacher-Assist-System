@extends('layouts.app', ['title' => 'Examination Classroom'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="mt-2">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">Examination Name</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" value="{{ $examination->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="release_date" class="col-md-4 col-form-label text-md-end fw-bold">Release Date</label>
                        <div class="col-md-8">
                            <input id="release_date" type="text" class="form-control" value="{{ $examination->release_date }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="start_date" class="col-md-4 col-form-label text-md-end fw-bold">Duration</label>
                        <div class="col-md-8">
                            <input id="start_date" type="text" class="form-control" value="{{ $examination->start_date }} until {{ $examination->end_date }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="type" class="col-md-4 col-form-label text-md-end fw-bold">Examination Type</label>
                        <div class="col-md-8">
                            <input id="type" type="text" class="form-control" value="{{ $examination->type }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="mt-2">
            <header>
                <h4 class="text-lg font-medium text-gray-900">Select Classroom To Insert Marks</h4>
            </header>
            <div class="d-flex justify-content-start">

                @if ($subjectClass)
                    <table class="table table-hover" style="max-width: 750px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">Form</th>
                                <th scope="col" class="text-center">Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjectClass as $index => $subject)
                                <tr class="align-middle teacher-list">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subject['subjectTeach'] }}</td>
                                    <td>{{ $subject['subjectForm'] }}</td>
                                    <td>
                                        @foreach ($subject['classes'] as $class)
                                            <div class="d-flex justify-content-start align-items-center mb-2">
                                                <span>{{ $class['className'] }}</span>
                                                &nbsp;&nbsp;
                                            @if ($class['markAvailability'] == 'No Grade')
                                                <a href="{{ route('students_exam_mark', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-primary tr-button">
                                                    Add Marks
                                                </a>

                                            @elseif($class['markAvailability'] == 'Has Grade')
                                                <a href="{{ route('registered_exam_marks', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-warning text-white tr-button">
                                                    Update Mark
                                                </a>
                                                &nbsp;
                                                <a href="{{ route('exam_mark_feedbacks', ['class_id' => $class['classID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-sm btn-primary text-white tr-button">
                                                    Add Feedback
                                                </a>
                                            @endif
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="d-flex justify-content-center mt-2">
                        <h4 class="fw-bold">N/A</h4>
                    </div>
                @endif
            </div>
        </div>

    @if ($subjectStudentElective)
        <hr>
        <div class="mt-2">
            <header>
                <h4 class="text-lg font-medium text-gray-900">Elective Subject To Insert Marks</h4>
            </header>
            <div>
                <table class="table table-hover" style="max-width: 750px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Student's Name</th>
                            <th scope="col" class="text-center">Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjectStudentElective as $index => $subject)
                            <tr class="align-middle teacher-list">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subject['subjectTeach'] }}</td>
                                <td>{{ $subject['studentName'] }}</td>
                                <td>

                                    @if ($subject['stdMarkAvailability'] == 'No Grade')
                                        <a href="{{ route('elective_subject_mark', ['std_id' => $subject['studentID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-primary tr-button">Add Mark</a>
                                    @elseif (($subject['stdMarkAvailability'] == 'Has Grade'))
                                        <a href="{{ route('edit_elective_subject_mark', ['std_id' => $subject['studentID'], 'subject_id' => $subject['subjectID'], 'exam_id' => $examination->id]) }}" class="btn btn-warning text-white tr-button">Update Mark</a>
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
