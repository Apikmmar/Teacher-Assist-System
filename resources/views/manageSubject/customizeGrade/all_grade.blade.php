@extends('layouts.app', ['title' => 'Grade Details'])

@section('content')
    <div class="container">
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
                            <div><strong>Name:</strong> {{ $form->name }}</div>
                        </td>
                        <td>
                            @foreach ($form->examgrade as $formGrade)
                                <div class="grade-container mb-2 p-2 border rounded d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="me-3"><strong>Grade ID:</strong> {{ $formGrade->id }}</span>
                                        <span class="badge bg-primary me-3">{{ $formGrade->grade }}</span>
                                        <span class="me-3"><strong>Range:</strong> {{ $formGrade->mark_min }}%-{{ $formGrade->mark_max }}%</span>
                                        <span><strong>Value:</strong> {{ $formGrade->grade_value }}</span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary edit-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            @endforeach
                        </td>
                        <td></td> <!-- Empty cell to align with header -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Add Font Awesome for the edit icon -->
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
@endsection