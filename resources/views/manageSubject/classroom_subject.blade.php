@extends('layouts.app', ['title' => 'Registered Subject of Classroom '. $class->name])

@section('content')
    <div class="container fade-in-text">

    @include('layouts.message')

        <header>
            <h4 class="text-lg font-medium">
                {{ __('List of Registered Subjects') }}
            </h4>
        </header>

        <div class="mt-3">

        @if ($subjectsTaken->isNotEmpty())
            <div class="d-flex justify-content-center">
                <table class="table table-hover" style="max-width: 800px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Current Teacher</th>
                            <th scope="col">Assign New Teacher</th>
                            <th scope="col" class="text-center">Registered Subject</th>
                        </tr>
                    </thead>
                    <tbody id="subjectTableBody">

                    @foreach ($subjectsTaken as $index => $subject)
                        <tr class="align-middle subject-list">
                            <th scope="row">{{ 1 + $index }}</th>
                            <td>{{ $subject->subject->name }}</td>
                            <td>{{ $teacherNames[$subject->id] }}</td>
                            <td>
                                <form action="{{ route('edit.classsubject_teacher') }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="subject" value="{{ $subject->subject->id }}">
                                    <input type="hidden" name="class" value="{{ $class->id }}">
                                    <select id="form" name="new_teacher" class="form-select">
                                        <option selected disabled>Select Teacher</option>
                                    @foreach ($registeredTeachers[$subject->id] as $teacher)
                                        <option value="{{ $teacher->teacher->id }}">{{ $teacher->teacher->name }}</option>
                                    @endforeach
                                    </select>
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-warning text-white tr-button">Update</button>
                                </form>
                                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" class="btn btn-danger" style="border-radius: 15px">Drop</button>
                            </td>

                            @include('layouts.partials.modal', [
                                'id' => $subject->id, 
                                'name' => "Are you sure you want to remove " . $subject->subject->name . " from class ". $class->name,
                                'deleteRoute' => route('edit.dropclassroom_subject', ['id' => $subject->id, 'class_id' => $class->id]),
                                'method' => 'DELETE'
                            ])
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <h4 class="fw-bold">No Subjects Registered</h4>
            </div>
        @endif

        @if ($subjectsNotTaken->isNotEmpty())
            <hr>

            <header>
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Available Subjects') }}
                </h4>
            </header>

            <div class="mt-3">
                <div class="d-flex justify-content-center">
                    <form action="{{ route('add.class_subject', ['id' => $class->id]) }}" method="post">
                        @csrf
                        <table class="table table-hover" style="max-width: 800px">
                            <thead>
                                <tr>
                                    <th scope="col">Select</th>
                                    <th scope="col">No</th>
                                    <th scope="col">Subject Name</th>
                                    <th scope="col">Registered Subject Teacher</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                                @php $startNumber = 1; @endphp
                                @foreach ($subjectsNotTaken as $subject)
                                    <tr class="align-middle subject-list">
                                        <td>
                                            <input type="checkbox" name="subjects[{{ $subject->id }}][selected]" value="1">
                                        </td>
                                        <th scope="row">{{ $startNumber }}</th>
                                        <td>
                                            {{ $subject->name }}
                                            <input type="hidden" name="subjects[{{ $subject->id }}][subject_id]" value="{{ $subject->id }}">
                                        </td>
                                        <td>
                                            <input type="hidden" name="subjects[{{ $subject->id }}][subject_id]" value="{{ $subject->id }}">
                                            <select name="subjects[{{ $subject->id }}][assigned_teacher]" class="form-select">
                                                <option selected disabled>Select Teacher</option>
                                                @foreach ($notRegisteredTeachers[$subject->id] as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </tr>
                                    @php $startNumber++ @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary text-white">Submit Selected</button>
                        </div>
                    </form>
                </div>
            @endif

            </div>
        </div>
    </div>
@endsection