@extends('layouts.app', ['title' => 'List Of Classrooms'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')

@if ($classrooms->isNotEmpty())
    <div class="d-flex justify-content-end me-4">
        <div>
            <form action="{{ route('search_classroom') }}" method="get">
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

    <div class="d-flex justify-content-end me-4 mb-2">
    @can('coordinator')
        <div class="col-auto me-2">
            <a href="{{ route('add_classroom') }}" class="btn text-white user-save-button">Register Classroom</a>
        </div>
    @endcan

    @can('classteacher')
        <div class="col-auto">
            <a href="{{ route('my_classroom') }}" class="btn text-white btn-success tr-button">My Class</a>
        </div>
    @endcan
    </div>
    

@if ($classrooms->isNotEmpty())
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Class Name</th>
                <th scope="col">Form</th>
                <th scope="col">Number Of Student</th>
                <th scope="col">Class Teacher</th>
                <th scope="col">Session</th>
                <th scope="col" class="text-center">Operation</th>
            </tr>
        </thead>
        <tbody>

            @php $startNumber = ($classrooms->currentPage() - 1) * $classrooms->perPage() + 1; @endphp
            @foreach ($classrooms as $index => $classroom)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ $startNumber + $index }}</th>
                    <td>{{ $classroom->name }}</td>
                    <td>{{ $classroom->form->name }}</td>
                    <td>{{ $classroom->num_student }} students</td>
                    <td>{{ $classroom->teacher_title }}</td>
                    <td>{{ $classroom->session }}</td>
                    <td class="text-center">
                        <a href="{{ route('view_classroom', ['id' => $classroom->id ]) }}" class="btn btn-success tr-button">View</a>

                        @can('coordinator')
                            <a href="{{ route('edit_classroom', ['id' => $classroom->id ]) }}" class="btn btn-warning text-white tr-button">Edit</a>
                            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $classroom->id }}" class="btn btn-danger tr-button">Delete</button>
                        @endcan

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
    
        <tfoot class="text-center">
            <tr>
                <td colspan="12" class="text-center">
                    {{ $classrooms->appends(request()->query())->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">classrooms Not Registered</h4>
        </div>
    @endif
    
    </div>
@endsection