<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Student;
use App\Models\Student_Examination_Report;
use App\Models\Student_Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    // class and form position not conclude yet
    public function viewStudentPerformanceFeedback($examID, $stdID) {
        $student = Student::findOrFail($stdID);
        $examination = Examination::findOrFail($examID);
        $stdResult = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)->get();
        $stdReport = Student_Examination_Report::where('examination_id', $examination->id)->where('student_id', $student->id)->first();

        if(!$stdReport) {
            return redirect()->back()->withErrors('Examination Report Not Found!');
        }

        $class = $student->classroom;
        $student->dob = Carbon::parse($student->dob)->format('j F Y');
        $examination->start_date = Carbon::parse($examination->start_date)->format('j F Y');
        $examination->end_date = Carbon::parse($examination->end_date)->format('j F Y');

        $stdResult->each(function ($grade) {
            $grade->subName = $grade->subject ? $grade->subject->name : 'N/A';
        });

        $stdResult->each(function ($grade) {
            $grade->subName = $grade->subject ? $grade->subject->name : 'N/A';
        });

        $students = $class->students;
        $placeInClass = NULL;

        $classReports = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))
                                                ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                                                ->get();


        $indexClass = $classReports->search(function ($classReport) use ($stdReport) {
            return $classReport->id == $stdReport->id;
        });

        if ($indexClass !== false) {
            $placeInClass = $indexClass + 1;
        }

        $form = $class->form;
        $classForm = $form->classrooms;
        $totalStudentInForm = NULL;
        $placeInForms = NULL;

        $classrooms = Classroom::whereIn('id', $classForm->pluck('id'))->with('students')->get();

        foreach ($classrooms as $classroom) {
            $students = $students->merge($classroom->students);
            $totalStudentInForm += $classroom->students->count();
        }

        $studentIds = $students->pluck('id');
        $formReports = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $studentIds)
                        ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                        ->get();

        $indexForm = $formReports->search(function ($classReport) use ($stdReport) {
            return $classReport->id == $stdReport->id;
        });

        if ($indexForm !== false) {
            $placeInForms = $indexForm + 1;
        }
        
        return view('manageExamFeedback.student_performance_feedback', [
            'student' => $student,
            'examination' => $examination,
            'class' => $class,
            'stdResult' => $stdResult,
            'stdReport' => $stdReport,
            'placeInClass' => $placeInClass,
            'totalStudentInClass' => $class->students->count(),
            'totalStudentInForm' => $totalStudentInForm,
            'placeInForms' => $placeInForms,
        ]);
    }

    public function manageStudentFeedback(Request $request): RedirectResponse {
        $request->validate([
            'action' => 'required|string|in:update,delete',
            'students_id' => 'required|exists:students,id',
            'examination_id' => 'required|exists:examinations,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exam = Examination::findOrFail($request->input('examination_id'));
        $subject = Subject::findOrFail($request->input('subject_id'));
        $student = Student::findOrFail($request->input('students_id'));
        $class_id = $student->classroom_id;
    
        $grade = Student_Grade::where('examination_id', $exam->id)->where('subject_id', $subject->id)->where('student_id', $student->id)->first();

        if (!$grade) {
            return redirect()->back()->withErrors('Grade record not found!');
        }
    
        if ($request->input('action') === 'update') {
            $grade->update(['feedback' => $request->input('feedback')]);
            $message = 'Successfully Updated Feedback for Student';
            $messageType = 'blue-message';

        } elseif ($request->input('action') === 'delete') {
            $grade->update(['feedback' => null]);
            $message = 'Successfully Deleted Feedback of Student';
            $messageType = 'red-message';
        }
    
        return redirect()->route('exam_mark_feedbacks', ['class_id' => $class_id, 'subject_id' => $subject->id, 'exam_id' => $exam->id])->with($messageType, $message);
    }

    public function addExamReportFeedback(Request $request, $id) {
        $request->validate([
            'feedback' => ['nullable' , 'string' , 'max:100'],
            'action' => 'required|string|in:update,delete',
        ]);
        
        $examReport = Student_Examination_Report::findOrFail($id);

        if ($request->input('action') === 'update') {
            $examReport->update(['feedback' => $request->input('feedback')]);
            $message = 'Successfully Update Report Feedback for Student';
            $messageType = 'blue-message';

        } elseif ($request->input('action') === 'delete') {
            $examReport->update(['feedback' => '-']);
            $message = 'Successfully Deleted Report Feedback of Student';
            $messageType = 'red-message';
        }

        return redirect()->route('student_ferformance.feedback', ['examID' => $examReport->examination_id, 'stdID' => $examReport->student_id])->with($messageType, $message);
    }
}
