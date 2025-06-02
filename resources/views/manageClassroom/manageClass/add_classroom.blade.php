@extends('layouts.app', ['title' => 'Register New Classroom'])

@section('content')
    <div class="container fade-in-text">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
                <div>
                    <h2 class="mb-1"><i class="bi bi-building me-2"></i>Classroom Registration</h2>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Fill in the details to register a new classroom</p>
                </div>
            </div>

            <form action="{{ route('add_classroom.create') }}" method="post">
                @csrf

                <div class="mb-5">
                    <div class="row mb-4">
                        <label for="form" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-layer-forward me-1"></i>Form <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-lg-7">
                            <select id="form" name="form" class="form-select border-2 py-2 @error('form') is-invalid @enderror" aria-label="Form">
                                <option selected disabled>Select Form</option>

                            @foreach ($forms as $form)
                                <option value="{{ $form->id }}" {{ old('form') == $form->id ? 'selected' : '' }}>
                                    {{ $form->name }}
                                </option>
                            @endforeach

                            </select>
                            @error('form')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-building me-1"></i>Classroom Name <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-lg-7">
                            <input id="name" type="text" class="form-control border-2 py-2 @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="class_teacher" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                            <i class="bi bi-person-video3 me-1"></i>Class Teacher <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-lg-7">
                            <select id="class_teacher" name="class_teacher" class="form-select border-2 py-2 @error('class_teacher') is-invalid @enderror">
                                <option selected disabled>Select Class Teacher</option>

                            @foreach ($availableTeachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('class_teacher') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach

                            </select>
                            @error('class_teacher')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="my-5">
                <div class="mb-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                        <div>
                            <h4 class="mb-1"><i class="bi bi-people me-2"></i>Student Selection</h4>
                            <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Select students for this classroom</p>
                        </div>
                    </div>

                @if ($students->isNotEmpty())
                    <div class="row align-items-center mb-4 bg-light rounded-3 p-3">
                        <div class="col-md-6">
                            <label for="ageRange" class="form-label fw-medium">
                                <i class="bi bi-funnel me-1"></i>Filter by Student Age:
                            </label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <input type="range" class="form-range" id="ageRange" min="13" max="17" step="1" value="{{ $students->min('age') }}">
                            <span class="badge bg-primary bg-opacity-10 text-primary ms-3 px-3 py-2" id="ageRangeValue">All Ages</span>
                        </div>
                        <div class="col-md-2">
                            <button id="resetFilter" type="button" class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4 fw-medium text-muted">#</th>
                                    <th scope="col" class="fw-medium"><i class="bi bi-person me-2"></i>Name</th>
                                    <th scope="col" class="fw-medium"><i class="bi bi-credit-card me-2"></i>IC Number</th>
                                    <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Student ID</th>
                                    <th scope="col" class="fw-medium"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                                    <th scope="col" class="fw-medium"><i class="bi bi-info-circle me-2"></i>Status</th>
                                    <th scope="col" class="fw-medium text-center pe-4">Add</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">

                            @foreach ($students as $index => $student)
                                <tr class="align-middle teacher-list" data-age="{{ $student->age ?? 0 }}">
                                    <td class="ps-4 text-muted fw-medium">{{ 1 + $index }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->ic }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->gender == 'Male' ? 'primary' : 'danger' }}-subtle text-{{ $student->gender == 'Male' ? 'primary' : 'danger' }}">
                                            {{ $student->gender }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $student->status == 'Active' ? 'success' : 'warning' }}-subtle text-{{ $student->status == 'Active' ? 'success' : 'warning' }}">
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                    value="{{ $student->id }}" name="students[]"
                                                    {{ in_array($student->id, $stdSelected) ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 my-4 bg-light rounded-3">
                        <div class="mb-3">
                            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
                        </div>
                        <h4 class="text-muted mb-2">No Students Available</h4>
                        <p class="text-muted mb-3">All students have been assigned to classrooms</p>
                    </div>
                @endif

                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-save me-1"></i>Register Classroom
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Form
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body p-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1"><i class="bi bi-upload me-2"></i>Bulk Classroom Registration</h4>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Upload a CSV file to register multiple classrooms</p>
                </div>
            </div>

            <form action="{{ route('import.classroom') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="import_csv" class="form-label fw-medium">
                                <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV File
                            </label>
                            <div class="input-group">
                                <input type="file" class="form-control border-2 py-2" id="import_csv" name="import_csv" accept=".csv">
                                <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon">
                                    <i class="bi bi-upload me-1"></i>Browse
                                </button>
                            </div>
                            <div class="form-text">File format: .csv (Download template <a href="#">here</a>)</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm w-100">
                            <i class="bi bi-cloud-arrow-up me-1"></i>Import Classrooms
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection