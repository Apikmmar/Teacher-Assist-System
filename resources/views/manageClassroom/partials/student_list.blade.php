@if ($students->isNotEmpty())
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Identity Card Number</th>
                <th scope="col">Student ID</th>
                <th scope="col">Gender</th>
                <th scope="col">Classroom</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Operation</th>
            </tr>
        </thead>
        <tbody>
        @php
            $startNumber = ($students->currentPage() - 1) * $students->perPage() + 1;
        @endphp
        @foreach ($students as $index => $student)
            <tr class="align-middle teacher-list">
                <th scope="row">{{ $startNumber + $index }}</th>
                <td>{{ $student->name }}</td>
                <td>{{ $student->ic }}</td>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->gender }}</td>
                <td>{!! optional($student)->classroom->name ?? '<i>N/A</i>' !!}</td>
                <td>{{ $student->status }}</td>
                <td class="text-center">
                    <a href="{{ route('view_student', ['id' => $student->id ]) }}" class="btn btn-success tr-button">View</a>
                @can('coordinator')
                    <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $student->id }}" class="btn btn-danger tr-button">Delete</button>
                @endcan
                </td>
            </tr>
        
            @include('layouts.partials.modal', [
                'id' => $student->id, 
                'name' => "Are you sure you want to remove " . $student->name . " from from the database?",
                'deleteRoute' => route('delete_student.delete', ['id' => $student->id]),
                'method' => 'DELETE'
            ])
        @endforeach
        
        @if ($students->total() > 10)
            <tfoot class="text-center">
                <tr>
                    <td colspan="12" class="text-center">
                        {{ $students->onEachSide(5)->appends(request()->query())->links() }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table> 
@else
    <div class="d-flex justify-content-center mt-2">
        <h4 class="fw-bold">Students Not Registered</h4>
    </div>
@endif