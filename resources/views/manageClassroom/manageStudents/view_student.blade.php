@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

    @can('coordinator')
        <div class="d-flex justify-content-end mb-2">
            <div class="btn-group mb-2">
                <button type="button" class="btn btn-info text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Edit Student
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('edit_student', ['id' => $std->id]) }}"><i class="bi bi-pencil"></i> Edit Student Info</a></li>

                @if ($std->classroom_id && $std->status == 'Active')
                <li><a class="dropdown-item" href="{{ route('student_subject', ['id' => $std->id]) }}"><i class="bi bi-book"></i> Registered Subject</a></li>
                @endif

                </ul>
            </div>
        </div>
    @endcan

        @include('manageClassroom.partials.student_info') 

    @if ($std->classroom_id && $std->status == 'Active')
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Taken by The Student') }}
            </h4>
        </header>

    @if ($subsTaken->isNotEmpty())
        <div class="d-flex justify-content-start align-items-center">
            <table class="table table-hover" style="max-width: 400px;">
                <tbody id="teacherTableBody">
                    @php $startNumber = 1; @endphp
                    @foreach ($subsTaken as $index => $subs)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ $startNumber + $index }}</th>
                            <td>{{ $subs }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="d-flex justify-content-center mt-2">
            <h4 class="fw-bold">No Subject Registered</h4>
        </div>
    @endif

    @endif

    @if ($transition)
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Transition Data') }}
            </h4>
        </header>

        <div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Transition Date') }}</label>
                        <div class="col-md-8">
                            <input id="ic" type="date" class="form-control @error('ic') is-invalid @enderror" value="{{ $transition->transition_date }}" readonly autocomplete="ic" autofocus>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="age" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Reason of Changing School') }}</label>
                        <div class="col-md-8">
                            <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" value="{{ $transition->change_school_reason }}" readonly autocomplete="age">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="status" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Reason of Dropping School') }}</label>
                        <div class="col-md-8">
                            <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" value="{{ $transition->reason_drop }}" readonly autocomplete="status">
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Last Classroom') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $transition->classID->name ?? 'N/A' }}" readonly autocomplete="name">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="student_id" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('New School Name') }}</label>
                        <div class="col-md-8">
                            <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" value="{{ $transition->new_school_name }}" readonly autocomplete="student_id">
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    @endif
    
        <div class="d-flex justify-content-end">
            @can('coordinator')
                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $std->id }}" class="btn btn-danger tr-button">Delete Student</button>
            @endcan

            @include('layouts.partials.modal', [
                    'id' => $std->id, 
                    'name' => "Are you sure you want to remove " . $std->name . " from from the database?",
                    'deleteRoute' => route('delete_student.delete', ['id' => $std->id]),
                    'method' => 'DELETE'
            ])
        </div>

    </div>
@endsection