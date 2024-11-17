<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Student;
use App\Models\Student_Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
    
    public function viewClassroomFeedback($class_id, $subject_id, $exam_id): View {
        $class = Classroom::findOrFail($class_id);
        $subject = Subject::findOrFail($subject_id);
        $exam = Examination::findOrFail($exam_id);
        
        $students = $class->students;
        $studentGrades = Student_Grade::where('examination_id', $exam->id)->where('subject_id', $subject->id)->whereIn('student_id', $students->pluck('id'))->get()->keyBy('student_id');

        return view('manageExamFeedback.classroom_feedbacks', [
            'class' => $class,
            'subject' => $subject,
            'exam' => $exam,
            'students' => $students,
            'studentGrades' => $studentGrades,
        ]);
    }

    public function viewMyClassFeed($id): View {
        $exam = Examination::findOrFail($id);
        $classroom = Classroom::where('classteacher_id', Auth::id())->first();

        return view('manageExamFeedback.my_class', [
            'exam' => $exam,
            'classroom' => $classroom,
        ]);
    }

    public function updateStudentFeedback(Request $request): RedirectResponse {
        $exam = Examination::findOrFail($request->input('examination_id'));
        $subject = Subject::findOrFail($request->input('subject_id'));
        $student = Student::findOrFail($request->input('students_id'));
        $class_id = $student->classroom_id;

        $grade = Student_Grade::where('examination_id', $exam->id)->where('subject_id', $subject->id)->where('student_id', $student->id)->first();

        $grade->update(['feedback' => $request->input('feedback')]);

        return redirect()->route('exam_mark_feedbacks', ['class_id' => $class_id, 'subject_id' => $subject->id, 'exam_id' => $exam->id])->with('blue-message', 'Successfully Update Feedback To Student');
    }

    public function deleteStudentFeedback(Request $request): RedirectResponse {
        $exam = Examination::findOrFail($request->input('examination_id'));
        $subject = Subject::findOrFail($request->input('subject_id'));
        $student = Student::findOrFail($request->input('students_id'));
        $class_id = $student->classroom_id;

        $grade = Student_Grade::where('examination_id', $exam->id)->where('subject_id', $subject->id)->where('student_id', $student->id)->first();

        $grade->update(['feedback' => NULL]);

        return redirect()->route('exam_mark_feedbacks', ['class_id' => $class_id, 'subject_id' => $subject->id, 'exam_id' => $exam->id])->with('red-message', 'Successfully Delete Feedback of Student');
    }
}
