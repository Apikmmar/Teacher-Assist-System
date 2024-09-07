@extends('layouts.app', ['title' => 'Register New Classroom'])

@section('content')

    <div class="container fade-in-text">
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Classroom Profile') }}
            </h4>
        </header>

        <form action="{{ route('add_classroom.create') }}" method="post">
            @csrf

            <div class="mb-5">
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Form') }} <label class="red-aestrist">*</label></label>
        
                    <div class="col-md-6">
                        <select id="form" name="form" class="form-select" aria-label="Gender">
                            <option selected disabled>Select Form</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom Name') }}</label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" autofocus>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Teacher') }} <label class="red-aestrist">*</label></label>
        
                    <div class="col-md-6">
                        <select id="class_teacher" name="class_teacher" class="form-select" aria-label="Gender">
                            <option selected disabled>Select Class Teacher</option>
                        @foreach ($availableTeachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <header>
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Select Student') }}
                </h4>
            </header>
            <div class="pt-2">
                @if ($students->isNotEmpty())
                <div class="row align-items-center mb-2">
                    <div class="col-md-6">
                        <label for="ageRange" class="form-label">Filter by Student Age:</label>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="range" class="form-range" id="ageRange" min="13" max="17" step="1" value="{{ $students->min('age') }}">
                        <span class="badge bg-primary ms-3" id="ageRangeValue">All Ages</span>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilter" type="button" style="border-radius: 30px" class="btn btn-secondary">Reset Age</button>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Identity Card Number</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Add</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($students as $index => $student)
                            <tr class="align-middle teacher-list" data-age="{{ $student->age ?? 0 }}">
                                <th scope="row">{{ $startNumber + $index }}</th>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->ic }}</td>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>{{ $student->status }}</td>
                                <td class="text-center">
                                    <input class="form-check-input mt-0" type="checkbox" value="{{ $student->id }}" name="students[]">
                                    {{ in_array($student->id, $stdSelected) ? 'checked' : '' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">Students Not Registered</h4>
                </div>
            @endif
            </div>

            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">Add Class</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </form>
    </div>
@endsection