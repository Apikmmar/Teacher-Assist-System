@extends('layouts.app', ['title' => 'Examination Details'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-file-earmark-text me-2"></i>Examination Details</h2>
                <p class="text-muted mb-0">{{ $exam->name }}</p>
            </div>
            
            @can('coordinator')
                @if ($exam->status == 'Pending')
                    <div>
                        <form action="{{ route('reminder.notification') }}" method="post" class="d-inline me-2">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                            <button type="submit" class="btn btn-outline-warning px-3 py-2">
                                <i class="bi bi-bell me-1"></i> Send Reminder
                            </button>
                        </form>
                        
                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $exam->id }}" class="btn btn-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Release Marks
                        </button>

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

        @can('coordinator')
            <form action="{{ route('update.view_examination', ['id' => $exam->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
        @endcan

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }} <span class="text-danger">*</span></label>
                    
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
                    <label for="start_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                    
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
                    <label for="end_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('End Date') }} <span class="text-danger">*</span></label>
                    
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
                    <label for="release_date" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Mark Release Date') }} <span class="text-danger">*</span></label>
                    
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

                <div class="row mb-3">
                    <label for="status" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Status') }} <span class="text-danger">*</span></label>
                    
                    <div class="col-md-6">
                        @php
                            $statusColor = $exam->status == 'Release' ? 'bg-success bg-opacity-10 text-success' : 
                                         ($exam->status == 'Pending' ? 'bg-warning bg-opacity-10 text-warning' : 'bg-secondary bg-opacity-10 text-secondary');
                        @endphp
                        
                        <span class="badge {{ $statusColor }}">
                            <i class="bi {{ $exam->status == 'Release' ? 'bi-check-circle' : ($exam->status == 'Pending' ? 'bi-hourglass' : 'bi-x-circle') }} me-1"></i>
                            {{ $exam->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @can('coordinator')
            <div class="d-flex justify-content-center gap-3 mb-4">
                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-save me-1"></i> Update
                </button>
                <button type="reset" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </button>
            </div>
            </form>
        @endcan

        @can('coordinator')
        @if ($exam->status == 'Pending')
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-clipboard-check me-2"></i> Mark Entry Status
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4" style="width: 50px">#</th>
                                    <th scope="col"><i class="bi bi-people me-2"></i>Class</th>
                                    <th scope="col"><i class="bi bi-book me-2"></i>Subjects</th>
                                    <th scope="col"><i class="bi bi-check-circle me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classMarkCollection as $index => $classMark)
                                    <tr>
                                        <th scope="row" class="ps-4">{{ 1 + $index }}</th>
                                        <td>
                                            <div class="fw-medium">{{ $classMark['class_name'] }}</div>
                                            <small class="text-muted">Form {{ $classMark['class_form'] }}</small>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($classMark['markCollection'] as $item)
                                                    <li class="mb-1">
                                                        <span>{{ $item['subject_name'] }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($classMark['markCollection'] as $item)
                                                    <li class="mb-1">
                                                        <span class="badge 
                                                            @if($item['key_in_status'] === 'COMPLETE') bg-success bg-opacity-10 text-success
                                                            @elseif($item['key_in_status'] === 'PENDING') bg-warning bg-opacity-10 text-warning
                                                            @else bg-secondary bg-opacity-10 text-secondary
                                                            @endif">
                                                            {{ $item['key_in_status'] }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @endcan
    </div>
@endsection