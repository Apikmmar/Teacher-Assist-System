@extends('layouts.app', ['title' => 'Registered Subject of '. $student->name .' from Class '. $class->name])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Student Info') }}
            </h4>

            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Identity Card Number') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $student->ic }}" readonly autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Class Name') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $class->name }}" readonly autofocus>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Student Name') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $student->name }}" readonly autofocus>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Taken') }}
            </h4>
        </header>

        @if (!empty($subsTaken))
            <div class="d-flex justify-content-center">
                <table class="table table-hover" style="max-width: 500px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Subject's Teacher</th>
                        </tr>
                    </thead>
                    <tbody id="teacherTableBody">
                        @foreach ($subsTaken as $index => $subject)
                            <tr class="align-middle teacher-list">
                                <th scope="row">{{ 1 + $index  }}</th>
                                <td>{{ $subject }}</td>
                                <td>{{ $subsTeacher[$index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex justify-content-center mt-2">
                <h4 class="fw-bold">No Teachers Assigned</h4>
            </div>
        @endif

        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Available') }}
            </h4>

        @if ($subsNotRegistered->isNotEmpty())
            <div class="d-flex justify-content-center">
                <table class="table table-hover" style="max-width: 800px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Available Teacher</th>
                            <th scope="col">Add Elective Subject</th>
                        </tr>
                    </thead>
                    <tbody id="teacherTableBody">
                        @foreach ($subsNotRegistered as $index => $subs)
                            <tr class="align-middle teacher-list">
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $subs->name }}</td>
                                <form action="{{ route('add.studentelective_subject', ['id' => $student->id]) }}" method="get">
                                    @csrf

                                    <td>
                                        <input type="hidden" name="subject_id" value="{{ $subs->id }}">
                                        <select id="form" name="teacher_id" class="form-select" style="max-width: 200px">
                                            <option selected disabled>Select Teacher</option>
                                            @if (isset($notRegisteredTeachers[$subs->id]))
                                                @foreach ($notRegisteredTeachers[$subs->id] as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            @else
                                                <option disabled>No available teachers</option>
                                            @endif
                                        </select> 
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary text-white tr-button">Add</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>                        
                </table>
            </div>
        @else
            <div class="d-flex justify-content-center mt-2">
                <h4 class="fw-bold">No Subjects Available</h4>
            </div>
        @endif

        </header>
    </div>

@endsection