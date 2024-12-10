@extends('layouts.app', ['title' => 'Student Examination Mark'])

@section('content')
    <div class="container fade-in-text py-4">
        @include('layouts.message')


        <div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="exam_name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }}</label>
                        <div class="col-md-8">
                            <input id="exam_name" type="text" class="form-control-plaintext border-bottom" value="{{ $exam->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="subject_name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Subject Name') }}</label>
                        <div class="col-md-8">
                            <input id="subject_name" type="text" class="form-control-plaintext border-bottom" value="{{ $subject->name }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="class_name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Name') }}</label>
                        <div class="col-md-8">
                            <input id="class_name" type="text" class="form-control-plaintext border-bottom" value="{{ $student->classroom->name }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center min-vh-100">
            <div class="card shadow p-4" style="max-width: 800px; width: 100%; max-height:480px">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
        
                    <div class="mb-3 row">
                        <label for="ic_number" class="col-md-4 col-form-label text-end fw-bold">{{ __('Identity Card Number') }}</label>
                        <div class="col-md-8">
                            <input id="ic_number" type="text" class="form-control-plaintext border-bottom" value="{{ $student->ic }}" readonly>
                        </div>
                    </div>
        
                    <div class="mb-3 row">
                        <label for="student_name" class="col-md-4 col-form-label text-end fw-bold">{{ __('Student Name') }}</label>
                        <div class="col-md-8">
                            <input id="student_name" type="text" class="form-control-plaintext border-bottom" value="{{ $student->name }}" readonly>
                        </div>
                    </div>
        
                    <div class="mb-3 row">
                        <label for="mark" class="col-md-4 col-form-label text-end fw-bold">{{ __('Marks') }}</label>
                        <div class="col-md-8">
                            <input id="mark" type="number" name="mark" class="form-control" placeholder="Enter Marks" min="0" max="100" required>
                        </div>
                    </div>
        
                    <div class="mb-3 row">
                        <label for="grade" class="col-md-4 col-form-label text-end fw-bold">{{ __('Grade') }}</label>
                        <div class="col-md-8">
                            <select id="grade" name="grade" class="form-select" required>
                                <option value="" disabled selected>Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->grade }}">{{ $grade->grade }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="grade" class="col-md-4 col-form-label text-end fw-bold">{{ __('Pointer') }}</label>
                        <div class="col-md-8">
                            <select id="grade" name="grade_value" class="form-select" required>
                                <option value="" disabled selected>Select Pointer</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->grade_value }}">{{ $grade->grade_value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <div class="mb-3 row">
                        <label for="feedback" class="col-md-4 col-form-label text-end fw-bold">{{ __('Feedback') }}</label>
                        <div class="col-md-8">
                            <textarea id="feedback" name="feedback" class="form-control" placeholder="Enter Feedback" rows="3"></textarea>
                        </div>
                    </div>
        
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary tr-button px-4 me-2">Save Mark</button>
                        <button type="reset" class="btn btn-outline-danger tr-button px-4">Reset</button>
                    </div>
                </form>
            </div>
        </div>        
    </div>

@endsection
