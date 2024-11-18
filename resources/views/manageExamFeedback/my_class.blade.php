@extends('layouts.app', ['title' => 'My Class Feedback'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="exam-name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }}</label>
                        <div class="col-md-8">
                            <input id="exam-name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="exam-name" value="{{ $exam->name }}" readonly autocomplete="name" autofocus>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="classroom-name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom Name') }}</label>
                        <div class="col-md-8">
                            <input id="classroom-name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="classroom-name" value="{{ $classroom->name }}" readonly autocomplete="name" autofocus>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="num-students" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Number of Students') }}</label>
                        <div class="col-md-8">
                            <input id="num-students" type="text" class="form-control @error('ic') is-invalid @enderror" 
                                name="num-students" value="{{ $classroom->num_student }} students" readonly autocomplete="ic" autofocus>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>

        <div class="d-flex justify-content-center">
            @if ($classroom->students->isNotEmpty())
                <table class="table table-hover" style="max-width: 700px; width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Identity Card Number</th>
                            <th scope="col">Student ID</th>
                            <th scope="col" class="text-center">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classroom->students as $index => $student)
                            <tr class="align-middle teacher-list">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->ic }}</td>
                                <td>{{ $student->student_id }}</td>
                                <td class="text-center">
                                    <a href="{{ route('student_ferformance.feedback', ['examID' => $exam->id, 'stdID' => $student->id]) }}" class="btn btn-primary tr-button">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">No students found in this classroom.</p>
            @endif
        </div>
    </div>
@endsection
