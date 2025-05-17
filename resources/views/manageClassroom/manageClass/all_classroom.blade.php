@extends('layouts.app', ['title' => 'List of Classrooms'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-building me-2"></i>Classroom Directory</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $classrooms->total() }} classrooms</p>
            </div>

            <div class="d-flex gap-2">

            @can('coordinator')
                <a href="{{ route('add_classroom') }}" class="btn btn-primary px-3 py-2">
                    <i class="bi bi-plus-lg me-1"></i> Register Classroom
                </a>
            @endcan
                
            @can('classteacher')
                <a href="{{ route('my_classroom') }}" class="btn btn-success px-3 py-2">
                    <i class="bi bi-person-vcard me-1"></i> My Class
                </a>
            @endcan

            </div>
        </div>

    @if ($forms->isNotEmpty())
        <div class="mb-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <form action="{{ route('search_classroom') }}" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                class="form-control border-start-0 ps-0" 
                                name="search_classroom" 
                                placeholder="Search classroom by name..." 
                                value="{{ request()->input('search_classroom') ?? '' }}">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('all_classroom') }}" method="get" id="filterForm">
                        <div class="input-group">
                            <select class="form-select" name="class_form" onchange="document.getElementById('filterForm').submit();">
                                <option value="">All Forms</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}" {{ request('class_form') == $form->id ? 'selected' : '' }}>
                                        {{ $form->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($classrooms->isNotEmpty())
        <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-building me-2"></i>Class Name</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-layer-forward me-2"></i>Form</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-people me-2"></i>Students</th>
                        <th scope="col" class="fw-medium d-none d-md-table-cell"><i class="bi bi-person-video3 me-2"></i>Class Teacher</th>
                        <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-calendar3 me-2"></i>Session</th>
                        <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody>

                @php $startNumber = ($classrooms->currentPage() - 1) * $classrooms->perPage() + 1; @endphp
                @foreach ($classrooms as $index => $classroom)
                    <tr class="border-top">
                        <td class="ps-4 text-muted fw-medium">{{ $startNumber + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-building text-primary"></i>
                                    </div>
                                </div>
                                <div class="fw-medium">{{ $classroom->name }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info">{{ $classroom->form->name }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $classroom->num_student }} students</span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <i class="bi bi-person-circle text-muted"></i>
                                </div>
                                <div>{{ $classroom->teacher_title }}</div>
                            </div>
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <span class="text-muted">{{ $classroom->session }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('view_classroom', ['id' => $classroom->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                            @can('coordinator')
                                <a href="{{ route('edit_classroom', ['id' => $classroom->id]) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $classroom->id }}"class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endcan

                            </div>
                        </td>
                    </tr>

                    @include('layouts.partials.modal', [
                        'id' => $classroom->id, 
                        'name' => "Are you sure you want to remove " . $classroom->name . " from the database?",
                        'deleteRoute' => route('delete_classroom.delete', ['id' => $classroom->id]),
                        'method' => 'DELETE'
                    ])
                @endforeach

                </tbody>
            </table>
        </div>

    @if ($classrooms->total() > 10)
        <div class="d-flex justify-content-center mt-3">
            {{ $classrooms->appends(request()->query())->links() }}
        </div>
    @endif

    @else
        <div class="text-center py-5 my-4">
            <div class="mb-3">
                <i class="bi bi-building" style="font-size: 3rem; opacity: 0.2"></i>
            </div>
            <h4 class="text-muted mb-2">

            @if(request()->has('class_form') && request('class_form') != '')
                No classrooms found for Form {{ $forms->find(request('class_form'))->name ?? 'selected form' }}
            @else
                No classrooms found
            @endif
            
            </h4>
            <p class="text-muted mb-3">Try adjusting your search or register a new classroom</p>
            
        @can('coordinator')
            <a href="{{ route('add_classroom') }}" class="btn btn-primary px-3">
                <i class="bi bi-plus-lg me-1"></i> Register Classroom
            </a>
        @endcan

        </div>
    @endif

    </div>
@endsection