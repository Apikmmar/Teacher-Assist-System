<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Form;
use App\Models\Student;
use App\Models\Student_Examination_Report;
use App\Models\Student_Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use ZipArchive;

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
            'subjectName' => $subject->name . ' '. $subject->form->name,
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
            'totalStudent' => 0,
            'passedStudents' => 0,
            'failedStudents' => 0,
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

        $totalStudent = $students->count();
        $passedStudents = 0;
        $failedStudents = 0;

        $studentGrades->each(function ($grade) use (&$passedStudents, &$failedStudents) {
            if ($grade->is_passed === 'passed') {
                $passedStudents++;
            } else {
                $failedStudents++;
            }
        });
    
        $studentGradeCounts = Student_Grade::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))
                                        ->select('student_id', 'grade', DB::raw('COUNT(*) as count'))
                                        ->groupBy('student_id', 'grade')->get()->groupBy('student_id');

        $grades = $students->mapWithKeys(function ($student) use ($studentGradeCounts) {
            $gradeData = $studentGradeCounts->get($student->id, collect())->sort();
            $gradeString = $gradeData->map(function ($record) {
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
            'class_name' => $classroom->name,
            'totalStudent' => $totalStudent,
            'passedStudents' => $passedStudents,
            'failedStudents' => $failedStudents,
        ]);
    }
    
    public function viewFormReport(Request $request, $id): View | RedirectResponse {
        $examination = Examination::findOrFail($id);
        $forms = Form::all();

        if ($request->has('form_id')) {
            return $this->viewReportByForm($request, $examination, $forms);
        }

        return view('ManageExamReport.form_report', [
            'forms' => $forms,
            'examination' => $examination,
            'studentGrades' => collect(),
            'grades' => collect(),
            'totalStudent' => 0,
            'passedStudents' => 0,
            'failedStudents' => 0,
        ]);
    }

    private function viewReportByForm($request, $examination, $forms) {
        $request->validate([
            'form_id' => 'required|exists:forms,id',
        ]);

        $form = Form::findOrFail($request->form_id);
        $classes = $form->classrooms;

        $studentGrades = collect();
        $grades = [];
        $totalStudent = 0;
        $passedStudents = 0;
        $failedStudents = 0;
        $students = collect();

        $classrooms = Classroom::whereIn('id', $classes->pluck('id'))->with('students')->get();

        foreach ($classrooms as $classroom) {
            $students = $students->merge($classroom->students);
            $totalStudent += $classroom->students->count();
        }

        $studentIds = $students->pluck('id');
        $studentGrades = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $studentIds)
                        ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                        ->get();
        
        if($studentGrades->isEmpty()) {
            return redirect()->back()->withErrors('Data Not Available');
        }

        $passedStudents = $studentGrades->where('is_passed', 'passed')->count();
        $failedStudents = $studentGrades->where('is_passed', 'failed')->count();

        $studentGradeCounts = Student_Grade::where('examination_id', $examination->id)->whereIn('student_id', $studentIds)
                                        ->select('student_id', 'grade', DB::raw('COUNT(*) as count'))
                                        ->groupBy('student_id', 'grade')->get()->groupBy('student_id');

        $grades = $students->mapWithKeys(function ($student) use ($studentGradeCounts) {
            $gradeData = $studentGradeCounts->get($student->id, collect())->sort();
            $gradeString = $gradeData->map(function ($record) {
                return "{$record->count}{$record->grade}";
            })->join(' ');

            return [$student->id => $gradeString ?: 'N/A'];
        });

        return view('ManageExamReport.form_report', [
            'forms' => $forms,
            'examination' => $examination,
            'studentGrades' => $studentGrades,
            'grades' => $grades,
            'formName' => $form->name,
            'totalStudent' => $totalStudent,
            'passedStudents' => $passedStudents,
            'failedStudents' => $failedStudents,
        ]);
    }

    public function viewClassRecomendationReport(Request $request, $id): View | RedirectResponse {
        $examination = Examination::findOrFail($id);
        $forms = Form::take(3)->get();
        $classrooms = Classroom::all();

        if ($request->has('classroom_id')) {
            return $this->viewReportByClassRecomendation($request, $examination, $forms, $classrooms);
        }
    
        return view('ManageExamReport.classrecomendation_report', [
            'examination' => $examination,
            'forms' => $forms,
            'classrooms' => $classrooms,
            'upgradeClass' => collect(),
            'downgradeClass' => collect(),
            'upgradegrades' => collect(),
            'downgradegrades' => collect(),
            'class_name' => NULL,
        ]);
    }

    private function viewReportByClassRecomendation($request, $examination, $forms, $classrooms) {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
    
        $classroom = Classroom::findOrFail($request->classroom_id);
        $students = $classroom->students;
    
        if ($students->isEmpty()) {
            return redirect()->back()->withErrors('No students found in the selected classroom.');
        }
    
        $upgradeClass = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->modelKeys())
                                                ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                                                ->take(4)->get()->keyBy('student_id');
    
        if ($upgradeClass->isEmpty()) {
            return redirect()->back()->withErrors('Upgrade data not available.');
        }
    
        $downgradeClass = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->modelKeys())
                                                ->orderBy('is_passed', 'desc')->orderBy('pointer', 'asc')->orderBy('average_mark', 'asc')
                                                ->take(4)->get()->keyBy('student_id');
    
        if ($downgradeClass->isEmpty()) {
            return redirect()->back()->withErrors('Downgrade data not available.');
        }
    
        $transformGrades = function ($students, $examination) {
            return $students->mapWithKeys(function ($student) use ($examination) {
                $gradeCounts = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)
                                            ->select('grade', DB::raw('COUNT(*) as count'))
                                            ->groupBy('grade')->get();
    
                $gradeString = $gradeCounts->map(fn($record) => "{$record->count}{$record->grade}")->join(' ');
                return [$student->id => $gradeString ?: 'N/A'];
            });
        };
    
        $upgradegrades = $transformGrades($students, $examination);
        $downgradegrades = $transformGrades($students, $examination);
    
        return view('ManageExamReport.classrecomendation_report', [
            'examination' => $examination,
            'forms' => $forms,
            'classrooms' => $classrooms,
            'upgradeClass' => $upgradeClass,
            'downgradeClass' => $downgradeClass,
            'upgradegrades' => $upgradegrades,
            'downgradegrades' => $downgradegrades,
            'selectedClassroom' => $classroom,
            'class_name' => $classroom->name,
        ]);
    }
    
    public function viewStudentReport($examReport, $stdID): View {
        $examination = Examination::findOrFail($examReport);
        $student = Student::findOrFail($stdID);
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

        $class = $student->classroom;
        $studentsInClass = $class->students;
        $totalStudentInClass = $studentsInClass->count();

        $placeInClass = $this->calculatePlace($examination, $studentsInClass, $stdReport);

        $studentsInForm = $studentsInClass;
        $totalStudentInForm = 0;
        $form = $class->form;
        $classForm = $form->classrooms;

        $classrooms = Classroom::whereIn('id', $classForm->pluck('id'))->with('students')->get();
        foreach ($classrooms as $classroom) {
            $studentsInForm = $studentsInForm->merge($classroom->students);
            $totalStudentInForm += $classroom->students->count();
        }

        $placeInForms = $this->calculatePlace($examination, $studentsInForm, $stdReport);

        return view('ManageExamReport.student_report',[
            'examination' => $examination,
            'student' => $student,
            'class' => $class,
            'stdResult' => $stdResult,
            'stdReport' => $stdReport,
            'placeInClass' => $placeInClass,
            'totalStudentInClass' => $totalStudentInClass,
            'totalStudentInForm' => $totalStudentInForm,
            'placeInForms' => $placeInForms,
        ]);
    }

    public function downloadExamResult($exam, $stdID) {
        $examination = Examination::findOrFail($exam);
        $student = Student::findOrFail($stdID);
        $stdResult = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)->get();
        $stdReport = Student_Examination_Report::where('examination_id', $examination->id)->where('student_id', $student->id)->first();

        if(!$stdReport) {
            return redirect()->back()->withErrors('Examination Report Not Found!');
        }

        $class = $student->classroom;
        $student->dob = Carbon::parse($student->dob)->format('j F Y');
        $examination->start_date = Carbon::parse($examination->start_date)->format('j F Y');
        $examination->end_date = Carbon::parse($examination->end_date)->format('j F Y');

        $class = $student->classroom;
        $students = $class->students;
        $totalStudentInClass = $students->count();

        $placeInClass = $this->calculatePlace($examination, $students, $stdReport);

        $totalStudentInForm = 0;
        $studentsInForm = $students;
        $form = $class->form;
        $classForm = $form->classrooms;

        $classrooms = Classroom::whereIn('id', $classForm->pluck('id'))->with('students')->get();

        foreach ($classrooms as $classroom) {
            $students = $students->merge($classroom->students);
            $totalStudentInForm += $classroom->students->count();
        }

        $placeInForms = $this->calculatePlace($examination, $studentsInForm, $stdReport);

        $pdf = Pdf::loadView('ManageExamReport.exam_result', compact('examination', 'student', 'class', 'stdResult', 'stdReport','placeInClass', 'totalStudentInClass', 'totalStudentInForm', 'placeInForms'));

        return $pdf->download('Result ' . $examination->name . ' ' . $student->name . '.pdf');
    }

    private function calculatePlace($examination, $students, $stdReport) {
        $classReports = Student_Examination_Report::where('examination_id', $examination->id)->whereIn('student_id', $students->pluck('id'))
                                                ->orderBy('is_passed', 'asc')->orderBy('pointer', 'desc')->orderBy('average_mark', 'desc')
                                                ->get();

        $index = $classReports->search(function ($classReport) use ($stdReport) {
            return $classReport->id == $stdReport->id;
        });

        return $index !== false ? $index + 1 : null;
    }

    public function downloadZipExamResult($exam, $students) {
        $examination = Examination::findOrFail($exam);

        $temppdfPaths = [];
        $storagePath = storage_path('storage/temp_pdfs/');

        if(!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        foreach ($students as $studentID) {
            $student =  Student::findOrFail($studentID);
            $stdResult = Student_Grade::where('examination_id', $examination->id)->where('student_id', $student->id)->get();
            $stdReport = Student_Examination_Report::where('examination_id', $examination->id)->where('student_id', $student->id)->first();

            if (!$stdReport) {
                continue;
            }

            $class = $student->classroom;
            $student->dob = Carbon::parse($student->dob)->format('j F Y');
            $examination->start_date = Carbon::parse($examination->start_date)->format('j F Y');
            $examination->end_date = Carbon::parse($examination->end_date)->format('j F Y');

            $studentsInClass = $class->students;
            $totalStudentInClass = $studentsInClass->count();

            $placeInClass = $this->calculatePlace($examination, $studentsInClass, $stdReport);

            $totalStudentInForm = 0;
            $studentsInForm = $studentsInClass;
            $form = $class->form;
            $classForm = $form->classrooms;

            $classrooms = Classroom::whereIn('id', $classForm->pluck('id'))->with('students')->get();

            foreach ($classrooms as $classroom) {
                $studentsInForm = $studentsInForm->merge($classroom->students);
                $totalStudentInForm += $classroom->students->count();
            }

            $placeInForms = $this->calculatePlace($examination, $studentsInForm, $stdReport);

            $pdf = Pdf::loadView('ManageExamReport.exam_result', compact('examination', 'student', 'class', 'stdResult', 'stdReport', 'placeInClass', 'totalStudentInClass', 'totalStudentInForm', 'placeInForms'));

            $fileName = 'Result_' . $examination->name . '_' . $student->name . '.pdf';
            $filePath = $storagePath . $fileName;

            $pdf->save($filePath);
            $temppdfPaths[] = $filePath;
        }

        $zipFileName = 'ExamResults.zip';
        $zipFilePath = storage_path($zipFileName);
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($temppdfPaths as $filePath) {
                $zip->addFile($filePath, basename($filePath));
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Unable to create ZIP file'], 500);
        }

        foreach ($temppdfPaths as $filePath) {
            File::delete($filePath);
        }
        File::deleteDirectory($storagePath);

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}