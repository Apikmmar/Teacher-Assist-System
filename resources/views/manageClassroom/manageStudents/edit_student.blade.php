@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="row justify-content-center">
            <form action="{{ route('edit_student.update', ['id' => $std->id]) }}" method="post">
                @csrf
                @method('PUT')
                
                <div class="col-10">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $std->name }}" autocomplete="name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                        <div class="col-md-8">
                            <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->ic }}" autocomplete="ic" autofocus>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="age" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Age') }}</label>
                        <div class="col-md-8">
                            <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ $age }} years old" autocomplete="age" readonly>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="status" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Status') }}</label>
                        <div class="col-md-8">
                            <select id="status" name="status" class="form-select" aria-label="status">
                                <option disabled value="NULL" {{ is_null($std->status) ? 'selected' : '' }}>Student Status</option>
                                <option value="Active" {{ $std->status === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $std->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="student_id" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Student ID') }}</label>
                        <div class="col-md-8">
                            <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ $std->student_id }}" autocomplete="student_id" readonly>
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="dob" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Birth') }}</label>
                        <div class="col-md-8">
                            <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ $std->dob }}" autocomplete="dob">
                        </div>
                    </div>
        
                    <div class="row mb-3">
                        <label for="join_school_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Joining School') }}</label>
                        <div class="col-md-8">
                            <input id="join_school_date" type="date" class="form-control @error('join_school_date') is-invalid @enderror" name="join_school_date" value="{{ $std->join_school_date }}" autocomplete="join_school_date">
                        </div>
                    </div>
        
                @if ($std_class)
                    <div class="row mb-3">
                        <label for="classroom" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom') }}</label>
                        <div class="col-md-8">
                            <select id="classroom_id" name="classroom_id" class="form-select" aria-label="Classroom">
                                <option selected value="">Select Classroom</option>
                                
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @if($class->id == $std_class->id) selected @endif>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
    
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="submit" class="btn text-white user-update-button">Update</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn text-white user-reset-button">Reset</button>
                </div>
            </form>
        </div>
        
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
                
                    <div class="col-md-4">
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