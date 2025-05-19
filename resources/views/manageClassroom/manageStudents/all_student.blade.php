@extends('layouts.app', ['title' => 'List of Students'])

@section('content')
    <div class="container fade-in-text">

    @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-people-fill me-2"></i>Student Directory</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $students->total() }} students</p>
            </div>

        @can('coordinator')
            <a href="{{ route('add_student') }}" class="btn btn-primary px-3 py-2">
                <i class="bi bi-plus-lg me-1"></i> Add Student
            </a>
        @endcan

        </div>

    @if ($students->isNotEmpty())
        <div class="mb-4">
            <div class="d-flex flex-column flex-md-row gap-3">
                <form action="{{ route('search_student') }}" method="get" class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" name="search_student" placeholder="Search students by name..." value="{{ request()->input('search_student') ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </form>
                
                <button type="button" class="btn btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                
                @include('manageClassroom.partials.filter')
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
                        <th scope="col" class="fw-medium"><i class="bi bi-mortarboard me-2"></i>Classroom</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-check-circle me-2"></i>Status</th>
                        <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        @php 
                            $rowNumber = ($students->currentPage() - 1) * $students->perPage() + $loop->iteration;
                            $genderIcon = $student->gender === 'Men' ? 'bi-gender-male' : 'bi-gender-female';
                            $genderColor = $student->gender === 'Men' ? 'text-primary' : 'text-danger';
                            $statusColor = $student->status === 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary';
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
                                <span class="badge bg-secondary bg-opacity-10 text-dark">{!! $student->student_id ?: '<span class="text-muted">N/A</span>' !!}</span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge {{ $student->gender === 'Men' ? 'bg-info bg-opacity-10 text-primary' : 'bg-pink bg-opacity-10 text-danger' }}">
                                    <i class="bi {{ $genderIcon }} me-1"></i>{{ $student->gender }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {!! optional($student)->classroom->name ?? '<span class="text-muted">N/A</span>' !!}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $statusColor }}">
                                    <i class="bi {{ $student->status === 'active' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('view_student', ['id' => $student->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @can('coordinator')
                                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
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
            <div class="d-flex justify-content-center mt-3">
                {{ $students->onEachSide(1)->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5 my-4">
            <div class="mb-3">
                <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
            </div>
            <h4 class="text-muted mb-2">No students found</h4>
            <p class="text-muted mb-3">Try adjusting your search or add a new student</p>

            @can('coordinator')
                <a href="{{ route('add_student') }}" class="btn btn-primary px-3">
                    <i class="bi bi-plus-lg me-1"></i> Add Student
                </a>
            @endcan
        </div>
    @endif
    
    </div>
@endsection