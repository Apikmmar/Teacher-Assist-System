@extends('manageExamReport.report_app', ['title' => 'Main Report'])

@section('content')
    <div class="container fade-in-text">
        <div class="form-container">
            <form action="{{ route('subject_report', ['id' => $examination->id]) }}" method="get">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row mb-3">
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
                        <div class="row mb-3">
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
        <div class="form-container">
            <table class="table table-hover">
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
    </div>
    @endif


    <script>
        window.subjects = @json($subjects);
    </script>
@endsection