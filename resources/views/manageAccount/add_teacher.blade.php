@extends('layouts.app', ['title' => 'Register New Teacher'])

@section('content')

    <form action="{{ route('register.create') }}" method="post" enctype="multipart/form-data">
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
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Teacher ID') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="teacher_id" placeholder="Teacher ID" required autocomplete="ic" autofocus>
                    
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
                            <option selected disabled>Select Gender</option>
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                        </select>
                    </div>                        
                </div>
    
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Contact') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="contact" placeholder="Contact" required autocomplete="ic" autofocus>
                    
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
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="email" placeholder="Email" required autocomplete="ic" autofocus>
                    
                    @error('ic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Password') }} <label class="red-aestrist">*</label></label>
                
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="password" autofocus>
                    
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="form-check d-flex justify-content-end mt-1">
                        <input class="form-check-input" type="checkbox" id="flexCheckChecked">&nbsp;
                        <label class="form-check-label" for="flexCheckChecked">
                            Set Password As IC Number
                        </label>
                    </div>
                </div>
            </div>
    
            <div class="row mb-3 ">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Role') }}</label></label>
                
                <div class="col-md-6 mt-2">
                    @foreach ($roles as $role)
                        <div class="d-inline-block me-3">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" 
                            {{ isset($userRoles) && in_array($role->name, $userRoles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">Register</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </div>
    </form>
@endsection