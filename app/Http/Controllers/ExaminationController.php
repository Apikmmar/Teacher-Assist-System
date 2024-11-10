<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddExaminationRequest;
use App\Models\Classroom;
use App\Models\Examination;
use App\Models\Examination_Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ExaminationController extends Controller
{
    //
    public function viewAllExamination(): View {
        $examinations = Examination::orderBy('end_date', 'desc')->orderBy('status')->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function viewAddExamination(): View {
        return view('manageExamGrade.add_examination');
    }

    public function viewExaminationDetails($id): View {
        
        return view('manageExamGrade.examination_details', [
            'exam' => Examination::findOrFail($id),
        ]);
    }

    public function viewStudentExamination(Request $request): View {
        if($request->exam_status != '') {
            $examinations = Examination::where('status', $request->exam_status)->orderBy('end_date', 'desc')->paginate(10);
        } else {
            $examinations = Examination::orderBy('status', 'desc')->orderBy('end_date', 'desc')->paginate(10);
        }

        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_student_exam', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function viewClassExamination($id): View {
        $user = Auth::user();
        $examination = Examination::findOrFail($id);

        $examination->start_date = Carbon::parse($examination->start_date)->format('j F Y');
        $examination->end_date = Carbon::parse($examination->end_date)->format('j F Y');
        $examination->release_date = Carbon::parse($examination->release_date)->format('j F Y');

        $subjectClass = [];
        
        foreach ($user->subjects as $subs) {
            $subjectID = $subs->id;
            $subjectTeach = $subs->name;
            $subjectForm = $subs->form->name;

            $teachesClass = $user->subjecttaken->where('subject_id', $subs->id);

            $classes = [];

            foreach ($teachesClass as $classT) {
                $class = Classroom::find($classT->classroom_id);

                $className = $class ? $class->name : 'No Class';
                $classID = $class ? $class->id : 'No ID';

                $classes[] = [
                    'className' => $className,
                    'classID' => $classID,
                ];
            }

            $subjectClass[] = [
                'subjectID' => $subjectID,
                'subjectTeach' => $subjectTeach,
                'subjectForm' => $subjectForm,
                'classes' => $classes,
            ];
        }

        usort($subjectClass, function ($a, $b) {
            return strcmp($a['subjectForm'], $b['subjectForm']);
        });

        return view('manageExamGrade.class_examination', [
            'examination' => $examination,
            'userSubs' => $user,
            'subjectClass' => $subjectClass
        ]);
    }

    public function viewStudentsExamMark($class_id, $subject_id, $exam_id) {
        $class = Classroom::findOrFail($class_id);
        $subject = Subject::findOrFail($subject_id);
        $exam = Examination::findOrFail($exam_id);
        $grades = Examination_Grade::where('form_id', $subject->form->id)->get();

        return view('manageExamGrade.students_exam_mark', [
            'class' => $class,
            'subject' => $subject,
            'exam' => $exam,
            'students' => $class->students,
            'grades' => $grades,
        ]);
    }

    public function addNewExamination(AddExaminationRequest $request): RedirectResponse {
        $request->validated();

        $examinationType = $request->type === 'Other' ? $request->otherExam : $request->type;

        $exam = Examination::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'type' => $examinationType,
            'release_date' => $request->release_date,
        ]);

        return redirect()->route('view_examination', ['id' => $exam->id])->with('blue-message', 'Successfully Registered New Examination');
    }

    public function updateExaminationDetails(Request $request, $id): RedirectResponse {
        $newData = $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'type' => ['nullable', 'string', 'max:200'],
        ]);

        $exam = Examination::findOrFail($id);

        $exam->update($newData);

        return redirect()->route('view_examination', ['id' => $id])->with('blue-message', 'Successfully Update Examination Data');
    }

    public function deleteExamination($id): RedirectResponse {
        $exam = Examination::findOrFail($id);

        $exam->delete();

        return redirect()->route('all_examination')->with('red-message', 'Examination Data Is Deleted');
    }

    public function releaseExamination($id): RedirectResponse {
        $exam = Examination::findOrFail($id);

        $exam->update(['status' => 'Release']);

        return redirect()->route('view_examination', ['id' => $id])->with('blue-message', 'Examination Data Is Released');
    }
    
    public function searchExamination(Request $request): View {
        $validator = Validator::make($request->all(), [
            'search_examination' => 'required | string | max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $searchTerm = $request->input('search_examination');

        $examinations = Examination::where('name', 'LIKE', '%' . $searchTerm . '%')->orderBy('start_date', 'desc')->orderBy('status')->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function searchStudentExamination(Request $request): View {
        $validator = Validator::make($request->all(), [
            'search_examination' => 'required | string | max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $searchTerm = $request->input('search_examination');

        $examinations = Examination::where('name', 'LIKE', '%' . $searchTerm . '%')->orderBy('start_date', 'desc')->orderBy('status')->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_student_exam', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    public function filterExamination(Request $request): View {
        $query = Examination::query();

        if ($request->filled('sort_name')) {
            $order = $request->sort_name === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('name', $order);
        }

        if ($request->filled('sort_duration')) {
            $order = $request->sort_duration === 'ASC' ? 'asc' : 'desc';
            $query->selectRaw('*, DATEDIFF(end_date, start_date) + 1 as duration')->orderBy('duration', $order);
        }

        if ($request->filled('sort_release')) {
            $order = $request->sort_release === 'ASC' ? 'asc' : 'desc';
            $query->orderBy('release_date', $order);
        }

        if ($request->filled('status_release')) {
            $query->where('status', 'Release');
        }

        if ($request->filled('status_pending')) {
            $query->where('status', 'Pending');
        }

        $examinations = $query->paginate(10);
        $duration = $this->convertExamDate($examinations);

        return view('manageExamGrade.all_examination', [
            'examinations' => $examinations,
            'duration' => $duration,
        ]);
    }

    private function convertExamDate($examinations) {
        $duration = [];

        foreach ($examinations as $exam) {
            $startDate = Carbon::parse($exam->start_date);
            $endDate = Carbon::parse($exam->end_date);
            $releaseDate = Carbon::parse($exam->release_date);
            
            $duration[] = $startDate->diffInDays($endDate) + 1;
            
            $exam->start_date = $startDate->format('j F Y');
            $exam->end_date = $endDate->format('j F Y');
            $exam->release_date = $releaseDate->format('j F Y');
        }

        return $duration;
    }
}