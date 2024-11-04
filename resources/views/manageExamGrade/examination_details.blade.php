@extends('layouts.app', ['title' => 'Examination Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        
        <div class="container fade-in-text">
        @can('coordinator')
            <form action="{{ route('update.view_examination', ['id' => $exam->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
        @endcan
                <header>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Examination Details') }}
                    </h4>
                </header>
                
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Examination Name" autocomplete="name" value="{{ $exam->name }}" @cannot('coordinator') readonly @endcannot>
                        
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
                        <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" autocomplete="start_date" value="{{ $exam->start_date }}" @cannot('coordinator') readonly @endcannot>
                        
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
                        <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" autocomplete="end_date" value="{{ $exam->end_date }}" @cannot('coordinator') readonly @endcannot>
                        
                        @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>                   
                </div>

                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end fw-bold">
                        {{ __('Examination Type') }} <span class="text-danger">*</span>
                    </label>
                
                    <div class="col-md-6">
                    @cannot('coordinator')
                        <input type="text" class="form-control" value="{{ old('type', $exam->type) }}" readonly>
                    @else
                        <select id="type" name="type" class="form-select">
                            <option disabled {{ old('type') ? '' : 'selected' }} value="">Select Examination</option>
                            <option value="Early Term Examination" @selected(old('type', $exam->type) == 'Early Term Examination')>Early Term Examination</option>
                            <option value="Mid Term Examination" @selected(old('type', $exam->type) == 'Mid Term Examination')>Mid Term Examination</option>
                            <option value="Final Term Examination" @selected(old('type', $exam->type) == 'Final Term Examination')>Final Term Examination</option>
                        </select>
                    @endcannot
                
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

        @can('coordinator')
                <div class="d-flex justify-content-center pt-2">
                    <button type="submit" class="btn text-white user-update-button">Update</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn text-white user-reset-button">Reset</button>
                </div>
            </form>
        @endcan
                    
                <hr>
                <div class="row mb-3">
                    <label for="status" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Status') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" placeholder="Examination Status" required autocomplete="status" value="{{ $exam->status }}" disabled>
                        
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                @can('coordinator')
                @if ($exam->status == 'Pending')
                    <div class="col">
                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $exam->id }}" class="btn btn-danger tr-button">Release</button>

                            @include('layouts.partials.modal', [
                                'id' => $exam->id, 
                                'name' => "Are you sure you want to release " . $exam->name . "?",
                                'deleteRoute' => route('update_release.view_examination', ['id' => $exam->id]),
                                'method' => 'PUT'
                            ])
                    </div>
                @endif
                @endcan
                </div>
        </div>

@endsection
