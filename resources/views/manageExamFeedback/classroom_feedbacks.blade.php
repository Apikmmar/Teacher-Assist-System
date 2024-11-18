@extends('layouts.app', ['title' => 'Registered Students Examination Mark'])

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

        <div class="d-flex justify-content-center">
            <div class="row">
                <table class="table table-hover" style="min-width: 700px">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Identity Card Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Marks</th>
                            <th scope="col">Feedback</th>
                            <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($students as $index => $student)
                        <tr class="align-middle teacher-list text-center" style="height: 40px;">
                            <th scope="row" class="py-1">{{ 1 + $index }}</th>
                            <td class="py-1">{{ $student->ic }}</td>
                            <td class="py-1">{{ $student->name }}</td>
                            <td>
                                {{ $studentGrades[$student->id]->marks ?? '' }} ({{ $studentGrades[$student->id]->grade ?? '-' }})
                            </td>
                            
                            <form action="{{ route('studente-feedback.update') }}" method="post" class="d-inline">
                                @csrf
                                @method('PATCH')
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="input-group" style="max-width: 200px;">
                                        <input type="text" class="form-control text-center" name="feedback" value="{{ $studentGrades[$student->id]->feedback ?? '' }}" placeholder="Feedback" style="height: 40px" aria-label="Grade input">
                                    </div>
                                </div>
                            </td>
                            <td>
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="students_id" value="{{ $student->id }}">
                                    <input type="hidden" name="examination_id" value="{{ $exam->id }}">
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <button type="submit" class="btn btn-primary text-white tr-button me-2">Update</button>
                            </form>
                            
                                <form action="{{ route('studente-feedback.update') }}" method="post" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="students_id" value="{{ $student->id }}">
                                    <input type="hidden" name="examination_id" value="{{ $exam->id }}">
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <button type="submit" class="btn btn-danger text-white tr-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection