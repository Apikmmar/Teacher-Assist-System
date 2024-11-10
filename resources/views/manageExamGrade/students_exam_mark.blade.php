@extends('layouts.app', ['title' => 'Students Examination Mark'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name', $exam->name) }}" readonly autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Subject Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name', $subject->name) }}" readonly autofocus>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name', $class->name) }}" readonly autofocus>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <form action="{{ route('add_exam_mark.create') }}" method="post">
            @csrf

            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <div class="d-flex justify-content-center">
                <div class="row">
                    <table class="table table-hover" style="min-width: 600px">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Identity Card Number</th>
                                <th scope="col">Name</th>
                                <th scope="col">Marks</th>
                                <th scope="col">Grade</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($students as $index => $student)
                            <input type="hidden" value="{{ $student->id }}" name="students_id[]">
                            <input type="hidden" value="{{ $class->id }}" name="class_id">

                            <tr class="align-middle teacher-list text-center" style="height: 40px;">
                                <th scope="row" class="py-1">{{ 1 + $index }}</th>
                                <td class="py-1">{{ $student->ic }}</td>
                                <td class="py-1">{{ $student->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group" style="max-width: 70px;">
                                            <input type="text" class="form-control text-center mark-input" name="student_marks[]" placeholder="Mark" style="height: 40px" aria-label="Mark input">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group" style="max-width: 70px;">
                                            <input type="text" class="form-control text-center grade-output" name="student_grades[]" placeholder="Grade" style="height: 40px" aria-label="Grade input" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" name="grade_values[]" class="grade-val-output">
                                </td>
                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center mt-2">
                <button type="submit" class="btn btn-primary tr-button">Add Mark</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-danger tr-button">Reset</button>
            </div>
        </form>
    </div>
    
    <script>window.gradeRanges = @json($grades)</script>
@endsection