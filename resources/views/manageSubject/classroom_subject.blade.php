@extends('layouts.app', ['title' => 'Registered Subject of Classroom '. $class->name])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('List of Registered Subject') }}
            </h4>
        </header>

        <div class="mt-3">
            @if ($subjects->isNotEmpty())
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
                            @php $startNumber = 1; @endphp
                            @foreach ($subjects as $index => $subject)
                                <tr class="align-middle subject-list">
                                    <th scope="row">{{ $startNumber + $index }}</th>
                                    <td>{{ $subject->subject->name }}</td>
                                    <td>{{ $teacherNames[$subject->id] }}</td>
                                    <td>
                                        <form action="{{ route('edit.classsubject_teacher') }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="subject" value="{{ $subject->id }}">
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
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">No subjects Assigned</h4>
                </div>
            @endif
        </div>
    </div>

@endsection