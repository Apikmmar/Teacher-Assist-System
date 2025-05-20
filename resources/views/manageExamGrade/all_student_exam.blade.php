@extends('layouts.app', ['title' => 'List Of Examination'])

@section('content')
    @include('manageExamGrade.partials.filter')

    <div class="container fade-in-text">
        <!-- Header and Add Button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-journal-text me-2"></i>Examination List</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $examinations->total() }} examinations</p>
            </div>
        </div>

        <!-- Search and Filter Section (Always shown) -->
        <div class="mb-4">
            <div class="d-flex flex-column flex-lg-row gap-3">
                <!-- Search Form -->
                <form action="{{ route('search_studentexam') }}" method="get" class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input id="search_examination" type="text" class="form-control border-start-0 ps-0" name="search_examination" placeholder="Search examinations..." value="{{ request('search_examination') }}" required>
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </form>
                
                <!-- Status Filter -->
                <form action="{{ route('student_examination') }}" method="get" id="filterForm" class="flex-grow-1 flex-lg-grow-0" style="min-width: 200px;">
                    <select class="form-select" name="exam_status" onchange="document.getElementById('filterForm').submit();">
                        <option value="" {{ request('exam_status') == '' ? 'selected' : '' }}>All Status</option>
                        <option value="Release" {{ request('exam_status') == 'Release' ? 'selected' : '' }}>Released</option>
                        <option value="Pending" {{ request('exam_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </form>
            </div>
        </div>

    @if ($examinations->isNotEmpty())
        <!-- Examination Table -->
        <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-journal-text me-2"></i>Examination Name</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-calendar-range me-2"></i>Duration</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-calendar-check me-2"></i>Release Date</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-info-circle me-2"></i>Status</th>
                        <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody>

                @php $loopIndex = ($examinations->currentPage() - 1) * $examinations->perPage() + 1; @endphp
                @foreach ($examinations as $index => $examination)
                    <tr class="border-top">
                        <th scope="row" class="ps-4 text-muted fw-medium">{{ $loopIndex + $index }}</th>
                        <td class="fw-medium">{{ $examination->name }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span>{{ $examination->start_date }} - {{ $examination->end_date }}</span>
                                <small class="text-muted">{{ $duration[$index] }} days</small>
                            </div>
                        </td>
                        <td>{{ $examination->release_date }}</td>
                        <td>
                            <span class="badge bg-{{ $examination->status == 'Release' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $examination->status == 'Release' ? 'success' : 'warning' }}">
                                <i class="bi {{ $examination->status == 'Release' ? 'bi-check-circle' : 'bi-hourglass' }} me-1"></i>{{ $examination->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">

                            @if ($examination->status == 'Pending')
                                <a href="{{ route('view_classexam', ['id' => $examination->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                            @endif

                            @can('classteacher')
                                <a href="{{ route('myclass_exam-feed', ['id' => $examination->id]) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-people-fill"></i>
                                </a>
                            @endcan

                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($examinations->total() > 10)
            <div class="d-flex justify-content-center mt-3">
                {{ $examinations->onEachSide(1)->appends(request()->query())->links() }}
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-5 my-4">
            <div class="mb-3">
                <i class="bi bi-journal-x" style="font-size: 3rem; opacity: 0.2"></i>
            </div>
            <h4 class="text-muted mb-2">No examinations found</h4>
            <p class="text-muted mb-3">Try adjusting your search or filter criteria</p>
        </div>
    @endif

    </div>
@endsection