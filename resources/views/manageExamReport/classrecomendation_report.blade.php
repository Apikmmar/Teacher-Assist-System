@extends('manageExamReport.report_app', ['title' => 'Classroom Recomendation '.  $class_name  .' Examination Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
            @include('layouts.message')
            
            <form action="{{ route('classrec_report', ['id' => $examination->id]) }}" method="get">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="form-select" class="col-md-4 col-form-label text-md-end fw-bold">Select Form</label>
                            <div class="col-md-6">
                                <select id="form-select-class" name="form" class="form-select" aria-label="Form">
                                    <option selected disabled>Select Form</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="subject-select" class="col-md-4 col-form-label text-md-end fw-bold">Select Classroom</label>
                            <div class="col-md-8">
                                <select id="class-select" name="classroom_id" class="form-select" aria-label="Subject" disabled>
                                    <option selected disabled>Select Classroom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center pt-2">
                    <button type="submit" class="btn btn-primary tr-button">View Report</button>
                </div>
            </form>
        </div>
        <br>
    @if ($upgradeClass->isNotEmpty())
        <div class="form-container">
            <p class="h4">Student That Recomended to Upgrade Class</p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Result</th>
                        <th scope="col">Pointer</th>
                        <th scope="col">Average Marks</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @php $index = 1; @endphp
                    @foreach ($upgradeClass as $studentGrade)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $index }}</th>
                            <td>{{ $studentGrade->student->ic }}</td>
                            <td>{{ $studentGrade->student->name }}</td>
                            <td>{{ $studentGrade->student->classroom->name }}</td>
                            <td>{{ $upgradegrades[$studentGrade->student_id] }}</td>
                            <td>{{ $studentGrade->pointer }}</td>
                            <td>{{ $studentGrade->average_mark }}%</td>
                            <td class="text-uppercase {{ $studentGrade->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                                {{ $studentGrade->is_passed }}
                            </td>
                        </tr>
                        @php $index++ @endphp

                    @endforeach

                </tbody>
            </table>
        </div>
    @endif

    @if ($downgradeClass->isNotEmpty())
        <br>
        <div class="form-container">
            <p class="h4">Student That Recomended to Downgrade Class</p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Result</th>
                        <th scope="col">Pointer</th>
                        <th scope="col">Average Marks</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @php $index = 1; @endphp
                    @foreach ($downgradeClass as $studentGrade)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $index }}</th>
                            <td>{{ $studentGrade->student->ic }}</td>
                            <td>{{ $studentGrade->student->name }}</td>
                            <td>{{ $studentGrade->student->classroom->name }}</td>
                            <td>{{ $downgradegrades[$studentGrade->student_id] }}</td>
                            <td>{{ $studentGrade->pointer }}</td>
                            <td>{{ $studentGrade->average_mark }}%</td>
                            <td class="text-uppercase {{ $studentGrade->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                                {{ $studentGrade->is_passed }}
                            </td>
                        </tr>
                        @php $index++ @endphp

                    @endforeach

                </tbody>
            </table>
        </div>
    @endif

    </div>

    <script>
        window.classrooms = @json($classrooms);
    </script>
@endsection