@extends('manageExamReport.report_app', ['title' => 'Classroom '.  $class_name  .' Examination Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
            @include('layouts.message')
            
            <form action="{{ route('classroom_report', ['id' => $examination->id]) }}" method="get">
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
        @if ($studentGrades->isNotEmpty())
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="d-flex justify-content-between">
                        <div class="chart-container flex-fill">
                            <canvas id="examPieChart"></canvas>
                        </div>
                        <div class="exam-stats-card flex-fill ms-4">
                            <h5 class="card-title text-center mb-4">Subject Statistics</h5>
                            <p>Total Students: <span class="stat-value">{{ $totalStudent }}</span></p>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                        style="width: {{ ($passedStudents / $totalStudent) * 100 }}%" 
                                        aria-valuenow="{{ ($passedStudents / $totalStudent) * 100 }}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <p>Passed: <span class="stat-value text-success">{{ $passedStudents }} students ({{ number_format(($passedStudents / $totalStudent) * 100, 2) }}%)</span></p>
                            <p>Failed: <span class="stat-value text-danger">{{ $failedStudents }} students ({{ number_format(($failedStudents / $totalStudent) * 100, 2) }}%)</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-container">
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
                    @foreach ($studentGrades as $studentGrade)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $index }}</th>
                            <td>{{ $studentGrade->student->ic }}</td>
                            <td>{{ $studentGrade->student->name }}</td>
                            <td>{{ $studentGrade->student->classroom->name }}</td>
                            <td>{{ $grades[$studentGrade->student_id] }}</td>
                            <td>{{ $studentGrade->pointer }}</td>
                            <td>{{ $studentGrade->average_mark }}%</td>
                            <td class="text-uppercase">{{ $studentGrade->is_passed }}</td>
                        </tr>
                        @php $index++ @endphp

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @endif

    <script>
        window.classrooms = @json($classrooms);
        
        const passedStudents = @json($passedStudents);
        const failedStudents = @json($failedStudents);
    </script>
@endsection