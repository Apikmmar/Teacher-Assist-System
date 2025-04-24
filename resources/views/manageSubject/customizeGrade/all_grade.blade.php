@extends('layouts.app', ['title' => 'Grade Details'])

@section('content')
    <div class="container mt-1 fade-in-text">
        @include('layouts.message')
        
        <table class="table table-striped mb-0">
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
                            <!-- Existing Grades -->
                            @foreach ($form->examgrade as $formGrade)
                            <form action="" method="post" class="mb-3">
                                @csrf
                                @method('PUT')
                                <div class="grade-container mb-3 p-3 border rounded d-flex justify-content-between align-items-center bg-light-hover transition-all">
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <!-- Grade -->
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted"><strong>Grade:</strong></span>
                                            <input type="text" name="grade" class="form-control-sm border-0 py-1 text-center" value="{{ $formGrade->grade }}" style="max-width: 50px;">
                                        </div>

                                        <!-- Range (Min/Max) -->
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted"><strong>Grade Range:</strong></span>
                                            <div class="d-flex align-items-center bg-white rounded px-2 border">
                                                <input type="number" name="mark_min" class="form-control-sm border-0 py-1 text-center" value="{{ $formGrade->mark_min }}" style="width: 65px;">
                                                <span class="mx-1">–</span>
                                                <input type="number" name="mark_max" class="form-control-sm border-0 py-1 text-center" value="{{ $formGrade->mark_max }}" style="width: 65px;">
                                                <span class="ms-1 text-muted">%</span>
                                            </div>
                                        </div>
                            
                                        <!-- Value -->
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted"><strong>Value:</strong></span>
                                            <input type="number" name="grade_value" class="form-control-sm border-0 py-1 px-2 bg-white rounded text-center" value="{{ $formGrade->grade_value }}" style="width: 60px;">
                                        </div>
                                    </div>
                            
                                    <!-- Save Button -->
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-undo me-1"></i> Reset
                                        </button>
                                        <a href="" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-check me-1"></i> Update
                                        </a>
                                        <a href="" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                            
                            <!-- Add New Grade Form (Initially Hidden) -->
                            <div id="add-grade-form-{{ $form->id }}" class="mb-3" style="display: none;">
                                <form action="{{ route('add.new_grade') }}" method="post">
                                    @csrf
                                    
                                    <input type="hidden" name="form_id" value="{{ $form->id }}">
                                    <div class="grade-container mb-3 p-3 border rounded d-flex justify-content-between align-items-center bg-light-hover transition-all">
                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <!-- Grade -->
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Grade:</strong></span>
                                                <input type="text" name="grade" class="form-control-sm border py-1 text-center" placeholder="A" style="max-width: 50px;" required>
                                            </div>

                                            <!-- Range (Min/Max) -->
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Grade Range:</strong></span>
                                                <div class="d-flex align-items-center bg-white rounded px-2 border">
                                                    <input type="number" name="mark_min" class="form-control-sm border py-1 text-center" placeholder="0" style="width: 65px;" required min="0" max="100">
                                                    <span class="mx-1">–</span>
                                                    <input type="number" name="mark_max" class="form-control-sm border py-1 text-center" placeholder="100" style="width: 65px;" required min="0" max="100">
                                                    <span class="ms-1 text-muted">%</span>
                                                </div>
                                            </div>
                                
                                            <!-- Value -->
                                            <div class="d-flex align-items-center">
                                                <span class="me-2 text-muted"><strong>Value:</strong></span>
                                                <input type="number" name="grade_value" class="form-control-sm border py-1 px-2 bg-white rounded text-center" placeholder="12" style="width: 60px;" required step="0.01">
                                            </div>
                                        </div>
                                
                                        <!-- Add Button -->
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                                <i class="fas fa-check me-1"></i> Save
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm cancel-add-grade" data-form-id="{{ $form->id }}">
                                                <i class="fas fa-times me-1"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
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