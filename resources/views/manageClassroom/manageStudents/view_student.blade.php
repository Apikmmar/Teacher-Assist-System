@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex justify-content-end mb-2">
            <div class="btn-group mb-2">
                <button type="button" class="btn btn-info text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Edit Student
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('student_subject', ['id' => $std->id]) }}"><i class="bi bi-pencil"></i> Edit Student Info</a></li>
                @if ($std->classroom_id && $std->status == 'Active')
                  <li><a class="dropdown-item" href="{{ route('student_subject', ['id' => $std->id]) }}"><i class="bi bi-book"></i> Registered Subject</a></li>
                @endif
                </ul>
            </div>
        </div>

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

        @if (is_null($std->classroom_id) && ($std->status == 'Active'))
        <div>
            <hr>
            <form action="{{ route('edit_student.add_class', ['id' => $std->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row mb-3 align-items-center">
                    <label for="classroom" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Select Classroom') }}</label>
                    
                    <div class="col-md-4">
                        <select id="classroom_id" name="classroom_id" class="form-select" aria-label="Classroom">
                            <option selected value="">Select Classroom</option>
                
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary tr-button">Add Class</button>
                    </div>
                </div>
            </form>
        </div>
        @endif

        @can('coordinator')
        @if ($std->status == 'Active')
        <div class="form-check form-switch d-flex justify-content-end">
            <input class="form-check-input" type="checkbox" role="switch" id="dropStudentSwitch">
            &nbsp;
            <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Drop This Student</label>
        </div>

            <div id="dropStudent">
                <hr>
                <header>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Drop Student') }}
                    </h4>
                </header>
                <form action="{{ route('transition_student.create', ['id' => $std->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Reason of Change School') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="change_school_reason" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('change_school_reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('New School Name') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="new_school_name" placeholder="Name" required autocomplete="name" autofocus>
                                
                                @error('new_school_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Reason of Drop School') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="reason_drop" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('reason_drop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Change/Drop School') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="date" class="form-control @error('name') is-invalid @enderror" name="transition_date" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('transition_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center pt-2">
                        <button type="submit" class="btn btn-danger tr-button">Drop Student</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn text-white btn-secondary tr-button">Reset</button>
                    </div>
                </form>
            </div>
        @endif
        @endcan
    </div>
@endsection