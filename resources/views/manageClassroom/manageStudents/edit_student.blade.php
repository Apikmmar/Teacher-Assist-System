@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                        <div class="col-md-8">
                            <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->ic }}" autocomplete="ic" autofocus>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="age" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Age') }}</label>
                        <div class="col-md-8">
                            <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ $age }} years old" autocomplete="age">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="status" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Status') }}</label>
                        <div class="col-md-8">
                            <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ $std->status }}" autocomplete="status">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="join_school_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Joining School') }}</label>
                        <div class="col-md-8">
                            <input id="join_school_date" type="text" class="form-control @error('join_school_date') is-invalid @enderror" name="join_school_date" value="{{ $std->join_school_date }}" autocomplete="join_school_date">
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $std->name }}" autocomplete="name">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="student_id" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Student ID') }}</label>
                        <div class="col-md-8">
                            <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ $std->student_id }}" autocomplete="student_id">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="dob" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Birth') }}</label>
                        <div class="col-md-8">
                            <input id="dob" type="text" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ $std->dob }}" autocomplete="dob">
                        </div>
                    </div>
                    
                    @if ($class)
                        <div class="row mb-3">
                            <label for="classroom" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom') }}</label>
                            <div class="col-md-8">
                                <input id="classroom" type="text" class="form-control @error('classroom') is-invalid @enderror" name="classroom" value="{{ $class->name ?? 'Not Applicable' }}" autocomplete="classroom">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>  
    </div>
@endsection