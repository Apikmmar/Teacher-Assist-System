@extends('layouts.app', ['title' => 'Class ' .$classroom->name. ' Details'])

@section('content')

    <div class="container fade-in-text">
        <div>
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Form') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $classroom->form->name }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $classroom->name }}" readonly autocomplete="name" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Teacher') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacherName }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Number of Students') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $classroom->num_student }} students" readonly autocomplete="ic" autofocus>
                </div>
            </div>
        </div>
        <hr>
        <div class="">
            @include('manageClassroom.partials.student_list')
        </div>
        <div class="d-flex justify-content-end mt-2">
            <a href="{{ route('edit_classroom', ['id' => $classroom->id]) }}" class="btn text-white user-update-button">Update Class Info</a>
        </div>
    </div>
@endsection