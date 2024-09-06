@extends('layouts.app', ['title' => 'Add New Details'])

@section('content')

    <div class="container fade-in-text">
        <form action="" method="post">
            <div>
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Form') }} <label class="red-aestrist">*</label></label>
        
                    <div class="col-md-6">
                        <select id="user_gender" name="form" class="form-select" aria-label="Gender">
                            <option selected disabled>Select Form</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                        @endforeach
                        </select>
                    </div>                        
                </div>
    
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Classroom Name') }}</label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" autofocus>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Teacher') }} <label class="red-aestrist">*</label></label>
        
                    <div class="col-md-6">
                        <select id="class_teacher" name="form" class="form-select" aria-label="Gender">
                            <option selected disabled>Select Form</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                        @endforeach
                        </select>
                    </div>                        
                </div>
            </div>
        </div>
        </form>
@endsection