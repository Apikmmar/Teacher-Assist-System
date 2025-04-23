@extends('layouts.app', ['title' => 'List Of Subjects'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')
        
    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            <a href="{{ route('view.gradesettings') }}" class="btn btn-warning text-white tr-button">Grade Settings</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('new_subject') }}" class="btn text-white user-save-button">Register Subject</a>
        </div>
        <div class="col-auto">
            <form action="{{ route('all_subjects') }}" method="get" id="filterForm">

                <div class="row mb-3 align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
                        <select class="form-select" aria-label="Default select example" name="subject_form" onchange="document.getElementById('filterForm').submit();">
                            <option value="" {{ request('subject_form') == '' ? 'selected' : '' }}><b>View by:</b> Default</option>
                        
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}" {{ request('subject_form') == $form->id ? 'selected' : '' }}>View by: {{ $form->name }}</option>
                        @endforeach
                        
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>    
        
    @if ($subjects->isNotEmpty())
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Form</th>
                    <th scope="col">Subject Descrption</th>
                    <th scope="col" class="text-center">Operation</th>
                </tr>
            </thead>
            <tbody>

            @php $startNumber = ($subjects->currentPage() - 1) * $subjects->perPage() + 1; @endphp
            @foreach ($subjects as $index => $subject)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ $startNumber + $index }}</th>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->form->name }}</td>
                    <td>{{ $subject->description }}</td>
                    <td class="text-center">
                        <a href="{{ route('edit_subject', ['id' => $subject->id ]) }}" class="btn btn-success tr-button">View</a>
                    @can('coordinator')
                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" class="btn btn-danger tr-button">Delete</button>
                    @endcan
                    </td>
                </tr>
            
                @include('layouts.partials.modal', [
                    'id' => $subject->id, 
                    'name' => "Are you sure you want to remove subject " . $subject->name . " of ". $subject->form->name ." from the database?",
                    'deleteRoute' => route('delete_subject.delete', ['id' => $subject->id]),
                    'method' => 'DELETE'
                ])
            @endforeach
            
        @if ($subjects->total() > 10)
            <tfoot class="text-center">
                <tr>
                    <td colspan="12" class="text-center">
                        {{ $subjects->onEachSide(5)->appends(['subject_form' => request()->input('subject_form')])->links() }}
                    </td>
                </tr>
            </tfoot>
        @endif
        
        </table>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">ubjects Not Registered</h4>
        </div>
    @endif

    </div>
@endsection