@extends('manageExamReport.report_app', ['title' => ($formName ?? 'Form') .' Report In Examination'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
            @include('layouts.message')

            <form action="{{ route('form_report', ['id' => $examination->id]) }}" method="get">
                <div class="col">
                    <div class="row">
                        <label for="form-select" class="col-md-4 col-form-label text-md-end fw-bold">Select Form</label>
                        <div class="col-md-6 d-flex align-items-center">
                            <select id="form-select-class" name="form_id" class="form-select me-2" aria-label="Form">
                                <option selected disabled>Select Form</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary tr-button" style="min-width: 120px;">View Report</button>
                        </div>
                    </div>
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
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($studentGrades as $studentGrade)
                    <tr class="align-middle teacher-list">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $studentGrade->student->ic }}</td>
                        <td>{{ $studentGrade->student->name }}</td>
                        <td>{{ $studentGrade->student->classroom->name }}</td>
                        <td>{{ $grades[$studentGrade->student_id] ?? 'N/A' }}</td>
                        <td>{{ $studentGrade->pointer }}</td>
                        <td class="text-uppercase {{ $studentGrade->is_passed === 'passed' ? 'text-success' : 'text-danger' }}">
                            {{ $studentGrade->is_passed }}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif
    
    </div>

    <script>
        const passedStudents = @json($passedStudents);
        const failedStudents = @json($failedStudents);
    </script>

@endsection