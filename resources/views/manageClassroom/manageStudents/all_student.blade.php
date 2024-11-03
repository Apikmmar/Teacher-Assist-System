@extends('layouts.app', ['title' => 'List Of Students'])

@section('content')
<div class="container mt-4 fade-in-text">
    
    @include('layouts.message')

@if ($students->isNotEmpty())
    <div class="d-flex justify-content-end me-4">
        <div>
            <form action="{{ route('search_student') }}" method="get">
    
                <div class="row mb-3 align-items-center">
                    <div class="col-md-12 d-flex align-items-center">
            
                        <input id="ic" type="text" style="width: 200px" class="form-control me-2 @error('ic') is-invalid @enderror" name="search_student" placeholder="Search Student Name" required autocomplete="ic" autofocus>
                        <button type="submit" class="btn btn-light" style="min-width: 50px; border-radius: 30%"><i class="bi bi-search" style="font-size: 1.2rem;"></i></button>
                    </div>
                </div>
            </form>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div>
            <button type="button" class="btn tr-button btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                Filter Students
            </button>

            @include('manageClassroom.partials.filter')
        </div>
    </div>
@endif

    @can('coordinator')
        <div class="d-flex justify-content-end me-4 mb-2">
            <a href="{{ route('add_student') }}" class="btn text-white user-save-button">Register Student</a>
        </div>
    @endcan

    @include('manageClassroom.partials.student_list')
    </div>
@endsection