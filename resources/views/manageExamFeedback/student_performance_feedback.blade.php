@extends('layouts.app', ['title' => 'Student Performance'])

@section('content')
    <div class="container fade-in-text">
    @include('layouts.message')

        <div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Identity Card Number') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->ic }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Gender') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->gender }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Class Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $class->name }}" autofocus readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Student Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->name }}" autofocus readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Date of Birth') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $student->dob }}" autofocus readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $examination->name }}" autofocus readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Examination Duration') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" value="{{ $examination->start_date.' - '.$examination->end_date }}" autofocus readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Subject Name</th>
                        <th scope="col">Mark</th>
                        <th scope="col">Result</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($stdResult as $index => $result)
                    <tr>
                        <th scope="row">{{ 1 + $index }}</th>
                        <td style="width: 75%">{{ $result->subject->name }}</td>
                        <td>{{ $result->marks }}</td>
                        <td>{{ $result->grade }}</td>
                        <td class="text-uppercase">{{ $result->is_passed }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <hr>
        <div class="container">
            <div class="row fw-bold">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Position In Class:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext">9/10</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Position In Form:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext">18/20</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Total Marks:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext">{{ $stdReport->total_mark }}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Average Mark:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext">{{ $stdReport->average_mark }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Pointer:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext">{{ $stdReport->pointer }}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Status:</label>
                        <div class="col-6">
                            <div class="form-control-plaintext text-uppercase">{{ $stdReport->is_passed }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-center align-items-center gap-2">
            <form action="{{ route('student_ferformance.update_feedback', ['id' => $stdReport->id]) }}" method="post" class="d-flex align-items-center gap-2">
                @csrf
                @method('PATCH')

                <div class="form-group mb-0">
                    <label for="feedback" class="me-2">Feedback:</label>
                    <input class="form-control d-inline-block" name="feedback" id="feedback" value="{{ $stdReport->feedback }}" style="width: 300px;"/>
                </div>
            
                <div>
                    <button type="submit" name="action" value="update" class="btn btn-primary tr-button me-2">Update Feedback</button>
                    @if (($stdReport->feedback == '-') || ($stdReport->feedback == ''))
                    <button type="reset" class="btn btn-danger tr-button">Reset</button>
                    @else
                    <button type="submit" name="action" value="delete" class="btn btn-secondary tr-button me-2">Delete Feedback</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection