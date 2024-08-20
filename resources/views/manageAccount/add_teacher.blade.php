@extends('layouts.app', ['title' => 'Register New Teacher'])

@section('content')
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
            <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Verification') }} <label class="red-aestrist">*</label></label>
            
            <div class="col-md-6">
                <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" placeholder="Verification" required autocomplete="ic" autofocus>
                
                @error('ic')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
@endsection