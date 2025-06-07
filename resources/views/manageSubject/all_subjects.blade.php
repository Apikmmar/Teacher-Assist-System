@extends('layouts.app', ['title' => 'List of Subjects'])

@section('content')
    <div class="container fade-in-text">
        
    @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-book me-2"></i>Subject Directory</h2>
                <p class="text-muted mb-0"><i class="bi bi-clipboard2-data me-1"></i>Total: {{ $subjects->total() }} subjects</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('view.gradesettings') }}" class="btn btn-warning text-white px-3 py-2">
                    <i class="bi bi-gear me-1"></i> Grade Settings
                </a>
                <a href="{{ route('new_subject') }}" class="btn btn-primary px-3 py-2">
                    <i class="bi bi-plus-lg me-1"></i> Register Subject
                </a>
            </div>
        </div>

        <div class="mb-4">
            <form action="{{ route('all_subjects') }}" method="get" id="filterForm" class="w-100">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-funnel"></i>
                    </span>
                    <select class="form-select border-start-0 ps-0" name="subject_form" onchange="document.getElementById('filterForm').submit();">
                        <option value="" {{ request('subject_form') == '' ? 'selected' : '' }}>&nbsp;All Forms</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}" {{ request('subject_form') == $form->id ? 'selected' : '' }}>&nbsp;{{ $form->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

    @if ($subjects->isNotEmpty())
        <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-book-half me-2"></i>Subject Name</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-mortarboard me-2"></i>Form</th>
                        <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-card-text me-2"></i>Description</th>
                        <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($subjects as $index => $subject)
                @php 
                    $rowNumber = ($subjects->currentPage() - 1) * $subjects->perPage() + $loop->iteration;
                    $formColor = 'bg-primary bg-opacity-10 text-primary';
                @endphp

                    <tr class="border-top">
                        <td class="ps-4 text-muted fw-medium">{{ $rowNumber }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-book text-primary"></i>
                                    </div>
                                </div>
                                <div class="fw-medium">{{ $subject->name }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $formColor }}">{{ $subject->form->name }}</span>
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <span class="text-muted">{{ $subject->description ?: 'No description' }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('edit_subject', ['id' => $subject->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>

                            @can('coordinator')
                                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endcan

                            </div>
                        </td>
                    </tr>

                    @include('layouts.partials.modal', [
                        'id' => $subject->id, 
                        'name' => "Are you sure you want to remove subject " . $subject->name . " of Form ". $subject->form->name ." from the database?",
                        'deleteRoute' => route('delete_subject.delete', ['id' => $subject->id]),
                        'method' => 'DELETE'
                    ])
                @endforeach

                </tbody>
            </table>
        </div>

    @if ($subjects->total() > 10)
        <div class="d-flex justify-content-center mt-3">
            {{ $subjects->onEachSide(1)->appends(['subject_form' => request()->input('subject_form')])->links() }}
        </div>
    @endif

    @else
        <div class="text-center py-5 my-4">
            <div class="mb-3">
                <i class="bi bi-book" style="font-size: 3rem; opacity: 0.2"></i>
            </div>
            <h4 class="text-muted mb-2">No subjects found</h4>
            <p class="text-muted mb-3">Try adjusting your filter or register a new subject</p>

            <a href="{{ route('new_subject') }}" class="btn btn-primary px-3">
                <i class="bi bi-plus-lg me-1"></i> Register Subject
            </a>
        </div>
    @endif

    </div>
@endsection