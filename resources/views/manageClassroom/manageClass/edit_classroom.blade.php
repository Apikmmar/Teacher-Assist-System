@extends('layouts.app', ['title' => 'Update Class ' .$classroom->name. ' Details'])

@section('content')

    <div class="container fade-in-text">

        @include('layouts.message')

        <div>
            <form action="{{ route('update_classroom.update', ['id' => $classroom->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
            
                <div class="row mb-3">
                    <label for="form" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Form') }}</label>
                    <div class="col-md-6">
                        <select id="form" class="form-control @error('form') is-invalid @enderror" name="form_id" autofocus style="border-radius: 15px">
                            <option value="" disabled>Select Form</option>

                            @foreach($forms as $form)
                                <option value="{{ $form->id }}" {{ $classroom->form->id == $form->id ? 'selected' : '' }}>
                                    {{ $form->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $classroom->name }}" autocomplete="name" autofocus>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <label for="classteacher" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Teacher') }}</label>
                    <div class="col-md-6">
                        <select id="classteacher" class="form-control @error('classteacher') is-invalid @enderror" name="classteacher_id" autofocus style="border-radius: 15px">
                            <option value="" disabled {{ $classroom->classteacher_id == NULL ? 'selected' : '' }}>Select Class Teacher</option>

                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $classroom->classteacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ strtolower($teacher->gender) == 'men' ? 'Mr. ' : 'Mrs. ' }} {{ Str::title($teacher->name) }}
                            </option>
                        @endforeach

                        </select>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <label for="num_student" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Number of Students') }}</label>
                    <div class="col-md-6">
                        <input id="num_student" type="text" class="form-control" name="" value="{{ $classroom->num_student }} students" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="num_student" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Number of Students') }}</label>
                    <div class="col-md-6">
                        <input id="num_student" type="text" class="form-control" name="" value="{{ $classroom->session }} students" readonly>
                    </div>
                </div>
            
                <div class="d-flex justify-content-center">
                    <button class="btn user-update-button text-white" type="submit">Update</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn user-reset-button text-white" type="reset">Reset</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="">

        @if ($students->isNotEmpty())
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Identity Card Number</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Gender</th>
                        <th scope="col" class="text-center">Operation</th>
                    </tr>
                </thead>
                <tbody>

                @php $startNumber = ($students->currentPage() - 1) * $students->perPage() + 1; @endphp
                @foreach ($students as $index => $student)
                    <tr class="align-middle teacher-list">
                        <th scope="row">{{ $startNumber + $index }}</th>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->ic }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->gender }}</td>
                        <td class="text-center">
                            <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-danger tr-button">Remove</button>
                        </td>
                    </tr>
                
                    @include('layouts.partials.modal', [
                        'id' => $student->id, 
                        'name' => "Are you sure you want to remove subject " . $student->name . " from ". $classroom->name ." from the database?",
                        'deleteRoute' => route('decrease_student.update', ['id' => $student->id]),
                        'method' => 'PATCH'
                    ])
                @endforeach
                
                @if ($students->total() > 10)
                    <tfoot class="text-center">
                        <tr>
                            <td colspan="12" class="text-center">
                                {{ $students->onEachSide(5)->links() }}
                            </td>
                        </tr>
                    </tfoot>
                @endif

            </table> 
        @endif
            
        </div>
    </div>
@endsection