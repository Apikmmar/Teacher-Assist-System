@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div>      
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->ic }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Student ID') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->student_id }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

        @if ($std->classroom_id)
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{!! optional($std)->classroom->name ?? 'Not Applicable' !!}" readonly autocomplete="ic" autofocus>
                </div>
            </div>
        @endif

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $std->name }}" readonly autocomplete="name" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Age') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $age }} years old" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Status') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->status }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Birth') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->dob }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Joining School') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $std->join_school_date }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>
        </div>

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
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="change_reason" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('change_reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('New School Name') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="new_school" placeholder="Name" required autocomplete="name" autofocus>
                                
                                @error('new_school')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Reason of Drop School') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="drop_reason" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('drop_reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Change/Drop School') }} </label>
                            
                            <div class="col-md-6">
                                <input id="name" type="date" class="form-control @error('name') is-invalid @enderror" name="date_transition" placeholder="Reason" required autocomplete="name" autofocus>
                                
                                @error('date_transition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center pt-2">
                    <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $std->id }}" class="btn btn-danger tr-button">Drop Student</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn text-white btn-secondary tr-button">Reset</button>
                    </div>
                </form>
            </div>
        @endif
        @endcan

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
    </div>
@endsection