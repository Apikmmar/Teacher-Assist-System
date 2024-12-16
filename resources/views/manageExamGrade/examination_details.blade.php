@extends('layouts.app', ['title' => 'Examination Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <div>
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
                    <label for="release_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Mark Release Date') }} <label class="red-aestrist">*</label></label>
                    
                    <div class="col-md-6">
                        <input id="release_date" type="date" class="form-control @error('release_date') is-invalid @enderror" name="release_date" autocomplete="release_date" value="{{ $exam->release_date }}" @cannot('coordinator') readonly @endcannot>
                        
                        @error('release_date')
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
                        @if (($exam->type == 'Early Term Examination') || ($exam->type == 'Mid Term Examination') || ($exam->type == 'Final Term Examination'))
                            <select id="type" name="type" class="form-select">
                                <option disabled {{ old('type') ? '' : 'selected' }} value="">Select Examination</option>
                                <option value="Early Term Examination" @selected(old('type', $exam->type) == 'Early Term Examination')>Early Term Examination</option>
                                <option value="Mid Term Examination" @selected(old('type', $exam->type) == 'Mid Term Examination')>Mid Term Examination</option>
                                <option value="Final Term Examination" @selected(old('type', $exam->type) == 'Final Term Examination')>Final Term Examination</option>
                            </select>
                        @else
                            <input type="text" class="form-control" name="type" value="{{ old('type', $exam->type) }}">
                        @endif
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
                            'text' => 'Release Examination',
                            'id' => $exam->id, 
                            'name' => "Are you sure you want to release " . $exam->name . " marks?",
                            'deleteRoute' => route('update_release.view_examination', ['id' => $exam->id]),
                            'method' => 'PUT',
                            'callItem' => 'Release'
                        ])
                </div>
            @endif
            @endcan
            </div>
        </div>

    @can('coordinator')
    @if ($exam->status == 'Pending')
        <hr>
        <div>
            <header class="d-flex">
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('List of Class Finished Key In Marks') }}
                </h4>
                &nbsp;&nbsp;&nbsp;
                <form action="{{ route('reminder.notification') }}" method="post">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                    <button type="submit" class="btn btn-outline-warning">Remind</button>
                </form>
            </header>
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Form</th>
                            <th scope="col">Subject Name</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($classMarkCollection as $index => $classMark)
                            <tr class="align-middle teacher-list">
                                <th scope="row">{{ 1 + $index }}</th>
                                <td class="fw-bold">{{ $classMark['class_name'] }}</td>
                                <td>{{ $classMark['class_form'] }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">

                                        @foreach ($classMark['markCollection'] as $item)
                                            <li>
                                                <span>{{ $item['subject_name'] }}</span>
                                                &nbsp;&nbsp;&nbsp;
                                                <span class="badge 
                                                @if($item['key_in_status'] === 'COMPLETE') bg-success 
                                                @elseif($item['key_in_status'] === 'PENDING') bg-warning 
                                                @else bg-secondary 
                                                @endif">
                                                    {{ $item['key_in_status'] }}
                                                </span>
                                            </li>
                                        @endforeach

                                    </ul>
                                </td>
                        @endforeach
    
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @endcan

    </div>

@endsection
