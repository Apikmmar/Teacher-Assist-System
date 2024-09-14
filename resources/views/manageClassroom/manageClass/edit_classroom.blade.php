@extends('layouts.app', ['title' => 'Update Class ' .$classroom->name. ' Details'])

@section('content')

    <div class="container fade-in-text">

        @include('layouts.message')

        <div>
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Form') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $classroom->form->name }}" autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $classroom->name }}" autocomplete="name" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Teacher') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacherName }}" autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Number of Students') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $classroom->num_student }} students" readonly autocomplete="ic" autofocus>
                </div>
            </div>
        </div>
        <hr>
        <div class="">
            @if ($students->isNotEmpty())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Gender</th>
                        <th scope="col" class="text-center">Operation</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $startNumber = ($students->currentPage() - 1) * $students->perPage() + 1;
                @endphp
                @foreach ($students as $index => $student)
                    <tr class="align-middle teacher-list">
                        <th scope="row">{{ $startNumber + $index }}</th>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->ic }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->gender }}</td>
                        <td class="text-center">
                            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-danger tr-button">Remove</button>
                        </td>
                    </tr>
                
                    <div class="modal fade" id="confirmDelete{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $student->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel{{ $student->id }}">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to remove {{ $student->name }} from {{ $classroom->name }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('decrease_student.update', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary tr-button">Remove</button>
                                    </form>
                                    <button type="button" class="btn btn-danger tr-button" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if ($students->total() > 10)
                    <tfoot class="text-center">
                        <tr>
                            <td colspan="12" class="text-center">
                                {{ $students->onEachSide(5)->links() }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table> 
            @endif
        </div>
    </div>
@endsection