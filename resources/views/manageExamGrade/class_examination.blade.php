@extends('layouts.app', ['title' => 'Examination Classroom'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="mt-2">
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold"> {{ __('Examination Name') }} </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name', $examination->name) }}" readonly autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="release_date" class="col-md-4 col-form-label text-md-end fw-bold"> {{ __('Release Date') }} </label>
                            <div class="col-md-8">
                                <input id="release_date" type="text" class="form-control @error('release_date') is-invalid @enderror" name="release_date" autocomplete="release_date" value="{{ old('release_date', $examination->release_date) }}" readonly autofocus>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="start_date" class="col-md-4 col-form-label text-md-end fw-bold"> {{ __('Duration') }} </label>
                            <div class="col-md-8">
                                <input id="start_date" type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" autocomplete="start_date" value="{{ old('start_date', $examination->start_date.' until '. $examination->end_date) }}" readonly autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end fw-bold"> {{ __('Examination Type') }} </label>
                            <div class="col-md-8">
                                <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" autocomplete="type" value="{{ old('type', $examination->type) }}" readonly autofocus>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <hr>
        <div class="mt-2">

            <header>
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Select Classroom To Insert Marks') }}
                </h4>
            </header>
            <div class="d-flex justify-content-START">

            @if ($subjectClass)
                <table class="table table-hover" style="max-width: 700px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Form</th>
                            <th scope="col" class="text-center">Classes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjectClass as $index => $subject)
                            <tr class="align-middle teacher-list">
                                <td>{{ 1 + $index }}</td>
                                <td>{{ $subject['subjectTeach'] }}</td>
                                <td>{{ $subject['subjectForm'] }}</td>
                                <td>

                                @foreach ($subject['classes'] as $class)
                                    <div class="d-flex justify-content-start align-items-center mb-2">
                                        @if ($class)
                                            <span>{{ $class['className'] }}</span>
                                            <a href="{{ route('students_exam_mark', ['class_id'=> $class['classID'], 'subject_id'=> $subject['subjectID'], 'exam_id'=> $examination->id]) }}" class="btn btn-sm btn-primary tr-button">Add Marks</a>
                                            <a href="{{ route('registered_exam_marks', ['class_id'=> $class['classID'], 'subject_id'=> $subject['subjectID'], 'exam_id'=> $examination->id]) }}" class="btn btn-sm btn-warning text-white tr-button">Update Mark</a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </div>
                                @endforeach

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">N/A</h4>
                </div>
            @endif

            </div>
        </div>
        <hr>
        @foreach ($registeredMarks as $item)
            {{ $item }}hr
        @endforeach
    </div>

@endsection