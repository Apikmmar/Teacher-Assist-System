@extends('layouts.app', ['title' => 'List Of Classrooms'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')

    @if ($classrooms->isNotEmpty())
    <div class="d-flex justify-content-end me-4">
        <div>
            <form action="{{ route('search_classroom') }}" method="post">
                @csrf
    
                <div class="row mb-3 align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
            
                        <input id="ic" type="text" style="width: 200px" class="form-control me-2 @error('ic') is-invalid @enderror" name="search_classroom" placeholder="Search Classroom Name" required autocomplete="ic" autofocus>
                        <button type="submit" class="btn btn-light" style="min-width: 50px; border-radius: 30%"><i class="bi bi-search" style="font-size: 1.2rem;"></i></button>
                    </div>
                </div>
            </form>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div>
            <form action="{{ route('all_classroom') }}" method="get" id="filterForm">

                <div class="row mb-3 align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
                        <select class="form-select" aria-label="Default select example" name="class_form" onchange="document.getElementById('filterForm').submit();">
                            <option value="" {{ request('class_form') == '' ? 'selected' : '' }}>View by: Default</option>
                            @foreach ($forms as $form)
                                <option value="{{ $form->id }}" {{ request('class_form') == $form->id ? 'selected' : '' }}>View by: {{ $form->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    @can('coordinator')
        
        <div class="d-flex justify-content-end me-4 mb-2">
            <a href="{{ route('add_classroom') }}" class="btn text-white user-save-button">Register Classroom</a>
        </div>
        
    @endcan

    @if ($classrooms->isNotEmpty())
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Class Name</th>
                    <th scope="col">Form</th>
                    <th scope="col">Number Of Student</th>
                    <th scope="col">Class Teacher</th>
                    <th scope="col" class="text-center">Operation</th>
                </tr>
            </thead>
            <tbody>
            @php
                $startNumber = ($classrooms->currentPage() - 1) * $classrooms->perPage() + 1;
            @endphp
            @foreach ($classrooms as $index => $classroom)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ $startNumber + $index }}</th>
                    <td>{{ $classroom->name }}</td>
                    <td>{{ $classroom->form->name }}</td>
                    <td>{{ $classroom->num_student }} students</td>
                    <td>{{ $classroom->teacher_title }}</td>
                    <td class="text-center">
                        <a href="{{ route('view_classroom', ['id' => $classroom->id ]) }}" class="btn btn-success tr-button">View</a>
                    @can('coordinator')
                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $classroom->id }}" class="btn btn-danger tr-button">Delete</button>
                    @endcan
                    </td>
                </tr>
            
                <div class="modal fade" id="confirmDelete{{ $classroom->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $classroom->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $classroom->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to remove {{ $classroom->name }} from school database?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('delete_classroom.delete', ['id' => $classroom->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary tr-button">Delete</button>
                                </form>
                                <button type="button" class="btn btn-danger tr-button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if ($classrooms->total() > 10)
                <tfoot class="text-center">
                    <tr>
                        <td colspan="12" class="text-center">
                            {{ $classrooms->onEachSide(5)->links() }}
                        </td>
                    </tr>
                </tfoot>
            @endif
            
        </table>
            
    @else
    
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">classrooms Not Registered</h4>
        </div>
    @endif
    </div>
@endsection