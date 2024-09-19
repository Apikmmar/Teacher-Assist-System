@extends('layouts.app', ['title' => 'Register New Subject'])

@section('content')
    
    <div class="container fade-in-text">
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Information') }}
            </h4>
        </header>

        <form action="{{ route('new_subject.create') }}" method="post">
            @csrf

            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Subject Name') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" autofocus>
                            </div>
                        </div>
            
                        <div class="row mb-3">
                            <label for="form" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Form') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <select id="form" name="form" class="form-select">
                                    <option selected disabled>Select Form</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Subject Description') }} <label class="red-aestrist">*</label>
                            </label>
                            <div class="col-md-8">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <header>
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Assign Teacher to Teach Subject') }}
                </h4>
            </header>
            <div class="pt-3">
                @if ($teachers->isNotEmpty())
                <div class="d-flex justify-content-center">
                    <table class="table table-hover" style="max-width: 900px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Teacher IC Number</th>
                                <th scope="col">Teacher Name</th>
                                <th scope="col" class="text-center">Assign Teacher</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($teachers as $index => $teacher)
                            <tr class="align-middle teacher-list" data-age="{{ $teacher->age ?? 0 }}">
                                <th scope="row">{{ $startNumber + $index }}</th>
                                <td>{{ $teacher->ic }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td class="text-center">
                                    <input class="form-check-input mt-0" type="checkbox" value="{{ $teacher->id }}" name="teachers[]" 
                                    {{ in_array($teacher->id, $teacherSelected) ? 'checked' : '' }}>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">teachers Not Registered</h4>
                </div>
            @endif
            </div>

            <div class="d-flex justify-content-center pt-2">
                <button type="submit" class="btn text-white user-save-button">Add Subject</button>
                &nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn text-white user-reset-button">Reset</button>
            </div>
        </form>
    </div>

@endsection