@extends('layouts.app', ['title' => 'Registered Subject of '. $student->name .' from Class '. $class->name])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Student Info') }}
            </h4>

            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Identity Card Number') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $student->ic }}" readonly autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Class Name') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $class->name }}" readonly autofocus>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">
                                {{ __('Student Name') }}
                            </label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control autocomplete" value="{{ $student->name }}" readonly autofocus>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Taken') }}
            </h4>
        </header>

        @if ($subsTaken->isNotEmpty())
                <div class="d-flex justify-content-center">
                    <table class="table table-hover" style="max-width: 900px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Subject Name</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($subsTaken as $index => $subs)
                                <tr class="align-middle teacher-list">
                                    <th scope="row">{{ $startNumber + $index }}</th>
                                    <td>{{ $subs }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">No Teachers Assigned</h4>
                </div>
            @endif
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Available') }}
            </h4>

            @if ($subsTaken->isNotEmpty())
                <div class="d-flex justify-content-center">
                    <table class="table table-hover" style="max-width: 900px">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Subject Name</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTableBody">
                            @php $startNumber = 1; @endphp
                            @foreach ($subsTaken as $index => $subs)
                                <tr class="align-middle teacher-list">
                                    <th scope="row">{{ $startNumber + $index }}</th>
                                    <td>{{ $subs }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-2">
                    <h4 class="fw-bold">No Teachers Assigned</h4>
                </div>
            @endif
        </header>
    </div>

@endsection