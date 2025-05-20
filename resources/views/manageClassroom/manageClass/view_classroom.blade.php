@extends('layouts.app', ['title' => 'Class ' .$classroom->name. ' Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')
        
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

            <div class="row mb-3">
                <label for="ic" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Session') }}</label>
                
                <div class="col-md-6">
                    <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ $classroom->session }}" readonly autocomplete="ic" autofocus>
                </div>
            </div>
        </div>
        <hr>
        <div class="">
            <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                        <th scope="col" class="fw-medium d-none d-lg-table-cell"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                        <th scope="col" class="fw-medium"><i class="bi bi-person-badge me-2"></i>Student ID</th>
                        <th scope="col" class="fw-medium d-none d-md-table-cell"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                        <th scope="col" class="fw-medium text-center pe-4" style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        @php 
                            $rowNumber = ($students->currentPage() - 1) * $students->perPage() + $loop->iteration;
                            $genderIcon = $student->gender === 'Men' ? 'bi-gender-male' : 'bi-gender-female';
                            $genderColor = $student->gender === 'Men' ? 'text-primary' : 'text-danger';
                            $statusColor = $student->status === 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary';
                        @endphp

                        <tr class="border-top">
                            <td class="ps-4 text-muted fw-medium">{{ $rowNumber }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="bi {{ $genderIcon }} {{ $genderColor }}"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $student->name }}</div>
                                        <div class="small text-muted d-lg-none">{{ $student->ic }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="text-muted">{{ $student->ic }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-dark">{!! $student->student_id ?: '<span class="text-muted">N/A</span>' !!}</span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge {{ $student->gender === 'Men' ? 'bg-info bg-opacity-10 text-primary' : 'bg-pink bg-opacity-10 text-danger' }}">
                                    <i class="bi {{ $genderIcon }} me-1"></i>{{ $student->gender }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('view_student', ['id' => $student->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @can('coordinator')
                                        <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        @include('layouts.partials.modal', [
                            'id' => $student->id, 
                            'name' => "Are you sure you want to remove " . $student->name . " from the database?",
                            'deleteRoute' => route('delete_student.delete', ['id' => $student->id]),
                            'method' => 'DELETE'
                        ])
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($students->total() > 10)
            <div class="d-flex justify-content-center mt-3">
                {{ $students->onEachSide(1)->appends(request()->query())->links() }}
            </div>
        @endif
        </div>
        <div class="d-flex justify-content-end mt-2">
        
        @can('coordinator')
            <a href="{{ route('edit_classroom', ['id' => $classroom->id]) }}" class="btn text-white user-update-button">Update Class Info</a>
            &nbsp;&nbsp;&nbsp;
            <a href="{{ route('class_subject', ['id' => $classroom->id]) }}" class="btn btn-success tr-button">Registered Subject</a>
        @endcan
        
        </div>
    </div>
@endsection