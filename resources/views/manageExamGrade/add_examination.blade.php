@extends('layouts.app', ['title' => 'Add New Examination'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        
        <form action="{{ route('create.add_examination') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="container fade-in-text">
                <header>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Examinaion Details') }}
                    </h4>
                </header>
                
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Examination Name" autocomplete="name" autofocus>
                        
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="start_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Start Date') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Start Date" required autocomplete="start_date" autofocus>
                        
                        @error('start_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="end_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('End Date') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" placeholder="End Date" required autocomplete="end_date" autofocus>
                        
                        @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>                   
                </div>
        
                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Type') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <select id="type" name="type" class="form-select" aria-label="Gender">
                            <option selected disabled value="NULL">Select Examination</option>
                            <option value="Early Term Examination">Early Term Examination</option>
                            <option value="Mid Term Examination">Mid Term Examination</option>
                            <option value="Final Term Examination">Final Term Examination</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-center pt-2">
                    <button type="submit" class="btn text-white user-save-button">Register</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn text-white user-reset-button">Reset</button>
                </div>
            </div>
        </form>
    </div>

@endsection