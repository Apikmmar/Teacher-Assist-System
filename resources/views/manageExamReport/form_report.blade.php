@extends('manageExamReport.report_app', ['title' => 'Main Report'])

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

                    @php $index = 1; @endphp
                    @foreach ($studentGrades as $studentGrade)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $index }}</th>
                            <td>{{ $studentGrade->student->ic }}</td>
                            <td>{{ $studentGrade->student->name }}</td>
                            <td>{{ $studentGrade->student->classroom->name }}</td>
                            <td>{{ $grades[$studentGrade->student_id] }}</td>
                            <td>{{ $studentGrade->pointer }}</td>
                            <td class="text-uppercase">{{ $studentGrade->is_passed }}</td>
                        </tr>
                        @php $index++ @endphp

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @endif

@endsection