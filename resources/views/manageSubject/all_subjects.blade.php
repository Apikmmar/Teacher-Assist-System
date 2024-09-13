@extends('layouts.app', ['title' => 'List Of Subjects'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')

    @can('coordinator')
        
        <div class="d-flex justify-content-end me-4 mb-2">
            {{-- <a href="{{ route('add_subject') }}" class="btn text-white user-save-button">Register subject</a> --}}
        </div>
        
    @endcan

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
                            {{ $subjects->onEachSide(5)->links() }}
                        </td>
                    </tr>
                </tfoot>
            @endif
            
        </table>
            
    @else
    
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">subjects Not Registered</h4>
        </div>
    @endif
    </div>
@endsection