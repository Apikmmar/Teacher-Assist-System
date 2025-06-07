@extends('layouts.app', ['title' => 'Update Class ' .$classroom->name. ' Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h2 class="mb-1"><i class="bi bi-pencil-square me-2"></i>Update {{ $classroom->name }}</h2>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Edit classroom information</p>
                </div>
            </div>

            <form action="{{ route('update_classroom.update', ['id' => $classroom->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row mb-4">
                    <label for="form" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-layer-forward me-1"></i>Form
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <select id="form" class="form-select border-2 py-2 @error('form_id') is-invalid @enderror" name="form_id" autofocus>
                            <option value="" disabled>Select Form</option>
                            @foreach($forms as $form)
                                <option value="{{ $form->id }}" {{ $classroom->form->id == $form->id ? 'selected' : '' }}>
                                    {{ $form->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('form_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="name" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-building me-1"></i>Class Name
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input id="name" type="text" class="form-control border-2 py-2 @error('name') is-invalid @enderror" 
                            name="name" value="{{ $classroom->name }}" autocomplete="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="classteacher" class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-person-video3 me-1"></i>Class Teacher
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <select id="classteacher" class="form-select border-2 py-2 @error('classteacher_id') is-invalid @enderror" 
                            name="classteacher_id">
                            <option value="" disabled {{ $classroom->classteacher_id == NULL ? 'selected' : '' }}>Select Class Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $classroom->classteacher_id == $teacher->id ? 'selected' : '' }}>
                                    {{ strtolower($teacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ' }} {{ Str::title($teacher->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('classteacher_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-people me-1"></i>Student Count
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input type="text" class="form-control border-2 py-2 bg-light" 
                            value="{{ $classroom->num_student }} students" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-4 col-lg-3 col-form-label text-md-end fw-bold">
                        <i class="bi bi-calendar3 me-1"></i>Session
                    </label>
                    <div class="col-md-8 col-lg-7">
                        <input type="text" class="form-control border-2 py-2 bg-light" 
                            value="{{ $classroom->session }}" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 pt-3">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle me-1"></i>Update Class
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                </div>
            </form>
        </div>
        <hr>
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1"><i class="bi bi-people-fill me-2"></i>Class Students</h4>
                    <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $students->total() }} students</p>
                </div>
            </div>

            @if ($students->isNotEmpty())
                <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4 fw-medium text-muted">#</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person me-2"></i>Name</th>
                                <th scope="col" class="fw-medium d-none d-md-table-cell"><i class="bi bi-credit-card me-2"></i>IC Number</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Student ID</th>
                                <th scope="col" class="fw-medium"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                                <th scope="col" class="fw-medium text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $startNumber = ($students->currentPage() - 1) * $students->perPage() + 1; @endphp
                            @foreach ($students as $index => $student)
                                <tr class="border-top">
                                    <td class="ps-4 text-muted fw-medium">{{ $startNumber + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                    <i class="bi {{ $student->gender === 'Men' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' }}"></i>
                                                </div>
                                            </div>
                                            <div>{{ $student->name }}</div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="text-muted">{{ $student->ic }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $student->student_id ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $student->gender === 'Men' ? 'bg-info bg-opacity-10 text-primary' : 'bg-pink bg-opacity-10 text-danger' }}">
                                            {{ $student->gender }}
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" 
                                            class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm"
                                            data-bs-toggle="tooltip" title="Remove from class">
                                            <i class="bi bi-trash me-1"></i>Remove
                                        </button>
                                    </td>
                                </tr>

                                @include('layouts.partials.modal', [
                                    'id' => $student->id, 
                                    'name' => "Are you sure you want to remove " . $student->name . " from ". $classroom->name ."?",
                                    'deleteRoute' => route('decrease_student.update', ['id' => $student->id]),
                                    'method' => 'PATCH'
                                ])
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($students->total() > 10)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $students->onEachSide(5)->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5 my-4 bg-light rounded-3">
                    <div class="mb-3">
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
                    </div>
                    <h4 class="text-muted mb-2">No Students Found</h4>
                    <p class="text-muted">This classroom currently has no students assigned</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
@endsection