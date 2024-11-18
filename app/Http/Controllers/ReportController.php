<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Student_Examination_Report;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function viewReportBySubject(Request $request, $id) {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $examination = Examination::findOrFail($id);
        $subject = Subject::findOrFail($request->subject_id);

        if (!$subject) {
            return redirect()->back()->withErrors('Subject Not Found!');
        }

        $examResult = Student_Examination_Report::where('examination_id', $examination->id)->where('subject_id', $subject->id)->orderBy('marks', 'desc')->get();
        $passedStudents = Student_Examination_Report::where('examination_id', $request->examination_id)->where('subject_id', $subject->id)->where('status', 'passed')->count();

        $totalStudent = $examResult->count();
        $failedStudents = $totalStudent - $passedStudents;
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
