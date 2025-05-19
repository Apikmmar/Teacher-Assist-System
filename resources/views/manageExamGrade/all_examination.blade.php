@extends('layouts.app', ['title' => 'List of Examinations'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-file-earmark-text me-2"></i>Examination Directory</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $examinations->total() }} examinations</p>
            </div>

            @can('coordinator')
                <a href="{{ route('add_examination') }}" class="btn btn-primary px-3 py-2">
                    <i class="bi bi-plus-lg me-1"></i> Register Exam
                </a>
            @endcan
        </div>

        <div class="mb-4">
            <div class="d-flex flex-column flex-md-row gap-3">
                @if ($examinations->isNotEmpty())
                    <form action="{{ route('search_examination') }}" method="get" class="flex-grow-1">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" name="search_examination" placeholder="Search examination by name..." value="{{ request()->input('search_examination') ?? '' }}">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </form>
                @endif
                
                <button type="button" class="btn btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                
                @include('manageExamGrade.partials.filter')
            </div>
        </div>

        @if ($examinations->isNotEmpty())
            <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-file-text me-2"></i>Name</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-calendar-range me-2"></i>Duration</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-check-circle me-2"></i>Status</th>
                            <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-calendar-check me-2"></i>Release Date</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-tag me-2"></i>Type</th>
                            <th scope="col" class="fw-medium text-center pe-4" style="width: 200px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($examinations as $index => $examination)
                            @php 
                                $rowNumber = ($examinations->currentPage() - 1) * $examinations->perPage() + $loop->iteration;
                                $statusColor = $examination->status == 'Release' ? 'bg-success bg-opacity-10 text-success' : 
                                             ($examination->status == 'Pending' ? 'bg-warning bg-opacity-10 text-warning' : 'bg-secondary bg-opacity-10 text-secondary');
                            @endphp

                            <tr class="border-top">
                                <td class="ps-4 text-muted fw-medium">{{ $rowNumber }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="bi bi-file-text text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="fw-medium">{{ $examination->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ $examination->start_date }} to</small>
                                        <small class="text-muted">{{ $examination->end_date }}</small>
                                        <small class="text-muted">({{ $duration[$index] }} days)</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $statusColor }}">
                                        <i class="bi {{ $examination->status == 'Release' ? 'bi-check-circle' : ($examination->status == 'Pending' ? 'bi-hourglass' : 'bi-x-circle') }} me-1"></i>
                                        {{ $examination->status }}
                                    </span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="text-muted">{{ $examination->release_date }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $examination->type }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('view_examination', ['id' => $examination->id]) }}" class="btn btn-sm btn-warning text-white rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if ($examination->status == 'Release')
                                            <a href="{{ route('all_report', ['id' => $examination->id]) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-file-earmark-bar-graph"></i>
                                            </a>
                                        @endif

                                        @can('coordinator')
                                            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $examination->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            @include('layouts.partials.modal', [
                                'id' => $examination->id, 
                                'name' => "Are you sure you want to remove " . $examination->name . " from the database?",
                                'deleteRoute' => route('delete.view_examination', ['id' => $examination->id]),
                                'method' => 'DELETE'
                            ])
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($examinations->total() > 10)
                <div class="d-flex justify-content-center mt-3">
                    {{ $examinations->onEachSide(1)->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5 my-4">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.2"></i>
                </div>
                <h4 class="text-muted mb-2">No examinations found</h4>
                <p class="text-muted mb-3">Try adjusting your search or register a new examination</p>

                @can('coordinator')
                    <a href="{{ route('add_examination') }}" class="btn btn-primary px-3">
                        <i class="bi bi-plus-lg me-1"></i> Register Exam
                    </a>
                @endcan
            </div>
        @endif
    </div>
@endsection