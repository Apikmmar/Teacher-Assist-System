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
        
            <div class="modal fade" id="confirmDelete{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $student->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel{{ $student->id }}">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove {{ $student->name }} from school database?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('delete_student.delete', ['id' => $student->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary tr-button">Delete</button>
                            </form>
                            <button type="button" class="btn btn-danger tr-button" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
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
@else
    <div class="d-flex justify-content-center mt-2">
        <h4 class="fw-bold">Students Not Registered</h4>
    </div>
@endif