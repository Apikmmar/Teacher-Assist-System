@extends('layouts.app', ['title' => 'List Of Teachers'])

@section('content')

    <div class="container mt-4 fade-in-text">

    @if ($teachers->isNotEmpty())
    <div class="d-flex justify-content-center mt-2">
        <div class="row mb-3 align-items-center">
            <div class="col-md-12 d-flex align-items-center">
                <label for="ic" class="col-form-label text-md-end fw-bold me-3">{{ __('Name') }}</label>
    
                <input id="ic" type="text" style="width: 500px" class="form-control me-3 @error('ic') is-invalid @enderror" name="ic" value="{{ old('ic') }}" placeholder="Teacher Name" required autocomplete="ic" autofocus>
    
                <a href="{{ route('all_teacher') }}" class="btn text-white user-save-button">{{ __('Search') }}</a>
            </div>
        </div>
    </div>
    
    
    
    @endif

        <div class="d-flex justify-content-end me-4">
            <a href="{{ route('add_teacher') }}" class="btn text-white user-save-button">Add Teacher</a>
        </div>

    @if ($teachers->isNotEmpty())
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Teacher ID</th>
                    <th scope="col">Identity Card Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Contact</th>
                    <th scope="col" class="text-center">Operation</th>
                </tr>
            </thead>
                <tbody>
                @php
                    $num = 1;   
                @endphp
                @foreach ($teachers as $teacher) 
                    <tr class="align-middle">
                        <th scope="row">{{ $num }}</th>
                        <td>{!! optional($teacher)->teacher_id ?? '<i>N/A</i>' !!}</td>
                        <td>{{ $teacher->ic }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->gender }}</td>
                        <td>{{ $teacher->contact }}</td>
                        <td class="text-center">
                            <a href="" class="btn btn-success tr-button">View</a>
                            <a href="" class="btn btn-danger tr-button">Delete</a>
                        </td>
                    </tr>
                    
                    @php
                        $num++;
                        @endphp
                @endforeach
            </tbody>
            </table>
            
            @else
            
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">No teacher found</h4>
                </div>
            @endif
    </div>
    
@endsection