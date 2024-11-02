@extends('layouts.app', ['title' => 'Teacher Details'])

@section('content')
    <div class="row fade-in-text mt-2">
        <div class="col-4 d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/asset/profile-photos/' . $teacher->photo) }}" style="max-width: 250px;" class="img-fluid" alt="SMK Baling Teacher.png">
        </div>
        

        <div class="col-8">
            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacher->ic }}" placeholder="Identity Card Number" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $teacher->name }}" placeholder="Name" readonly autocomplete="name" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Age') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $age }} years old" placeholder="Teacher ID" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Teacher ID') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacher->teacher_id }}" placeholder="Teacher ID" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacher->gender }}" placeholder="Teacher ID" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Contact') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacher->contact }}" placeholder="Contact" readonly autocomplete="ic" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $teacher->email }}" placeholder="Email" readonly autocomplete="ic" autofocus>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <div>
        <section>
            <header>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Teached Subject') }}
                </h3>
            </header>
        
            <div>
                @if ($subClassTeacher)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Form</th>
                            <th scope="col">Subject Descrption</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subClassTeacher as $index => $subject)
                        <tr class="align-middle teacher-list">
                            <th scope="row">{{ 1 + $index }}</th>
                            <td>{{ $subject['subjectTeach'] }}</td>
                            <td>{{ $subject['subjectForm'] }}</td>
                            <td>
                                <ul class="mt-2">
                                    @foreach ($subject['classNames'] as $className)
                                        <li>{{ $className }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
            
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">No Subject Assiged</h4>
                </div>
            @endif
            </div>
        </section>
    </div>
@endsection