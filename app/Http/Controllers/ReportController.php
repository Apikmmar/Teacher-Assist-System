<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Form;
use App\Models\Student_Examination_Report;
use App\Models\Student_Grade;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function viewAllReport($id) {

        return view('ManageExamReport.all_report', [
            'examination' => Examination::findOrFail($id),
        ]);
    }

    public function viewSubjectReport(Request $request, $id): View| RedirectResponse {
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
            'examResults' => collect(),
            'totalStudent' => 0,
            'passedStudents' => 0,
            'failedStudents' => 0,
        ]);
    }

    private function viewReportBySubject($request, $examination, $forms, $subjects) {
        $request->validate([
            'form' => 'required|exists:forms,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        $examResults = Student_Grade::where('examination_id', $examination->id)->where('subject_id', $subject->id)->orderBy('marks', 'desc')->get();

        if($examResults->isEmpty()) {
            return redirect()->back()->withErrors('Data Not Available');
        }

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

    public function viewClassroomReport(Request $request, $id): View | RedirectResponse {
        $examination = Examination::findOrFail($id);
        $forms = Form::all();
        $classrooms = Classroom::all();
        $studentGrades = collect();
        $grades = collect();
    
        if ($request->has('classroom_id')) {
            return $this->viewReportByClassroom($request, $examination, $forms, $classrooms);
        }
    
        return view('ManageExamReport.class_report', [
            'examination' => $examination,
            'forms' => $forms,
            'classrooms' => $classrooms,
            'studentGrades' => $studentGrades,
            'grades' => $grades,
            'class_name' => NULL,
        ]);
    }
    
    private function viewReportByClassroom($request, $examination, $forms, $classrooms) {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
    
        $classroom = Classroom::findOrFail($request->classroom_id);
        $students = $classroom->students;
    
        $studentGrades = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))
                                                ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                                                ->get()->keyBy('student_id');

        if($studentGrades->isEmpty()) {
            return redirect()->back()->withErrors('Data Not Available');
        }
    
        $grades = $students->mapWithKeys(function ($student) use ($examination) {
            $gradeCounts = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)
                                        ->select('grade', DB::raw('COUNT(*) as count'))
                                        ->groupBy('grade')->get();
    
            $gradeString = $gradeCounts->map(function ($record) {
                return "{$record->count}{$record->grade}";
            })->join(' ');
    
            return [$student->id => $gradeString ?: 'N/A'];
        });
    
        return view('ManageExamReport.class_report', [
            'examination' => $examination,
            'forms' => $forms,
            'classrooms' => $classrooms,
            'studentGrades' => $studentGrades,
            'grades' => $grades,
            'selectedClassroom' => $classroom,
            'class_name' => $classroom->name
        ]);
    }
    
    public function viewFormReport(Request $request, $id): View | RedirectResponse {
        $examination = Examination::findOrFail($id);
        $forms = Form::all();
        $studentGrades = collect();
        $grades = collect();

        if ($request->has('form_id')) {
            return $this->viewReportByForm($request, $examination, $forms, $studentGrades, $grades);
        }

        return view('ManageExamReport.form_report', [
            'forms' => $forms,
            'examination' => $examination,
            'studentGrades' => $studentGrades,
            'grades' => $grades,
        ]);
    }

    private function viewReportByForm($request, $examination, $forms, $studentGrades, $grades) {
        $request->validate([
            'form_id' => 'required|exists:forms,id',
        ]);

        $form = Form::findOrFail($request->form_id);
        $classes = $form->classrooms;

        foreach ($classes as $index => $classroom) {
            $class = Classroom::findOrFail($classroom->id);
            $students = $class->students;
    
            $studentGrades = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))
                                                    ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                                                    ->get()->keyBy('student_id');

            if($studentGrades->isEmpty()) {
                return redirect()->back()->withErrors('Data Not Available');
            }
        
            $grades = $students->mapWithKeys(function ($student) use ($examination) {
                $gradeCounts = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)
                                            ->select('grade', DB::raw('COUNT(*) as count'))
                                            ->groupBy('grade')->get();
        
                $gradeString = $gradeCounts->map(function ($record) {
                    return "{$record->count}{$record->grade}";
                })->join(' ');
        
                return [$student->id => $gradeString ?: 'N/A'];
            });
        }

        return view('ManageExamReport.form_report', [
            'forms' => $forms,
            'examination' => $examination,
            'studentGrades' => $studentGrades,
            'grades' => $grades,
        ]);
    }
}
