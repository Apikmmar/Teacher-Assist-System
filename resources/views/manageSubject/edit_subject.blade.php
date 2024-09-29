@extends('layouts.app', ['title' => 'Subject Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Information') }}
            </h4>
        </header>

        <form action="{{ route('update_subject.update', ['id' => $subject->id]) }}" method="post">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Subject Name') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ old('name', $subject->name) }}" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="form" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Form') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <select id="form" name="form_id" class="form-select">
                                    <option disabled>Select Form</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}" {{ $form->id == $subject->form_id ? 'selected' : '' }}>
                                            {{ $form->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Subject Description') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus>{{ old('description', $subject->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">Update Info</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </form>

        <hr>

        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Assigned Teachers') }}
            </h4>
        </header>

        <div class="pt-3">
            @if ($teachers->isNotEmpty())
                <div class="d-flex justify-content-center">
                    <table class="table table-hover" style="max-width: 900px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Teacher IC Number</th>
                                <th scope="col">Teacher Name</th>
                                <th scope="col" class="text-center">Assign Teacher</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($teachers as $index => $teacher)
                                <tr class="align-middle teacher-list">
                                    <th scope="row">{{ $startNumber + $index }}</th>
                                    <td>{{ $teacher->ic }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td class="text-center">
                                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" class="btn btn-danger" style="border-radius: 15px">Drop</button>
                                    </td>

                                    @include('layouts.partials.modal', [
                                        'id' => $subject->id, 
                                        'name' => "Are you sure you want to remove " . $teacher->name . " from teach ". $subject->name ." from the database?",
                                        'deleteRoute' => route('edit_subject.drop_teacher', ['id' => $subject->id, 'teacher_id' => $teacher->id]),
                                        'method' => 'DELETE'
                                    ])
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
        </div>

        <hr>

        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Teacher') }}
            </h4>
        </header>

        <div class="pt-3">
            @if ($newTeachers->isNotEmpty())
                <div class="d-flex justify-content-center">
                    <table class="table table-hover" style="max-width: 900px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Teacher IC Number</th>
                                <th scope="col">Teacher Name</th>
                                <th scope="col" class="text-center">Assign Teacher</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($newTeachers as $index => $teacher)
                                <tr class="align-middle teacher-list">
                                    <th scope="row">{{ $startNumber + $index }}</th>
                                    <td>{{ $teacher->ic }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('edit_subject.add_teacher', ['id' => $subject->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                            <button class="btn btn-primary" style="border-radius: 15px">Add</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">Teachers Not Available</h4>
                </div>
            @endif
        </div>
    </div>

@endsection