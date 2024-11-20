<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Form;
use App\Models\Student_Examination_Report;
use App\Models\Student_Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function viewAllReport($id) {

        return view('ManageExamReport.all_report', [
            'examination' => Examination::findOrFail($id),
        ]);
    }

    public function viewSubjectReport(Request $request, $id) {
        $examination = Examination::findOrFail($id);
        $forms = Form::all();
        $subjects = Subject::all();

        if($request->has('subject_id')) {
            return $this->viewReportBySubject($request, $examination, $forms, $subjects);
        }

        return view('ManageExamReport.subject_report', [
            'examination' => $examination,
            'forms' => $forms,
            'subjects' => $subjects,
        ]);
    }

    private function viewReportBySubject($request, $examination, $forms, $subjects) {
        $request->validate([
            'form' => 'required|exists:forms,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        $examResults = Student_Grade::where('examination_id', $examination->id)->where('subject_id', $subject->id)->orderBy('marks', 'desc')->get();
        $passedStudents = Student_Grade::where('examination_id', $request->examination_id)->where('subject_id', $subject->id)->where('is_passed', 'passed')->count();

        $passedStudents = $examResults->where('is_passed', 'passed')->count();
        $totalStudent = $examResults->count();
        $failedStudents = $totalStudent - $passedStudents;

        return view('ManageExamReport.subject_report', [
            'examination' => $examination,
            'forms' => $forms,
            'subjects' => $subjects,
            'examResults' => $examResults,
            'totalStudent' => $totalStudent,
            'passedStudents' => $passedStudents,
            'failedStudents' => $failedStudents,
        ]);
    }

    public function viewReportByClassroom(Request $request, $id) {
        $request->validate([
            'classroom_id' => 'required|exists:classroom,id',
        ]);

        $class = Classroom::findOrFaiil($request->classroom_id);
        $examination = Examination::findOrFail($id);

        if (!$class) {
            return redirect()->back()->withErrors('Subject Not Found!');
        }

        $students = $class->students;
        $studentGrades = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))->get()->keyBy('student_id');
    }
}
