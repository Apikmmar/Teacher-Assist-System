@extends('layouts.app', ['title' => 'Grade Details'])

@section('content')
    <div class="container mt-1 fade-in-text">
        @include('layouts.message')
        
        <div class="table-responsive rounded-3 border overflow-hidden shadow-sm">
            <table class="table table-hover table-striped mb-0 align-middle mb-0">
                <thead>
                    <tr>
                        <th>Form</th>
                        <th>Grades Info</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($forms as $form)
                    <tr>
                        <td>
                            <div>
                                <strong>Name:</strong> {{ $form->name }}
                                <hr>
                                <button class="btn btn-sm btn-outline-primary edit-btn toggle-grade-form" data-form-id="{{ $form->id }}">
                                    <i class="fas fa-plus me-1"></i> Add New Grade
                                </button>
                            </div>
                        </td>
                        <td>

                        @foreach ($form->examgrade->sortByDesc('mark_min') as $formGrade)
                            <div class="grade-container mb-3 p-2 border rounded bg-light-hover transition-all">
                                <form action="{{ route('update.current_grade', ['id' => $formGrade->id]) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                        
                                    <div class="row g-2 align-items-center">
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Grade:</strong></span>
                                                <input type="text" name="grade" class="form-control form-control-sm border-0 py-1 text-center" value="{{ $formGrade->grade }}" style="max-width: 60px;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Range:</strong></span>
                                                <div class="d-flex align-items-center bg-white rounded px-2 border">
                                                    <input type="number" name="mark_min" class="form-control form-control-sm border-0 py-1 text-center" value="{{ $formGrade->mark_min }}" style="max-width: 55px;">
                                                    <span class="mx-1">–</span>
                                                    <input type="number" name="mark_max" class="form-control form-control-sm border-0 py-1 text-center" value="{{ $formGrade->mark_max }}" style="max-width: 55px;">
                                                    <span class="ms-1 text-muted">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Value:</strong></span>
                                                <input type="number" step="0.01" name="grade_value" class="form-control form-control-sm border-0 py-1 px-2 bg-white rounded text-center" value="{{ $formGrade->grade_value }}" style="width: 60px;">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                            <div class="d-flex align-items-center">
                                                <select name="is_passed" class="form-select form-select-sm border-0 py-1 px-2 bg-white rounded text-center" style="min-width: 100px;">
                                                    <option value="passed" {{ $formGrade->is_passed == 'passed' ? 'selected' : '' }}>Status: Pass</option>
                                                    <option value="failed" {{ $formGrade->is_passed == 'failed' ? 'selected' : '' }}>Status: Fail</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 col-lg-2">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <button type="reset" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" title="Reset">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm" title="Update">
                                                    <i class="fas fa-check text-white"></i>
                                                </button>
                                                <button data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $formGrade->id }}" 
                                                        class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" type="button" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        
                            @include('layouts.partials.modal', [
                                'id' => $formGrade->id, 
                                'name' => "Are you sure you want to remove this grade?",
                                'deleteRoute' => route('delete.current_grade', ['id' => $formGrade->id]),
                                'method' => 'DELETE'
                            ])
                        @endforeach
                            
                            <div id="add-grade-form-{{ $form->id }}" class="mb-3" style="display: none;">
                                <form action="{{ route('add.new_grade') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ $form->id }}">
                                    <div class="grade-container mb-3 p-2 border rounded bg-light-hover transition-all">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 text-muted"><strong>Grade:</strong></span>
                                                    <input type="text" name="grade" class="form-control form-control-sm border py-1 text-center" placeholder="A" style="max-width: 50px;" required>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 text-muted"><strong>Range:</strong></span>
                                                    <div class="d-flex align-items-center bg-white rounded px-2 border">
                                                        <input type="number" name="mark_min" class="form-control form-control-sm border-0 py-1 text-center" style="max-width: 55px;" placeholder="0">
                                                        <span class="mx-1">–</span>
                                                        <input type="number" name="mark_max" class="form-control form-control-sm border-0 py-1 text-center" style="max-width: 55px;" placeholder="0">
                                                        <span class="ms-1 text-muted">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 text-muted"><strong>Value:</strong></span>
                                                    <input type="number" name="grade_value" class="form-control form-control-sm border py-1 px-2 bg-white rounded text-center" placeholder="12" style="width: 60px;" required step="0.01">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 text-muted"><strong>Status:</strong></span>
                                                    <select name="is_passed" class="form-select form-select-sm border py-1 bg-white rounded" required>
                                                        <option value="passed">Pass</option>
                                                        <option value="failed">Fail</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-2">
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                        <i class="fas fa-check me-1"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm cancel-add-grade" data-form-id="{{ $form->id }}">
                                                        <i class="fas fa-times me-1"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <style>
            .grade-container {
                transition: all 0.2s ease;
            }
            .grade-container:hover {
                background-color: #f8f9fa;
            }
            .edit-btn {
                white-space: nowrap;
            }
            @media (max-width: 768px) {
                .table-responsive {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
                .grade-container {
                    padding: 0.5rem !important;
                }
                .btn {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.8rem;
                }
            }
        </style>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle add grade form visibility
        document.querySelectorAll('.toggle-grade-form').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.getAttribute('data-form-id');
                const formElement = document.getElementById(`add-grade-form-${formId}`);
                
                // Toggle display
                if (formElement.style.display === 'none') {
                    formElement.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-minus me-1"></i> Cancel Adding';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-outline-secondary');
                } else {
                    formElement.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-plus me-1"></i> Add New Grade';
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-outline-primary');
                }
            });
        });

        // Cancel button in the form
        document.querySelectorAll('.cancel-add-grade').forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-form-id');
                const formElement = document.getElementById(`add-grade-form-${formId}`);
                const toggleButton = document.querySelector(`.toggle-grade-form[data-form-id="${formId}"]`);
                
                formElement.style.display = 'none';
                toggleButton.innerHTML = '<i class="fas fa-plus me-1"></i> Add New Grade';
                toggleButton.classList.remove('btn-outline-secondary');
                toggleButton.classList.add('btn-outline-primary');
            });
        });
    });
    </script>  
@endsection