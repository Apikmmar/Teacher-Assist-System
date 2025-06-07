@extends('layouts.app', ['title' => 'Registered Students Examination Mark'])

@section('content')
    <div class="container fade-in-text">
        @include('layouts.message')

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1"><i class="bi bi-clipboard-data me-2"></i>Student Examination Results</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-journal-bookmark me-1"></i>{{ $exam->name }} | 
                    <i class="bi bi-book me-1"></i>{{ $subject->name }} | 
                    <i class="bi bi-people-fill me-1"></i>{{ $class->name }}
                </p>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive rounded-3 border overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-medium text-muted" style="width: 50px">#</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-credit-card-2-front me-2"></i>IC Number</th>
                            <th scope="col" class="fw-medium"><i class="bi bi-person-fill me-2"></i>Name</th>
                            <th scope="col" class="fw-medium text-center"><i class="bi bi-percent me-2"></i>Marks</th>
                            <th scope="col" class="fw-medium text-center"><i class="bi bi-chat-left-text me-2"></i>Feedback</th>
                            <th scope="col" class="fw-medium text-center pe-4"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr class="border-top">
                                <td class="ps-4 text-muted fw-medium">{{ 1 + $index }}</td>
                                <td>{{ $student->ic }}</td>
                                <td>{{ $student->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $studentGrades[$student->id]->marks ?? 'N/A' }} 
                                        <span class="text-muted">({{ $studentGrades[$student->id]->grade ?? '-' }})</span>
                                    </span>
                                </td>
                                
                                <form action="{{ route('studente-feedback.update') }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <td class="text-center">
                                        <div class="input-group" style="max-width: 250px; margin: 0 auto;">
                                            <input type="text" class="form-control text-center" name="feedback" 
                                                    value="{{ $studentGrades[$student->id]->feedback ?? '' }}" 
                                                    placeholder="Enter feedback">
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="students_id" value="{{ $student->id }}">
                                            <input type="hidden" name="examination_id" value="{{ $exam->id }}">
                                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-save me-1"></i>Update
                                            </button>
                                            
                                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteFeedbackModal{{ $student->id }}">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </form>
                            </tr>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteFeedbackModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete feedback for {{ $student->name }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('studente-feedback.update') }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="students_id" value="{{ $student->id }}">
                                                <input type="hidden" name="examination_id" value="{{ $exam->id }}">
                                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash me-1"></i>Confirm Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection