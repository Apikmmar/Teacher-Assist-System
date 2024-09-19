<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSubjectRequest;
use App\Models\Form;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function viewAllSubject(Request $request): View {
        if($request->subject_form != '') {
            $subjects = Subject::where('form_id', $request->subject_form)->orderBy('name')->paginate(10);
        } else {
            $subjects = Subject::orderBy('name')->paginate(10);
        }

        return view('manageSubject.all_subjects', [
            'subjects' => $subjects,
            'forms' => Form::all(),
        ]);
    }

    public function viewAddNewSubject(): View {
        $teachers = User::all();
        $teachers = $this->convertTeacherNameFormat($teachers);

        $teacherSelected = [];

        return view('manageSubject.add_subject', [
            'teachers' => $teachers,
            'forms' => Form::all(),
            'teacherSelected' => $teacherSelected
        ]);
    }

    public function viewEditSubject($id): View {
        $subject = Subject::findOrFail($id);
        $teachers = $subject->teachers;

        $teachers = $this->convertTeacherNameFormat($subject->teachers);

        $assignedTeacherIds = $teachers->pluck('id')->toArray();
        $newTeachers = User::whereNotIn('id', $assignedTeacherIds)->get();

        $newTeachers = $this->convertTeacherNameFormat($newTeachers);

        return view('manageSubject.edit_subject', [
            'subject' => $subject,
            'forms' => Form::all(),
            'teachers' => $teachers,
            'newTeachers' => $newTeachers,
        ]);
    }

    private function convertTeacherNameFormat($teachers): Collection {
        return $teachers->map(function ($teacher) {
            $title = $teacher->gender === 'Men' ? 'Mr.' : 'Mrs.';
            $teacher->name = $title . ' ' . Str::title($teacher->name);
            return $teacher;
        });
    }

    public function createNewSubject(AddSubjectRequest $request): RedirectResponse {
        $request->validated();

        $subject = Subject::create([
            'name' => $request->name,
            'form_id' => $request->form,
            'description' => $request->description,
        ]);

        $subject->save();

        if ($request->teachers != null) {
            $subjectTeacher = [];
    
            foreach ($request->teachers as $teacherId) {
                $subjectTeacher[] = [
                    'user_id' => $teacherId,
                    'subject_id' => $subject->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            DB::table('subject__teachers')->insert($subjectTeacher);
        }

        return redirect()->route('all_subjects')->with('blue-message', 'Successfully Register New Subject');
    }
}
