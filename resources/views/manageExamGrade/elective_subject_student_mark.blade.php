@extends('layouts.app', ['title' => 'Student Examination Mark'])

@section('content')
<div class="container py-4">
    @include('layouts.message')

    <div class="card shadow-sm rounded" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body p-4">
            <h5 class="card-title text-center mb-4">Enter Student Elective Subject Marks</h5>
            
            <!-- Student Info -->
            <div class="student-info mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Student:</span>
                    <span>{{ $student->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subject:</span>
                    <span>{{ $subject->name }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Exam:</span>
                    <span>{{ $exam->name }}</span>
                </div>
            </div>

            <hr class="my-3">

            <!-- Mark Entry Form -->
            <form action="{{ route('create.elective_mark') }}" method="POST">
                @csrf
                <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div class="mb-3">
                    <label for="mark" class="form-label">Marks (0-100)</label>
                    <input id="mark" type="number" name="mark" class="form-control" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label for="grade" class="form-label">Grade</label>
                        <select id="grade" name="grade" class="form-select" required>
                            <option value="" selected disabled>Select grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->grade }}" 
                                        data-min="{{ $grade->mark_min }}" 
                                        data-max="{{ $grade->mark_max }}">
                                    {{ $grade->grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pointer" class="form-label">Pointer</label>
                        <select id="pointer" name="grade_value" class="form-select" required>
                            <option value="" selected disabled>Select pointer</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->grade_value }}" 
                                        data-grade="{{ $grade->grade }}">
                                    {{ $grade->grade_value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="feedback" class="form-label">Feedback (Optional)</label>
                    <textarea id="feedback" name="feedback" class="form-control" rows="2"></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Save Mark</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const markInput = document.getElementById('mark');
    const gradeSelect = document.getElementById('grade');
    const pointerSelect = document.getElementById('pointer');
    
    markInput.addEventListener('input', function() {
        const mark = parseFloat(this.value);
        
        // Reset if invalid
        if (isNaN(mark) || mark < 0 || mark > 100) {
            gradeSelect.value = '';
            pointerSelect.value = '';
            return;
        }
        
        // Find matching grade
        const gradeOptions = Array.from(gradeSelect.options);
        const matchedGrade = gradeOptions.find(opt => {
            const min = parseFloat(opt.dataset.min);
            const max = parseFloat(opt.dataset.max);
            return mark >= min && mark <= max;
        });
        
        if (matchedGrade) {
            gradeSelect.value = matchedGrade.value;
            
            // Find matching pointer
            const pointerOptions = Array.from(pointerSelect.options);
            const matchedPointer = pointerOptions.find(
                opt => opt.dataset.grade === matchedGrade.value
            );
            
            if (matchedPointer) pointerSelect.value = matchedPointer.value;
        } else {
            gradeSelect.value = '';
            pointerSelect.value = '';
        }
    });
});
</script>
@endsection