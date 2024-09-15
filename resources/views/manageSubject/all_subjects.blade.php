@extends('layouts.app', ['title' => 'List Of Subjects'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')
        
    <div class="row d-flex justify-content-end mb-4">
        <div class="col-auto">
            <a href="" class="btn text-white user-save-button">Register Subject</a>
        </div>
        <div class="col-auto">
            <form action="{{ route('all_subjects') }}" method="get" id="filterForm">

                <div class="row mb-3 align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
                        <select class="form-select" aria-label="Default select example" name="subject_form" onchange="document.getElementById('filterForm').submit();">
                            <option value="" {{ request('subject_form') == '' ? 'selected' : '' }}>View by: Default</option>
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
            @php
                $startNumber = ($subjects->currentPage() - 1) * $subjects->perPage() + 1;
            @endphp
            @foreach ($subjects as $index => $subject)
                <tr class="align-middle teacher-list">
                    <th scope="row">{{ $startNumber + $index }}</th>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->form->name }}</td>
                    <td>{{ $subject->description }}</td>
                    <td class="text-center">
                        {{-- <a href="{{ route('view_subject', ['id' => $subject->id ]) }}" class="btn btn-success tr-button">View</a> --}}
                    @can('coordinator')
                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $subject->id }}" class="btn btn-danger tr-button">Delete</button>
                    @endcan
                    </td>
                </tr>
            
                {{-- <div class="modal fade" id="confirmDelete{{ $subject->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $subject->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $subject->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to remove {{ $subject->name }} from school database?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('delete_subject.delete', ['id' => $subject->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary tr-button">Delete</button>
                                </form>
                                <button type="button" class="btn btn-danger tr-button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
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