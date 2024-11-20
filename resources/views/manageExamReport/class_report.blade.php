@extends('manageExamReport.report_app', ['title' => 'Main Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
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
        <div class="form-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($studentGrades as $index => $studentGrade)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ 1 + $index }}</th>
                            <td>{{ $studentGrade->student }}</td>
                            <td>{{ $studentGrade->student }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @endif

    <script>
        window.classrooms = @json($classrooms);
    </script>
@endsection