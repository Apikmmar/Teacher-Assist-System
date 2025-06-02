@extends('layouts.app', ['title' => 'Class ' .$classroom->name. ' Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h2 class="mb-1"><i class="bi bi-building me-2"></i>{{ $classroom->name }} Details</h2>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Classroom information and student list</p>
                </div>
                <div class="d-flex gap-2">
                    @can('coordinator')
                        <a href="{{ route('edit_classroom', ['id' => $classroom->id]) }}" class="btn btn-warning px-3 py-2 rounded-pill shadow-sm text-white">
                            <i class="bi bi-pencil me-1"></i>Update Class
                        </a>
                        <a href="{{ route('class_subject', ['id' => $classroom->id]) }}" class="btn btn-success px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-book me-1"></i>Subjects
                        </a>
                    @endcan
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="bg-light rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-layer-forward text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Form</h6>
                                <p class="mb-0">{{ $classroom->form->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="bg-light rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-person-video3 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Class Teacher</h6>
                                <p class="mb-0">{{ $teacherName }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="bg-light rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-people text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Number of Students</h6>
                                <p class="mb-0">{{ $classroom->num_student }} students</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="bg-light rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-calendar3 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Session</h6>
                                <p class="mb-0">{{ $classroom->session }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="mb-1"><i class="bi bi-people-fill me-2"></i>Student List</h4>
                    <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $students->total() }} students</p>
                </div>
            </div>

            <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                            <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Student ID</th>
                            <th scope="col" class="fw-medium d-none d-md-table-cell"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                            <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            @php 
                                $rowNumber = ($students->currentPage() - 1) * $students->perPage() + $loop->iteration;
                                $genderIcon = $student->gender === 'Men' ? 'bi-gender-male' : 'bi-gender-female';
                                $genderColor = $student->gender === 'Men' ? 'text-primary' : 'text-danger';
                            @endphp

                            <tr class="border-top">
                                <td class="ps-4 text-muted fw-medium">{{ $rowNumber }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="bi {{ $genderIcon }} {{ $genderColor }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $student->name }}</div>
                                            <div class="small text-muted d-lg-none">{{ $student->ic }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="text-muted">{{ $student->ic }}</span>
                                </td>
                                <td>
                                    @if($student->student_id)
                                        <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $student->student_id }}</span>
                                    @else
                                        <span class="badge bg-light text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge {{ $student->gender === 'Men' ? 'bg-info bg-opacity-10 text-primary' : 'bg-pink bg-opacity-10 text-danger' }}">
                                        <i class="bi {{ $genderIcon }} me-1"></i>{{ $student->gender }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('view_student', ['id' => $student->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="tooltip" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @can('coordinator')
                                            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" data-bs-toggle="tooltip" title="Remove Student">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            @include('layouts.partials.modal', [
                                'id' => $student->id, 
                                'name' => "Are you sure you want to remove " . $student->name . " from the database?",
                                'deleteRoute' => route('delete_student.delete', ['id' => $student->id]),
                                'method' => 'DELETE'
                            ])
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($students->total() > 10)
                <div class="d-flex justify-content-center mt-4">
                    {{ $students->onEachSide(1)->appends(request()->query())->links() }}
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