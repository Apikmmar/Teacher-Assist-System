@extends('layouts.app', ['title' => 'Register New Teacher'])

@section('content')

    <form action="" method="post" enctype="multipart/form-data">
    
        <div class="container fade-in-text">
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Identity Card Number" readonly autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" required autocomplete="name" autofocus>
                    
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Teacher ID') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Teacher ID" required autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }} <label class="red-aestrist">*</label></label>
    
                    <div class="col-md-6">
                        <select id="user_gender" name="gender" class="form-select" aria-label="Gender">
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>                        
                </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Contact') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Contact" required autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Email" required autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Role') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <div class="d-inline-block me-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckExamCoordinator">
                        <label class="form-check-label" for="flexCheckExamCoordinator">Exam Coordinator</label>
                    </div>
                    <div class="d-inline-block me-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckClassTeacher">
                        <label class="form-check-label" for="flexCheckClassTeacher">Class Teacher</label>
                    </div>
                    <div class="d-inline-block me-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckSubjectTeacher">
                        <label class="form-check-label" for="flexCheckSubjectTeacher">Subject Teacher</label>
                    </div>
                    <div class="d-inline-block">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckManagementOfSchool">
                        <label class="form-check-label" for="flexCheckManagementOfSchool">Management of School</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">View</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </div>
    </form>
@endsection