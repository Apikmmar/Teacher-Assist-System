@extends('layouts.app', ['title' => 'Register New Student'])

@section('content')

    <form action="" method="post" enctype="multipart/form-data">
        @csrf
    
        <div class="container fade-in-text">
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Identity Card Number" autocomplete="ic" autofocus>
                    
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
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }} <label class="red-aestrist">*</label></label>
    
                    <div class="col-md-6">
                        <select id="user_gender" name="gender" class="form-select" aria-label="Gender">
                            <option selected disabled>Select Gender</option>
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>                        
                </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date Of Birth') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob">
            
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date Of Joining School') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="jsd" type="date" class="form-control @error('jsd') is-invalid @enderror" name="jsd" value="{{ old('jsd') }}" required autocomplete="jsd">
            
                    @error('jsd')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Status') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <select id="status" name="gender" class="form-select" aria-label="Gender">
                        <option selected value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div> 
            </div>

            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">Add Student</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </div>
    </form>
@endsection