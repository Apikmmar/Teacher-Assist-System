@extends('layouts.app', ['title' => 'Student Performance'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')

        <div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->ic }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->gender }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $class->name }}" autofocus readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Student Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->name }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Birth') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->dob }}" autofocus readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $examination->name }}" autofocus readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Duration') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $examination->start_date.' - '.$examination->end_date }}" autofocus readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div>
            @foreach ($stdResult as $result)
                {{ $result }} <br>
            @endforeach
        </div>
        <hr>
        <div>

        </div>
    </div>

@endsection