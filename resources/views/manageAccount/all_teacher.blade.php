@extends('layouts.app', ['title' => 'List of Teachers'])

@section('content')
    <div  class="container fade-in-text">
    @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-people-fill me-2"></i>Teacher Directory</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $teachers->total() }} teachers</p>
            </div>

        @can('coordinator')
            <a href="{{ route('add_teacher') }}" class="btn btn-primary px-3 py-2">
                <i class="bi bi-plus-lg me-1"></i> Add Teacher
            </a>
        @endcan

        </div>

    @if ($teachers->isNotEmpty())
        <div class="mb-4">
            <form action="{{ route('search_teacher') }}" method="get">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search_teacher" placeholder="Search teachers by name..." value="{{ request()->input('search_teacher') ?? '' }}">
                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                </div>
            </form>
        </div>

        <div class="table-responsive rounded-3 border overflow-hidden bg-white">
            <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                            <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Teacher ID</th>
                            <th scope="col" class="fw-medium d-none d-md-table-cell"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                            <th scope="col" class="fw-medium d-none d-sm-table-cell"><i class="bi bi-telephone me-2"></i>Contact</th>
                            <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($teachers as $index => $teacher)
                    @php 
                        $call = ($teacher->gender === 'Men') ? 'Mr.' : (($teacher->gender === 'Women') ? 'Mrs.' : '');
                        $rowNumber = ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration;
                        $genderIcon = $teacher->gender === 'Men' ? 'bi-gender-male' : 'bi-gender-female';
                        $genderColor = $teacher->gender === 'Men' ? 'text-primary' : 'text-danger';
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
                                        <div class="fw-medium">{{ $call }} {{ $teacher->name }}</div>
                                        <div class="small text-muted d-lg-none">{{ $teacher->ic }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="text-muted">{{ $teacher->ic }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-dark">{!! $teacher->teacher_id ?: '<span class="text-muted">N/A</span>' !!}</span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge {{ $teacher->gender === 'Men' ? 'bg-info bg-opacity-10 text-primary' : 'bg-pink bg-opacity-10 text-danger' }}">
                                    <i class="bi {{ $genderIcon }} me-1"></i>{{ $teacher->gender }}
                                </span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <a href="tel:{{ $teacher->contact }}" class="text-decoration-none">
                                    <i class="bi bi-telephone-outbound me-1 text-muted"></i>
                                    <span class="text-dark">{{ $teacher->contact }}</span>
                                </a>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('view_teacher', ['id' => $teacher->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                @can('coordinator')
                                    <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $teacher->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endcan

                                </div>
                            </td>
                        </tr>

                        @include('layouts.partials.modal', [
                            'id' => $teacher->id, 
                            'name' => "Are you sure you want to remove subject " . $call . $teacher->name . " from from the database?",
                            'deleteRoute' => route('delete.teacher', ['id' => $teacher->id]),
                            'method' => 'DELETE'
                        ])
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>

    @if ($teachers->total() > 10)
        <div class="d-flex justify-content-center mt-3">
            {{ $teachers->onEachSide(1)->appends(['search_teacher' => request()->input('search_teacher')])->links() }}
        </div>
    @endif

        @else
        <div class="text-center py-5 my-4">
            <div class="mb-3">
                <i class="bi bi-people" style="font-size: 3rem; opacity: 0.2"></i>
            </div>
            <h4 class="text-muted mb-2">No teachers found</h4>
            <p class="text-muted mb-3">Try adjusting your search or add a new teacher</p>

        @can('coordinator')
            <a href="{{ route('add_teacher') }}" class="btn btn-primary px-3">
                <i class="bi bi-plus-lg me-1"></i> Add Teacher
            </a>
        @endcan

        </div>
    @endif

    </div>
@endsection