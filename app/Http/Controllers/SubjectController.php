<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSubjectRequest;
use App\Http\Requests\UpdateSubjectInfoRequest;
use App\Models\Classroom;
use App\Models\Form;
use App\Models\Subject;
use App\Models\Subject_Taken;
use App\Models\Subject_Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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

    public function viewclassroomsubject($id): View {

        $teacherNames = [];
        $registeredTeachers = [];
        
        $class = Classroom::findOrFail($id);
        $subjects = Subject_Taken::where('classroom_id', $id)->get();

        foreach ($subjects as $subject) {
            if ($subject->subject != NULL) {
                $subject->subject->name = Str::title($subject->subject->name);
            } else {
                $subject->subject->name = 'N/A';
            }

            if ($subject->subjectTeacher !== NULL) {
                $teacher = $subject->subjectTeacher->teacher;

                if (strtolower($teacher->gender) == 'Men') {
                    $teacherNames[$subject->id] = 'Mr. ' . Str::title($teacher->name);
                } else {
                    $teacherNames[$subject->id] = 'Mrs. ' . Str::title($teacher->name);
                }
            } else {
                $teacherNames[$subject->id] = 'Not Assigned Yet';
            }

            $registeredTeachers[$subject->id] = Subject_Teacher::where('subject_id', $subject->subject->id)->get();

            foreach ($registeredTeachers[$subject->id] as $teacher) {
                $teacher = $teacher->teacher;

                if (strtolower($teacher->gender) == 'Men') {
                    $teacher->name = 'Mr. ' . Str::title($teacher->name);
                } else {
                    $teacher->name = 'Mrs. ' . Str::title($teacher->name);
                }
            }
        }
        
        return view('manageSubject.classroom_subject', [
            'class' => $class,
            'subjects' => $subjects,
            'teacherNames' => $teacherNames,
            'registeredTeachers' => $registeredTeachers,
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

    public function updateSubjectInfo(UpdateSubjectInfoRequest $request, $id): RedirectResponse {
        $newInfo = $request->validated();
        
        $sub = Subject::findOrFail($id);

        $sub->update($newInfo);

        return redirect()->route('edit_subject', ['id' => $id ])->with('blue-message', 'Successfully Update Subject Info');
    }

    public function deleteSubject($id): RedirectResponse {
        $subject = Subject::findOrFail($id);

        $subject->delete();

        return redirect()->route('all_subjects')->with('red-message', 'Successfully Delete Subject');
    }

    public function addSubjectTeacher(Request $request, $id): RedirectResponse {
        $subjectTC = Subject_Teacher::create([
            'user_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subjectTC->save();

        return redirect()->route('edit_subject', ['id' => $id])->with('blue-message', 'Teacher Successfuly Added');
    }

    public function dropSubjectTeacher($id, $teacher_id): RedirectResponse {
        $subjectTC = Subject_Teacher::where('user_id', $teacher_id)->where('subject_id', $id)->first();
        $subjectTC->delete();

        return redirect()->route('edit_subject', ['id' => $id])->with('red-message', 'Teacher Has Been Removed');
    }
}
