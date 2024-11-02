@extends('layouts.app', ['title' => 'Student Details'])

@section('content')

    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex justify-content-end mb-2">
            <div class="btn-group mb-2">
                <button type="button" class="btn btn-info text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Edit Student
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('edit_student', ['id' => $std->id]) }}"><i class="bi bi-pencil"></i> Edit Student Info</a></li>
                @if ($std->classroom_id && $std->status == 'Active')
                  <li><a class="dropdown-item" href="{{ route('student_subject', ['id' => $std->id]) }}"><i class="bi bi-book"></i> Registered Subject</a></li>
                @endif
                </ul>
            </div>
        </div>

        @include('manageClassroom.partials.student_info') 

        @if ($std->classroom_id && $std->status == 'Active')
        <hr>
        <header>
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Subject Taken by The Student') }}
            </h4>
        </header>
        @if ($subsTaken->isNotEmpty())
        <div class="d-flex justify-content-start align-items-center">
            <table class="table table-hover" style="max-width: 400px;">

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
                <h4 class="fw-bold">No Subject Registered</h4>
            </div>
        @endif
        @endif
    </div>
@endsection