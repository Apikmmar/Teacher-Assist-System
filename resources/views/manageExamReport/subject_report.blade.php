@extends('manageExamReport.report_app', ['title' => 'Subject Examination Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
            @include('layouts.message')

            <form action="{{ route('subject_report', ['id' => $examination->id]) }}" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="form-select" class="col-md-4 col-form-label text-md-end fw-bold">Select Form</label>
                            <div class="col-md-6">
                                <select id="form-select" name="form" class="form-select" aria-label="Form">
                                    <option selected disabled>Select Form</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="subject-select" class="col-md-4 col-form-label text-md-end fw-bold">Select Subject</label>
                            <div class="col-md-8">
                                <select id="subject-select" name="subject_id" class="form-select" aria-label="Subject" disabled>
                                    <option selected disabled>Select Subject</option>
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

        @if ($examResults->isNotEmpty())
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="d-flex justify-content-between mb-4">
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
            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Class</th>
                        <th scope="col">Marks(Grade)</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examResults as $index => $examResult)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ 1 + $index }}</th>
                            <td>{{ $examResult->student->ic }}</td>
                            <td>{{ $examResult->student->name }}</td>
                            <td>{{ $examResult->student->classroom->name }}</td>
                            <td>{{ $examResult->marks }} ({{ $examResult->grade }})</td>
                            <td class="text-uppercase">{{ $examResult->is_passed }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        window.subjects = @json($subjects);

        const passedStudents = @json($passedStudents);
        const failedStudents = @json($failedStudents);

        const data = {
            labels: ['Passed', 'Failed'],
            datasets: [{
                label: 'Exam Results',
                data: [passedStudents, failedStudents],
                backgroundColor: ['#4CAF50', '#F44336'],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        enabled: true,
                    },
                },
            },
        };

        const examPieChart = new Chart(
            document.getElementById('examPieChart'),
            config
        );
    </script>

@endsection
